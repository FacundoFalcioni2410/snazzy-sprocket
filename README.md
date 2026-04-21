# Snazzy Sprocket — WordPress Theme

Custom WordPress theme for the Snazzy Sprocket agency site. Built with Tailwind CSS, ACF, and custom post types.

---

## Prerequisites

- [LocalWP](https://localwp.com/) (or any local WordPress environment)
- Node.js 18+ and npm
- WordPress plugins installed and activated:
  - **Advanced Custom Fields** (free version)
  - WP-CLI (bundled with LocalWP)

---

## Local Setup

### 1. Clone the repo

From inside your WordPress installation's `wp-content/themes/` folder, run:

```bash
git clone <repo-url>
```

This will create `wp-content/themes/snazzy-sprocket/` automatically.

### 2. Install dependencies

```bash
cd wp-content/themes/snazzy-sprocket
npm install
```

### 3. Build Tailwind CSS

```bash
npm run build
```

### 4. Activate the theme

Go to **WP Admin → Appearance → Themes** and activate **Snazzy Sprocket**.

### 5. Seed demo content

Open the LocalWP terminal (right-click your site → Open Site Shell) and run:

```bash
wp eval-file wp-content/themes/snazzy-sprocket/seed.php
```

This creates:
- 6 industry taxonomy terms + 6 technology taxonomy terms
- 9 case studies with Gutenberg content, ACF fields, featured images, and taxonomy assignments
- 10 team members with roles and bios
- About and Contact pages with correct templates assigned
- Homepage, About, and Contact ACF field values

### 6. Set the front page (required for ACF fields)

The homepage template (`front-page.php`) loads automatically without a page. However, to make the ACF fields (hero headline, stats, services) editable in WP Admin, a page must be set as the front page:

1. Create a page (title can be anything, e.g. "Home")
2. Go to **WP Admin → Settings → Reading**
3. Set "Your homepage displays" → **A static page** → select that page

The ACF fields will then appear when editing that page.

### 7. Assign page templates (if not set by seed)

- **About** page → Page Attributes → Template → **About Page**
- **Contact** page → Page Attributes → Template → **Contact Page**

---

## Project Structure

```
snazzy-sprocket/
├── dist/
│   ├── css/app.css          # Compiled Tailwind (git-ignored)
│   └── js/app.js            # Vanilla JS (mobile nav + filters)
├── src/
│   └── css/app.css          # Tailwind source with @layer components
├── template-parts/
│   ├── hero.php             # Homepage hero
│   ├── services.php         # Homepage services grid
│   ├── featured-cases.php   # Homepage case study teasers
│   ├── cta-banner.php       # Bottom CTA section
│   ├── case-study-card.php  # Reusable case study card
│   └── team-member-card.php # Team member card with avatar fallback
├── front-page.php           # Homepage
├── page-about.php           # About page template
├── page-contact.php         # Contact page template
├── archive-case_study.php   # Case studies listing + filters
├── single-case_study.php    # Single case study
├── functions.php            # CPTs, taxonomies, ACF fields, enqueue
├── header.php               # Sticky nav with mobile hamburger
├── footer.php               # Footer with links
├── tailwind.config.js       # Brand design tokens
├── seed.php                 # Demo content seed script
└── package.json
```

---

## Content Editing Guide

| What to edit | Where in WP Admin |
|---|---|
| Case study narrative (challenge, solution, results) | Case Studies → edit post → Gutenberg editor |
| Case study meta (client, timeline, services) | Case Studies → edit post → Meta Boxes below editor |
| Team members | Team Members → edit post |
| About page story | Pages → About → Gutenberg editor |
| About page hero, values | Pages → About → Meta Boxes below editor |
| Contact info (email, phone, address) | Pages → Contact → Meta Boxes below editor |
| Homepage hero, stats, services | Pages → your front page → Meta Boxes below editor |
| Case studies archive description | Appearance → Customize → Case Studies Archive |

---

## npm Scripts

| Command | Description |
|---|---|
| `npm run build` | Compiles and minifies Tailwind CSS into `dist/css/app.css` |
| `npm run dev` | Optional watch mode — recompiles on every file save during development |

---

## Custom Post Types

- **case_study** — archive at `/case-studies/`, filterable by industry and technology
- **team_member** — displayed in the About page team grid

## Taxonomies

- **industry** — e.g. Healthcare, E-Commerce, SaaS (attached to case_study)
- **technology** — e.g. WordPress, React, Next.js (attached to case_study)
