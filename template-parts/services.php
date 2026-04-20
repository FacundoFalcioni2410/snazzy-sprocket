<?php
/**
 * Services section — homepage
 */
$services = get_field('services');

// Default services if none set in ACF
if (empty($services)) {
    $services = [
        ['service_title' => 'UX & UI Design',          'service_desc' => 'Research-driven design systems that balance aesthetics with usability. We create interfaces people actually enjoy using.'],
        ['service_title' => 'Custom Development',      'service_desc' => 'Bespoke WordPress themes and applications built for performance, accessibility, and long-term maintainability.'],
        ['service_title' => 'SEO & Strategy',          'service_desc' => 'Data-backed strategies that improve visibility and convert visitors. Semantic markup and technical SEO baked in from day one.'],
        ['service_title' => 'Managed Hosting',         'service_desc' => 'Enterprise-grade hosting: security monitoring, and ongoing maintenance so you can focus on running your business.'],
        ['service_title' => 'Responsive Engineering',  'service_desc' => 'Every pixel considered across every breakpoint. Mobile-first development that performs at any screen size.'],
        ['service_title' => 'Accessibility',           'service_desc' => 'WCAG 2.1 AA compliance built into every project. Inclusive design isn\'t an afterthought — it\'s how we work.'],
    ];
}
?>

<section class="bg-white section-padding" aria-labelledby="services-heading">
    <div class="container-site">

        <!-- Header -->
        <div class="max-w-xl mb-14">
            <p class="section-label">What We Do</p>
            <h2 id="services-heading" class="section-title mb-4">
                Services built for growth
            </h2>
            <p class="text-muted text-base leading-relaxed">
                From concept to launch and beyond, we deliver end-to-end digital solutions that move the needle.
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-100">
            <?php foreach ($services as $index => $service) : ?>
            <article class="bg-white p-8 hover:bg-paper transition-colors duration-200">
                <span class="font-display font-bold text-cloud/50 text-sm tracking-widest mb-5 block">
                    <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                </span>
                <h3 class="font-display font-bold text-ink text-lg mb-3">
                    <?php echo esc_html($service['service_title']); ?>
                </h3>
                <p class="text-muted text-sm leading-relaxed">
                    <?php echo esc_html($service['service_desc']); ?>
                </p>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
