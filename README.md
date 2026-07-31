# Haven Hands Services — cPanel Deployment & Email Setup Guide

This guide walks you through uploading the Haven Hands website to your cPanel hosting
and configuring email so that **job applications** (CV + passport photo) and **contact
form messages** reach you by email.

---

## 1. What's in this project

| File/folder                 | What it is                                                         |
| --------------------------- | ------------------------------------------------------------------ |
| `*.html` (root)             | The website pages: `index`, `about`, `services`, `workers`, `caregivers`, `pricing`, `contact` |
| `blog/`                     | Blog listing (`index.html`) + 6 article pages (`post-1.html` … `post-6.html`) |
| `style.css`                 | The single stylesheet used by every page                           |
| `main.js`                   | Site JavaScript: menus, hero slider, forms, animations             |
| `config.js`                 | *(removed — no longer used)*                                  |
| `send_staff_application.php`| PHP handler that emails **job applications** (caregivers.html)     |
| `send_contact.php`          | PHP handler that emails **contact form** inquiries (contact.html)  |
| `sitemap.xml`               | SEO sitemap for Google                                            |
| `robots.txt`                | SEO crawler rules                                                 |
| `.jpg` / `.jpeg` / `.png`   | Photos & images used by the pages                                  |
| `design-system.html`, `haven_hands_redesign_plan.html`, `instagram_planner.html` | Internal/reference pages (not indexed, safe to skip uploading) |

> Note: `implementation_plan.md`, `walkthrough.md`, `walkthrough_planned.md`, the `.docx`
> files, and the duplicate images (`.png` versions of `.jpg`s) are working files — you
> don't need to upload them.

---

## 2. Upload the site to cPanel

1. Log in to **cPanel** (e.g. `https://yourdomain.com:2083`).
2. Open **File Manager** → go to `public_html` (or the correct document root for your
   domain).
3. Upload **all** of the files below into `public_html`:
   - All root `.html` files
   - `style.css`, `main.js`
   - `send_staff_application.php`, `send_contact.php`
   - `sitemap.xml`, `robots.txt`
   - All image files (`.jpg`, `.jpeg`, `.png`) at the root
   - The **`blog/`** folder (with its `index.html` + `post-1.html`…`post-6.html`)
4. Open `https://yourdomain.com/` to confirm the site loads.
5. **Optional but recommended:** delete `design-system.html`, `haven_hands_redesign_plan.html`,
   and `instagram_planner.html` from the server (they are internal-only pages).

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
$SMTP_HOST     = 'mail.havenhandsservices.com';  // usually mail.yourdomain.com
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
2. Open `https://yourdomain.com/caregivers.html`, fill the form, attach a CV + photo, submit.
3. Check your Gmail inbox — you should receive the application with the attachments.

**If the email lands in Gmail's Spam folder**
- Enable **SPF & DKIM** (see Step 5) and re-test. Wait a few hours for DNS to propagate.

---

## 5. Configure SPF & DKIM (so emails don't go to spam)

1. In cPanel open **Email Deliverability**.
2. Find `havenhandsservices.com` and click **Manage**.
3. Confirm **SPF** and **DKIM** are **Enabled**. If anything is missing, click
   **Repair** / **Generate** and follow cPanel's instructions to add the DNS records.
4. DNS changes can take up to 24 hours to fully propagate.

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
$SMTP_HOST     = 'mail.havenhandsservices.com';
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
- [ ] `$TO_EMAIL` and `$SMTP_PASS` set in `send_staff_application.php`
- [ ] SPF & DKIM enabled (Email Deliverability)
- [ ] PHP upload limits raised to at least 8M
- [ ] Tested the **caregivers** form end-to-end (email received with attachments)
- [ ] Tested the **contact** form (EmailJS)
- [ ] `sitemap.xml` submitted in Google Search Console

---

## Troubleshooting

| Problem                                    | Likely fix                                                                 |
| ------------------------------------------ | -------------------------------------------------------------------------- |
| "Email sending failed" on caregivers form  | Wrong `$SMTP_PASS` or `$SMTP_HOST`. Check Email Deliverability + account password. |
| Email goes to Spam                         | Enable SPF/DKIM (Step 5) and wait for DNS propagation.                      |
| CV upload always fails                     | Raise `upload_max_filesize` / `post_max_size` (Step 6).                     |
| Contact form never sends                   | Wrong `$SMTP_PASS`/`$SMTP_HOST` in `send_contact.php`, or `send_contact.php` not uploaded. |
| PHP script shows raw text / 500 error      | Your host may not run PHP — enable PHP in cPanel → **Select PHP Version**.  |
| 404 on images                              | Keep the folder structure — all images must be at the root, `blog/` files inside `blog/`. |
