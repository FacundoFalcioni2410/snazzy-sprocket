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
    if (has_post_thumbnail($post_id)) return;

    $attachment_id = media_sideload_image($url, $post_id, $desc, 'id');
    if (is_wp_error($attachment_id)) {
        WP_CLI::warning("  Image failed ({$desc}): " . $attachment_id->get_error_message());
        return;
    }
    set_post_thumbnail($post_id, $attachment_id);
    WP_CLI::line("  Image set for: {$desc}");
}

/**
 * Download an image and set it as an ACF image field value.
 */
function seed_set_acf_image(int $post_id, string $acf_key, string $url, string $desc): void {
    if (get_field($acf_key, $post_id)) return;

    $attachment_id = media_sideload_image($url, $post_id, $desc, 'id');
    if (is_wp_error($attachment_id)) {
        WP_CLI::warning("  ACF image failed ({$desc}): " . $attachment_id->get_error_message());
        return;
    }
    update_field($acf_key, $attachment_id, $post_id);
    WP_CLI::line("  ACF image set ({$acf_key}): {$desc}");
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
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>MedVista Health Systems operates 12 clinics across three states. Their existing patient portal was built on a legacy .NET stack, required separate logins for scheduling and lab results, and had a 23% abandonment rate on the appointment booking flow.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Patients were calling the front desk for tasks that should have been self-service, costing the organization an estimated $180K per year in administrative overhead.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We conducted stakeholder interviews with clinic administrators, front-desk staff, and a panel of 15 patients to map the complete user journey. Key findings:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Patients over 65 accounted for 40% of portal usage but had the highest drop-off rates</li><li>Mobile usage had grown to 62% but the existing portal wasn\'t responsive</li><li>Providers wanted a way to share post-visit summaries directly through the portal</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>The new portal consolidates all patient-facing features into a single responsive application. <strong>Unified Dashboard:</strong> Appointments, lab results, and messages accessible from one screen. <strong>Smart Scheduling:</strong> Provider availability synced in real-time with the EHR. <strong>Accessible Design:</strong> WCAG 2.1 AA compliant with large touch targets and high-contrast mode. <strong>Secure Messaging:</strong> End-to-end encrypted provider messaging with file attachment support.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Within 90 days of launch:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Appointment booking completion rate increased from 77% to 94%</li><li>Front-desk call volume decreased by 35%</li><li>Patient satisfaction scores rose from 3.2 to 4.6 out of 5</li><li>Mobile session duration increased 2.4x</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'MedVista Health Systems',
            'timeline'          => '14 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'A HIPAA-compliant patient portal that unified appointment scheduling, lab results, and secure provider messaging into a single, accessible platform.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/threadline/800/480.jpg',
        'title'      => 'Threadline Apparel',
        'excerpt'    => 'High-converting storefront for a sustainable fashion brand with custom product filtering and lookbook integration.',
        'industries' => ['E-Commerce'],
        'techs'      => ['WooCommerce'],
        'featured'   => true,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Threadline\'s existing Shopify store was limiting their ability to offer custom filtering by material, origin, and sustainability rating — features central to their brand story. Customers couldn\'t narrow down products the way the brand needed them to, and the checkout flow had a 34% abandonment rate.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We migrated to WooCommerce and built a custom faceted filtering system using a combination of product attributes and AJAX-powered UI. The lookbook was built as a custom post type with ACF, letting the editorial team create shoppable editorial content without developer help.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Audited all 340 SKUs and mapped them to a new attribute taxonomy</li><li>Prototyped the filter UI with 12 target customers before building</li><li>Integrated with the brand\'s existing Klaviyo email flows</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>A fully custom WooCommerce theme with real-time product filtering, a shoppable lookbook, and a streamlined 2-step checkout flow. The new experience lets customers filter by material, country of origin, and sustainability certification simultaneously.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Post-launch results over 60 days:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Conversion rate improved by 28%</li><li>Average order value increased by $14</li><li>Bounce rate on product pages dropped by 19%</li><li>Lookbook pages drove 23% of total revenue in the first month</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Threadline Co.',
            'timeline'          => '10 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'High-converting storefront for a sustainable fashion brand with custom product filtering and lookbook integration.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/nimbus/800/480.jpg',
        'title'      => 'Nimbus Analytics Dashboard',
        'excerpt'    => 'Real-time analytics dashboard integrating multiple data sources into a unified, actionable experience.',
        'industries' => ['SaaS'],
        'techs'      => ['React'],
        'featured'   => true,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Nimbus customers were toggling between 4 separate tools to get a complete picture of their pipeline. Churn was spiking at the 90-day mark, directly tied to dashboard fatigue. Power users were exporting data to spreadsheets just to answer basic questions.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We ran a UX audit and competitive analysis, then prototyped a unified dashboard with progressive disclosure — surfacing the most critical metrics by default while letting power users drill into raw data.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Interviewed 22 active users across 3 customer segments</li><li>Identified 7 "must-have" metrics that 80% of users checked daily</li><li>Built and tested 3 layout prototypes before committing to a direction</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>A React-based SPA with a WordPress headless CMS backend for managing chart configs and onboarding content. Real-time data via WebSocket connections to Nimbus\'s existing API layer. The dashboard supports customizable widget layouts saved per user.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Within one quarter of launch:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>90-day churn dropped from 18% to 9%</li><li>Daily active users increased 41%</li><li>Support tickets related to "can\'t find data" decreased by 60%</li><li>NPS score jumped from 31 to 58</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Nimbus Data Inc.',
            'timeline'          => '16 Weeks',
            'services_provided' => 'Development, Strategy',
            'tagline'           => 'Real-time analytics dashboard integrating multiple data sources into a unified, actionable experience.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/greenroots/800/480.jpg',
        'title'      => 'GreenRoots Foundation',
        'excerpt'    => 'Donation platform and campaign hub for an environmental non-profit with 50K monthly visitors.',
        'industries' => ['Non-Profit'],
        'techs'      => ['WordPress'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>GreenRoots was losing donations at the payment step due to an outdated, non-mobile-friendly form. Their campaign pages had no clear hierarchy, making it hard for visitors to understand the impact of their gift. Approximately 61% of traffic was mobile but the existing site wasn\'t responsive.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We audited the donation funnel, identified 3 key drop-off points, and redesigned the flow around a single clear CTA per page with impact metrics front and center.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Heat-mapped the existing donation flow with 500+ sessions of data</li><li>A/B tested two donation form layouts with the existing audience</li><li>Worked with the content team to rewrite impact statements for clarity</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Custom WordPress theme with Stripe-integrated donation forms, campaign landing page templates, and a recurring giving program module. Donors can see real-time impact stats (trees planted, acres restored) that update as donations come in.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>After 60 days live:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Monthly donations increased by 47%</li><li>Mobile conversion rate tripled</li><li>Recurring donor sign-ups grew by 210%</li><li>Average donation amount up 18%</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'GreenRoots Foundation',
            'timeline'          => '8 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Donation platform and campaign hub for an environmental non-profit with 50K monthly visitors.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/meridian/800/480.jpg',
        'title'      => 'Meridian Wealth Portal',
        'excerpt'    => 'Client portal and marketing site for a wealth management firm with strict compliance needs.',
        'industries' => ['Finance'],
        'techs'      => ['Next.js'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Meridian\'s compliance team required all client-facing content to go through a review workflow before publishing. Their existing CMS had no approval process, leading to legal risk and slow content updates that sometimes took 5 business days to go live.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We built a Next.js frontend with a headless WordPress CMS and a custom multi-step editorial workflow using ACF and WordPress user roles. Compliance reviewers get a dedicated approval interface that makes the review queue visible and actionable.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Mapped the existing review process with the compliance and marketing teams</li><li>Designed a role-based permission model: Author → Editor → Compliance → Publish</li><li>Built email notifications at each workflow stage</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>A statically generated marketing site with Incremental Static Regeneration, paired with a password-protected client portal for document sharing and portfolio summaries. The editorial workflow is embedded directly in the WordPress admin with a custom compliance dashboard.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Key outcomes in the first year:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Content approval time reduced from 5 days to same-day</li><li>Site performance score: 98 on Lighthouse</li><li>Zero compliance incidents in first year of operation</li><li>Marketing team publishes 3x more content per month</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Meridian Advisory Group',
            'timeline'          => '20 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Client portal and marketing site for a wealth management firm with strict compliance needs.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/crestwood/800/480.jpg',
        'title'      => 'Crestwood University Redesign',
        'excerpt'    => 'Full redesign of a university website with course catalog, events, and faculty directory serving 30,000 students.',
        'industries' => ['Education'],
        'techs'      => ['WordPress', 'Tailwind CSS'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>The existing site had 14 years of content sprawl across 4 subsites, inconsistent navigation, and a course catalog that hadn\'t been updated since 2018. Prospective students were calling admissions for information that should have been findable in under 2 clicks.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We conducted an information architecture audit of 2,400+ pages, a full content inventory, and stakeholder workshops with 6 departments to align on taxonomy and navigation structure.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Surveyed 400 current and prospective students on navigation pain points</li><li>Consolidated 4 subsites into a single unified domain</li><li>Created a content governance model to prevent future sprawl</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Unified WordPress multisite with a shared design system, ACF-powered course catalog, events calendar, and faculty directory with department filtering. Department editors manage their own content within a governed template system.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>First semester post-launch:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Prospective student inquiries via phone down 31%</li><li>Course catalog page views up 180%</li><li>Accessibility score improved from 54 to 97</li><li>Average session duration increased 2.1x</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Crestwood University',
            'timeline'          => '24 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Full redesign of a university website with course catalog, events, and faculty directory serving 30,000 students.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/artisankitchen/800/480.jpg',
        'title'      => 'Artisan Kitchen Co.',
        'excerpt'    => 'Artisanal kitchenware brand with headless WooCommerce backend and React storefront.',
        'industries' => ['E-Commerce'],
        'techs'      => ['WooCommerce', 'React'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>The client wanted the flexibility of WooCommerce for inventory and fulfillment but needed a storefront that could match the premium feel of their handcrafted products. The existing theme felt generic and didn\'t support their custom engraving upsell, which was their highest-margin offering.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We proposed a decoupled architecture: WooCommerce as the commerce layer exposed via REST API, React for the frontend. This allows the team to iterate on the UI without touching the commerce logic — and the performance gains were a significant added benefit.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Benchmarked the existing site at 4.2s LCP on mobile</li><li>Designed the engraving configurator with live preview in the browser</li><li>Built a custom product photography workflow into the CMS</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>A headless React storefront with server-side rendering for SEO, real-time inventory, and a custom product configurator for engraving options. The configurator renders a live preview of the engraving before add-to-cart.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Post-launch metrics:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Page load time dropped from 4.2s to 0.9s</li><li>Cart abandonment rate fell by 22%</li><li>Average session duration doubled</li><li>Engraving upsell attach rate increased from 12% to 31%</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Artisan Kitchen Co.',
            'timeline'          => '12 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Artisanal kitchenware brand with headless WooCommerce backend and React storefront.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/launchpadcrm/800/480.jpg',
        'title'      => 'Launchpad CRM',
        'excerpt'    => 'Marketing site and documentation platform for a CRM startup with interactive product tours.',
        'industries' => ['SaaS'],
        'techs'      => ['Next.js', 'Tailwind CSS'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Launchpad\'s self-serve trial sign-up rate was low because prospects couldn\'t understand the product\'s value without booking a demo. The sales team was spending 60% of their time on discovery calls that should have been handled by the marketing site.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We mapped the buyer journey and identified 3 "aha moments" in the product. The marketing site was designed to recreate those moments before signup — giving prospects a taste of the value before they committed to anything.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Conducted win/loss interviews with 30 recent trial signups</li><li>Identified that prospects needed to see their own data in the product to convert</li><li>Built a sample data mode that mimics a real account with anonymized data</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Next.js marketing site with embedded interactive product tours built with custom React components, a headless WordPress docs site, and an animated pricing calculator that models savings against their current tool stack.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>90-day results post-launch:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Trial sign-ups increased 83%</li><li>Demo requests dropped (users self-served instead)</li><li>Time-to-signup reduced from 8 days to 2</li><li>Sales team capacity freed up by ~40%</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'Launchpad Technologies',
            'timeline'          => '14 Weeks',
            'services_provided' => 'Design, Development',
            'tagline'           => 'Marketing site and documentation platform for a CRM startup with interactive product tours.',
        ],
    ],
    [
        'image_url'  => 'https://picsum.photos/seed/clearpath/800/480.jpg',
        'title'      => 'ClearPath Wellness',
        'excerpt'    => 'Multi-location wellness clinic with online booking, provider bios, and telehealth integration.',
        'industries' => ['Healthcare'],
        'techs'      => ['WordPress', 'React'],
        'featured'   => false,
        'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Challenge</h2><!-- /wp:heading --><!-- wp:paragraph --><p>ClearPath had 8 locations with separate outdated websites, inconsistent branding, and no central booking system. Patients were confused about which location offered which services, and the lack of online booking was creating friction that sent patients to competitors.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Consolidation strategy: one WordPress multisite with shared components but location-specific content. Provider profiles and service pages are managed via ACF by clinic coordinators without developer involvement.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Audited all 8 existing sites and built a unified content model</li><li>Ran accessibility audit — existing sites averaged a score of 38</li><li>Designed a location-switcher UX that preserves context across clinic changes</li></ul><!-- /wp:list --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The Solution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Unified brand site with location pages, a custom booking integration via Calendly API, provider directory with specialty filtering, and a telehealth portal link system. Each location has its own admin with limited permissions scoped to their content.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Results</h2><!-- /wp:heading --><!-- wp:paragraph --><p>6 months post-launch across all 8 locations:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Online bookings up 340%</li><li>Phone booking volume down 28%</li><li>New patient registrations up 55%</li><li>Accessibility score improved from 38 to 94</li></ul><!-- /wp:list -->',
        'acf' => [
            'client_name'       => 'ClearPath Wellness Centers',
            'timeline'          => '18 Weeks',
            'services_provided' => 'Design, Development, Strategy',
            'tagline'           => 'Multi-location wellness clinic with online booking, provider bios, and telehealth integration.',
        ],
    ],
];

foreach ($case_studies as $data) {
    $gutenberg_content = $data['content'] ?? '';

    // Check if already exists
    $existing = get_page_by_title($data['title'], OBJECT, 'case_study');
    if ($existing) {
        // Update post_content with Gutenberg blocks
        if ($gutenberg_content) {
            wp_update_post(['ID' => $existing->ID, 'post_content' => $gutenberg_content]);
        }
        // Still set the image if missing
        if (!empty($data['image_url'])) {
            seed_set_featured_image($existing->ID, $data['image_url'], $data['title']);
            seed_set_acf_image($existing->ID, 'hero_screenshot', $data['image_url'], $data['title'] . ' screenshot');
        }
        // Refresh ACF fields (strip old wysiwyg keys, update structured fields)
        foreach ($data['acf'] as $key => $value) {
            update_field($key, $value, $existing->ID);
        }
        update_field('is_featured', $data['featured'] ? 1 : 0, $existing->ID);
        WP_CLI::line("Updated (content): {$data['title']}");
        continue;
    }

    $post_id = wp_insert_post([
        'post_title'   => $data['title'],
        'post_excerpt' => $data['excerpt'],
        'post_content' => $gutenberg_content,
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

    // Featured image + hero screenshot ACF field
    if (!empty($data['image_url'])) {
        seed_set_acf_image($post_id, 'hero_screenshot', $data['image_url'], $data['title'] . ' screenshot');
    }
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
    ['title' => 'Home',    'slug' => 'home',    'template' => ''],
    ['title' => 'About',   'slug' => 'about',   'template' => 'page-about.php'],
    ['title' => 'Contact', 'slug' => 'contact', 'template' => 'page-contact.php'],
];

foreach ($required_pages as $pg) {
    $existing = get_page_by_path($pg['slug']);
    if (!$existing) {
        $id = wp_insert_post([
            'post_title'  => $pg['title'],
            'post_name'   => $pg['slug'],
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);
        if ($pg['template']) {
            update_post_meta($id, '_wp_page_template', $pg['template']);
        }
        // Set Home as the static front page
        if ($pg['slug'] === 'home') {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $id);
            WP_CLI::success("Created Home page and set as front page (ID: $id)");
        } else {
            WP_CLI::success("Created page: {$pg['title']} (ID: $id)");
        }
    } else {
        if ($pg['template']) {
            update_post_meta($existing->ID, '_wp_page_template', $pg['template']);
        }
        if ($pg['slug'] === 'home' && !get_option('page_on_front')) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $existing->ID);
            WP_CLI::line("Set existing Home page as front page (ID: {$existing->ID})");
        } else {
            WP_CLI::line("Updated template for: {$pg['title']}");
        }
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
    // Hero text lives in the page content (Gutenberg blocks)
    $hero_content = '<!-- wp:heading {"level":1} --><h1 class="wp-block-heading">We engineer websites that <span style="color:#00D4A4">drive results</span></h1><!-- /wp:heading --><!-- wp:paragraph --><p>Snazzy Sprocket crafts high-performance digital experiences for ambitious brands. Strategy, design, and engineering — all under one roof.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/case-studies">View Our Work →</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/contact">Start a Project</a></div><!-- /wp:button --></div><!-- /wp:buttons -->';
    wp_update_post(['ID' => $home_page->ID, 'post_content' => $hero_content]);

    update_field('stat_1_number', '120+',  $home_page->ID);
    update_field('stat_1_label',  'Projects Delivered', $home_page->ID);
    update_field('stat_2_number', '98%',   $home_page->ID);
    update_field('stat_2_label',  'Client Satisfaction', $home_page->ID);
    update_field('stat_3_number', '8 yrs', $home_page->ID);
    update_field('stat_3_label',  'In Business', $home_page->ID);
    update_field('stat_4_number', '15',    $home_page->ID);
    update_field('stat_4_label',  'Industry Awards', $home_page->ID);

    update_field('service_1_title', 'UX & UI Design', $home_page->ID);
    update_field('service_1_label',  'Research-driven design systems', $home_page->ID);
    update_field('service_2_title', 'Custom Development', $home_page->ID);
    update_field('service_2_label',  'Bespoke WordPress themes', $home_page->ID);
    update_field('service_3_title', 'SEO & Strategy', $home_page->ID);
    update_field('service_3_label',  'Data-backed strategies', $home_page->ID);
    update_field('service_4_title', 'Managed Hosting', $home_page->ID);
    update_field('service_4_label',  'Enterprise-grade hosting', $home_page->ID);
    update_field('service_5_title', 'Responsive Engineering', $home_page->ID);
    update_field('service_5_label',  'Mobile-first development', $home_page->ID);
    update_field('service_6_title', 'Accessibility', $home_page->ID);
    update_field('service_6_label',  'WCAG 2.1 AA compliance', $home_page->ID);

    seed_set_acf_image($home_page->ID, 'hero_bg_image', 'https://picsum.photos/seed/snazzy-hero/1600/900.jpg', 'Homepage hero background');

    update_field('footer_tagline', 'High-performance digital experiences for ambitious brands. Based in Philadelphia, working worldwide.', $home_page->ID);

    WP_CLI::success("Updated homepage ACF fields (ID: {$home_page->ID})");
} else {
    WP_CLI::warning("Homepage not found — create a page with slug 'home' and re-run, or set it as the front page first.");
}

// ─────────────────────────────────────────────
// 7. About page ACF fields
// ─────────────────────────────────────────────
$about_page = get_page_by_path('about');
if ($about_page) {
    wp_update_post(['ID' => $about_page->ID, 'post_title' => 'About']);
    update_field('about_hero_headline', "We're the team behind your next big launch.", $about_page->ID);
    update_field('about_hero_subtext',  "We believe the web should be fast, beautiful, and accessible to everyone. Eight years later, we're still proving it — one project at a time.", $about_page->ID);

    // Individual value fields (replaces repeater — works with free ACF)
    update_field('value_1_title', 'Ship with Purpose', $about_page->ID);
    update_field('value_1_desc',  "Every feature, every line of code should solve a real problem for real users. If it doesn't move the needle, it doesn't ship.", $about_page->ID);
    update_field('value_2_title', 'Radical Candor', $about_page->ID);
    update_field('value_2_desc',  "We tell clients what they need to hear, not just what they want to hear. Honest collaboration builds better products.", $about_page->ID);
    update_field('value_3_title', 'Craft Over Hype', $about_page->ID);
    update_field('value_3_desc',  "We'd rather build it right than build it fast. Quality compounds over time and outlasts every trend.", $about_page->ID);
    update_field('value_4_title', 'Access for All', $about_page->ID);
    update_field('value_4_desc',  "The web belongs to everyone. Accessibility and performance are non-negotiable baseline requirements.", $about_page->ID);

    $about_content = '<!-- wp:paragraph --><p>What started as two developers freelancing out of a co-working space has grown into a team of 10 specialists spanning design, engineering, and strategy. We built our first client site in 2016 for a Philadelphia coffee roaster who needed something better than a template. They\'re still a client today.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>We\'ve worked with startups finding product-market fit, mid-market companies scaling their digital presence, and enterprise organizations modernizing legacy platforms. The problems look different each time; the approach is the same.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Understand the business problem first, then build the right solution — not the trendiest one. We write clean code, ship on time, and pick up the phone when things break.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li><strong>120+ projects</strong> delivered across healthcare, e-commerce, SaaS, and education</li><li><strong>98% client satisfaction</strong> across all engagements</li><li><strong>15 industry awards</strong> including Awwwards Site of the Day (twice)</li></ul><!-- /wp:list -->';

    wp_update_post(['ID' => $about_page->ID, 'post_content' => $about_content]);
    seed_set_acf_image($about_page->ID, 'agency_photo', 'https://picsum.photos/seed/snazzy-team/560/380.jpg', 'About page team photo');

    WP_CLI::success("Updated about page content and ACF fields.");
} else {
    WP_CLI::warning("About page not found — create a page with slug 'about' first.");
}

// ─────────────────────────────────────────────
// 8. Contact page ACF fields
// ─────────────────────────────────────────────
$contact_page = get_page_by_path('contact');
if ($contact_page) {
    wp_update_post(['ID' => $contact_page->ID, 'post_title' => 'Contact']);
    update_field('contact_hero_headline',    "Let's build something together", $contact_page->ID);
    update_field('contact_hero_subheadline', "Fill out the form below and we'll get back to you within one business day.", $contact_page->ID);
    update_field('contact_email',  'hello@snazzysprocket.com', $contact_page->ID);
    update_field('contact_phone',  '(215) 555-0147', $contact_page->ID);
    update_field('contact_office', '1247 Market Street, Suite 400, Philadelphia, PA 19107', $contact_page->ID);
    update_field('contact_hours',  'Monday – Friday, 9:00 AM – 6:00 PM EST', $contact_page->ID);

    WP_CLI::success("Updated contact page ACF fields.");
} else {
    WP_CLI::warning("Contact page not found — create a page with slug 'contact' first.");
}

WP_CLI::success("Seed complete!");
