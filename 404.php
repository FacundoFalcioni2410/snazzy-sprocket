<?php
/**
 * 404 template
 */
get_header();
?>

<main class="bg-ink min-h-[60vh] flex items-center">
    <div class="container-site py-24 text-center">
        <p class="section-label">404 Error</p>
        <h1 class="font-display font-extrabold text-white text-6xl md:text-8xl mb-4">Oops.</h1>
        <p class="text-cloud/60 text-lg mb-10">That page doesn't exist or has been moved.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">Back to Home &rarr;</a>
    </div>
</main>

<?php get_footer(); ?>
