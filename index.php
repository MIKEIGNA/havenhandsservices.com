<?php
// Page: index
$pageTitle = "Haven Hands | Trusted Nanny Agency &amp; Professional Staff in Jacaranda Gardens, Kamiti Road";
$pageDesc  = "Haven Hands matches Nairobi families with verified, trained, and ethical Staff and house helps. Get matched in 3–7 days. Background checked professionals.";
$canonical = "https://havenhandsservices.com/";
$ogImage   = "https://havenhandsservices.com/onehaven.jpg";
$ogType    = "website";
$hreflang  = "https://havenhandsservices.com/";
$ogTitle   = "Haven Hands | Trusted Nannies &amp; Staff in Jacaranda Gardens, Kamiti Road";
$ogDesc    = "Haven Hands matches families with trained, verified, and ethical house helps and Staff in Kenya.";
$extraHead = <<<'HTML'
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Haven Hands Services",
      "image": "https://havenhandsservices.com/logo.png",
      "logo": "https://havenhandsservices.com/logo.png",
      "telephone": "+254118971254",
      "email": "info@havenhandsservices.com",
      "url": "https://havenhandsservices.com/",
      "priceRange": "$$",
      "address": { "@type": "PostalAddress", "addressLocality": "Nairobi", "addressRegion": "Nairobi County", "addressCountry": "KE" },
      "geo": { "@type": "GeoCoordinates", "latitude": -1.286389, "longitude": 36.817223 },
      "areaServed": [
        { "@type": "City", "name": "Nairobi" },
        { "@type": "City", "name": "Mombasa" },
        { "@type": "Country", "name": "Kenya" }
      ]
    }
    </script>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        { "@type": "Question", "name": "How does Haven Hands vet its Staff?", "acceptedAnswer": { "@type": "Answer", "text": "Every Staff undergoes background checks, character reference verification, and ethical screening." } },
        { "@type": "Question", "name": "How long does the hiring process take?", "acceptedAnswer": { "@type": "Answer", "text": "Most families are matched within 3 to 7 days after the initial consultation." } }
      ]
    }
    </script>
HTML;
$active    = "home";
$bodyClass = "";
require 'includes/head.php';
require 'includes/header.php';
?>

<main>

<!-- HERO -->
<section class="hero-slider" id="home">
    <div class="hero-slides">
        <!-- Slide 1 -->
        <div class="hero-slide active" style="background-image: url('training.jpeg');">
            <div class="hero-overlay"></div>
            <div class="container hero-slide-content">
                <h1>Trusted homecare <span>staff</span></h1>
                <p>Background-checked, trained professionals for Nairobi families.</p>
                <div class="hero-ctas">
                    <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I'd%20like%20to%20find%20a%20house%20help%20or%20nanny." target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        WhatsApp us
                    </a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="hero-slide" style="background-image: url('vetted.jpg'); background-position: 50% 0%;">
            <div class="hero-overlay"></div>
            <div class="container hero-slide-content">
                <h2>Trained &amp; vetted <span>professionals</span></h2>
                <p>Meet our staff - trained, verified, and ready for your home.</p>
                <div class="hero-ctas">
                    <a href="workers.html" class="btn btn-white btn-lg">
                        Browse staff profiles
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-dots">
        <button class="hero-dot active" data-slide="0" aria-label="Slide 1"></button>
        <button class="hero-dot" data-slide="1" aria-label="Slide 2"></button>
    </div>
</section>
 
<!-- LOCATIONS -->
<section class="section-locations" id="locations">
    <div class="container">
        <div class="locations-flex">
            <div class="loc-left">
                <span class="section-tag-light">We are located at</span>
                <h2>Jacaranda Gardens, <span>Kamiti Road</span></h2>
                <p class="loc-intro">Serving families across Nairobi and beyond -</p>
                <div class="locations-marquee" aria-label="Areas we serve">
                    <div class="locations-marquee-track">
                        <div class="locations-marquee-group" aria-hidden="true">
                            <span class="loc-chip">Kilimani</span>
                            <span class="loc-chip">Westlands</span>
                            <span class="loc-chip">Karen</span>
                            <span class="loc-chip">Lavington</span>
                            <span class="loc-chip">Runda</span>
                            <span class="loc-chip">Muthaiga</span>
                            <span class="loc-chip">Gigiri</span>
                            <span class="loc-chip">Spring Valley</span>
                            <span class="loc-chip">Parklands</span>
                            <span class="loc-chip">Syokimau</span>
                            <span class="loc-chip">Kiambu</span>
                            <span class="loc-chip">Ruiru</span>
                             <span class="loc-chip">Ngong</span>
                            <span class="loc-chip">Thome</span>
                            <span class="loc-chip">Kikuyu</span>
                            <span class="loc-chip">Lang'ata</span>
                            <span class="loc-chip">BuruBuru</span>
                            <span class="loc-chip">Donholm</span>
                            <span class="loc-chip">Rongai</span>
                            <span class="loc-chip">Limuru</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loc-right">
                <div class="loc-stat">
                    <span class="loc-stat-num">98%</span>
                    <span class="loc-stat-label">Satisfaction Rate</span>
                </div>
                <div class="loc-stat">
                    <span class="loc-stat-num">3-7 days</span>
                    <span class="loc-stat-label">Average Placement</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 
     HOW IT WORKS
 -->
