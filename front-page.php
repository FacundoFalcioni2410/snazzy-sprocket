<?php
/**
 * Homepage template
 */
get_header();

// Set up the global post so the_content() works in template-parts/hero
if (have_posts()) { the_post(); }
?>

<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/services'); ?>
<?php get_template_part('template-parts/featured-cases'); ?>
<?php get_template_part('template-parts/cta-banner'); ?>

<?php get_footer(); ?>
