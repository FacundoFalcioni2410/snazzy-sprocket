<?php
/**
 * Case Studies archive — listing page with front-end filters.
 */
get_header();

// Fetch all case studies
$all_cases = new WP_Query([
    'post_type'      => 'case_study',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

// Build filter term lists
$industry_terms   = get_terms(['taxonomy' => 'industry',   'hide_empty' => true]);
$technology_terms = get_terms(['taxonomy' => 'technology', 'hide_empty' => true]);
?>

<!-- ── Hero ─────────────────────────────────── -->
<section class="bg-ink" aria-label="Case studies hero">
    <div class="container-site py-20 md:py-24">
        <p class="section-label">Our Work</p>
        <h1 class="font-display font-extrabold text-white text-5xl md:text-7xl leading-none mb-5">
            Case Studies
        </h1>
        <p class="text-cloud/60 text-base md:text-lg leading-relaxed max-w-lg">
            <?php echo esc_html(get_theme_mod('ss_case_studies_description', "A look at how we've helped businesses across industries build better digital products and grow online.")); ?>
        </p>
    </div>
</section>

<!-- ── Filters ───────────────────────────────── -->
<section class="bg-white py-8 border-b border-cloud/40 sticky top-16 z-40" aria-label="Filter case studies">
    <div class="container-site space-y-4">

        <!-- Industry filters -->
        <?php if (!empty($industry_terms) && !is_wp_error($industry_terms)) : ?>
        <div class="flex flex-col gap-2">
            <span class="text-label font-bold uppercase tracking-widest text-steel">Industry</span>
            <div class="flex flex-wrap gap-2">
                <button
                    class="filter-btn active"
                    data-filter="all"
                    data-filter-type="industry"
                    aria-pressed="true"
                >All</button>
                <?php foreach ($industry_terms as $term) : ?>
                <button
                    class="filter-btn"
                    data-filter="<?php echo esc_attr($term->slug); ?>"
                    data-filter-type="industry"
                    aria-pressed="false"
                ><?php echo esc_html($term->name); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Technology filters -->
        <?php if (!empty($technology_terms) && !is_wp_error($technology_terms)) : ?>
        <div class="flex flex-col gap-2">
            <span class="text-label font-bold uppercase tracking-widest text-steel">Technology</span>
            <div class="flex flex-wrap gap-2">
                <button
                    class="filter-btn active"
                    data-filter="all"
                    data-filter-type="technology"
                    aria-pressed="true"
                >All</button>
                <?php foreach ($technology_terms as $term) : ?>
                <button
                    class="filter-btn"
                    data-filter="<?php echo esc_attr($term->slug); ?>"
                    data-filter-type="technology"
                    aria-pressed="false"
                ><?php echo esc_html($term->name); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- ── Card Grid ─────────────────────────────── -->
<section class="bg-white section-padding" aria-label="Case studies list" aria-live="polite">
    <div class="container-site">

        <?php if ($all_cases->have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="case-studies-grid">
            <?php while ($all_cases->have_posts()) : $all_cases->the_post(); ?>

            <?php
            // Build data attributes for filtering
            $industries   = get_the_terms(get_the_ID(), 'industry');
            $technologies = get_the_terms(get_the_ID(), 'technology');

            $industry_slugs   = (!empty($industries)   && !is_wp_error($industries))   ? implode(',', wp_list_pluck($industries,   'slug')) : '';
            $technology_slugs = (!empty($technologies) && !is_wp_error($technologies)) ? implode(',', wp_list_pluck($technologies, 'slug')) : '';

            $client_name = get_field('client_name');
            $thumb_url   = get_the_post_thumbnail_url(null, 'large');
            ?>

            <article
                class="group"
                data-industries="<?php echo esc_attr($industry_slugs); ?>"
                data-technologies="<?php echo esc_attr($technology_slugs); ?>"
                aria-label="<?php echo esc_attr(get_the_title()); ?>"
            >
                <!-- Image -->
                <a href="<?php the_permalink(); ?>" class="block rounded-xl overflow-hidden mb-4 aspect-[16/10] bg-paper" tabindex="-1" aria-hidden="true">
                    <?php if ($thumb_url) : ?>
                    <img
                        src="<?php echo esc_url($thumb_url); ?>"
                        alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                    <?php else : ?>
                    <div class="w-full h-full flex items-center justify-center text-muted/40 text-sm font-display">
                        Project Image
                    </div>
                    <?php endif; ?>
                </a>

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-3">
                    <?php if (!empty($industries) && !is_wp_error($industries)) : ?>
                        <?php foreach ($industries as $term) : ?>
                        <span class="inline-block px-3 py-1 rounded-tag text-xs font-display font-bold uppercase tracking-wider bg-accent/15 text-accent-dim border border-accent/20">
                            <?php echo esc_html($term->name); ?>
                        </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($technologies) && !is_wp_error($technologies)) : ?>
                        <?php foreach ($technologies as $term) : ?>
                        <span class="inline-block px-3 py-1 rounded-tag text-xs font-display font-bold uppercase tracking-wider border border-cloud text-steel">
                            <?php echo esc_html($term->name); ?>
                        </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Title -->
                <h2 class="font-display font-bold text-ink text-lg leading-snug mb-2">
                    <a href="<?php the_permalink(); ?>" class="hover:text-accent transition-colors duration-150">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <!-- Excerpt -->
                <p class="text-muted text-sm leading-relaxed mb-4">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '…')); ?>
                </p>

                <!-- CTA -->
                <a href="<?php the_permalink(); ?>" class="text-accent text-xs font-display font-bold uppercase tracking-wider hover:text-accent-dim transition-colors inline-flex items-center gap-1.5">
                    Read Case Study <span aria-hidden="true">&rarr;</span>
                </a>
            </article>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- No results message (shown by JS when all filtered out) -->
        <p id="no-results" class="hidden text-center text-muted py-16">
            No case studies match the selected filters.
        </p>

        <?php else : ?>
        <p class="text-center text-muted py-16">No case studies published yet.</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
