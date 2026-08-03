# Haven Hands Services — cPanel Deployment & Email Setup Guide

This guide walks you through uploading the Haven Hands website to your cPanel hosting
and configuring email so that **job applications** (CV + passport photo) and **contact
form messages** reach you by email.

---

## 1. What's in this project

| File/folder                 | What it is                                                         |
| --------------------------- | ------------------------------------------------------------------ |
| `*.php` (root)              | The website pages: `index`, `about`, `services`, `workers`, `caregivers`, `pricing`, `contact` — built with PHP includes |
| `includes/`                 | Shared partials: `head.php`, `header.php`, `footer.php` — edit the nav/footer once here, every page updates |
| `.htaccess`                 | Rewrites `.html` URLs to the `.php` files so existing URLs, canonicals and the sitemap keep working |
| `blog/`                     | Blog listing (`index.php`) + 6 article pages (`post-1.php` … `post-6.php`) |
| `style.css`                 | The single stylesheet used by every page                           |
| `main.js`                   | Site JavaScript: menus, hero slider, forms, animations             |
| `send_staff_application.php`| PHP handler that emails **job applications** (caregivers.html URL)  |
| `send_contact.php`          | PHP handler that emails **contact form** inquiries (contact.html URL) |
| `PHPMailer/`                | Bundled PHPMailer library — sends over SMTP since `mail()` is disabled on this host |
| `form-backups/`             | Failsafe folder — saves any submission that couldn't be emailed (protected by `.htaccess`) |
| `sitemap.xml`               | SEO sitemap for Google (still points to `.html` URLs — they work via the rewrite) |
| `robots.txt`                | SEO crawler rules                                                 |
| `.jpg` / `.jpeg` / `.png`   | Photos & images used by the pages                                  |
| `design-system.html`, `haven_hands_redesign_plan.html`, `instagram_planner.html` | Internal/reference pages (not indexed, safe to skip uploading) |

> **Why PHP?** The header, navigation, and footer used to be duplicated in every page.
> Now they live once in `includes/`, so editing them in one place updates the whole site.
> Pages use root-relative paths (`/style.css`, `/about.html`) — this assumes the site is
> installed at the domain root (public_html), which is the normal cPanel setup.

> Note: `implementation_plan.md`, `walkthrough.md`, `walkthrough_planned.md`, the `.docx`
> files, and the duplicate images (`.png` versions of `.jpg`s) are working files — you
> don't need to upload them.

---

## 2. Upload the site to cPanel

1. Log in to **cPanel** (e.g. `https://yourdomain.com:2083`).
2. Open **File Manager** → go to `public_html` (or the correct document root for your
   domain).
3. Upload **all** of the files below into `public_html`:
   - All root `.php` files
   - The **`includes/`** folder (head.php, header.php, footer.php)
   - The **`.htaccess`** file (enables the `.html` → `.php` rewrite)
   - `style.css`, `main.js`
   - `send_staff_application.php`, `send_contact.php`
   - The **`form-backups/`** folder (contains its own `.htaccess` guard — upload it too)
   - `sitemap.xml`, `robots.txt`
   - All image files (`.jpg`, `.jpeg`, `.png`) at the root
   - The **`blog/`** folder (with `index.php` + `post-1.php`…`post-6.php`)
4. **Remove the old `.html` files** from `public_html` and `blog/` (index.html, about.html,
   … and the old post-*.html) — the rewrite serves the `.php` files for those URLs.
   If an old `.html` file is still present, it will be served instead.
5. Open `https://yourdomain.com/` to confirm the site loads.
6. **Optional but recommended:** delete `design-system.html`, `haven_hands_redesign_plan.html`,
   and `instagram_planner.html` from the server (they are internal-only pages).

### Local testing (XAMPP)

The site auto-detects its install folder, so it works both at the domain root (cPanel) and
in a local subfolder:

- Copy the whole project into `C:\xampp\htdocs\hands` (or any subfolder)
- Open `http://localhost/hands/`
- `includes/config.php` computes the base path automatically (e.g. `/hands/` locally, `/`
  on production) — no manual config needed
- Remember to copy your PHP files (including `send_*.php`, `includes/`, `.htaccess`) after
  making changes, and keep the old `.html` files removed

---

## 3. Set up your email accounts (cPanel)

1. In cPanel open **Email Accounts**.
2. Create (or confirm) the account **`info@havenhandsservices.com`**. This is the
   *sender* — the account the website uses to send emails.
