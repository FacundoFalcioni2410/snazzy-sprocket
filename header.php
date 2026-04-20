<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white'); ?>>
<?php wp_body_open(); ?>

<header class="bg-ink sticky top-0 z-50 border-b border-white/5">
    <div class="container-site">
        <nav class="flex items-center justify-between h-16" aria-label="Primary navigation">

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group" aria-label="<?php bloginfo('name'); ?> — Home">
                <span class="w-8 h-8 bg-accent rounded-sm flex items-center justify-center flex-shrink-0" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="8" cy="8" r="3" fill="#090F1A"/>
                        <path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.05 3.05l1.41 1.41M11.54 11.54l1.41 1.41M3.05 12.95l1.41-1.41M11.54 4.46l1.41-1.41" stroke="#090F1A" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="font-display font-bold text-white text-base tracking-tight group-hover:text-accent transition-colors duration-150">
                    Snazzy Sprocket
                </span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-8">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-8',
                    'fallback_cb'    => function() {
                        echo '<ul class="flex items-center gap-8">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '" class="nav-link">Home</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/about')) . '" class="nav-link">About</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/case-studies')) . '" class="nav-link">Case Studies</a></li>';
                        echo '</ul>';
                    },
                    'items_wrap'     => '<ul class="flex items-center gap-8" id="%1$s">%3$s</ul>',
                    'walker'         => new class extends Walker_Nav_Menu {
                        public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0) {
                            $output .= '<li>';
                            $output .= '<a href="' . esc_url($data_object->url) . '" class="nav-link">' . esc_html($data_object->title) . '</a>';
                            $output .= '</li>';
                        }
                    },
                ]);
                ?>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary text-xs px-5 py-2.5">
                    Get In Touch
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button id="nav-toggle" class="md:hidden flex items-center p-2 text-cloud hover:text-accent transition-colors" aria-label="Toggle menu" aria-expanded="false" aria-controls="nav-menu">
                <svg id="nav-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="nav-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        <!-- Mobile menu -->
        <div id="nav-menu" class="hidden md:hidden border-t border-white/10 py-4">
            <ul class="flex flex-col gap-1">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="block py-2 nav-link">Home</a></li>
                <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="block py-2 nav-link">About</a></li>
                <li><a href="<?php echo esc_url(home_url('/case-studies')); ?>" class="block py-2 nav-link">Case Studies</a></li>
                <li class="pt-2">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary text-xs px-5 py-2.5 w-full justify-center">
                        Get In Touch
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
