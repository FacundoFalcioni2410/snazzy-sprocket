<?php
/**
 * Featured Case Studies section — homepage
 */
$featured = new WP_Query([
    'post_type'      => 'case_study',
    'posts_per_page' => 3,
    'meta_query'     => [
        ['key' => 'is_featured', 'value' => '1', 'compare' => '='],
    ],
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

// Fallback: show latest 3 if none are flagged featured
if (!$featured->have_posts()) {
    $featured = new WP_Query([
        'post_type'      => 'case_study',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}
?>

<section class="bg-paper section-padding" aria-labelledby="featured-work-heading">
    <div class="container-site">

        <!-- Header (centered) -->
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="section-label">Featured Work</p>
            <h2 id="featured-work-heading" class="section-title mb-4">
                Case studies that speak<br class="hidden sm:block"> for themselves
            </h2>
            <p class="text-muted text-base leading-relaxed">
                A selection of recent projects where strategy met execution — and the results exceeded expectations.
            </p>
        </div>

        <?php if ($featured->have_posts()) : ?>
        <!-- Cards grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <?php while ($featured->have_posts()) : $featured->the_post(); ?>
                <?php get_template_part('template-parts/case-study-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- View all CTA -->
        <div class="text-center">
            <a href="<?php echo esc_url(get_post_type_archive_link('case_study')); ?>" class="btn-outline">
                View All Case Studies &rarr;
            </a>
        </div>
        <?php else : ?>
        <p class="text-center text-muted">No case studies published yet.</p>
        <?php endif; ?>

    </div>
</section>
