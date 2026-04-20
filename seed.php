<?php
/**
 * Demo content seed script.
 * Run once via WP-CLI: wp eval-file wp-content/themes/snazzy-sprocket/seed.php
 *
 * Creates: taxonomy terms, 9 case studies, 10 team members, homepage + about + contact ACF fields.
 */

if (!defined('ABSPATH')) {
    die('Run via WP-CLI only: wp eval-file wp-content/themes/snazzy-sprocket/seed.php');
}

// Required for media_sideload_image()
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * Download an image from $url, attach it to $post_id, and set as featured image.
 */
function seed_set_featured_image(int $post_id, string $url, string $desc): void {
    // Skip if featured image already set
    if (has_post_thumbnail($post_id)) return;

    $attachment_id = media_sideload_image($url, $post_id, $desc, 'id');
    if (is_wp_error($attachment_id)) {
        WP_CLI::warning("  Image failed ({$desc}): " . $attachment_id->get_error_message());
        return;
    }
    set_post_thumbnail($post_id, $attachment_id);
    WP_CLI::line("  Image set for: {$desc}");
}

// ─────────────────────────────────────────────
// 1. Taxonomy terms
// ─────────────────────────────────────────────
$industries = ['Healthcare', 'E-Commerce', 'SaaS', 'Non-Profit', 'Finance', 'Education'];
$technologies = ['WordPress', 'WooCommerce', 'React', 'Next.js', 'Tailwind CSS', 'ACF Pro'];

foreach ($industries as $name) {
    if (!term_exists($name, 'industry')) {
        wp_insert_term($name, 'industry');
        WP_CLI::line("Created industry: $name");
    }
}
foreach ($technologies as $name) {
    if (!term_exists($name, 'technology')) {
        wp_insert_term($name, 'technology');
        WP_CLI::line("Created technology: $name");
    }
}

// Helper to get term IDs by name
function seed_term_ids(array $names, string $taxonomy): array {
    $ids = [];
    foreach ($names as $name) {
        $term = get_term_by('name', $name, $taxonomy);
        if ($term) $ids[] = $term->term_id;
    }
    return $ids;
}