3. Note the **password** you set for it — you need it in Step 4.
4. Recommended: create an **alias/forwarder** or simply use your **Gmail** inbox as the
   destination for applications (set in Step 4).

---

## 4. Configure job applications email (PHP handler)

The file `send_staff_application.php` is the handler for the **caregivers / job
application form**. Open it in a text editor and edit the top section:

```php
$TO_EMAIL      = 'YOUR_GMAIL@gmail.com';   // ← your Gmail inbox (receives applications)
$SENDER_EMAIL  = 'info@havenhandsservices.com';
$SMTP_HOST     = 'localhost';                 // same server; mail.havenhandsservices.com also works
$SMTP_PORT     = 465;                       // 465 (SSL) or 587 (STARTTLS)
$SMTP_SECURE   = 'ssl';                     // 'ssl' for 465, 'tls' for 587
$SMTP_USER     = $SENDER_EMAIL;
$SMTP_PASS     = 'YOUR_EMAIL_PASSWORD';     // ← password of info@havenhandsservices.com
```

**How it works**
- The form on `caregivers.html` posts to this file with all fields plus the **CV** and
  **passport photo** as file uploads.
- The script sends the email via **SMTP** using **PHPMailer** if it's available on the
  server, and automatically falls back to PHP's built-in `mail()` if not — so it works
  out of the box on almost any cPanel host.

**Upload & test**
1. After editing, upload `send_staff_application.php` to `public_html`.
2. **This host has `mail()` disabled**, so you must also upload the bundled **`PHPMailer/`**
   folder (contains `src/PHPMailer.php`, `src/SMTP.php`, `src/Exception.php`) into
   `public_html` — the handlers detect it there and send over SMTP instead.
3. Open `https://yourdomain.com/caregivers.html`, fill the form, attach a CV + photo, submit.
4. Check your Gmail inbox — you should receive the application with the attachments.
5. If it still doesn't send, open `public_html/form-backups/…/debug.txt` — it records
   `mail_function_exists`, `phpmailer_available`, and any `smtp_error`, which tells us
   exactly what to change (port/secure mode/account).

**If the email lands in Gmail's Spam folder**
- Enable **SPF & DKIM** (see Step 5) and re-test. Wait a few hours for DNS to propagate.

---

## 5. Configure SPF & DKIM (so emails don't go to spam)

**This domain needs 2 DNS records updated in Cloudflare** (your DNS is on Cloudflare —
`archer`/`peaches.ns.cloudflare.com` — so the cPanel "Email Deliverability" suggestions
must be added there, not in cPanel). The current Cloudflare records don't match the
cPanel mail server, which is why email isn't being delivered.

In **Cloudflare → DNS → Records**:

1. **DKIM** — replace the existing `default._domainkey.havenhandsservices.com` TXT with the
   value cPanel suggests (Email Deliverability → Manage → DKIM). It changes every time the
   server's key is regenerated, so copy it fresh from cPanel. It looks like:
   `v=DKIM1; k=rsa; p=MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwg4Q8...`
2. **SPF** — edit the `havenhandsservices.com` TXT to add the server IP:
   `v=spf1 +a +mx +ip4:102.212.246.90 +include:_spf.truehostcloud.com ~all`
3. **DMARC** — already present (`v=DMARC1; p=quarantine; …`); it will validate once SPF/DKIM
   are correct.

DNS changes take a few minutes to a few hours on Cloudflare. After they propagate, re-check
cPanel → **Email Deliverability** — all three should show green.

> The mail server's HELO is `das118.truehost.cloud`, and the PTR is valid, so the remaining
> requirements are just the correct DKIM + SPF records above.

---

## 6. Raise the file upload size limit (important for CVs)

The form allows a CV up to **5MB**, but many cPanel hosts cap PHP uploads at **2MB** by
default. If large CV uploads fail:

1. In cPanel open **MultiPHP INI Editor** (sometimes called "PHP Version" → options).
2. Select the domain and set:
   - `upload_max_filesize = 8M`
   - `post_max_size = 8M`
3. Save. (You can also add these as `php_value` lines in an `.htaccess` file.)

---

## 7. Configure the contact form email (PHP handler)

The **contact form** (contact.html) also uses the same cPanel email approach — it posts
to `send_contact.php`, which has its own config block at the top:

