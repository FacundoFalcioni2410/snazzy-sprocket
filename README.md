# Snazzy Sprocket — WordPress Theme

Custom WordPress theme for the Snazzy Sprocket agency site. Built with Tailwind CSS, ACF, and custom post types.

---

## Setup

### 1. Install LocalWP

Download and install [LocalWP](https://localwp.com/).

### 2. Create a site

Create a new site in LocalWP (default settings work fine).

### 3. Clone the repository

Inside your site's `wp-content/themes/` folder:

```bash
git clone <repo-url>
cd snazzy-sprocket
npm install
npm run build
```

This will create `wp-content/themes/snazzy-sprocket/` and build the CSS.

### 4. Activate the theme

Go to **WP Admin → Appearance → Themes** and activate **Snazzy Sprocket**.

### 5. Install ACF plugin

Go to **WP Admin → Plugins → Add New** and install **Advanced Custom Fields**.

### 6. Run the seeder

Open the LocalWP terminal (right-click your site → Open Site Shell) and run:

```bash
wp eval-file wp-content/themes/snazzy-sprocket/seed.php
```

This creates:
- 6 industry taxonomy terms + 6 technology taxonomy terms
- 9 case studies with Gutenberg content, ACF fields, featured images, and taxonomy assignments
- 10 team members with roles and bios
- About and Contact pages with correct templates assigned
- Homepage set as front page automatically
- Homepage, About, and Contact ACF field values

### 6. Assign page templates (if not set by seed)

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

## ACF Fields Reference

All custom fields are editable in WP Admin. Each section below shows the field name and its label.

### Homepage (front page)

| Field Name | Label | Type |
|---|---|---|
| `hero_headline` | Hero Headline | text |
| `hero_subheadline` | Hero Subheadline | text |
| `hero_cta_label` | Hero CTA Button Label | text |
| `hero_cta_url` | Hero CTA Button URL | url |
| `stat_1_number` | Stat 1 Number | text |
| `stat_1_label` | Stat 1 Label | text |
| `stat_2_number` | Stat 2 Number | text |
| `stat_2_label` | Stat 2 Label | text |
| `stat_3_number` | Stat 3 Number | text |
| `stat_3_label` | Stat 3 Label | text |
| `stat_4_number` | Stat 4 Number | text |
| `stat_4_label` | Stat 4 Label | text |
| `services_headline` | Services Section Headline | text |
| `services_description` | Services Section Description | textarea |
| `service_1_title` | Service 1 Title | text |
| `service_1_label` | Service 1 Label | text |
| `service_2_title` | Service 2 Title | text |
| `service_2_label` | Service 2 Label | text |
| `service_3_title` | Service 3 Title | text |
| `service_3_label` | Service 3 Label | text |
| `service_4_title` | Service 4 Title | text |
| `service_4_label` | Service 4 Label | text |
| `service_5_title` | Service 5 Title | text |
| `service_5_label` | Service 5 Label | text |
| `service_6_title` | Service 6 Title | text |
| `service_6_label` | Service 6 Label | text |
| `footer_tagline` | Footer Tagline | textarea |

### About Page

| Field Name | Label | Type |
|---|---|---|
| `about_hero_headline` | Hero Headline | text |
| `about_hero_subtext` | Hero Subtext | textarea |
| `agency_photo` | Team Photo | image |
| `value_1_title` | Value 1 — Title | text |
| `value_1_desc` | Value 1 — Description | textarea |
| `value_2_title` | Value 2 — Title | text |
| `value_2_desc` | Value 2 — Description | textarea |
| `value_3_title` | Value 3 — Title | text |
| `value_3_desc` | Value 3 — Description | textarea |
| `value_4_title` | Value 4 — Title | text |
| `value_4_desc` | Value 4 — Description | textarea |

### Contact Page

| Field Name | Label | Type |
|---|---|---|
| `contact_hero_headline` | Hero Headline | text |
| `contact_hero_subheadline` | Hero Subtext | textarea |
| `contact_email` | Email Address | email |
| `contact_phone` | Phone | text |
| `contact_office` | Office Address | text |
| `contact_hours` | Business Hours | text |
| `contact_map_embed` | Map Embed Code | textarea |
| `contact_twitter` | Twitter / X URL | url |
| `contact_linkedin` | LinkedIn URL | url |
| `contact_dribbble` | Dribbble URL | url |

### Case Study (CPT)

| Field Name | Label | Type |
|---|---|---|
| `is_featured` | Feature on Homepage | true/false |
| `client_name` | Client Name | text |
| `timeline` | Timeline | text |
| `services_provided` | Services Provided | text |
| `tagline` | Project Tagline | textarea |
| `hero_screenshot` | Hero Screenshot | image |

### Team Member (CPT)

| Field Name | Label | Type |
|---|---|---|
| `role` | Role / Title | text |
| `photo` | Photo | image |
| `bio` | Bio | textarea |
| `linkedin_url` | LinkedIn URL | url |

### Theme Customizer

| Setting | Where in WP Admin |
|---|---|
| Case Studies archive description | Appearance → Customize → Case Studies Archive |

---

## Content Editing Guide

| What to edit | Where in WP Admin |
|---|---|
| Case study narrative (challenge, solution, results) | Case Studies → edit post → Gutenberg editor |
| Homepage ACF fields | Pages → Home → Meta Boxes below editor |
| About page ACF fields | Pages → About → Meta Boxes below editor |
| Contact page ACF fields | Pages → Contact → Meta Boxes below editor |
| Team members | Team Members → edit post |
| Case Studies archive description | Appearance → Customize → Case Studies Archive |

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
