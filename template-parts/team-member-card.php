<?php
/**
 * Team Member card — used on the About page team grid.
 * Expects to be called inside a WP_Query loop over team_member CPT.
 */
$role    = get_field('role');
$photo   = get_field('photo');
$bio     = get_field('bio');
$linkedin = get_field('linkedin_url');

// Generate colored avatar from initials when no photo
$name     = get_the_title();
$words    = explode(' ', trim($name));
$initials = '';
foreach (array_slice($words, 0, 2) as $word) {
    $initials .= strtoupper(mb_substr($word, 0, 1));
}

// Deterministic color from name hash — cycles through brand palette
$avatar_colors = [
    'bg-accent text-ink',
    'bg-slate text-white',
    'bg-accent-teal text-white',
    'bg-steel text-white',
    'bg-ink-light text-accent',
    'bg-accent-dim text-white',
];
$color_class = $avatar_colors[crc32($name) % count($avatar_colors)];
?>

<article class="flex flex-col items-center text-center p-4" aria-label="<?php echo esc_attr($name); ?>">

    <!-- Avatar or photo -->
    <div class="w-14 h-14 rounded-md overflow-hidden mb-3 flex-shrink-0">
        <?php if (!empty($photo)) : ?>
        <img
            src="<?php echo esc_url(ss_get_image_src($photo, 'thumbnail')); ?>"
            alt="<?php echo esc_attr($name); ?>"
            class="w-full h-full object-cover"
            loading="lazy"
        >
        <?php else : ?>
        <div class="w-full h-full flex items-center justify-center font-display font-bold text-base <?php echo esc_attr($color_class); ?>">
            <?php echo esc_html($initials); ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Name -->
    <h3 class="font-display font-bold text-ink text-sm leading-tight mb-0.5">
        <?php if ($linkedin) : ?>
        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-accent transition-colors duration-150">
            <?php the_title(); ?>
        </a>
        <?php else : ?>
        <?php the_title(); ?>
        <?php endif; ?>
    </h3>

    <!-- Role -->
    <?php if ($role) : ?>
    <p class="text-accent text-label font-bold uppercase tracking-widest mb-2">
        <?php echo esc_html($role); ?>
    </p>
    <?php endif; ?>

    <!-- Bio -->
    <?php if ($bio) : ?>
    <p class="text-muted text-xs leading-relaxed">
        <?php echo esc_html($bio); ?>
    </p>
    <?php endif; ?>

</article>