```php
$TO_EMAIL      = 'YOUR_GMAIL@gmail.com';   // ← your Gmail inbox (receives inquiries)
$SENDER_EMAIL  = 'info@havenhandsservices.com';
$SMTP_HOST     = 'localhost';                 // same server
$SMTP_PORT     = 465;                       // 465 (SSL) or 587 (STARTTLS)
$SMTP_SECURE   = 'ssl';
$SMTP_USER     = $SENDER_EMAIL;
$SMTP_PASS     = 'YOUR_EMAIL_PASSWORD';     // ← password of info@havenhandsservices.com
```

**Set the same `$SMTP_*` values as in `send_staff_application.php`**, then upload
`send_contact.php` to `public_html` and test the contact form.

> Both PHP handlers share the same setup: they use **PHPMailer** over SMTP when available
> and fall back to PHP's built-in `mail()` otherwise. No EmailJS, no third-party service —
> everything goes through your own cPanel email account.

---

## 7b. Email failsafe (no lost submissions)

Both PHP handlers use a **save-first** design: the submission (and any uploaded
CV/passport photo) is **saved to `form-backups/` immediately on submit**, *before* email
is even attempted. Email is then tried via `mail()` (cPanel local Exim, DKIM-signed) or,
if unavailable, PHPMailer over SMTP.

- If the email **sends** → the saved copy is removed automatically.
- If the email **fails** (e.g. `mail()` is disabled on the host, or SMTP is blocked) →
  the saved copy stays on the server. The visitor still sees a success message, because
  their data was captured.

This means a server restriction can **never cause a 500** or lose a submission — worst
case, the application/inquiry sits in `form-backups/` for you to check.

- **Job applications** → saved to `form-backups/applications/…` (fields + CV + photo)
- **Contact inquiries** → saved to `form-backups/contact/…`

**To check for unsent submissions:** cPanel → **File Manager** →
`public_html/form-backups/` → open the timestamped folders' `submission.json` (and files).

> **Privacy note:** `form-backups` contains personal data (CVs, ID/passport photos).
> Keep the `.htaccess` in that folder, and back up or delete old submissions regularly.

---

## 8. Submit the site to Google (SEO)

Once the site is live:

1. Go to [Google Search Console](https://search.google.com/search-console).
2. Add your property (domain or URL prefix).
3. Verify ownership (use DNS TXT or HTML tag — cPanel can help add DNS records).
4. Under **Sitemaps**, submit: `https://yourdomain.com/sitemap.xml`
5. Google will also read `robots.txt`, which allows crawling and points to the sitemap.

---

## 9. Quick checklist before launch

- [ ] Site loads at `https://yourdomain.com/`
- [ ] `info@havenhandsservices.com` email account exists
- [ ] `$TO_EMAIL` and `$SMTP_PASS` set in `send_staff_application.php` **and** `send_contact.php`
- [ ] SPF & DKIM enabled (Email Deliverability)
- [ ] PHP upload limits raised to at least 8M
- [ ] `form-backups/` folder uploaded (with `.htaccess`)
- [ ] Tested the **caregivers** form end-to-end (email received with attachments)
- [ ] Tested the **contact** form (email received)
- [ ] `sitemap.xml` submitted in Google Search Console

---

## Troubleshooting

| Problem                                    | Likely fix                                                                 |
| ------------------------------------------ | -------------------------------------------------------------------------- |
| `.html` URL returns 404                    | `.htaccess` not uploaded or `mod_rewrite` off. Re-upload `.htaccess`; if still failing, ensure the matching `.php` file exists. |
| Page shows raw PHP code                    | PHP not enabled for the folder — enable PHP in cPanel → **Select PHP Version** (apply to the domain). |
| Nav/footer look broken                     | The `includes/` folder wasn't uploaded, or a page is missing its `require` lines. |
| "Email sending failed" on caregivers form  | Wrong `$SMTP_PASS` or `$SMTP_HOST`. Check Email Deliverability + account password. |
| Email goes to Spam                         | Enable SPF/DKIM (Step 5) and wait for DNS propagation.                      |
| CV upload always fails                     | Raise `upload_max_filesize` / `post_max_size` (Step 6).                     |
| Contact form never sends                   | Wrong `$SMTP_PASS`/`$SMTP_HOST` in `send_contact.php`, or `send_contact.php` not uploaded. |
| Submission saved but no email received     | Email failed → it's in `form-backups/`. Check File Manager; fix SMTP config, then re-send manually. |
| 404 on images                              | Keep the folder structure — all images must be at the root, `blog/` files inside `blog/`. |
