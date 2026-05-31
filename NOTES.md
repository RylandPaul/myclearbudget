# MyClearBudget — Landing Page Notes

**File:** `index.html`
**Built:** 2026-05-30
**By:** OpenClaw (subagent)

---

## Design Decisions

### Color Palette
- **Primary:** `#1B2A4A` deep navy — trustworthy, serious, financial
- **Accent:** `#10B981` emerald green (Tailwind `emerald-500`) — chosen over teal `#2DD4BF`
  because emerald reads more "growth + money" and stays legible on light backgrounds
- **Accent dark:** `#059669` — used for hover states and gradient CTA section
- **Off-white:** `#F8FAFC` — alternating section backgrounds to add depth without jarring contrast

### Typography
- **Headlines:** `Sora` (Google Fonts) — bold, modern, confident without feeling "startup bro"
- **Body:** `Inter` — clean, highly legible, industry standard for SaaS and fintech
- `Playfair Display` was considered but felt too editorial/luxury for the paycheck-to-paycheck audience

### Layout
- Three-column grids collapse to single column at ≤900px (tablet) and ≤600px (mobile)
- Two email capture forms: hero and closing CTA — both `action="#"` placeholder
- Stats section in Problem uses visual weight to establish urgency without being alarmist
- Social proof area is a placeholder (4 avatar initials + copy) — update with real data

### Icons
- Feather Icons loaded via CDN (`feather-icons`) — SVG-based, MIT licensed, very lightweight
- Custom inline SVGs used for logo mark and a few cases where Feather had no exact match

### Headline Alternatives (in HTML comments, search for `HEADLINE OPTIONS FOR CEO REVIEW`)
- **Option A (active):** "Finally Know Where Your Money Goes"
- **Option B:** "Your Budget. Your Rules. Total Clarity."
- **Option C:** "Stop Guessing. Start Knowing. Take Control of Your Money."

---

## Placeholder Content to Replace Before Launch

| Location | Placeholder | Action Required |
|---|---|---|
| Hero proof strip | "Join hundreds of people..." | Update with real subscriber count |
| Problem stats | 78%, $1.1T, 1 in 3 | Verify with cited sources (CNBC, Federal Reserve, etc.) |
| Audience quotes | Italicized sample quotes | Replace with real customer quotes/testimonials |
| Form `action="#"` | Both email forms | Wire to real backend (see below) |
| Footer copyright | "Trailhead Standard, LLC" | Confirm legal entity name with CEO |
| Privacy Policy link | `href="#"` | Create real `/privacy` page |
| Terms link | `href="#"` | Create real `/terms` page |
| `<meta name="description">` | Generic description | Refine for SEO once messaging is locked |
| Favicon | None set | Add a `<link rel="icon">` with a real favicon |
| Open Graph tags | None | Add `og:title`, `og:image`, `og:description` for social sharing |

---

## Suggested Next Steps

### 1. Deploy to GitHub Pages (Fast, Free)
```bash
# From the myclearbudget/ folder:
git init
git add .
git commit -m "Initial landing page"
gh repo create myclearbudget-landing --public
git remote add origin https://github.com/RylandPaul/myclearbudget-landing.git
git push -u origin main
# Enable GitHub Pages in repo Settings → Pages → Deploy from main branch
```
Custom domain: buy `myclearbudget.com` on Namecheap/Cloudflare, add `CNAME` in repo root.

### 2. Wire Up the Email Form
**Option A: ConvertKit (Recommended for creators/early stage)**
- Free up to 1,000 subscribers
- Replace `action="#"` with ConvertKit embed form URL
- Gives you landing page, automation, and broadcast emails in one

**Option B: Mailchimp**
- Widely known, slightly clunkier free tier
- Good if you want a drag-drop email builder

**Option C: Loops.so (Modern, built for SaaS)**
- Clean API, Slack-style design, good for transactional + marketing
- Better than Mailchimp for SaaS / early-stage products

**Option D: Self-hosted with Resend + Supabase**
- Full control, cheapest at scale
- Requires a tiny serverless function to handle POST → insert to DB + send confirmation
- Good long-term option once you have a developer involved

### 3. Analytics
- Add [Plausible](https://plausible.io) or [Fathom](https://usefathom.com) — privacy-friendly, GDPR-safe
- Or just paste in the free Google Analytics 4 snippet
- At minimum, track: page views + form submission events

### 4. SEO Basics
Before launch, add to `<head>`:
```html
<meta property="og:title" content="MyClearBudget — Finally Know Where Your Money Goes" />
<meta property="og:description" content="A personal finance tool that gives you clarity and control over your money. No jargon. No fluff." />
<meta property="og:image" content="https://myclearbudget.com/og-image.png" />
<meta property="og:url" content="https://myclearbudget.com" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" href="/favicon.ico" />
```

### 5. A/B Test Headlines
Once you have traffic, test the 3 headline variants with a simple tool like:
- [VWO](https://vwo.com) (free tier)
- [Google Optimize](https://optimize.google.com) (being sunset, but still viable)
- Manually rotate with query params and Plausible goals

---

## File Size
- `index.html` is ~38 KB (all-in, no external files except CDN fonts + icons)
- Google Fonts and Feather Icons load from CDN — first paint is fast
- No JavaScript frameworks — no React, no Vue, nothing. Pure vanilla.
- Lighthouse score estimate: 95+ Performance, 100 Accessibility (with ARIA labels in place)

---

*Questions? Ping John Savage or the Trailhead Standard team.*
