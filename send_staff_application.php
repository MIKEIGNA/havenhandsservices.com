<?php
/**
 * Haven Hands — Staff Application Email Handler
 * -------------------------------------------------
 * Receives the job application form from caregivers.html and emails it
 * (fields + CV + passport photo) to your Gmail inbox via the cPanel
 * mail server.
 *
 * Design: the submission + files are SAVED TO form-backups FIRST, then
 * email is attempted (mail() if enabled, else PHPMailer SMTP). If the
 * email cannot be sent, the saved copy stays on disk — nothing is ever
 * lost, and a server restriction (e.g. mail() disabled) can never cause
 * a 500.
 *
 * ── SETUP ─────────────────────────────────────────────────────────
 * 1. Edit TO_EMAIL / SMTP_PASS below.
 * 2. Upload this file to public_html (next to caregivers.html).
 * ─────────────────────────────────────────────────────────────────
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
if (function_exists('set_time_limit')) { @set_time_limit(30); }
header('Content-Type: application/json');

/* ═══════════════════ 1. CONFIG — EDIT THESE  ═══════════════════ */
$TO_EMAIL      = 'serviceshavenhands@gmail.com';            // ← Gmail inbox that receives applications
$SENDER_EMAIL  = 'info@havenhandsservices.com';     // cPanel email account that sends
$SENDER_NAME   = 'Haven Hands Careers';
$SMTP_HOST     = 'localhost';                       // site + mail share the same server; 'mail.havenhandsservices.com' also works
$SMTP_PORT     = 465;                               // 465 (SSL) or 587 (STARTTLS)
$SMTP_SECURE   = 'ssl';                             // 'ssl' for 465, 'tls' for 587
$SMTP_USER     = $SENDER_EMAIL;
$SMTP_PASS     = 'jF0!v5}Kw.=o^Vr(';             // ← password of the cPanel email account
/* ═══════════════════════════════════════════════════════════════ */

function respond($ok, $msg) {
    echo json_encode(['success' => (bool)$ok, 'message' => $msg]);
    exit;
}
function post($k) {
    $v = isset($_POST[$k]) ? (string)$_POST[$k] : '';
    return trim(preg_replace('/[\r\n]+/', ' ', strip_tags($v)));
}

/* ── FAILSAFE: save every submission + files to form-backups ── */
$BACKUP_DIR = __DIR__ . '/form-backups/applications';

function save_backup($fields, $attachments) {
    global $BACKUP_DIR;
    if (!is_dir($BACKUP_DIR)) { @mkdir($BACKUP_DIR, 0755, true); }
    $guard = dirname($BACKUP_DIR) . '/.htaccess';
    if (!file_exists($guard)) {
        @file_put_contents($guard,
            "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n" .
            "<IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n</IfModule>\n");
    }
    $sub = $BACKUP_DIR . '/' . date('Ymd_His');
    if (!is_dir($sub)) { @mkdir($sub, 0755, true); }
    $record = $fields;
    $record['saved_at'] = date('c');
    $record['type'] = 'job_application';
    $record['files'] = [];
    foreach ($attachments as $att) {
        $dest = $sub . '/' . $att['name'];
        $copied = (function_exists('copy') && @copy($att['tmp'], $dest));
        if (!$copied && function_exists('file_get_contents') && function_exists('file_put_contents')) {
            $data = @file_get_contents($att['tmp']);
            if ($data !== false && @file_put_contents($dest, $data) !== false) { $copied = true; }
        }
        if ($copied) { $record['files'][] = $att['name']; }
    }
    @file_put_contents($sub . '/submission.json', json_encode($record, JSON_PRETTY_PRINT));
    return $sub;
}