<section class="section-pad bg-off-white" id="how-it-works">
    <div class="container">
        <!-- <div class="section-header centered" data-reveal>
            <h2 class="section-title">It's actually pretty <span>straightforward</span></h2>
            <p class="section-intro">No long forms. No complicated process. Just three simple steps.</p>
        </div> -->
        <div class="steps-grid">
            <div class="step-card" data-reveal data-delay="100">
                <div class="step-num">1</div>
                <h4>Browse profiles</h4>
                <p>Look through our staff. See who's available, their experience, and what they're good at.</p>
            </div>
            <div class="step-card" data-reveal data-delay="200">
                <div class="step-num">2</div>
                <h4>Request an interview</h4>
                <p>Found someone you like? Request an interview directly through WhatsApp. We'll arrange the details.</p>
            </div>
            <div class="step-card" data-reveal data-delay="300">
                <div class="step-num">3</div>
                <h4>We follow up</h4>
                <p>After placement, we check in to make sure everything is working well for both you and your new staff member.</p>
            </div>
        </div>
    </div>
</section>

<!-- 
     FEATURED Staff
 -->
<section class="section-pad" id="featured-workers">
    <div class="container">
        <div class="section-header centered" data-reveal>
            <h2 class="section-title">Staff <span>Profiles</span></h2>
            <p class="section-intro">Real staff members - vetted, trained, and ready to start.</p>
        </div>
        <div class="workers-grid">
            <!-- Worker 1: Ann -->
            <div class="worker-card" data-reveal data-delay="100">
                <div class="worker-img-wrap">
                    <img src="ann-profile.jpeg" alt="Ann - House Manager" class="worker-img">
                </div>
                <div class="worker-info">
                    <span class="worker-type">House Manager</span>
                    <span class="worker-status not-available">Not Available</span>
                    <div class="worker-name">Ann</div>
                    <div class="worker-exp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        3 years experience
                    </div>
                    <div class="worker-skills">
                        <span class="skill-chip">Housekeeping</span>
                        <span class="skill-chip">Child &amp; Elderly Care</span>
                        <span class="skill-chip">First Aid &amp; Home Safety</span>
                        <span class="skill-chip">Digital Literacy</span>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1rem;">Loving, kind and hardworking. Asking salary KSH 15,000 and above.</p>
                    <div class="worker-actions">
                        <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I%27d%20like%20to%20request%20an%20interview%20with%20Ann%20for%20a%20House%20Manager%20role." target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">Request Interview</a>
                    </div>
                </div>
            </div>
            <!-- Worker 2: Millicent -->
            <div class="worker-card" data-reveal data-delay="200">
                <div class="worker-img-wrap">
                    <img src="staff-another.jpeg" alt="Millicent A. - Daybug" class="worker-img">
                </div>
                <div class="worker-info">
                    <span class="worker-type">Daybug (Part-Time Help)</span>
                    <span class="worker-status not-available">Not Available</span>
                    <div class="worker-name">Millicent A.</div>
                    <div class="worker-exp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        5+ years experience
                    </div>
                    <div class="worker-skills">
                        <span class="skill-chip">Housekeeping</span>
                        <span class="skill-chip">Communication &amp; Etiquette</span>
                        <span class="skill-chip">First Aid &amp; Safety</span>
                        <span class="skill-chip">Meal Planning</span>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1rem;">Hardworking, disciplined and professional. Asking salary KSH 15,000.</p>
                    <div class="worker-actions">
                        <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I%27d%20like%20to%20request%20an%20interview%20with%20Millicent%20for%20a%20Daybug%20role." target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">Request Interview</a>
                    </div>
                </div>
            </div>
            <!-- Worker 3: Audrey -->
            <div class="worker-card" data-reveal data-delay="300">
                <div class="worker-img-wrap">
                    <img src="Audrey-profile.png" alt="Audrey C. - House Manager" class="worker-img">
                </div>
                <div class="worker-info">
                    <span class="worker-type">House Manager</span>
                    <span class="worker-status not-available">Not Available</span>
                    <div class="worker-name">Audrey C.</div>
                    <div class="worker-skills">
                        <span class="skill-chip">Household Management</span>
                        <span class="skill-chip">Childcare</span>
                        <span class="skill-chip">Housekeeping</span>
                        <span class="skill-chip">Meal Preparation</span>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1rem;">Dedicated and caring, known for dependability and strong communication.</p>
                    <div class="worker-actions">
                        <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I%27d%20like%20to%20request%20an%20interview%20with%20Audrey%20for%20a%20House%20Manager%20role." target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">Request Interview</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4" data-reveal>
            <a href="workers.html" class="btn btn-primary">View Profiles</a>
        </div>
    </div>
