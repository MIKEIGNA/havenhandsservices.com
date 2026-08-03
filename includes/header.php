<?php
/**
 * Shared header + navigation partial.
 * Expects $active (string): home|about|services|workers|pricing|blog|contact
 */
function nav_active($key, $active) { return ($key === $active) ? ' active' : ''; }
?>
<div class="site-wrapper">

<!-- HEADER -->
<header id="header">
    <nav class="container nav-center">
        <div class="nav-left">
            <a href="<?php echo $SITE_BASE; ?>about.html" class="nav-link-alt<?php echo nav_active('about', $active ?? ''); ?>">About</a>
            <a href="<?php echo $SITE_BASE; ?>services.html" class="nav-link-alt<?php echo nav_active('services', $active ?? ''); ?>">Services</a>
            <div class="nav-dropdown">
                <a href="<?php echo $SITE_BASE; ?>workers.html" class="nav-link-alt<?php echo nav_active('workers', $active ?? ''); ?>">Staff</a>
                <div class="nav-dropdown-menu">
                    <a href="<?php echo $SITE_BASE; ?>workers.html">Find Staff</a>
                    <a href="<?php echo $SITE_BASE; ?>caregivers.html">Jobs</a>
                </div>
            </div>
        </div>
        <a href="<?php echo $SITE_BASE; ?>index.html" class="logo-center" aria-label="Haven Hands Home">
            <img src="<?php echo $SITE_BASE; ?>logo.png" alt="Haven Hands Logo" class="logo-img-center">
        </a>
        <div class="nav-right">
            <div class="nav-dropdown">
                <a href="<?php echo $SITE_BASE; ?>pricing.html" class="nav-link-alt<?php echo nav_active('pricing', $active ?? ''); ?>">Pricing</a>
                <div class="nav-dropdown-menu">
                    <a href="<?php echo $SITE_BASE; ?>pricing.html#employers">For Employers</a>
                    <a href="<?php echo $SITE_BASE; ?>pricing.html#training">Training Program</a>
                </div>
            </div>
            <a href="<?php echo $SITE_BASE; ?>blog/index.html" class="nav-link-alt<?php echo nav_active('blog', $active ?? ''); ?>">Blog</a>
            <a href="<?php echo $SITE_BASE; ?>contact.html" class="nav-link-alt<?php echo nav_active('contact', $active ?? ''); ?>">Contact</a>
            <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I'd%20like%20to%20inquire%20about%20your%20services." target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp btn-nav" id="nav-whatsapp">WhatsApp us &rarr;</a>
        </div>
    </nav>
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</header>

<!-- Mobile Nav Overlay -->
<div class="mobile-nav-overlay" id="mobileNav">
    <div class="mobile-nav-content">
        <a href="<?php echo $SITE_BASE; ?>index.html" class="mobile-nav-logo">
            <img src="<?php echo $SITE_BASE; ?>logo.png" alt="Haven Hands Logo">
        </a>
        <div class="mobile-nav-links">
            <a href="<?php echo $SITE_BASE; ?>index.html" class="mobile-link<?php echo nav_active('home', $active ?? ''); ?>">Home</a>
            <a href="<?php echo $SITE_BASE; ?>about.html" class="mobile-link<?php echo nav_active('about', $active ?? ''); ?>">About</a>
            <a href="<?php echo $SITE_BASE; ?>services.html" class="mobile-link<?php echo nav_active('services', $active ?? ''); ?>">Services</a>
            <a href="<?php echo $SITE_BASE; ?>workers.html" class="mobile-link<?php echo nav_active('workers', $active ?? ''); ?>">Staff</a>
            <a href="<?php echo $SITE_BASE; ?>pricing.html" class="mobile-link<?php echo nav_active('pricing', $active ?? ''); ?>">Pricing</a>
            <a href="<?php echo $SITE_BASE; ?>blog/index.html" class="mobile-link<?php echo nav_active('blog', $active ?? ''); ?>">Blog</a>
            <a href="<?php echo $SITE_BASE; ?>caregivers.html" class="mobile-link">Jobs</a>
        </div>
        <a href="<?php echo $SITE_BASE; ?>contact.html" class="btn btn-primary btn-full btn-mobile">Get Started</a>
        <div class="mobile-nav-socials">
            <a href="https://wa.me/254118971254" target="_blank" rel="noopener noreferrer">WhatsApp</a>
            <a href="https://www.instagram.com/havenhandsservices" target="_blank" rel="noopener noreferrer">Instagram</a>
            <a href="https://www.tiktok.com/@havenhandsservices" target="_blank" rel="noopener noreferrer">TikTok</a>
        </div>
    </div>
</div>
