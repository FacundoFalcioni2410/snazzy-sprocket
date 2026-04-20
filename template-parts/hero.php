<?php
/**
 * Hero section — homepage
 */
$headline    = get_field('hero_headline')    ?: 'We engineer websites that <span class="text-accent">drive results</span>';
$subheadline = get_field('hero_subheadline') ?: 'Snazzy Sprocket crafts high-performance digital experiences for ambitious brands. Strategy, design, and engineering — all under one roof.';
$cta_label   = get_field('hero_cta_label')  ?: 'View Our Work';
$cta_url     = get_field('hero_cta_url')    ?: get_post_type_archive_link('case_study');
$stats       = get_field('stats');

// Default stats if none set in ACF
if (empty($stats)) {
    $stats = [
        ['stat_number' => '120+', 'stat_label' => 'Projects Delivered'],
        ['stat_number' => '98%',  'stat_label' => 'Client Satisfaction'],
        ['stat_number' => '8 yrs', 'stat_label' => 'In Business'],
        ['stat_number' => '15',   'stat_label' => 'Industry Awards'],
    ];
}
?>

<section class="bg-ink min-h-[calc(100vh-64px)] flex items-center" aria-label="Hero">
    <div class="container-site py-20 md:py-28 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-12 lg:gap-16 items-center">

            <!-- Left: copy -->
            <div>
                <p class="section-label">Award-Winning Digital Agency</p>

                <h1 class="font-display font-extrabold text-white leading-[1.02] mb-6
                            text-4xl sm:text-5xl lg:text-hero">
                    <?php echo wp_kses($headline, ['span' => ['class' => []]]); ?>
                </h1>

                <p class="text-cloud/70 text-base md:text-lg leading-relaxed max-w-lg mb-10">
                    <?php echo esc_html($subheadline); ?>
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo esc_url($cta_url); ?>" class="btn-primary">
                        <?php echo esc_html($cta_label); ?> &rarr;
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-ghost text-cloud hover:text-white">
                        Start a Project
                    </a>
                </div>
            </div>

            <!-- Right: stats -->
            <?php if (!empty($stats)) : ?>
            <div class="grid grid-cols-1 gap-2" role="list" aria-label="Agency statistics">
                <?php foreach ($stats as $stat) : ?>
                <div class="bg-ink-light rounded-xl px-6 py-5 border border-white/5" role="listitem">
                    <p class="font-display font-bold text-white text-4xl md:text-5xl leading-none mb-1">
                        <?php echo esc_html($stat['stat_number']); ?>
                    </p>
                    <p class="text-muted text-sm"><?php echo esc_html($stat['stat_label']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
