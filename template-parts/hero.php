<?php
/**
 * Hero section — homepage
 * Left column: Gutenberg page content (headline, subheadline, CTAs)
 * Right column: Stats from ACF
 */
$stat_1_number = get_field('stat_1_number') ?: '120+';
$stat_1_label  = get_field('stat_1_label')  ?: 'Projects Delivered';
$stat_2_number = get_field('stat_2_number') ?: '98%';
$stat_2_label  = get_field('stat_2_label')  ?: 'Client Satisfaction';
$stat_3_number = get_field('stat_3_number') ?: '8 yrs';
$stat_3_label  = get_field('stat_3_label')  ?: 'In Business';
$stat_4_number = get_field('stat_4_number') ?: '15';
$stat_4_label  = get_field('stat_4_label')  ?: 'Industry Awards';
?>

<section class="bg-ink min-h-[calc(100vh-64px)] flex items-center" aria-label="Hero">
    <div class="container-site py-20 md:py-28 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-12 lg:gap-16 items-center">

            <!-- Left: Gutenberg content -->
            <div class="hero-content">
                <p class="section-label">Award-Winning Digital Agency</p>
                <?php the_content(); ?>
            </div>

            <!-- Right: stats -->
            <div class="grid grid-cols-1 gap-2" role="list" aria-label="Agency statistics">
                <?php
                $stats = [
                    ['stat_number' => $stat_1_number, 'stat_label' => $stat_1_label],
                    ['stat_number' => $stat_2_number, 'stat_label' => $stat_2_label],
                    ['stat_number' => $stat_3_number, 'stat_label' => $stat_3_label],
                    ['stat_number' => $stat_4_number, 'stat_label' => $stat_4_label],
                ];
                foreach ($stats as $stat) : ?>
                <div class="bg-ink-light rounded-lg px-5 py-4 border border-white/5" role="listitem">
                    <p class="font-display font-bold text-white text-2xl md:text-3xl leading-none mb-1">
                        <?php echo esc_html($stat['stat_number']); ?>
                    </p>
                    <p class="text-muted text-xs"><?php echo esc_html($stat['stat_label']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
