<?php
/**
 * Shared <head> partial.
 * Required variables set by the page BEFORE including this file:
 *   $pageTitle   (string)
 *   $pageDesc    (string)
 *   $canonical   (string) full URL
 * Optional:
 *   $ogImage     (string) full URL of share image (default: onehaven.jpg)
 *   $ogType      (string) 'website' or 'article'
 *   $ogTitle     (string) override og/twitter title
 *   $ogDesc      (string) override og/twitter description
 *   $hreflang    (string) full URL for hreflang "en-ke" (omit for none)
 *   $extraHead   (string) extra <head> markup, e.g. JSON-LD scripts
 *   $bodyClass   (string) extra <body> class, e.g. 'blog-page'
 */
require __DIR__ . '/config.php';
$ogType  = $ogType  ?? 'website';
$ogImage = $ogImage ?? 'https://havenhandsservices.com/onehaven.jpg';
$ogTitle = $ogTitle ?? $pageTitle;
$ogDesc  = $ogDesc  ?? $pageDesc;
function e_attr($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e_attr($pageTitle); ?></title>
    <meta name="description" content="<?php echo e_attr($pageDesc); ?>">
    <link rel="icon" type="image/png" href="<?php echo $SITE_BASE; ?>favicon.png">
    <meta name="theme-color" content="#006A71">

    <!-- GEO / SEO -->
    <meta name="geo.region" content="KE">
    <meta name="geo.placename" content="Nairobi">
    <meta name="geo.position" content="-1.286389;36.817223">
    <meta name="ICBM" content="-1.286389, 36.817223">
    <link rel="canonical" href="<?php echo e_attr($canonical); ?>">
    <?php if (!empty($hreflang)): ?>
    <link rel="alternate" hreflang="en-ke" href="<?php echo e_attr($hreflang); ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type" content="<?php echo e_attr($ogType); ?>">
    <meta property="og:locale" content="en_KE">
    <meta property="og:url" content="<?php echo e_attr($canonical); ?>">
    <meta property="og:title" content="<?php echo e_attr($ogTitle); ?>">
    <meta property="og:description" content="<?php echo e_attr($ogDesc); ?>">
    <meta property="og:image" content="<?php echo e_attr($ogImage); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e_attr($ogTitle); ?>">
    <meta name="twitter:description" content="<?php echo e_attr($ogDesc); ?>">
    <meta name="twitter:image" content="<?php echo e_attr($ogImage); ?>">

    <?php if (!empty($extraHead)) echo $extraHead; ?>

    <!-- Fonts & CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $SITE_BASE; ?>style.css">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body<?php echo $bodyClass ? ' class="' . e_attr($bodyClass) . '"' : ''; ?>>
