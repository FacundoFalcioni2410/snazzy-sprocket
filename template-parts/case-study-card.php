<?php
/**
 * Case Study card — used on homepage featured section and archive listing.
 * Expects to be called inside a WP_Query loop.
 */
$client_name = get_field('client_name');
$industries  = get_the_terms(get_the_ID(), 'industry');
$technologies = get_the_terms(get_the_ID(), 'technology');
$permalink   = get_permalink();
$thumb_url   = get_the_post_thumbnail_url(null, 'large');
?>

<article class="card group flex flex-col" aria-label="<?php echo esc_attr(get_the_title()); ?>">

    <!-- Image -->
    <a href="<?php echo esc_url($permalink); ?>" class="block overflow-hidden aspect-[5/3] bg-ink-light" tabindex="-1" aria-hidden="true">
        <?php if ($thumb_url) : ?>
        <img
            src="<?php echo esc_url($thumb_url); ?>"
            alt="<?php echo esc_attr(get_the_title()); ?>"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            loading="lazy"
        >
        <?php else : ?>
        <div class="w-full h-full flex items-center justify-center text-muted/30 text-sm font-display">
            Project Image — 800 × 480
        </div>
        <?php endif; ?>
    </a>

    <!-- Body -->
    <div class="p-6 flex flex-col flex-1">

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-4">
            <?php if ($industries && !is_wp_error($industries)) : ?>
                <?php foreach ($industries as $term) : ?>
                <span class="tag-accent"><?php echo esc_html($term->name); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($technologies && !is_wp_error($technologies)) : ?>
                <?php foreach ($technologies as $term) : ?>
                <span class="tag"><?php echo esc_html($term->name); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Title -->
        <h3 class="font-display font-bold text-ink text-lg leading-snug mb-2">
            <a href="<?php echo esc_url($permalink); ?>" class="hover:text-accent transition-colors duration-150">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="text-muted text-sm leading-relaxed mb-5 flex-1">
            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '…')); ?>
        </p>

        <!-- CTA -->
        <a href="<?php echo esc_url($permalink); ?>" class="text-accent text-sm font-display font-bold hover:text-accent-bright transition-colors duration-150 inline-flex items-center gap-1">
            Read Case Study <span aria-hidden="true">&rarr;</span>
        </a>
    </div>

</article>