</section>


<!-- 
     SERVICES
 -->
<section class="section-pad" id="home-services">
    <div class="container">
        <div class="section-header centered" data-reveal>
            <span class="section-tag">We Provide</span>
             <h2 class="section-title">Professional staff for <span>every need</span></h2>
           <!-- <p class="section-intro">From full-time home managers to part-time daybugs — trained, vetted, and matched to your household.</p> -->
        </div>
        <div class="home-services-grid" data-reveal>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">House Manager</span>
                    <span class="hs-desc">Cooking, cleaning, laundry, and full home upkeep.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Nannies &amp; Babysitters</span>
                    <span class="hs-desc">First-aid trained staff who keep kids safe and happy.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Elderly &amp; Companion Care</span>
                    <span class="hs-desc">Medication reminders, mobility, meals, and company.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h.01"/><path d="M15 12h.01"/><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Newborn &amp; Postnatal Care</span>
                    <span class="hs-desc">Feeding, bath time, sleep routines, and recovery care.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Drivers</span>
                    <span class="hs-desc">Licensed, defensive drivers for school runs and errands.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Gardeners</span>
                    <span class="hs-desc">Lawn care, landscaping, and beautiful outdoor spaces.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Special Needs Care</span>
                    <span class="hs-desc">Compassionate, trained support with patience and skill.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Daybugs (Part-Time Help)</span>
                    <span class="hs-desc">Flexible help for cleaning, cooking, or occasional tasks.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <a href="services.html" class="home-service-card">
                <span class="hs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/></svg>
                </span>
                <span class="hs-text">
                    <span class="hs-title">Pet Sitters</span>
                    <span class="hs-desc">Feeding, walking, and care while you're away.</span>
                </span>
                <svg class="hs-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
        <!-- <div class="text-center mt-4" data-reveal>
            <a href="services.html" class="btn btn-primary">Browse All Services</a>
        </div> -->
    </div>
</section>


<!-- 
     TRAINING PILLARS (after profiles)
 -->
<section class="section-pad bg-light" id="training-pillars">
    <div class="container">
        <div class="section-header centered" data-reveal>
            <h2 class="section-title">Every staff member is <span>trained before placement</span></h2>
            <p class="section-intro">Our 2-week, 10-module program covers everything your new staff member needs to show up ready on day one.</p>
        </div>
        <div class="training-clean-grid" data-reveal>
            <div class="training-clean-card">
                <h4>Professional Communication</h4>
                <p>Workplace etiquette, tone, and how to communicate professionally in a modern home environment.</p>
            </div>
            <div class="training-clean-card">
                <h4>Housekeeping &amp; Home Management</h4>
                <p>Cleaning standards, organisation, and full home management from daily routines to deep-cleaning.</p>
            </div>
            <div class="training-clean-card">
                <h4>First Aid &amp; Home Safety</h4>
                <p>Emergency response, safety protocols, and what to do in common household accidents.</p>
            </div>
            <div class="training-clean-card">
                <h4>Childcare &amp; Elderly Care Basics</h4>
                <p>Age-appropriate care, developmental support, and respectful assistance for elderly family members.</p>
            </div>
        </div>
        <div class="text-center mt-4" data-reveal>
            <a href="pricing.html#training" class="btn btn-primary btn-lg">View Full Training Program</a>
        </div>
    </div>
</section>


<!-- 
     BLOG PREVIEW
 -->
