<?php
/**
 * Haven Hands — Staff Application Email Handler
 * -------------------------------------------------
 * Receives the job application form from caregivers.html and emails
 * it (fields + CV + passport photo) to your Gmail inbox using your
 * cPanel email account over SMTP (PHPMailer if available, otherwise
 * a dependency-free mail() fallback).
 *
 * ── SETUP ─────────────────────────────────────────────────────────
 * 1. Open cPanel → Email Accounts → find info@havenhandsservices.com
 * 2. Edit the 3 settings below (TO_EMAIL, SMTP_PASS, and SMTP_HOST
 *    only if it is not mail.havenhandsservices.com).
 * 3. Upload this file to public_html (next to caregivers.html).
 * 4. Test by submitting the application form.
 * ─────────────────────────────────────────────────────────────────
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
header('Content-Type: application/json');

/* ═══════════════════ 1. CONFIG — EDIT THESE  ═══════════════════ */
$TO_EMAIL      = 'YOUR_GMAIL@gmail.com';            // ← Gmail inbox that receives applications
$SENDER_EMAIL  = 'info@havenhandsservices.com';     // cPanel email account that sends
$SENDER_NAME   = 'Haven Hands Careers';
$SMTP_HOST     = 'mail.havenhandsservices.com';     // usually mail.yourdomain.com (or localhost)
$SMTP_PORT     = 465;                               // 465 (SSL) or 587 (STARTTLS)
$SMTP_SECURE   = 'ssl';                             // 'ssl' for 465, 'tls' for 587
$SMTP_USER     = $SENDER_EMAIL;
$SMTP_PASS     = 'YOUR_EMAIL_PASSWORD';             // ← password of the cPanel email account
/* ═══════════════════════════════════════════════════════════════ */

/* ── Helpers ── */
function respond($ok, $msg) {
    echo json_encode(['success' => (bool)$ok, 'message' => $msg]);
    exit;
}
function post($k) {
    $v = isset($_POST[$k]) ? (string)$_POST[$k] : '';
    return trim(preg_replace('/[\r\n]+/', ' ', strip_tags($v)));
}

/* ── Only POST ── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Invalid request method.');

/* ── Gather fields ── */
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
        $attachments[] = [
            'tmp'  => $f['tmp_name'],
            'name' => basename($f['name']),
            'type' => $f['type'],
        ];
    } elseif ($field === 'passport' || $field === 'cv') {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
            respond(false, 'Could not upload ' . $field . '. Please try again.');
        }
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

function row($k, $v) {
    return "<tr><td style=\"padding:6px 12px;background:#e6f4f5;font-weight:bold;color:#004d52;border:1px solid #d4e8e9\">$k</td>"
        . "<td style=\"padding:6px 12px;border:1px solid #d4e8e9\">$v</td></tr>";
}

$subject = 'New Staff Application - ' . preg_replace('/[^\p{L}\p{N} .\-\']/u', '', $name);

/* ── Try PHPMailer first ── */
$phpmailerLoaded = false;
$pmPaths = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/PHPMailer/src/PHPMailer.php',
    '/usr/share/php/PHPMailer/PHPMailer.php',
    '/usr/share/php/PHPMailer/src/PHPMailer.php',
];
foreach ($pmPaths as $path) {
    if (file_exists($path)) { require_once $path; $phpmailerLoaded = true; break; }
}

if ($phpmailerLoaded) {
    try {
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $SMTP_USER;
            $mail->Password   = $SMTP_PASS;
            $mail->Port       = $SMTP_PORT;
            $mail->SMTPSecure = ($SMTP_SECURE === 'tls') ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->CharSet    = 'UTF-8';
            $mail->setFrom($SENDER_EMAIL, $SENDER_NAME);
            $mail->addAddress($TO_EMAIL);
            $mail->addReplyTo($SENDER_EMAIL, $SENDER_NAME);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody;
            foreach ($attachments as $att) $mail->addAttachment($att['tmp'], $att['name']);
            $mail->send();
            respond(true, 'Application sent. We will be in touch within 48 hours.');
        }
    } catch (Exception $e) {
        // fall through to mail() fallback
    }
}

/* ── Fallback: dependency-free mail() ── */
function fallback_send($to, $subject, $html, $text, $attachments, $fromEmail, $fromName) {
    $boundary = md5(uniqid(mt_rand(), true));
    $headers  = "From: $fromName <$fromEmail>\r\n"
              . "Reply-To: $fromEmail\r\n"
              . "MIME-Version: 1.0\r\n"
              . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $body = "--$boundary\r\n"
          . "Content-Type: multipart/alternative; boundary=\"alt-$boundary\"\r\n\r\n"
          . "--alt-$boundary\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n$text\r\n\r\n"
          . "--alt-$boundary\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n$html\r\n\r\n"
          . "--alt-$boundary--\r\n";
    foreach ($attachments as $att) {
        $data = chunk_split(base64_encode(file_get_contents($att['tmp'])));
        $body .= "--$boundary\r\n"
              . "Content-Type: {$att['type']}; name=\"{$att['name']}\"\r\n"
              . "Content-Transfer-Encoding: base64\r\n"
              . "Content-Disposition: attachment; filename=\"{$att['name']}\"\r\n\r\n"
              . $data . "\r\n";
    }
    $body .= "--$boundary--\r\n";
    return @mail($to, $subject, $body, $headers);
}

$sent = fallback_send($TO_EMAIL, $subject, $htmlBody, $textBody, $attachments, $SENDER_EMAIL, $SENDER_NAME);
if ($sent) {
    respond(true, 'Application sent. We will be in touch within 48 hours.');
} else {
    respond(false, 'Email sending failed. Please try again or WhatsApp us directly.');
}
