<?php
// Page: index
$pageTitle = "Blog &amp; Insights | Haven Hands - Home Care &amp; Childcare Tips";
$pageDesc  = "Read expert home management tips, child care guides, and professional advice for employer-Staff relationships in Jacaranda Gardens, Kamiti Road.";
$canonical = "https://havenhandsservices.com/blog/index.html";
$ogImage   = "https://havenhandsservices.com/blog-featured.jpg";
$ogType    = "website";
$ogTitle   = "Blog &amp; Insights | Haven Hands - Domestic Care Articles";
$ogDesc    = "Read guides on how to select nannies, establish healthy working relations, and manage modern households.";
$active    = "blog";
$bodyClass = "blog-page";
require '../includes/head.php';
require '../includes/header.php';
?>

<main>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="container page-hero-grid">
        <div class="page-hero-content" data-reveal="left">
            <span class="section-tag">Insights &amp; Resources</span>
            <h1>Haven Hands <span>Blog</span></h1>
            <p class="sub">Expert home management advice, childcare guides, safety tips, and articles designed for modern Nairobi families and professional Staff.</p>
            <div class="form-group" style="max-width: 400px; margin-top: 1.5rem;">
                <input type="text" id="blogSearch" placeholder="Search articles..." style="border-radius: var(--radius-full); padding: 0.8rem 1.5rem;">
            </div>
        </div>
        <div class="page-hero-img" data-reveal="right">
            <img src="../blog-featured.jpg" alt="Haven Hands Blog &amp; Insights">
        </div>
    </div>
</section>

<!-- ARTICLES SECTION -->
<section class="section-pad">
    <div class="container">
        
        <!-- Featured Post -->
        <div class="blog-featured" data-reveal>
            <div class="blog-card-img-wrap" style="height: 100%;">
                <img src="../new_photos/clean home.jpeg" alt="Featured Post" class="blog-card-img">
            </div>
            <div class="blog-featured-body">
                <span class="blog-cat">Home Tips</span>
                <h2 class="blog-title" style="font-size: 1.6rem; margin: 0.5rem 0 1rem;"><a href="post-2.html">The Modern Home Manager: 5 Cleaning Hacks for a Stress-Free Household</a></h2>
                <p class="blog-excerpt" style="margin-bottom: 1.5rem;">At Haven Hands, we don't just provide help; we provide premium service through professional "Home Managers" who bring order to your sanctuary.</p>
                <div class="blog-meta" style="border: none; padding-top: 0;">
                    <span>July 10, 2026</span>
                    <a href="post-2.html" class="read-more">Read Full Article <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                </div>
            </div>
        </div>

        <div class="blog-grid" data-reveal>
            
            <!-- Post 2 -->
            <article class="blog-card" data-title="The Dignity of Domestic Work Building a Respectful Relationship">
                <div class="blog-card-img-wrap">
                    <img src="../new_photos/staff.jpeg" alt="Dignity of Domestic Work" class="blog-card-img">
                </div>
                <div class="blog-card-body">
                    <span class="blog-cat">Employer Tips</span>
                    <h3 class="blog-title">The Dignity of Domestic Work: Building a Respectful Relationship</h3>
                    <p class="blog-excerpt">At Haven Hands, we believe that the secret to a thriving home lies in the dignity of the relationship between an employer and their caregiver.</p>
                    <div class="blog-meta">
                        <span>July 8, 2026</span>
                        <a href="post-3.html" class="read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                    </div>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="blog-card" data-title="Faith in the Home How Values-Driven Service Creates Harmony">
                <div class="blog-card-img-wrap">
                    <img src="../new_photos/staff-house-manager.jpeg" alt="Faith in the Home" class="blog-card-img">
                </div>
                <div class="blog-card-body">
                    <span class="blog-cat">Family Life</span>
                    <h3 class="blog-title">Faith in the Home: How Values-Driven Service Creates a Harmonious Sanctuary</h3>
                    <p class="blog-excerpt">A home should be more than just a physical space; it should be a sanctuary of peace. See how faith-driven service transforms households.</p>
                    <div class="blog-meta">
                        <span>July 5, 2026</span>
                        <a href="post-4.html" class="read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                    </div>
                </div>
            </article>

            <!-- Post 4 -->
            <article class="blog-card" data-title="Safety First Why First Aid Training is Non-Negotiable">
                <div class="blog-card-img-wrap">
                    <img src="../new_photos/training.jpeg" alt="First Aid Training" class="blog-card-img">
                </div>
                <div class="blog-card-body">
                    <span class="blog-cat">Child Safety</span>
                    <h3 class="blog-title">Safety First: Why First Aid Training is Non-Negotiable for Every Nanny</h3>
                    <p class="blog-excerpt">When it comes to childcare, safety and trust are the foundations of a happy home. Learn why first aid training is essential for every nanny.</p>
                    <div class="blog-meta">
                        <span>July 3, 2026</span>
                        <a href="post-5.html" class="read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                    </div>
                </div>
            </article>

            <!-- Post 5 -->
            <article class="blog-card" data-title="The Haven Hands Standard Why Professional Training Changes Everything">
                <div class="blog-card-img-wrap">
                    <img src="../new_photos/staff-profile.jpeg" alt="Professional Training" class="blog-card-img">
                </div>
                <div class="blog-card-body">
                    <span class="blog-cat">Training</span>
                    <h3 class="blog-title">The Haven Hands Standard: Why Professional Training Changes Everything</h3>
                    <p class="blog-excerpt">In the modern Nairobi household, there is a profound difference between hiring "help" and welcoming a professional caregiver.</p>
                    <div class="blog-meta">
                        <span>June 28, 2026</span>
                        <a href="post-6.html" class="read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- NEWSLETTER / WHATSAPP BANNER -->
<section class="section-pad bg-light">
    <div class="container">
        <div class="cta-banner" data-reveal>
            <h2>Want home tips directly in your inbox?</h2>
            <p>Connect with us on WhatsApp to receive quick guides, parent advice, and featured Staff profiles directly on your phone.</p>
            <div class="cta-actions">
                <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20please%20add%20me%20to%20your%20broadcast%20list%20for%20home%20care%20tips." target="_blank" rel="noopener noreferrer" class="btn btn-white btn-lg">
                    Join Our WhatsApp List
                </a>
            </div>
        </div>
    </div>
</section>

</main>

<?php require '../includes/footer.php'; ?>