<section class="section-pad bg-off-white" id="blog-preview">
    <div class="container">
        <div class="section-header centered" data-reveal>
            <h2 class="section-title">Things we've <span>learned along the way</span></h2>
            <p class="section-intro">Practical advice on hiring, managing, and working well with your house manager or nanny.</p>
        </div>
        <div class="blog-grid">
            <article class="blog-card" data-reveal data-delay="100">
                <div class="blog-card-img-wrap">
                    <img src="new_photos/clean home.jpeg" alt="Cleaning hacks" class="blog-card-img" loading="lazy">
                </div>
                <div class="blog-card-body">
                    <div class="blog-cat">Home Tips</div>
                    <h3 class="blog-title">5 Cleaning Hacks for a Stress-Free Household</h3>
                    <p class="blog-excerpt">Professional cleaning tips from our home managers to keep your Nairobi household spotless and stress-free.</p>
                    <div class="blog-meta">
                        <span>July 10, 2026</span>
                        <a href="blog/post-2.html" class="read-more">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            <article class="blog-card" data-reveal data-delay="200">
                <div class="blog-card-img-wrap">
                    <img src="new_photos/training.jpeg" alt="First Aid Training" class="blog-card-img" loading="lazy">
                </div>
                <div class="blog-card-body">
                    <div class="blog-cat">Child Safety</div>
                    <h3 class="blog-title">Why First Aid Training is Non-Negotiable for Every Nanny</h3>
                    <p class="blog-excerpt">Safety and trust are the foundations of a happy home. Learn why first aid training is essential for every nanny.</p>
                    <div class="blog-meta">
                        <span>July 3, 2026</span>
                        <a href="blog/post-5.html" class="read-more">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            <article class="blog-card" data-reveal data-delay="300">
                <div class="blog-card-img-wrap">
                    <img src="new_photos/staff-profile.jpeg" alt="Professional Training" class="blog-card-img" loading="lazy">
                </div>
                <div class="blog-card-body">
                    <div class="blog-cat">Training</div>
                    <h3 class="blog-title">Why Professional Training Changes Everything</h3>
                    <p class="blog-excerpt">The profound difference between hiring "help" and welcoming a professional caregiver rooted in elite training.</p>
                    <div class="blog-meta">
                        <span>June 28, 2026</span>
                        <a href="blog/post-6.html" class="read-more">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        </div>
        <div class="text-center mt-4" data-reveal>
            <a href="blog/index.html" class="btn btn-outline">View All Articles</a>
        </div>
    </div>
</section>

<!-- 
     FAQ
 -->
<section class="section-pad bg-light" id="faq">
    <div class="container container-narrow">
        <div class="section-header centered" data-reveal>
            <h2 class="section-title">Before you get in <span>touch</span></h2>
        </div>
        <div class="faq-list" data-reveal>
            <div class="faq-item open">
                <div class="faq-q">
                    <span>How do you check your Staff?</span>
                    <span class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                </div>
                <div class="faq-a"><p>We do criminal background checks, call their references, verify previous employment, and sit down with them for a personal interview. If anything doesn't add up, they don't make it into our pool.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q">
                    <span>What training do your Staff get?</span>
                    <span class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                </div>
                <div class="faq-a"><p>They go through 10 modules - things like first aid, kitchen hygiene, how to use modern appliances, professional communication, and even basic financial skills. It takes about two weeks.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q">
                    <span>How long does it take to get matched?</span>
                    <span class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                </div>
                <div class="faq-a"><p>Usually 3 to 7 days after we talk. We'll send you a few candidates to choose from - you interview them and pick the one that feels right.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q">
                    <span>What if it doesn't work out?</span>
                    <span class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                </div>
                <div class="faq-a"><p>We'll work with you to understand what went wrong and find someone better suited. We do replacement placements if the match isn't working.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q">
                    <span>Do you only work in Nairobi?</span>
                    <span class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                </div>
                <div class="faq-a"><p>Nairobi is our main area. Just get in touch and we'll see what we can do.</p></div>
            </div>
        </div>
    </div>
</section>

<!-- 
     CTA BANNER
 -->
<section class="section-pad" id="cta">
    <div class="container">
        <div class="cta-banner" data-reveal>
            <h2>Need help at home? Let's talk.</h2>
            <p>Tell us what you're looking for and we'll match you with someone who fits. Most families find their person within a week.</p>
            <div class="cta-actions">
                <a href="https://wa.me/254118971254?text=Hello%20Haven%20Hands%2C%20I'd%20like%20to%20inquire%20about%20your%20services." target="_blank" rel="noopener noreferrer" class="btn btn-white btn-lg" id="cta-whatsapp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                    WhatsApp us now
                </a>
                <a href="contact.html" class="btn btn-outline-white btn-lg" id="cta-contact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Send us a message
                </a>
            </div>
        </div>
    </div>
</section>

</main>

<?php require 'includes/footer.php'; ?>
