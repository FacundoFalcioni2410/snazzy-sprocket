<?php
/**
 * CTA Banner — ink background with dot grid overlay
 * Used at the bottom of the homepage (and optionally other pages).
 */
?>

<section class="bg-ink relative overflow-hidden" aria-label="Call to action">
    <!-- Dot grid overlay -->
    <div class="absolute inset-0 dot-overlay opacity-60 pointer-events-none" aria-hidden="true"></div>

    <div class="container-site py-20 md:py-28 relative z-10 text-center">
        <h2 class="font-display font-extrabold text-white text-3xl md:text-5xl leading-tight mb-4">
            Ready to build something great?
        </h2>
        <p class="text-cloud/60 text-base md:text-lg mb-10 max-w-md mx-auto">
            Let's talk about your next project. We're here to help you ship faster and smarter.
        </p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary text-sm px-8 py-4">
            Start a Conversation &rarr;
        </a>
    </div>
</section>
