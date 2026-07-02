# Haven Hands Website Revamp — Implementation Plan

## Overview

A complete rebuild of **havenhandsservices.com** as a clean, new set of static HTML/CSS/JS files in the same directory. The revamped site will use the brand-correct teal palette (`#006A71`), feature all the new deliverables (Workers/housekeeper profiles, blog section, WhatsApp integration, branded contact form, testimonials, "How It Works", trust badges), and be structured so that any non-technical person can edit content easily.

> [!IMPORTANT]
> **No PHP — Pure HTML/CSS/JS**: PHP is not needed and adds deployment friction. A static site can do everything required (blog, profiles, contact form via EmailJS). Blog articles will be separate HTML files in a `blog/` folder — easy to duplicate and edit. Staff profiles will be editable card snippets in a single `workers.html` file.

> [!IMPORTANT]
> **Separate new build, original preserved**: All new files will be created fresh in the same root directory. The old files (index.html, style1bce.css, etc.) will remain untouched until you're ready to swap in.

---

## Key Issues Identified in Current Site

| Problem | Detail |
|---|---|
| **Wrong brand colors** | CSS uses purple/pink HSL instead of `#006A71` teal |
| **Google Form CTA** | Sends users off-site — kills conversions |
| **No testimonials** | Zero social proof shown anywhere |
| **No Staff profile cards** | "Staff" page only talks about training, no actual worker listings |
| **No blog section** | Missed major SEO opportunity |
| **No WhatsApp button** | Direct communication channel missing |
| **No "How It Works"** | Process is unclear, creates friction |
| **No trust stats/badges** | No credibility signals |
| **Header not sticky** | User loses nav on scroll |
| **Duplicated footer** | Code copied into every file — harder to maintain |
| **HTTrack mirror artifacts** | `cdn-cgi` paths, email obfuscation, Cloudflare beacon all in source |

---

## New Site Structure

```
havenhandsservices.com/
├── index.html          ← Revamped homepage (replaces current)
├── about.html          ← Revamped about page
├── services.html       ← Revamped services page
├── workers.html        ← NEW: Housekeeper profiles (replaces workers.html concept)
├── workers.html     ← Revamped: For job-seekers / join us
├── pricing.html        ← Revamped pricing page
├── contact.html        ← Revamped contact with branded form + WhatsApp
├── blog/
│   ├── index.html      ← NEW: Blog listing page
│   └── post-1.html     ← NEW: First blog article (template)
├── style.css           ← NEW master stylesheet (teal brand palette, clean)
└── main.js             ← NEW enhanced JS (sticky nav, animations, form, WhatsApp)
```

---

## Design System

- **Primary Teal**: `#006A71`
- **Secondary Grey**: `#A6A8AB`
- **White**: `#FFFFFF`
- **Dark text**: `#1a2e2f`
- **Light bg**: `#f0f7f7`
- **Font**: `Outfit` (headings) + `Inter` (body) — same as current, good choice
- **Header**: Fixed/sticky, glass-morphism, teal-accented
- **Buttons**: Solid teal primary, outlined secondary
- **WhatsApp FAB**: Fixed floating button bottom-right

---

## Pages to Create

### [NEW] style.css
Complete design system rebuilt around teal. Includes sticky nav, all new section styles, blog cards, worker profile cards, WhatsApp FAB, testimonial cards, trust badge strip.

### [NEW] main.js
Enhanced JS: sticky header, mobile menu, scroll animations, contact form (EmailJS), WhatsApp click tracking, FAQ accordion, blog search filter.

---

### [NEW] index.html — Homepage
Sections:
1. **Hero** — Strong headline, sub-text, two CTAs ("Find a Staff" → contact, "See Our Workers" → workers.html), hero image
2. **Trust Strip** — Logos/stats: "100+ Placements", "3–7 Day Match", "Background Checked", "Nairobi-Based"
3. **Services Overview** — Cards: Full-time House Help, Professional Nannies, Childcare Support
4. **How It Works** — 4-step process: Consult → Match → Interview → Place
5. **Why Haven Hands** — 3 feature cards: Thorough Vetting, Expert Training, Ongoing Support
6. **Featured Staff** — 3 preview profile cards linking to workers.html
7. **Testimonials** — 3–4 client testimonial cards with stars and names
8. **Blog Preview** — 3 latest article cards linking to blog/
9. **WhatsApp CTA** — Banner with direct WhatsApp link
10. **Contact CTA** — "Ready to find help?" with form or link to contact.html
11. **FAQ Accordion** — 5 expandable Q&A items
12. **Footer** — Full footer with nav links, socials, contact, copyright