function delete_backup($sub) {
    if (is_dir($sub)) {
        foreach (glob($sub . '/*') as $f) { @unlink($f); }
        @rmdir($sub);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Invalid request method.');

$name       = post('name');
$phone      = post('phone');
$location   = post('location');
$experience = post('experience');
$gender     = post('gender');
$age        = post('age');
$education  = post('education');
$type       = post('type');
$certs      = post('certs');

if ($name === '' || $phone === '') respond(false, 'Name and phone number are required.');

/* ── Attachments (passport photo + CV) ── */
$attachments = [];
foreach (['passport' => 2, 'cv' => 5] as $field => $maxMB) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
        $f = $_FILES[$field];
        if ($f['size'] > $maxMB * 1024 * 1024) {
            respond(false, ucfirst($field) . ' file is larger than ' . $maxMB . 'MB.');
        }
        $attachments[] = ['tmp' => $f['tmp_name'], 'name' => basename($f['name']), 'type' => $f['type']];
    }
}

/* ── Email body ── */
$textBody = "New job application from the website:\r\n"
    . "-------------------------------------\r\n"
    . "Name: $name\r\n"
    . "Phone: $phone\r\n"
    . "Location: $location\r\n"
    . "Experience: $experience\r\n"
    . "Gender: $gender\r\n"
    . "Age: $age\r\n"
    . "Education: $education\r\n"
    . "Position: $type\r\n"
    . "Certifications: $certs\r\n"
    . "-------------------------------------\r\n"
    . "Attachments: " . ($attachments ? implode(', ', array_column($attachments, 'name')) : 'none');

$esc = function ($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); };
function row($k, $v) {
    return "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">$k</td>"
        . "<td style=\"padding:6px 12px;border:1px solid #d4e8e9\">$v</td></tr>";
}
$htmlBody = "<div style=\"font-family:Arial,sans-serif;max-width:640px\">"
    . "<h2 style=\"color:#006A71;margin:0 0 16px\">New Job Application</h2>"
    . "<table cellpadding=\"6\" style=\"border-collapse:collapse;font-size:14px\">"
    . row('Name', $esc($name)) . row('Phone', $esc($phone))
    . row('Location', $esc($location)) . row('Experience', $esc($experience))
    . row('Gender', $esc($gender)) . row('Age', $esc($age))
    . row('Education', $esc($education)) . row('Position', $esc($type))
    . row('Certifications', $esc($certs))
    . "</table>"
    . ($attachments ? "<p style=\"font-size:13px;color:#5a7273\">Attachments: " . $esc(implode(', ', array_column($attachments, 'name'))) . "</p>" : '')
    . "</div>";

$subject = 'New Staff Application - ' . preg_replace('/[^\p{L}\p{N} .\-\']/u', '', $name);

/* ── 1. FAILSAFE FIRST: save the submission + files now ── */
$backupFields = ['name' => $name, 'phone' => $phone, 'location' => $location,
                 'experience' => $experience, 'gender' => $gender, 'age' => $age,
                 'education' => $education, 'position' => $type, 'certs' => $certs];
$savedPath = save_backup($backupFields, $attachments);

$sent = false;
$debug = ['php' => PHP_VERSION, 'time' => date('c')];

/* ── 2. Try mail() — reliable on cPanel (local Exim, DKIM-signed) ── */
$debug['mail_function_exists'] = function_exists('mail');
if (!$sent && function_exists('mail') && function_exists('file_get_contents')
    && function_exists('base64_encode') && function_exists('chunk_split')) {
    $boundary = md5(uniqid(mt_rand(), true));
    $headers  = "From: $SENDER_NAME <$SENDER_EMAIL>\r\n"
              . "Reply-To: $SENDER_EMAIL\r\n"
              . "MIME-Version: 1.0\r\n"
              . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $body = "--$boundary\r\n"
          . "Content-Type: multipart/alternative; boundary=\"alt-$boundary\"\r\n\r\n"
          . "--alt-$boundary\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n$textBody\r\n\r\n"
          . "--alt-$boundary\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n$htmlBody\r\n\r\n"
          . "--alt-$boundary--\r\n";
    foreach ($attachments as $att) {
        $data = chunk_split(base64_encode(@file_get_contents($att['tmp'])));
        $body .= "--$boundary\r\n"
              . "Content-Type: {$att['type']}; name=\"{$att['name']}\"\r\n"
              . "Content-Transfer-Encoding: base64\r\n"
              . "Content-Disposition: attachment; filename=\"{$att['name']}\"\r\n\r\n"
              . $data . "\r\n";
    }
    $body .= "--$boundary--\r\n";
    $sent = @mail($TO_EMAIL, $subject, $body, $headers);
    $debug['mail_result'] = $sent;
} else {
    $debug['mail_result'] = 'not_called';
}

