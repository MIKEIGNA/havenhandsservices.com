<?php
/**
 * SITE_BASE — folder the site lives in, relative to the domain root.
 *
 * Auto-detected from the server so it works in both places:
 *   - Production (cPanel, public_html / domain root) → '/'
 *   - Local XAMPP subfolder (e.g. D:\xampp\htdocs\hands) → '/hands/'
 *
 * To force a value instead of auto-detecting, define SITE_BASE before
 * this file is loaded (rarely needed).
 */
if (!defined('SITE_BASE')) {
    $docRoot = isset($_SERVER['DOCUMENT_ROOT'])
        ? rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/')
        : '';
    $incDir  = str_replace('\\', '/', __DIR__);          // .../includes

    if ($docRoot !== '' && strpos($incDir, $docRoot) === 0) {
        $rel  = substr($incDir, strlen($docRoot));        // '/hands/includes' or '/includes'
        $base = substr($rel, 0, -strlen('/includes'));    // '/hands' or ''
        define('SITE_BASE', $base . '/');                 // '/hands/' or '/'
    } else {
        define('SITE_BASE', '/');
    }
}

$SITE_BASE = SITE_BASE;