---

### [NEW] workers.html — Housekeeper/Staff Profiles (Client-facing)
> [!NOTE]
> This is the major new page. Each card represents a real or sample worker. Structure is made dead-simple for editing — just copy-paste a `<div class="worker-card">` block and change the name/details.

Sections:
1. **Page Hero** — "Meet Our Staff" headline, filter bar
2. **Filter Controls** — Buttons: All | Nanny | House Help | Childcare (JS-powered filter)
3. **Worker Grid** — Cards with: photo placeholder, name, specialty tag, experience, skills chips, "Request Interview" button (→ WhatsApp or contact.html)
4. **CTA** — "Don't see the right fit? We'll find them for you."

---

### [NEW] blog/index.html — Blog Listing
Sections:
1. **Page Hero** — "Insights & Tips" headline
2. **Featured Post** — Large card for first article
3. **Article Grid** — Cards with: image, category tag, date, title, excerpt, "Read More"
4. **Newsletter CTA** — Simple email capture or WhatsApp link

### [NEW] blog/post-1.html — Blog Article Template
- Full article layout with sidebar
- Category, date, author
- Table of contents
- Related articles at bottom
- CTA at end: "Need a Staff? Contact us"

---

### [MODIFY] about.html — Fully Revamped
- Correct brand colors
- Mission/Vision cards
- Stats counter section (years, placements, Staff trained)
- Team/founder section

### [MODIFY] services.html — Fully Revamped
- Detail cards for each service with full training modules list
- Visual process diagram
- Per-service pricing CTA

### [MODIFY] pricing.html — Revamped
- Same packages (Silver/Bronze/Gold) with better card design
- Teal featured card for Gold
- FAQ below pricing

### [MODIFY] contact.html — Branded Contact Form + WhatsApp
- Remove Google Form dependency
- Branded form: Name, Email, Phone, Service Type, Message
- EmailJS integration (same config.js approach)
- WhatsApp button prominent: "Chat on WhatsApp"
- Contact info cards

### [MODIFY] workers.html — For Job Seekers
- "Join Our Team" focus
- Full training modules (all 10 from brief)
- Application flow
- Apply button → WhatsApp or Google Form

---

## Key Features

### WhatsApp Integration
- **Floating Action Button** (fixed, bottom-right) on all pages: green WhatsApp button
- **Number**: `+254118971254`
- Pre-filled message: "Hello Haven Hands, I'd like to inquire about your services."

### Branded Contact Form
- Fields: Full Name, Email, Phone Number, Service Needed, Message
- Powered by EmailJS (existing config.js setup, same keys)
- Success/error states with smooth UI feedback

### Blog Section (Easy to Edit)
- Each blog post = one HTML file in `blog/`
- A simple HTML comment block at the top of each post file marks editable fields (title, date, content)
- Listing page reads no database — it's just static cards, manually maintained (simplest approach)

### Worker Profiles (Easy to Edit)
- All profiles in one file (`workers.html`)
- Clear HTML comment: `<!-- ADD A NEW WORKER: copy the block below and fill in details -->`
- Each card uses only basic HTML, no JS required to add a new one

---

## Verification Plan

### Manual Verification
- Open `index.html` locally in browser and check all sections render correctly
- Test mobile responsive layout at 375px width
- Test WhatsApp floating button opens correct link
- Test contact form submission flow
- Test blog navigation (listing → article → back)
- Test workers filter buttons (All / Nanny / House Help)
- Verify teal brand color `#006A71` is used consistently throughout
- Check sticky header on scroll
- Verify FAQ accordion expand/collapse works
