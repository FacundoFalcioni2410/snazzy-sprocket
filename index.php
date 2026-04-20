<?php
/**
 * Fallback template — WordPress requires this file to exist.
 */
get_header();
?>

<main class="container-site section-padding">
    <?php if (have_posts()) : ?>
        <div class="grid gap-8">
            <?php while (have_posts()) : the_post(); ?>
            <article>
                <h2 class="font-display text-2xl font-bold text-ink mb-2">
                    <a href="<?php the_permalink(); ?>" class="hover:text-accent transition-colors">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <p class="text-muted text-sm"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 30, '…')); ?></p>
            </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p class="text-muted">No posts found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
