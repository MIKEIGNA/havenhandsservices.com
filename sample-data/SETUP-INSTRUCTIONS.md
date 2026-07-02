# Haven Hands Google Sheets Setup Guide

## Quick Start (5 minutes)

### Step 1: Create Google Sheet
1. Go to [Google Sheets](https://sheets.google.com)
2. Click **Blank** to create a new spreadsheet
3. Name it: `Haven Hands Content`

### Step 2: Create 5 Tabs
At the bottom of the sheet, click the **+** button to add tabs:
- Tab 1: `Caregivers`
- Tab 2: `Pricing`
- Tab 3: `Blog`
- Tab 4: `Testimonials`
- Tab 5: `FAQ`

### Step 3: Import Sample Data
For each tab:
1. Click on the tab name
2. Go to **File → Import**
3. Click **Upload** and select the corresponding CSV file from the `sample-data` folder
4. Choose **Replace current sheet** 
5. Click **Import data**

Import files in this order:
- `caregivers.csv` → Caregivers tab
- `pricing.csv` → Pricing tab
- `blog.csv` → Blog tab
- `testimonials.csv` → Testimonials tab
- `faq.csv` → FAQ tab

### Step 4: Publish to Web
For each tab:
1. Go to **File → Share → Publish to web**
2. Select the tab from the dropdown
3. Choose **Comma-separated values (.csv)**
4. Click **Publish**
5. Copy the URL (it looks like: `https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=0&single=true&output=csv`)

https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?output=csv

**Important:** The `gid` number changes for each tab:
- Caregivers: `gid=0`
- Pricing: `gid=1`
- Blog: `gid=2`
- Testimonials: `gid=3`
- FAQ: `gid=4`

### Step 5: Update data.js
Open `data.js` and replace the empty URLs in the SHEETS object:

```javascript
const SHEETS = {
    caregivers:  'YOUR_CAREGIVERS_URL',
    pricing:     'YOUR_PRICING_URL',
    blog:        'YOUR_BLOG_URL',
    testimonials:'YOUR_TESTIMONIALS_URL',
    faq:         'YOUR_FAQ_URL',
};
```

### Step 6: Test
1. Open your website in a browser
2. Check that content loads on each page
3. If content doesn't appear, open browser console (F12) to check for errors

---

## Adding/Editing Content

### Caregivers
| Column | Description | Example |
|--------|-------------|---------|
| name | Caregiver's full name | Grace Wanjiku |
| type | Position type | House Help, Nanny, Caregiver |
| status | Availability | available, booked, not-available, matched |
| featured | Show on homepage? | yes, no |
| experience | Years of experience | 3 years experience |
| description | Brief bio | Experienced house help... |
| image | Photo filename | worker-1.jpg |
| alt | Image alt text | Grace Wanjiku - House Help |
| order | Sort order (1 = first) | 1 |

### Pricing
| Column | Description | Example |
|--------|-------------|---------|
| name | Package name | Gold Package |
| section | Package type | employers, training |
| price | Price display | KES 8,000 |
| unit | Price unit | one-time, /month |
| features | Pipe-separated list | Feature 1\|Feature 2 |
| featured | Most Popular badge? | yes, no |
| buttonStyle | Button type | primary, outline |
| buttonLink | Button URL | contact.html |
| buttonText | Button text | Get Started |
| order | Sort order | 1 |

### Blog
| Column | Description | Example |
|--------|-------------|---------|
| title | Post title | How to Choose... |
| slug | URL-friendly name | choose-right-caregiver |
| category | Post category | Family, Safety, Training |
| date | Publication date | June 15 2026 |
| excerpt | Short summary | Finding the right... |
| content | Full HTML content | \<h2\>Title\</h2\>\<p\>Content... |
| image | Featured image | worker-1.jpg |
| featured | Featured post? | yes, no |
| order | Sort order | 1 |

### Testimonials
| Column | Description | Example |
|--------|-------------|---------|
| quote | Testimonial text | "Haven Hands made..." |
| authorName | Client name | Wanjiku Family |
| authorLocation | Location | Karen |
| active | Show on site? | yes, no |
| order | Sort order | 1 |

### FAQ
| Column | Description | Example |
|--------|-------------|---------|
| question | FAQ question | How do I request... |
| answer | FAQ answer | Simply browse... |
| section | Page location | index, pricing |
| openByDefault | Expanded by default? | yes, no |
| order | Sort order | 1 |

---

## Tips

1. **Cache clearing**: After editing, changes appear within 6 hours. To see changes immediately, open browser console and type: `HH.clearCache()`

2. **Image uploads**: Upload caregiver images to the root folder of your website (same folder as `index.html`). Use filenames like `worker-1.jpg`.

3. **Blog content**: Use HTML in the content column. Basic tags:
   - `<h2>Heading</h2>`
   - `<p>Paragraph</p>`
   - `<ul><li>List item</li></ul>`
   - `<strong>Bold text</strong>`

4. **Multiple staff**: Share the Google Sheet with your team. Anyone with edit access can update content.

5. **Mobile-friendly**: The website automatically adjusts for mobile devices.

---

## Troubleshooting

**Content not loading?**
- Check that URLs are correct in `data.js`
- Ensure the sheet is published to web
- Check browser console for errors (F12)

**Images not showing?**
- Verify image filename matches exactly (case-sensitive)
- Ensure image is uploaded to the correct folder

**Wrong order?**
- Edit the `order` column (lower numbers appear first)
- Clear cache with `HH.clearCache()`

---

## Need Help?

Contact Brightlab Technologies: [brightlab.africa](https://brightlab.africa)
