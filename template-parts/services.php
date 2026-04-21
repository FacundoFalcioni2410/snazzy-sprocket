<?php
/**
 * Services section — homepage
 */
$services_headline    = get_field('services_headline')    ?: 'Services built for growth';
$services_description = get_field('services_description') ?: 'From concept to launch and beyond, we deliver end-to-end digital solutions that move the needle.';

$service_1 = [
    'title' => get_field('service_1_title') ?: 'UX & UI Design',
    'label' => get_field('service_1_label') ?: 'Research-driven design systems',
];
$service_2 = [
    'title' => get_field('service_2_title') ?: 'Custom Development',
    'label' => get_field('service_2_label') ?: 'Bespoke WordPress themes',
];
$service_3 = [
    'title' => get_field('service_3_title') ?: 'SEO & Strategy',
    'label' => get_field('service_3_label') ?: 'Data-backed strategies',
];
$service_4 = [
    'title' => get_field('service_4_title') ?: 'Managed Hosting',
    'label' => get_field('service_4_label') ?: 'Enterprise-grade hosting',
];
$service_5 = [
    'title' => get_field('service_5_title') ?: 'Responsive Engineering',
    'label' => get_field('service_5_label') ?: 'Mobile-first development',
];
$service_6 = [
    'title' => get_field('service_6_title') ?: 'Accessibility',
    'label' => get_field('service_6_label') ?: 'WCAG 2.1 AA compliance',
];

$services = array_filter([$service_1, $service_2, $service_3, $service_4, $service_5, $service_6], fn($s) => !empty($s['title']));
?>

<section class="bg-white section-padding" aria-labelledby="services-heading">
    <div class="container-site">

        <!-- Header -->
        <div class="max-w-xl mb-14">
            <p class="section-label">What We Do</p>
            <h2 id="services-heading" class="section-title mb-4">
                <?php echo esc_html($services_headline); ?>
            </h2>
            <p class="text-muted text-base leading-relaxed">
                <?php echo esc_html($services_description); ?>
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-cloud/30 border border-cloud/30">
            <?php foreach ($services as $index => $service) : ?>
            <article class="bg-white p-8 hover:bg-paper transition-colors duration-200">
                <span class="font-display font-bold text-cloud/50 text-sm tracking-widest mb-5 block">
                    <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                </span>
                <h3 class="font-display font-bold text-ink text-lg mb-3">
                    <?php echo esc_html($service['title']); ?>
                </h3>
                <p class="text-muted text-sm leading-relaxed">
                    <?php echo esc_html($service['label']); ?>
                </p>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
