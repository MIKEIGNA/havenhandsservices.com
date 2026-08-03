<?php
/**
 * Haven Hands — Contact Form Email Handler
 * -------------------------------------------------
 * Receives the contact form from contact.html and emails the inquiry
 * to your Gmail inbox via the cPanel mail server.
 *
 * Design: the submission is SAVED TO form-backups FIRST, then email is
 * attempted (mail() if enabled, else PHPMailer SMTP). If the email
 * cannot be sent, the saved copy stays on disk — nothing is ever lost,
 * and a server restriction (e.g. mail() disabled) can never cause a 500.
 *
 * ── SETUP ─────────────────────────────────────────────────────────
 * 1. Edit TO_EMAIL / SMTP_PASS below.
 * 2. Upload this file to public_html (next to contact.html / contact.php).
 * ─────────────────────────────────────────────────────────────────
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
if (function_exists('set_time_limit')) { @set_time_limit(30); }
header('Content-Type: application/json');

/* ═══════════════════ 1. CONFIG — EDIT THESE  ═══════════════════ */
$TO_EMAIL      = 'serviceshavenhands@gmail.com';            // ← Gmail inbox that receives inquiries
$SENDER_EMAIL  = 'info@havenhandsservices.com';     // cPanel email account that sends
$SENDER_NAME   = 'Haven Hands Website';
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

/* ── FAILSAFE: save every submission to form-backups ── */
$BACKUP_DIR = __DIR__ . '/form-backups/contact';

function save_backup($fields) {
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
    $record['type'] = 'contact_inquiry';
    @file_put_contents($sub . '/submission.json', json_encode($record, JSON_PRETTY_PRINT));
    return $sub;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Invalid request method.');

$name    = post('name');
$email   = post('email');
$phone   = post('phone');
$service = post('service');
$message = post('message');

if ($name === '' || $email === '' || $message === '') {
    respond(false, 'Name, email and message are required.');
}

$serviceLabels = [
    'nanny' => 'Nanny Services', 'househelp' => 'Full-time House Help',
    'Staff' => 'Professional Elderly Care', 'training' => 'Staff Training Program',
    'other' => 'Other / Custom Request', '' => 'Not specified',
];
$serviceLabel = isset($serviceLabels[$service]) ? $serviceLabels[$service] : $service;

$textBody = "New inquiry from the website contact form:\r\n"
    . "-------------------------------------\r\n"
    . "Name: $name\r\n"
    . "Email: $email\r\n"
    . "Phone: $phone\r\n"
    . "Service needed: $serviceLabel\r\n"
    . "-------------------------------------\r\n"
    . "Message:\r\n$message";

$esc = function ($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); };
$htmlBody = "<div style=\"font-family:Arial,sans-serif;max-width:640px\">"
    . "<h2 style=\"color:#006A71;margin:0 0 16px\">New Contact Form Inquiry</h2>"
    . "<table cellpadding=\"6\" style=\"border-collapse:collapse;font-size:14px\">"
    . "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">Name</td><td style=\"padding:6px 12px;border:1px solid #d4e8e9\">" . $esc($name) . "</td></tr>"
    . "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">Email</td><td style=\"padding:6px 12px;border:1px solid #d4e8e9\">" . $esc($email) . "</td></tr>"
    . "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">Phone</td><td style=\"padding:6px 12px;border:1px solid #d4e8e9\">" . $esc($phone) . "</td></tr>"
    . "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">Service needed</td><td style=\"padding:6px 12px;border:1px solid #d4e8e9\">" . $esc($serviceLabel) . "</td></tr>"
    . "</table>"
    . "<p style=\"margin-top:16px\"><strong>Message:</strong></p>"
    . "<p style=\"color:#2d4546;line-height:1.6\">" . nl2br($esc($message)) . "</p>"
    . "</div>";

$subject = 'New Website Inquiry - ' . preg_replace('/[^\p{L}\p{N} .\-\']/u', '', $name);

/* ── 1. FAILSAFE FIRST: save the submission now ── */
$backupFields = ['name' => $name, 'email' => $email, 'phone' => $phone,
                 'service' => $serviceLabel, 'message' => $message];
$savedPath = save_backup($backupFields);

$sent = false;
$debug = ['php' => PHP_VERSION, 'time' => date('c')];

/* ── 2. Try mail() — reliable on cPanel (local Exim, DKIM-signed) ── */
$debug['mail_function_exists'] = function_exists('mail');
if (!$sent && function_exists('mail')) {
    $boundary = md5(uniqid(mt_rand(), true));
    $headers  = "From: $SENDER_NAME <$SENDER_EMAIL>\r\n"
              . "Reply-To: $email\r\n"
              . "MIME-Version: 1.0\r\n"
              . "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n";
    $body = "--$boundary\r\n"
          . "Content-Type: text/plain; charset=UTF-8\r\n\r\n$textBody\r\n\r\n"
          . "--$boundary\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n$htmlBody\r\n\r\n"
          . "--$boundary--";
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
            $mail->addReplyTo($email, $name);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody;
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
    @unlink($savedPath . '/submission.json');
    @rmdir($savedPath);
    respond(true, 'Message sent. We will get back to you within 24 hours.');
}

@file_put_contents($savedPath . '/debug.txt', json_encode($debug, JSON_PRETTY_PRINT));
respond(true, 'We received your message. We will get back to you within 24 hours.');
