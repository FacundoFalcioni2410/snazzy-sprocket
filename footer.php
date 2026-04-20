    <!-- Footer -->
    <footer class="bg-ink text-cloud" role="contentinfo">
        <div class="container-site py-16">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 md:gap-8">

                <!-- Brand col -->
                <div class="md:col-span-2">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 mb-4" aria-label="<?php bloginfo('name'); ?> — Home">
                        <span class="w-8 h-8 bg-accent rounded-sm flex items-center justify-center flex-shrink-0" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="3" fill="#090F1A"/>
                                <path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.05 3.05l1.41 1.41M11.54 11.54l1.41 1.41M3.05 12.95l1.41-1.41M11.54 4.46l1.41-1.41" stroke="#090F1A" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="font-display font-bold text-white text-base tracking-tight">Snazzy Sprocket</span>
                    </a>
                    <p class="text-sm text-muted leading-relaxed max-w-xs">
                        High-performance digital experiences for ambitious brands. Based in Philadelphia, working worldwide.
                    </p>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="font-display font-bold text-white text-xs uppercase tracking-widest mb-5">Company</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="text-muted hover:text-accent transition-colors duration-150">About</a></li>
                        <li><a href="<?php echo esc_url(home_url('/case-studies')); ?>" class="text-muted hover:text-accent transition-colors duration-150">Case Studies</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-muted hover:text-accent transition-colors duration-150">Contact</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Careers</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="font-display font-bold text-white text-xs uppercase tracking-widest mb-5">Services</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Web Design</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Development</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">SEO</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Hosting</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div>
                    <h3 class="font-display font-bold text-white text-xs uppercase tracking-widest mb-5">Connect</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Twitter / X</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">LinkedIn</a></li>
                        <li><a href="#" class="text-muted hover:text-accent transition-colors duration-150">Dribbble</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-muted hover:text-accent transition-colors duration-150">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="border-t border-white/10 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-muted">
                    &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.
                </p>
                <p class="text-xs text-muted/60">Crafted with WordPress &amp; Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