/* ── 3. Fallback: PHPMailer over SMTP — try common cPanel configs ── */
if (!$sent) {
    $debug['openssl'] = extension_loaded('openssl');
    $phpmailerLoaded = false;
    foreach ([__DIR__ . '/vendor/autoload.php', __DIR__ . '/PHPMailer/src/PHPMailer.php',
              '/usr/share/php/PHPMailer/PHPMailer.php', '/usr/share/php/PHPMailer/src/PHPMailer.php'] as $path) {
        if (file_exists($path)) {
            $srcDir = dirname($path);
            if (file_exists($srcDir . '/Exception.php')) require_once $srcDir . '/Exception.php';
            if (file_exists($srcDir . '/SMTP.php')) require_once $srcDir . '/SMTP.php';
            require_once $path;
            $phpmailerLoaded = true;
            break;
        }
    }
    $debug['phpmailer_available'] = $phpmailerLoaded && class_exists('PHPMailer\PHPMailer\PHPMailer');

    $attempts = [
        ['host' => $SMTP_HOST, 'port' => 587, 'secure' => 'tls',  'auth' => true],
        ['host' => $SMTP_HOST, 'port' => 465, 'secure' => 'ssl',  'auth' => true],
        ['host' => $SMTP_HOST, 'port' => 25,  'secure' => '',     'auth' => true],
        ['host' => $SMTP_HOST, 'port' => 25,  'secure' => '',     'auth' => false],
    ];
    $attemptLog = [];
    foreach ($attempts as $a) {
        if ($sent) break;
        if (!$phpmailerLoaded || !class_exists('PHPMailer\PHPMailer\PHPMailer')) break;
        $label = $a['host'] . ':' . $a['port'] . '/' . ($a['secure'] ?: 'plain') . '/' . ($a['auth'] ? 'auth' : 'noauth');
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host               = $a['host'];
            $mail->Port               = $a['port'];
            $mail->SMTPSecure         = $a['secure'];
            $mail->SMTPAuth           = $a['auth'];
            $mail->SMTPAutoTLS        = ($a['secure'] === 'tls');
            if ($a['auth']) { $mail->Username = $SMTP_USER; $mail->Password = $SMTP_PASS; }
            $mail->Timeout            = 5;
            $mail->SMTPConnectTimeout = 5;
            $mail->CharSet            = 'UTF-8';
            $mail->setFrom($SENDER_EMAIL, $SENDER_NAME);
            $mail->addAddress($TO_EMAIL);
            $mail->addReplyTo($SENDER_EMAIL, $SENDER_NAME);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody;
            foreach ($attachments as $att) $mail->addAttachment($att['tmp'], $att['name']);
            $mail->send();
            $sent = true;
            $debug['smtp_used'] = $label;
        } catch (Exception $e) {
            $attemptLog[] = $label . ' => ' . $e->getMessage();
        }
    }
    if ($attemptLog) { $debug['smtp_attempts'] = $attemptLog; }
}

/* ── 4. Email sent → remove the backup. Not sent → keep it (failsafe). ── */
if ($sent) {
    delete_backup($savedPath);
    respond(true, 'Application sent. We will be in touch within 48 hours.');
}

@file_put_contents($savedPath . '/debug.txt', json_encode($debug, JSON_PRETTY_PRINT));
respond(true, 'We received your application. We will be in touch within 48 hours.');
