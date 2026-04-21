<?php
/**
 * Template Name: About Page
 *
 * Assign this template to your "About" page in WP Admin → Page Attributes → Template.
 */
get_header();

$hero_headline = get_field('about_hero_headline') ?: "We're the team behind your next big launch.";
$hero_subtext  = get_field('about_hero_subtext')  ?: 'We believe the web should be fast, beautiful, and accessible to everyone. Eight years later, we\'re still proving it — one project at a time.';
$story_headline = get_field('agency_headline') ?: 'From side project to full-service agency';
$agency_photo   = get_field('agency_photo');
$values = [
    [
        'value_title' => get_field('value_1_title') ?: 'Ship with Purpose',
        'value_desc'  => get_field('value_1_desc')  ?: 'Every feature, every line of code should solve a real problem for real users. If it doesn\'t move the needle, it doesn\'t ship.',
    ],
    [
        'value_title' => get_field('value_2_title') ?: 'Radical Candor',
        'value_desc'  => get_field('value_2_desc')  ?: 'We tell clients what they need to hear, not just what they want to hear. Honest collaboration builds better products.',
    ],
    [
        'value_title' => get_field('value_3_title') ?: 'Craft Over Hype',
        'value_desc'  => get_field('value_3_desc')  ?: 'We\'d rather build it right than build it fast. Quality compounds over time and outlasts every trend.',
    ],
    [
        'value_title' => get_field('value_4_title') ?: 'Access for All',
        'value_desc'  => get_field('value_4_desc')  ?: 'The web belongs to everyone. Accessibility and performance are non-negotiable baseline requirements.',
    ],
];
?>

<!-- ── Hero ─────────────────────────────────── -->
<section class="bg-ink" aria-label="About hero">
    <div class="container-site py-20 md:py-28">
        <p class="section-label">About Us</p>
        <h1 class="font-display font-extrabold text-white leading-[1.05] max-w-2xl
                    text-4xl sm:text-5xl lg:text-6xl mb-6">
            <?php echo esc_html($hero_headline); ?>
        </h1>
        <p class="text-cloud/60 text-base md:text-lg leading-relaxed max-w-xl">
            <?php echo esc_html($hero_subtext); ?>
        </p>
    </div>
</section>

<!-- ── Our Story ─────────────────────────────── -->
<section class="bg-white section-padding" aria-labelledby="story-heading">
    <div class="container-site">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            <!-- Text -->
            <div>
                <p class="section-label">Our Story</p>
                <h2 id="story-heading" class="section-title mb-6">
                    <?php echo esc_html($story_headline); ?>
                </h2>
                <div class="prose prose-gray max-w-none text-muted leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Photo -->
            <div class="rounded-2xl overflow-hidden bg-paper aspect-[560/380] flex items-center justify-center">
                <?php if (!empty($agency_photo)) : ?>
                <img
                    src="<?php echo esc_url(ss_get_image_src($agency_photo, 'large')); ?>"
                    alt="<?php echo ss_get_image_alt($agency_photo); ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
                <?php else : ?>
                <p class="text-muted/40 text-sm font-display">Team Photo — 560 × 380</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<!-- ── Our Values ─────────────────────────────── -->
<section class="bg-paper section-padding" aria-labelledby="values-heading">
    <div class="container-site">
        <div class="text-center mb-12">
            <p class="section-label">Our Values</p>
            <h2 id="values-heading" class="section-title">
                What drives every decision
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($values as $value) : ?>
            <div class="bg-white rounded-xl p-6 border border-cloud/40">
                <h3 class="font-display font-bold text-ink text-base mb-2">
                    <?php echo esc_html($value['value_title']); ?>
                </h3>
                <p class="text-muted text-sm leading-relaxed">
                    <?php echo esc_html($value['value_desc']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── The Team ───────────────────────────────── -->
<section class="bg-white section-padding" aria-labelledby="team-heading">
    <div class="container-site">
        <div class="text-center max-w-xl mx-auto mb-14">
            <p class="section-label">The Team</p>
            <h2 id="team-heading" class="section-title mb-4">
                Meet the people<br>behind the pixels
            </h2>
            <p class="text-muted text-base leading-relaxed">
                A tight-knit crew of designers, developers, and strategists who care deeply about the work.
            </p>
        </div>

        <?php
        $team = new WP_Query([
            'post_type'      => 'team_member',
            'posts_per_page' => 10,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        ?>

        <?php if ($team->have_posts()) : ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <?php while ($team->have_posts()) : $team->the_post(); ?>
                <?php get_template_part('template-parts/team-member-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php else : ?>
        <p class="text-center text-muted">No team members found. Add some in WP Admin → Team.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ── Join the Team CTA ─────────────────────── -->
<section class="bg-ink relative overflow-hidden" aria-label="Join the team">
    <div class="absolute inset-0 dot-overlay opacity-60 pointer-events-none" aria-hidden="true"></div>
    <div class="container-site py-20 md:py-24 relative z-10 text-center">
        <h2 class="font-display font-extrabold text-white text-3xl md:text-4xl mb-4">
            Want to join the team?
        </h2>
        <p class="text-cloud/60 text-base mb-8 max-w-sm mx-auto">
            We're always looking for talented people who care about craft. Check out our open roles.
        </p>
        <a href="#" class="btn-primary">View Open Positions &rarr;</a>
    </div>
</section>

<?php get_footer(); ?>
