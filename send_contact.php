<?php
/**
 * Haven Hands — Contact Form Email Handler
 * -------------------------------------------------
 * Receives the contact form from contact.html and emails the inquiry
 * to your Gmail inbox using your cPanel email account over SMTP.
 * Same config as send_staff_application.php.
 *
 * ── SETUP ─────────────────────────────────────────────────────────
 * 1. Edit the 3 settings below (TO_EMAIL, SMTP_PASS, and SMTP_HOST
 *    only if it is not mail.havenhandsservices.com).
 * 2. Upload this file to public_html (next to contact.html).
 * ─────────────────────────────────────────────────────────────────
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
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

/* ── FAILSAFE: save submissions when email cannot be sent ── */
$BACKUP_DIR = __DIR__ . '/form-backups/contact';

function save_backup($fields) {
    global $BACKUP_DIR;
    if (!is_dir($BACKUP_DIR)) @mkdir($BACKUP_DIR, 0755, true);
    $guard = dirname($BACKUP_DIR) . '/.htaccess';
    if (!file_exists($guard)) {
        @file_put_contents($guard,
            "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n" .
            "<IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n</IfModule>\n");
    }
    $sub = $BACKUP_DIR . '/' . date('Ymd_His');
    @mkdir($sub, 0755, true);
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

if ($phpmailerLoaded && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    try {
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
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body    = $htmlBody;
        $mail->AltBody = $textBody;
        $mail->send();
        respond(true, 'Message sent. We will get back to you within 24 hours.');
    } catch (Exception $e) {
        // fall through to mail() fallback
    }
}

/* ── Fallback: dependency-free mail() ── */
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
if ($sent) {
    respond(true, 'Message sent. We will get back to you within 24 hours.');
}

/* ── FAILSAFE: email failed → save submission in cPanel ── */
$backupFields = [
    'name' => $name, 'email' => $email, 'phone' => $phone,
    'service' => $serviceLabel, 'message' => $message,
];
$savedPath = save_backup($backupFields);

if ($savedPath) {
    respond(true, 'We received your message. We will get back to you within 24 hours.');
} else {
    respond(false, 'Sending failed. Please try again or use WhatsApp.');
}
