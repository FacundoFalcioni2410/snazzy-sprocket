<?php
/**
 * Single Case Study template.
 */
get_header();

the_post();

$client_name     = get_field('client_name');
$timeline        = get_field('timeline');
$services_prov   = get_field('services_provided');
$tagline         = get_field('tagline');
$hero_screenshot = get_field('hero_screenshot');

$industries   = get_the_terms(get_the_ID(), 'industry');
$technologies = get_the_terms(get_the_ID(), 'technology');

$all_terms = array_merge(
    (!empty($industries)   && !is_wp_error($industries))   ? $industries   : [],
    (!empty($technologies) && !is_wp_error($technologies)) ? $technologies : []
);
?>

<!-- ── Hero ─────────────────────────────────── -->
<section class="bg-ink" aria-label="Case study hero">
    <div class="container-site py-16 md:py-24">

        <!-- Taxonomy tags -->
        <?php if (!empty($all_terms)) : ?>
        <div class="flex flex-wrap gap-2 mb-6" aria-label="Project tags">
            <?php foreach ($all_terms as $term) : ?>
            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="tag-accent text-xs hover:bg-accent/20 transition-colors">
                <?php echo esc_html(strtoupper($term->name)); ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="font-display font-extrabold text-white leading-[1.05]
                    text-4xl sm:text-5xl lg:text-6xl mb-6 max-w-3xl">
            <?php the_title(); ?>
        </h1>

        <!-- Tagline -->
        <?php if ($tagline) : ?>
        <p class="text-cloud/60 text-base md:text-lg leading-relaxed max-w-2xl">
            <?php echo esc_html($tagline); ?>
        </p>
        <?php endif; ?>

    </div>
</section>

<!-- ── Hero Screenshot ───────────────────────── -->
<section class="bg-paper py-10" aria-hidden="<?php echo empty($hero_screenshot) ? 'true' : 'false'; ?>">
    <div class="container-site">
        <div class="rounded-2xl overflow-hidden bg-fog/30 aspect-[3/1] flex items-center justify-center border border-cloud/40">
            <?php if (!empty($hero_screenshot)) : ?>
            <img
                src="<?php echo esc_url(ss_get_image_src($hero_screenshot, 'full')); ?>"
                alt="<?php echo ss_get_image_alt($hero_screenshot) ?: esc_attr(get_the_title()) . ' screenshot'; ?>"
                class="w-full h-full object-cover"
                loading="eager"
            >
            <?php else : ?>
            <p class="text-muted/40 text-sm font-display">Hero Screenshot — 1200 × 400</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ── Project Meta ──────────────────────────── -->
<?php if ($client_name || $timeline || $services_prov) : ?>
<section class="bg-white border-b border-cloud/40" aria-label="Project details">
    <div class="container-site py-10">
        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <?php if ($client_name) : ?>
            <div>
                <dt class="text-label font-bold uppercase tracking-widest text-muted mb-1">Client</dt>
                <dd class="font-display font-semibold text-ink text-base"><?php echo esc_html($client_name); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($timeline) : ?>
            <div>
                <dt class="text-label font-bold uppercase tracking-widest text-muted mb-1">Timeline</dt>
                <dd class="font-display font-semibold text-ink text-base"><?php echo esc_html($timeline); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($services_prov) : ?>
            <div>
                <dt class="text-label font-bold uppercase tracking-widest text-muted mb-1">Services</dt>
                <dd class="font-display font-semibold text-ink text-base"><?php echo esc_html($services_prov); ?></dd>
            </div>
            <?php endif; ?>
        </dl>
    </div>
</section>
<?php endif; ?>

<!-- ── Content (Gutenberg blocks) ────────────── -->
<div class="bg-white">
    <div class="container-site py-16 md:py-20">
        <div class="max-w-2xl prose prose-gray prose-headings:font-display prose-headings:font-extrabold prose-headings:text-ink prose-h2:text-3xl prose-h2:md:text-4xl prose-li:text-muted prose-p:text-muted">
            <?php the_content(); ?>
        </div>
    </div>
</div>

<!-- ── Bottom CTA Banner ─────────────────────── -->
<section class="bg-ink relative overflow-hidden mx-6 mb-10 rounded-2xl" aria-label="Start a project">
    <div class="absolute inset-0 dot-overlay opacity-60 pointer-events-none" aria-hidden="true"></div>
    <div class="relative z-10 py-16 md:py-20 text-center px-6">
        <h2 class="font-display font-extrabold text-white text-3xl md:text-4xl mb-3">
            Like what you see?
        </h2>
        <p class="text-cloud/60 text-base mb-8 max-w-sm mx-auto">
            Let's build something just as impactful for your organization.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">
                Start a Project &rarr;
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('case_study')); ?>" class="btn-ghost text-cloud hover:text-white">
                More Case Studies
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
