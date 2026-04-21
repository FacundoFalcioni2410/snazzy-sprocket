<?php
/**
 * Snazzy Sprocket Theme Functions
 */

// ─────────────────────────────────────────────
// Theme Setup
// ─────────────────────────────────────────────
function ss_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'snazzy-sprocket'),
        'footer'  => __('Footer Navigation', 'snazzy-sprocket'),
    ]);
}
add_action('after_setup_theme', 'ss_theme_setup');

// ─────────────────────────────────────────────
// Enqueue Assets
// ─────────────────────────────────────────────
function ss_enqueue_assets(): void {
    // Google Fonts
    wp_enqueue_style(
        'ss-google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Syne:wght@600;700;800&display=swap',
        [],
        null
    );

    // Compiled Tailwind CSS
    wp_enqueue_style(
        'ss-styles',
        get_template_directory_uri() . '/dist/css/app.css',
        ['ss-google-fonts'],
        filemtime(get_template_directory() . '/dist/css/app.css')
    );

    // Theme JS
    wp_enqueue_script(
        'ss-scripts',
        get_template_directory_uri() . '/dist/js/app.js',
        [],
        filemtime(get_template_directory() . '/dist/js/app.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'ss_enqueue_assets');

// ─────────────────────────────────────────────
// Custom Post Types
// ─────────────────────────────────────────────
function ss_register_post_types(): void {
    // Case Studies
    register_post_type('case_study', [
        'labels' => [
            'name'               => __('Case Studies', 'snazzy-sprocket'),
            'singular_name'      => __('Case Study', 'snazzy-sprocket'),
            'add_new'            => __('Add New Case Study', 'snazzy-sprocket'),
            'add_new_item'       => __('Add New Case Study', 'snazzy-sprocket'),
            'edit_item'          => __('Edit Case Study', 'snazzy-sprocket'),
            'new_item'           => __('New Case Study', 'snazzy-sprocket'),
            'view_item'          => __('View Case Study', 'snazzy-sprocket'),
            'search_items'       => __('Search Case Studies', 'snazzy-sprocket'),
            'not_found'          => __('No case studies found', 'snazzy-sprocket'),
            'not_found_in_trash' => __('No case studies found in Trash', 'snazzy-sprocket'),
            'menu_name'          => __('Case Studies', 'snazzy-sprocket'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'case-studies'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'menu_position'      => 5,
    ]);

    // Team Members
    register_post_type('team_member', [
        'labels' => [
            'name'               => __('Team Members', 'snazzy-sprocket'),
            'singular_name'      => __('Team Member', 'snazzy-sprocket'),
            'add_new'            => __('Add New Team Member', 'snazzy-sprocket'),
            'add_new_item'       => __('Add New Team Member', 'snazzy-sprocket'),
            'edit_item'          => __('Edit Team Member', 'snazzy-sprocket'),
            'new_item'           => __('New Team Member', 'snazzy-sprocket'),
            'view_item'          => __('View Team Member', 'snazzy-sprocket'),
            'search_items'       => __('Search Team Members', 'snazzy-sprocket'),
            'not_found'          => __('No team members found', 'snazzy-sprocket'),
            'not_found_in_trash' => __('No team members found in Trash', 'snazzy-sprocket'),
            'menu_name'          => __('Team', 'snazzy-sprocket'),
        ],
        'public'        => true,
        'has_archive'   => false,
        'rewrite'       => ['slug' => 'team'],
        'supports'      => ['title', 'thumbnail'],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-groups',
        'menu_position' => 6,
    ]);
}
add_action('init', 'ss_register_post_types');

// ─────────────────────────────────────────────
// Taxonomies
// ─────────────────────────────────────────────
function ss_register_taxonomies(): void {
    // Industry
    register_taxonomy('industry', ['case_study'], [
        'labels' => [
            'name'              => __('Industries', 'snazzy-sprocket'),
            'singular_name'     => __('Industry', 'snazzy-sprocket'),
            'search_items'      => __('Search Industries', 'snazzy-sprocket'),
            'all_items'         => __('All Industries', 'snazzy-sprocket'),
            'edit_item'         => __('Edit Industry', 'snazzy-sprocket'),
            'update_item'       => __('Update Industry', 'snazzy-sprocket'),
            'add_new_item'      => __('Add New Industry', 'snazzy-sprocket'),
            'new_item_name'     => __('New Industry Name', 'snazzy-sprocket'),
            'menu_name'         => __('Industries', 'snazzy-sprocket'),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'industry'],
        'show_admin_column' => true,
    ]);

    // Technology
    register_taxonomy('technology', ['case_study'], [
        'labels' => [
            'name'              => __('Technologies', 'snazzy-sprocket'),
            'singular_name'     => __('Technology', 'snazzy-sprocket'),
            'search_items'      => __('Search Technologies', 'snazzy-sprocket'),
            'all_items'         => __('All Technologies', 'snazzy-sprocket'),
            'edit_item'         => __('Edit Technology', 'snazzy-sprocket'),
            'update_item'       => __('Update Technology', 'snazzy-sprocket'),
            'add_new_item'      => __('Add New Technology', 'snazzy-sprocket'),
            'new_item_name'     => __('New Technology Name', 'snazzy-sprocket'),
            'menu_name'         => __('Technologies', 'snazzy-sprocket'),
        ],
        'hierarchical'      => false,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'technology'],
        'show_admin_column' => true,
    ]);
}
add_action('init', 'ss_register_taxonomies');

// ─────────────────────────────────────────────
// ACF Field Groups (programmatic registration)
// ─────────────────────────────────────────────
function ss_register_acf_fields(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // ── Case Study Fields ──────────────────────
    acf_add_local_field_group([
        'key'      => 'group_case_study',
        'title'    => 'Case Study Details',
        'fields'   => [
            [
                'key'          => 'field_is_featured',
                'label'        => 'Feature on Homepage',
                'name'         => 'is_featured',
                'type'         => 'true_false',
                'ui'           => 1,
                'instructions' => 'Toggle on to show this case study in the homepage featured section.',
            ],
            [
                'key'   => 'field_client_name',
                'label' => 'Client Name',
                'name'  => 'client_name',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_timeline',
                'label'        => 'Timeline',
                'name'         => 'timeline',
                'type'         => 'text',
                'placeholder'  => 'e.g. 14 Weeks',
            ],
            [
                'key'          => 'field_services_provided',
                'label'        => 'Services Provided',
                'name'         => 'services_provided',
                'type'         => 'text',
                'placeholder'  => 'e.g. Design, Development, Strategy',
            ],
            [
                'key'          => 'field_tagline',
                'label'        => 'Project Tagline',
                'name'         => 'tagline',
                'type'         => 'textarea',
                'rows'         => 2,
                'instructions' => 'Short summary shown under the title in the hero. 1–2 sentences.',
            ],
            [
                'key'           => 'field_hero_screenshot',
                'label'         => 'Hero Screenshot',
                'name'          => 'hero_screenshot',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'large',
                'instructions'  => 'Wide project screenshot shown below the hero. Recommended: 1200×400px.',
            ],
            [
                'key'          => 'field_content_note',
                'label'        => 'Project Content',
                'name'         => '',
                'type'         => 'message',
                'message'      => '<strong>Use the block editor above</strong> to write the project narrative — Challenge, Approach, Solution, and Results. Use Heading blocks (H2) for section titles and Paragraph/List blocks for body content.',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'case_study']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);

    // ── Team Member Fields ─────────────────────
    acf_add_local_field_group([
        'key'    => 'group_team_member',
        'title'  => 'Team Member Details',
        'fields' => [
            [
                'key'   => 'field_role',
                'label' => 'Role / Title',
                'name'  => 'role',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_photo',
                'label'         => 'Photo',
                'name'          => 'photo',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'   => 'field_bio',
                'label' => 'Bio',
                'name'  => 'bio',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_linkedin_url',
                'label' => 'LinkedIn URL',
                'name'  => 'linkedin_url',
                'type'  => 'url',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'team_member']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);

    // ── Homepage Fields ────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_homepage',
        'title'  => 'Homepage Content',
        'fields' => [
            [
                'key'   => 'field_hero_headline',
                'label' => 'Hero Headline',
                'name'  => 'hero_headline',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_hero_subheadline',
                'label' => 'Hero Subheadline',
                'name'  => 'hero_subheadline',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_hero_cta_label',
                'label' => 'Hero CTA Button Label',
                'name'  => 'hero_cta_label',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_hero_cta_url',
                'label' => 'Hero CTA Button URL',
                'name'  => 'hero_cta_url',
                'type'  => 'url',
            ],
            [
                'key'           => 'field_hero_bg_image',
                'label'         => 'Hero Background Image',
                'name'          => 'hero_bg_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'large',
            ],
            [
                'key'        => 'field_stats',
                'label'      => 'Hero Stats',
                'name'       => 'stats',
                'type'       => 'repeater',
                'min'        => 0,
                'max'        => 4,
                'layout'     => 'table',
                'button_label' => 'Add Stat',
                'instructions' => 'Up to 4 stats shown in the hero right column (e.g. 120+, Projects Delivered)',
                'sub_fields' => [
                    [
                        'key'   => 'field_stat_number',
                        'label' => 'Number / Value',
                        'name'  => 'stat_number',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_stat_label',
                        'label' => 'Label',
                        'name'  => 'stat_label',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'        => 'field_services',
                'label'      => 'Services',
                'name'       => 'services',
                'type'       => 'repeater',
                'min'        => 1,
                'max'        => 6,
                'layout'     => 'block',
                'button_label' => 'Add Service',
                'sub_fields' => [
                    [
                        'key'   => 'field_service_title',
                        'label' => 'Service Title',
                        'name'  => 'service_title',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_service_desc',
                        'label' => 'Service Description',
                        'name'  => 'service_desc',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'           => 'field_service_icon',
                        'label'         => 'Service Icon',
                        'name'          => 'service_icon',
                        'type'          => 'image',
                        'return_format' => 'array',
                        'preview_size'  => 'thumbnail',
                        'instructions'  => 'Upload an SVG or PNG icon (recommended: 64×64px)',
                    ],
                ],
            ],
        ],
        'location' => [
            [['param' => 'page_type', 'operator' => '==', 'value' => 'front_page']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);

    // ── About Page Fields ──────────────────────
    acf_add_local_field_group([
        'key'    => 'group_about_page',
        'title'  => 'About Page Content',
        'fields' => [
            [
                'key'          => 'field_about_hero_headline',
                'label'        => 'Hero Headline',
                'name'         => 'about_hero_headline',
                'type'         => 'text',
                'instructions' => 'Large headline shown in the dark hero area.',
            ],
            [
                'key'          => 'field_about_hero_subtext',
                'label'        => 'Hero Subtext',
                'name'         => 'about_hero_subtext',
                'type'         => 'textarea',
                'rows'         => 2,
            ],
            [
                'key'   => 'field_agency_headline',
                'label' => 'Story Headline',
                'name'  => 'agency_headline',
                'type'  => 'text',
            ],
            [
                'key'     => 'field_agency_story_note',
                'label'   => 'Agency Story',
                'name'    => '',
                'type'    => 'message',
                'message' => '<strong>Write the agency story in the block editor above.</strong> Use paragraphs, headings, and any other blocks you need.',
            ],
            [
                'key'           => 'field_agency_photo',
                'label'         => 'Team Photo',
                'name'          => 'agency_photo',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'Shown beside the agency story. Recommended: 560×380px.',
            ],
            // Value 1
            ['key' => 'field_value_1_title', 'label' => 'Value 1 — Title',       'name' => 'value_1_title', 'type' => 'text',     'default_value' => 'Ship with Purpose'],
            ['key' => 'field_value_1_desc',  'label' => 'Value 1 — Description', 'name' => 'value_1_desc',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'Every feature, every line of code should solve a real problem for real users. If it doesn\'t move the needle, it doesn\'t ship.'],
            // Value 2
            ['key' => 'field_value_2_title', 'label' => 'Value 2 — Title',       'name' => 'value_2_title', 'type' => 'text',     'default_value' => 'Radical Candor'],
            ['key' => 'field_value_2_desc',  'label' => 'Value 2 — Description', 'name' => 'value_2_desc',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'We tell clients what they need to hear, not just what they want to hear. Honest collaboration builds better products.'],
            // Value 3
            ['key' => 'field_value_3_title', 'label' => 'Value 3 — Title',       'name' => 'value_3_title', 'type' => 'text',     'default_value' => 'Craft Over Hype'],
            ['key' => 'field_value_3_desc',  'label' => 'Value 3 — Description', 'name' => 'value_3_desc',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'We\'d rather build it right than build it fast. Quality compounds over time and outlasts every trend.'],
            // Value 4
            ['key' => 'field_value_4_title', 'label' => 'Value 4 — Title',       'name' => 'value_4_title', 'type' => 'text',     'default_value' => 'Access for All'],
            ['key' => 'field_value_4_desc',  'label' => 'Value 4 — Description', 'name' => 'value_4_desc',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'The web belongs to everyone. Accessibility and performance are non-negotiable baseline requirements.'],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);

    // ── Contact Page Fields ────────────────────
    acf_add_local_field_group([
        'key'    => 'group_contact_page',
        'title'  => 'Contact Information',
        'fields' => [
            [
                'key'          => 'field_contact_email',
                'label'        => 'Email Address',
                'name'         => 'contact_email',
                'type'         => 'email',
                'default_value' => 'hello@snazzysprocket.com',
            ],
            [
                'key'          => 'field_contact_phone',
                'label'        => 'Phone',
                'name'         => 'contact_phone',
                'type'         => 'text',
                'default_value' => '(215) 555-0147',
            ],
            [
                'key'          => 'field_contact_office',
                'label'        => 'Office Address',
                'name'         => 'contact_office',
                'type'         => 'text',
                'default_value' => '1247 Market Street, Suite 400, Philadelphia, PA 19107',
            ],
            [
                'key'          => 'field_contact_hours',
                'label'        => 'Business Hours',
                'name'         => 'contact_hours',
                'type'         => 'text',
                'default_value' => 'Monday – Friday, 9:00 AM – 6:00 PM EST',
            ],
            [
                'key'          => 'field_contact_map_embed',
                'label'        => 'Map Embed Code',
                'name'         => 'contact_map_embed',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Paste your Google Maps or Mapbox <iframe> embed code here.',
            ],
            [
                'key'          => 'field_contact_twitter',
                'label'        => 'Twitter / X URL',
                'name'         => 'contact_twitter',
                'type'         => 'url',
            ],
            [
                'key'          => 'field_contact_linkedin',
                'label'        => 'LinkedIn URL',
                'name'         => 'contact_linkedin',
                'type'         => 'url',
            ],
            [
                'key'          => 'field_contact_dribbble',
                'label'        => 'Dribbble URL',
                'name'         => 'contact_dribbble',
                'type'         => 'url',
            ],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);
}
add_action('acf/init', 'ss_register_acf_fields');

// ─────────────────────────────────────────────
// Contact form handler
// ─────────────────────────────────────────────
function ss_handle_contact_form(): void {
    if (
        !isset($_POST['ss_contact_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ss_contact_nonce'])), 'ss_contact_form')
    ) {
        return;
    }

    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name  = sanitize_text_field($_POST['last_name']  ?? '');
    $email      = sanitize_email($_POST['email']           ?? '');
    $company    = sanitize_text_field($_POST['company']    ?? '');
    $budget     = sanitize_text_field($_POST['budget']     ?? '');
    $message    = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($first_name) || empty($email) || empty($message)) {
        set_transient('ss_contact_error_' . get_current_user_id(), 'Please fill in all required fields.', 60);
        return;
    }

    $to      = get_option('admin_email');
    $subject = "New project inquiry from {$first_name} {$last_name}";
    $body    = "Name: {$first_name} {$last_name}\nEmail: {$email}\nCompany: {$company}\nBudget: {$budget}\n\nMessage:\n{$message}";
    $headers = ["Reply-To: {$email}"];

    wp_mail($to, $subject, $body, $headers);
    set_transient('ss_contact_success_' . session_id(), true, 60);

    wp_safe_redirect(add_query_arg('sent', '1', get_permalink()));
    exit;
}
add_action('init', 'ss_handle_contact_form');

// ─────────────────────────────────────────────
// Flush rewrite rules on activation
// ─────────────────────────────────────────────
function ss_flush_rewrite_rules(): void {
    ss_register_post_types();
    ss_register_taxonomies();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'ss_flush_rewrite_rules');

// Also flush once on init if flag is set
function ss_maybe_flush(): void {
    if (get_option('ss_flush_needed')) {
        flush_rewrite_rules();
        delete_option('ss_flush_needed');
    }
}
add_action('init', 'ss_maybe_flush', 20);


// ─────────────────────────────────────────────
// Customizer — editable text for CPT archives
// ─────────────────────────────────────────────
function ss_customizer_settings( WP_Customize_Manager $wp_customize ): void {
    $wp_customize->add_section('ss_case_studies', [
        'title'    => 'Case Studies Archive',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('ss_case_studies_description', [
        'default'           => 'A look at how we\'ve helped businesses across industries build better digital products and grow online.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control('ss_case_studies_description', [
        'label'   => 'Archive Page Description',
        'section' => 'ss_case_studies',
        'type'    => 'textarea',
    ]);
}
add_action('customize_register', 'ss_customizer_settings');

// ─────────────────────────────────────────────
// Helper: get image src safely from ACF field
// ─────────────────────────────────────────────
function ss_get_image_src(mixed $image, string $size = 'full'): string {
    if (empty($image)) {
        return '';
    }
    if (is_array($image)) {
        return $image['sizes'][$size] ?? $image['url'] ?? '';
    }
    if (is_numeric($image)) {
        return wp_get_attachment_image_url((int) $image, $size) ?: '';
    }
    return (string) $image;
}

// ─────────────────────────────────────────────
// Helper: get image alt safely
// ─────────────────────────────────────────────
function ss_get_image_alt(mixed $image): string {
    if (is_array($image)) {
        return esc_attr($image['alt'] ?? $image['title'] ?? '');
    }
    return '';
}