// ─────────────────────────────────────────────
// 2. Case Studies
// ─────────────────────────────────────────────
$case_studies = [
    [
        'image_url'  => 'https://picsum.photos/seed/medvista/800/480.jpg',
        'title'      => 'MedVista Patient Portal',
        'excerpt'    => 'A HIPAA-compliant patient portal that unified appointment scheduling, lab results, and secure provider messaging into a single, accessible platform.',
        'industries' => ['Healthcare'],
        'techs'      => ['WordPress', 'ACF Pro', 'Tailwind CSS'],
        'featured'   => true,
        'acf' => [
            'client_name'       => 'MedVista Health Systems',
            'timeline'          => '14 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'A HIPAA-compliant patient portal that unified appointment scheduling, lab results, and secure provider messaging into a single, accessible platform.',
            'challenge'         => '<p>MedVista Health Systems operates 12 clinics across three states. Their existing patient portal was built on a legacy .NET stack, required separate logins for scheduling and lab results, and had a 23% abandonment rate on the appointment booking flow.</p><p>Patients were calling the front desk for tasks that should have been self-service, costing the organization an estimated $180K per year in administrative overhead.</p>',
            'approach'          => '<p>We conducted stakeholder interviews with clinic administrators, front-desk staff, and a panel of 15 patients to map the complete user journey. Key findings:</p><ul><li>Patients over 65 accounted for 40% of portal usage but had the highest drop-off rates</li><li>Mobile usage had grown to 62% but the existing portal wasn\'t responsive</li><li>Providers wanted a way to share post-visit summaries directly through the portal</li></ul><p>We proposed a WordPress-based platform using ACF Pro for structured content management, a Tailwind CSS design system for consistent UI, and a headless integration layer for connecting to MedVista\'s EHR system via FHIR APIs.</p>',
            'solution'          => '<p>The new portal consolidates all patient-facing features into a single responsive application.</p><p><strong>Unified Dashboard:</strong> Appointments, lab results, and messages accessible from one screen.</p><p><strong>Smart Scheduling:</strong> Provider availability synced in real-time with the EHR, with intelligent time-slot suggestions.</p><p><strong>Accessible Design:</strong> WCAG 2.1 AA compliant, with large touch targets, high-contrast mode, and screen reader optimization.</p><p><strong>Secure Messaging:</strong> End-to-end encrypted provider messaging with file attachment support.</p>',
            'results_intro'     => 'Within 90 days of launch:',
            'results'           => '<ul><li>Appointment booking completion rate increased from 77% to 94%</li><li>Front-desk call volume decreased by 35%</li><li>Patient satisfaction scores rose from 3.2 to 4.6 out of 5</li><li>Mobile session duration increased 2.4x</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/threadline/800/480.jpg',
        'title'      => 'Threadline Apparel',
        'excerpt'    => 'High-converting storefront for a sustainable fashion brand with custom product filtering and lookbook integration.',
        'industries' => ['E-Commerce'],
        'techs'      => ['WooCommerce'],
        'featured'   => true,
        'acf' => [
            'client_name'       => 'Threadline Co.',
            'timeline'          => '10 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'High-converting storefront for a sustainable fashion brand with custom product filtering and lookbook integration.',
            'challenge'         => '<p>Threadline\'s existing Shopify store was limiting their ability to offer custom filtering by material, origin, and sustainability rating — features central to their brand story.</p>',
            'approach'          => '<p>We migrated to WooCommerce and built a custom faceted filtering system using a combination of product attributes and AJAX-powered UI. The lookbook was built as a custom post type with ACF.</p>',
            'solution'          => '<p>A fully custom WooCommerce theme with real-time product filtering, a shoppable lookbook, and a streamlined 2-step checkout flow.</p>',
            'results_intro'     => 'Post-launch results:',
            'results'           => '<ul><li>Conversion rate improved by 28%</li><li>Average order value increased by $14</li><li>Bounce rate on product pages dropped by 19%</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/nimbus/800/480.jpg',
        'title'      => 'Nimbus Analytics Dashboard',
        'excerpt'    => 'Real-time analytics dashboard integrating multiple data sources into a unified, actionable experience.',
        'industries' => ['SaaS'],
        'techs'      => ['React'],
        'featured'   => true,
        'acf' => [
            'client_name'       => 'Nimbus Data Inc.',
            'timeline'          => '16 Weeks',
            'services_provided' => 'Development, Strategy',
            'tagline'           => 'Real-time analytics dashboard integrating multiple data sources into a unified, actionable experience.',
            'challenge'         => '<p>Nimbus customers were toggling between 4 separate tools to get a complete picture of their pipeline. Churn was spiking at the 90-day mark, directly tied to dashboard fatigue.</p>',
            'approach'          => '<p>We ran a UX audit and competitive analysis, then prototyped a unified dashboard with progressive disclosure — surfacing the most critical metrics by default while letting power users drill into raw data.</p>',
            'solution'          => '<p>A React-based SPA with a WordPress headless CMS backend for managing chart configs and onboarding content. Real-time data via WebSocket connections to Nimbus\'s existing API layer.</p>',
            'results_intro'     => 'Within one quarter:',
            'results'           => '<ul><li>90-day churn dropped from 18% to 9%</li><li>Daily active users increased 41%</li><li>Support tickets related to "can\'t find data" decreased by 60%</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/greenroots/800/480.jpg',
        'title'      => 'GreenRoots Foundation',
        'excerpt'    => 'Donation platform and campaign hub for an environmental non-profit with 50K monthly visitors.',
        'industries' => ['Non-Profit'],
        'techs'      => ['WordPress'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'GreenRoots Foundation',
            'timeline'          => '8 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Donation platform and campaign hub for an environmental non-profit with 50K monthly visitors.',
            'challenge'         => '<p>GreenRoots was losing donations at the payment step due to an outdated, non-mobile-friendly form. Their campaign pages had no clear hierarchy, making it hard for visitors to understand the impact of their gift.</p>',
            'approach'          => '<p>We audited the donation funnel, identified 3 key drop-off points, and redesigned the flow around a single clear CTA per page with impact metrics front and center.</p>',
            'solution'          => '<p>Custom WordPress theme with Stripe-integrated donation forms, campaign landing page templates, and a recurring giving program module.</p>',
            'results_intro'     => 'After 60 days live:',
            'results'           => '<ul><li>Monthly donations increased by 47%</li><li>Mobile conversion rate tripled</li><li>Recurring donor sign-ups grew by 210%</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/meridian/800/480.jpg',
        'title'      => 'Meridian Wealth Portal',
        'excerpt'    => 'Client portal and marketing site for a wealth management firm with strict compliance needs.',
        'industries' => ['Finance'],
        'techs'      => ['Next.js'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'Meridian Advisory Group',
            'timeline'          => '20 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Client portal and marketing site for a wealth management firm with strict compliance needs.',
            'challenge'         => '<p>Meridian\'s compliance team required all client-facing content to go through a review workflow before publishing. Their existing CMS had no approval process, leading to legal risk and slow updates.</p>',
            'approach'          => '<p>We built a Next.js frontend with a headless WordPress CMS and a custom multi-step editorial workflow using ACF and WordPress user roles. Compliance reviewers get a dedicated approval interface.</p>',
            'solution'          => '<p>A statically generated marketing site with ISR, paired with a password-protected client portal for document sharing and portfolio summaries.</p>',
            'results_intro'     => 'Key outcomes:',
            'results'           => '<ul><li>Content approval time reduced from 5 days to same-day</li><li>Site performance score: 98 on Lighthouse</li><li>Zero compliance incidents in first year of operation</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/crestwood/800/480.jpg',
        'title'      => 'Crestwood University Redesign',
        'excerpt'    => 'Full redesign of a university website with course catalog, events, and faculty directory serving 30,000 students.',
        'industries' => ['Education'],
        'techs'      => ['WordPress', 'Tailwind CSS'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'Crestwood University',
            'timeline'          => '24 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Full redesign of a university website with course catalog, events, and faculty directory serving 30,000 students.',
            'challenge'         => '<p>The existing site had 14 years of content sprawl across 4 subsites, inconsistent navigation, and a course catalog that hadn\'t been updated since 2018. Prospective students were calling admissions for information that should have been findable in under 2 clicks.</p>',
            'approach'          => '<p>Information architecture audit of 2,400+ pages, a full content inventory, and stakeholder workshops with 6 departments to align on taxonomy and navigation.</p>',
            'solution'          => '<p>Unified WordPress multisite with a shared design system, ACF-powered course catalog, events calendar, and faculty directory with department filtering.</p>',
            'results_intro'     => 'First semester post-launch:',
            'results'           => '<ul><li>Prospective student inquiries via phone down 31%</li><li>Course catalog page views up 180%</li><li>Accessibility score improved from 54 to 97</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/artisankitchen/800/480.jpg',
        'title'      => 'Artisan Kitchen Co.',
        'excerpt'    => 'Artisanal kitchenware brand with headless WooCommerce backend and React storefront.',
        'industries' => ['E-Commerce'],
        'techs'      => ['WooCommerce', 'React'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'Artisan Kitchen Co.',
            'timeline'          => '12 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Artisanal kitchenware brand with headless WooCommerce backend and React storefront.',
            'challenge'         => '<p>The client wanted the flexibility of WooCommerce for inventory and fulfillment but needed a storefront that could match the premium feel of their handcrafted products.</p>',
            'approach'          => '<p>Decoupled architecture: WooCommerce as the commerce layer exposed via REST API, React for the frontend. Allows the team to iterate on the UI without touching the commerce logic.</p>',
            'solution'          => '<p>A headless React storefront with server-side rendering for SEO, real-time inventory, and a custom product configurator for engraving options.</p>',
            'results_intro'     => 'Post-launch:',
            'results'           => '<ul><li>Page load time dropped from 4.2s to 0.9s</li><li>Cart abandonment rate fell by 22%</li><li>Average session duration doubled</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/launchpadcrm/800/480.jpg',
        'title'      => 'Launchpad CRM',
        'excerpt'    => 'Marketing site and documentation platform for a CRM startup with interactive product tours.',
        'industries' => ['SaaS'],
        'techs'      => ['Next.js', 'Tailwind CSS'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'Launchpad Technologies',
            'timeline'          => '14 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Marketing site and documentation platform for a CRM startup with interactive product tours.',
            'challenge'         => '<p>Launchpad\'s self-serve trial sign-up rate was low because prospects couldn\'t understand the product\'s value without booking a demo. They needed an interactive way to show — not tell.</p>',
            'approach'          => '<p>We mapped the buyer journey and identified 3 "aha moments" in the product. The marketing site was designed to recreate those moments before signup.</p>',
            'solution'          => '<p>Next.js marketing site with embedded interactive product tours, a headless WordPress docs site, and an animated pricing calculator.</p>',
            'results_intro'     => '90-day results:',
            'results'           => '<ul><li>Trial sign-ups increased 83%</li><li>Demo requests dropped (users self-served instead)</li><li>Time-to-signup reduced from 8 days to 2</li></ul>',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/clearpath/800/480.jpg',
        'title'      => 'ClearPath Wellness',
        'excerpt'    => 'Multi-location wellness clinic with online booking, provider bios, and telehealth integration.',
        'industries' => ['Healthcare'],
        'techs'      => ['WordPress', 'React'],
        'featured'   => false,
        'acf' => [
            'client_name'       => 'ClearPath Wellness Centers',
            'timeline'          => '18 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Multi-location wellness clinic with online booking, provider bios, and telehealth integration.',
            'challenge'         => '<p>ClearPath had 8 locations with separate outdated websites, inconsistent branding, and no central booking system. Patients were confused about which location offered which services.</p>',
            'approach'          => '<p>Consolidation strategy: one WordPress multisite with shared components but location-specific content. Provider profiles and service pages managed via ACF.</p>',
            'solution'          => '<p>Unified brand site with location pages, a custom booking integration via Calendly API, provider directory with specialty filtering, and a telehealth portal link system.</p>',
            'results_intro'     => '6 months post-launch:',
            'results'           => '<ul><li>Online bookings up 340%</li><li>Phone booking volume down 28%</li><li>New patient registrations up 55%</li></ul>',
        ],
    ],
];

foreach ($case_studies as $data) {
    // Check if already exists
    $existing = get_page_by_title($data['title'], OBJECT, 'case_study');
    if ($existing) {
        // Still set the image if missing
        if (!empty($data['image_url'])) {
            seed_set_featured_image($existing->ID, $data['image_url'], $data['title']);
        }
        WP_CLI::line("Skipping (exists): {$data['title']}");
        continue;
    }

    $post_id = wp_insert_post([
        'post_title'   => $data['title'],
        'post_excerpt' => $data['excerpt'],
        'post_status'  => 'publish',
        'post_type'    => 'case_study',
    ]);

    if (is_wp_error($post_id)) {
        WP_CLI::warning("Failed: {$data['title']}");
        continue;
    }

    // Taxonomies
    wp_set_object_terms($post_id, seed_term_ids($data['industries'], 'industry'), 'industry');
    wp_set_object_terms($post_id, seed_term_ids($data['techs'], 'technology'), 'technology');

    // ACF fields
    foreach ($data['acf'] as $key => $value) {
        update_field($key, $value, $post_id);
    }
    update_field('is_featured', $data['featured'] ? 1 : 0, $post_id);

    // Featured image
    if (!empty($data['image_url'])) {
        seed_set_featured_image($post_id, $data['image_url'], $data['title']);
    }

    WP_CLI::success("Created case study: {$data['title']}");
}

// ─────────────────────────────────────────────
// 3. Team Members
// ─────────────────────────────────────────────
$team_members = [
    ['name' => 'Jordan Kim',    'role' => 'Founder & CEO',        'bio' => 'Full-stack strategist. 12 years in digital. Obsessed with performance budgets.'],
    ['name' => 'Sadie Patel',   'role' => 'Creative Director',    'bio' => 'Brand-obsessed designer. Turns complex systems into intuitive interfaces.'],
    ['name' => 'Marcus Chen',   'role' => 'Lead Engineer',        'bio' => 'WordPress core contributor. Writes code that other developers enjoy reading.'],
    ['name' => 'Aisha Robinson','role' => 'UX Researcher',        'bio' => 'Turns user interviews into actionable design recommendations.'],
    ['name' => 'Tomás Navarro', 'role' => 'Senior Developer',     'bio' => 'React and WordPress specialist. Accessibility advocate. Tailwind enthusiast.'],
    ['name' => 'Lily Whitfield','role' => 'Project Manager',      'bio' => 'Keeps timelines tight and stakeholders happy. Certified Scrum Master.'],
    ['name' => 'Derek Olsen',   'role' => 'SEO Strategist',       'bio' => 'Data nerd. Grew organic traffic 340% for a B2B client last quarter.'],
    ['name' => 'Rina Johal',    'role' => 'UI Designer',          'bio' => 'Design systems thinker. Ensures every component feels intentional and cohesive.'],
    ['name' => 'Eliot Fang',    'role' => 'DevOps Engineer',      'bio' => 'Manages infrastructure, CI/CD and deployment pipelines. Uptime is his love language.'],
    ['name' => 'Nina Brooks',   'role' => 'Content Strategist',   'bio' => 'Writes copy that converts. Believes every page should earn its place on the sitemap.'],
];

foreach ($team_members as $index => $member) {
    $existing = get_page_by_title($member['name'], OBJECT, 'team_member');
    if ($existing) {
        WP_CLI::line("Skipping (exists): {$member['name']}");
        continue;
    }

    $post_id = wp_insert_post([
        'post_title'  => $member['name'],
        'post_status' => 'publish',
        'post_type'   => 'team_member',
        'menu_order'  => $index,
    ]);

    if (is_wp_error($post_id)) {
        WP_CLI::warning("Failed: {$member['name']}");
        continue;
    }

    update_field('role', $member['role'], $post_id);
    update_field('bio',  $member['bio'],  $post_id);

    WP_CLI::success("Created team member: {$member['name']}");
}

// ─────────────────────────────────────────────
// 4. Ensure required pages exist
// ─────────────────────────────────────────────
$required_pages = [
    ['title' => 'About',   'slug' => 'about'],
    ['title' => 'Contact', 'slug' => 'contact'],
];

foreach ($required_pages as $pg) {
    if (!get_page_by_path($pg['slug'])) {
        $id = wp_insert_post([
            'post_title'  => $pg['title'],
            'post_name'   => $pg['slug'],
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);
        WP_CLI::success("Created page: {$pg['title']} (ID: $id)");
    } else {
        WP_CLI::line("Page exists: {$pg['title']}");
    }
}

flush_rewrite_rules();

// ─────────────────────────────────────────────
// 6. Homepage ACF fields
// ─────────────────────────────────────────────
$home_page = get_page_by_path('home') ?: get_page_by_path('/');
if (!$home_page) {
    // Try finding the front page
    $front_id = (int) get_option('page_on_front');
    if ($front_id) $home_page = get_post($front_id);
}

if ($home_page) {
    update_field('hero_headline',    'We engineer websites that <span class="text-accent">drive results</span>', $home_page->ID);
    update_field('hero_subheadline', 'Snazzy Sprocket crafts high-performance digital experiences for ambitious brands. Strategy, design, and engineering — all under one roof.', $home_page->ID);
    update_field('hero_cta_label',   'View Our Work', $home_page->ID);
    update_field('hero_cta_url',     home_url('/case-studies'), $home_page->ID);

    update_field('stats', [
        ['stat_number' => '120+',  'stat_label' => 'Projects Delivered'],
        ['stat_number' => '98%',   'stat_label' => 'Client Satisfaction'],
        ['stat_number' => '8 yrs', 'stat_label' => 'In Business'],
        ['stat_number' => '15',    'stat_label' => 'Industry Awards'],
    ], $home_page->ID);

    WP_CLI::success("Updated homepage ACF fields (ID: {$home_page->ID})");
} else {
    WP_CLI::warning("Homepage not found — create a page with slug 'home' and re-run, or set it as the front page first.");
}

// ─────────────────────────────────────────────
// 7. About page ACF fields
// ─────────────────────────────────────────────
$about_page = get_page_by_path('about');
if ($about_page) {
    update_field('about_hero_headline', "We're the team behind your next big launch.", $about_page->ID);
    update_field('about_hero_subtext',  "We believe the web should be fast, beautiful, and accessible to everyone. Eight years later, we're still proving it — one project at a time.", $about_page->ID);
    update_field('agency_headline',     'From side project to full-service agency', $about_page->ID);
    update_field('agency_story',        "<p>What started as two developers freelancing out of a co-working space has grown into a team of 10 specialists spanning design, engineering, and strategy.</p><p>We've worked with startups finding product-market fit, mid-market companies scaling their digital presence, and enterprise organizations modernizing legacy platforms.</p><p>Our approach is simple: understand the business problem first, then build the right solution — not the trendiest one. We write clean code, ship on time, and pick up the phone when things break.</p>", $about_page->ID);

    WP_CLI::success("Updated about page ACF fields.");
} else {
    WP_CLI::warning("About page not found — create a page with slug 'about' first.");
}

// ─────────────────────────────────────────────
// 8. Contact page ACF fields
// ─────────────────────────────────────────────
$contact_page = get_page_by_path('contact');
if ($contact_page) {
    update_field('contact_email',  'hello@snazzysprocket.com', $contact_page->ID);
    update_field('contact_phone',  '(215) 555-0147', $contact_page->ID);
    update_field('contact_office', '1247 Market Street, Suite 400, Philadelphia, PA 19107', $contact_page->ID);
    update_field('contact_hours',  'Monday – Friday, 9:00 AM – 6:00 PM EST', $contact_page->ID);

    WP_CLI::success("Updated contact page ACF fields.");
} else {
    WP_CLI::warning("Contact page not found — create a page with slug 'contact' first.");
}

WP_CLI::success("Seed complete!");
