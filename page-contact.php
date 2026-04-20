<?php
/**
 * Template Name: Contact Page
 *
 * Assign to a page with slug "contact" in WP Admin → Page Attributes → Template,
 * OR WordPress will auto-select it for a page whose slug is "contact".
 */
get_header();

$email     = get_field('contact_email')     ?: 'hello@snazzysprocket.com';
$phone     = get_field('contact_phone')     ?: '(215) 555-0147';
$office    = get_field('contact_office')    ?: '1247 Market Street, Suite 400, Philadelphia, PA 19107';
$hours     = get_field('contact_hours')     ?: 'Monday – Friday, 9:00 AM – 6:00 PM EST';
$map_embed = get_field('contact_map_embed') ?: '';
$twitter   = get_field('contact_twitter')   ?: '#';
$linkedin  = get_field('contact_linkedin')  ?: '#';
$dribbble  = get_field('contact_dribbble')  ?: '#';

$sent  = isset($_GET['sent']);
?>

<!-- ── Hero ─────────────────────────────────── -->
<section class="bg-ink" aria-label="Contact hero">
    <div class="container-site py-20 md:py-28">
        <p class="section-label">Contact</p>
        <h1 class="font-display font-extrabold text-white leading-[1.05]
                    text-4xl sm:text-5xl lg:text-6xl mb-6 max-w-xl">
            Let's build something together
        </h1>
        <p class="text-cloud/60 text-base md:text-lg leading-relaxed max-w-md">
            Fill out the form below and we'll get back to you within one business day.
        </p>
    </div>
</section>

<!-- ── Form + Info ───────────────────────────── -->
<section class="bg-white section-padding" aria-labelledby="contact-form-heading">
    <div class="container-site">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-10 lg:gap-12 items-start">

            <!-- Left: Form -->
            <div>
                <h2 id="contact-form-heading" class="sr-only">Contact Form</h2>

                <?php if ($sent) : ?>
                <div class="bg-accent/10 border border-accent/30 rounded-xl p-5 mb-8 text-accent font-display font-semibold">
                    Message sent! We'll be in touch within one business day.
                </div>
                <?php endif; ?>

                <form method="POST" action="" novalidate class="space-y-5">
                    <?php wp_nonce_field('ss_contact_form', 'ss_contact_nonce'); ?>

                    <!-- First / Last name -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="first_name" class="form-label">First Name <span class="text-brand-accent" aria-hidden="true">*</span></label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                class="form-input"
                                placeholder="Jane"
                                required
                                value="<?php echo esc_attr($_POST['first_name'] ?? ''); ?>"
                            >
                        </div>
                        <div>
                            <label for="last_name" class="form-label">Last Name</label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="form-input"
                                placeholder="Smith"
                                value="<?php echo esc_attr($_POST['last_name'] ?? ''); ?>"
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">Email Address <span class="text-brand-accent" aria-hidden="true">*</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="jane@company.com"
                            required
                            value="<?php echo esc_attr($_POST['email'] ?? ''); ?>"
                        >
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="form-label">Company</label>
                        <input
                            type="text"
                            id="company"
                            name="company"
                            class="form-input"
                            placeholder="Acme Corp"
                            value="<?php echo esc_attr($_POST['company'] ?? ''); ?>"
                        >
                    </div>

                    <!-- Budget -->
                    <div>
                        <label for="budget" class="form-label">Project Budget</label>
                        <select id="budget" name="budget" class="form-input bg-white">
                            <option value="" disabled <?php selected(empty($_POST['budget'] ?? '')); ?>>Select a range…</option>
                            <option value="Under $10k"    <?php selected(($_POST['budget'] ?? ''), 'Under $10k'); ?>>Under $10k</option>
                            <option value="$10k – $25k"   <?php selected(($_POST['budget'] ?? ''), '$10k – $25k'); ?>>$10k – $25k</option>
                            <option value="$25k – $50k"   <?php selected(($_POST['budget'] ?? ''), '$25k – $50k'); ?>>$25k – $50k</option>
                            <option value="$50k – $100k"  <?php selected(($_POST['budget'] ?? ''), '$50k – $100k'); ?>>$50k – $100k</option>
                            <option value="$100k+"        <?php selected(($_POST['budget'] ?? ''), '$100k+'); ?>>$100k+</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="form-label">Tell Us About Your Project <span class="text-brand-accent" aria-hidden="true">*</span></label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="form-input resize-none"
                            placeholder="Describe your project goals, timeline, and any specific requirements…"
                            required
                        ><?php echo esc_textarea($_POST['message'] ?? ''); ?></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-primary w-full justify-center py-4 text-sm tracking-wider">
                        Send Message &rarr;
                    </button>
                </form>
            </div>

            <!-- Right: Contact info card -->
            <aside class="bg-ink-light rounded-2xl p-8 text-cloud" aria-label="Contact information">
                <h2 class="font-display font-bold text-white text-2xl mb-2">Get in touch</h2>
                <p class="text-muted text-sm mb-8">Prefer to reach out directly? Here's how to find us.</p>

                <ul class="space-y-6">
                    <!-- Email -->
                    <li class="flex items-start gap-4">
                        <span class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-label text-muted uppercase tracking-widest font-bold mb-0.5">Email</p>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-white text-sm hover:text-accent transition-colors">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    </li>

                    <!-- Phone -->
                    <li class="flex items-start gap-4">
                        <span class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <div>
                            <p class="text-label text-muted uppercase tracking-widest font-bold mb-0.5">Phone</p>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', $phone)); ?>" class="text-white text-sm hover:text-accent transition-colors">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </div>
                    </li>

                    <!-- Office -->
                    <li class="flex items-start gap-4">
                        <span class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-label text-muted uppercase tracking-widest font-bold mb-0.5">Office</p>
                            <p class="text-white text-sm leading-relaxed"><?php echo esc_html($office); ?></p>
                        </div>
                    </li>

                    <!-- Hours -->
                    <li class="flex items-start gap-4">
                        <span class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-label text-muted uppercase tracking-widest font-bold mb-0.5">Hours</p>
                            <p class="text-white text-sm leading-relaxed"><?php echo esc_html($hours); ?></p>
                        </div>
                    </li>
                </ul>

                <!-- Social -->
                <div class="mt-8 pt-6 border-t border-white/10">
                    <p class="text-label text-muted uppercase tracking-widest font-bold mb-4">Follow Us</p>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center hover:bg-accent/20 transition-colors group" aria-label="Twitter / X">
                            <svg class="w-4 h-4 text-muted group-hover:text-accent transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.259 5.631 5.905-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center hover:bg-accent/20 transition-colors group" aria-label="LinkedIn">
                            <svg class="w-4 h-4 text-muted group-hover:text-accent transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="<?php echo esc_url($dribbble); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center hover:bg-accent/20 transition-colors group" aria-label="Dribbble">
                            <svg class="w-4 h-4 text-muted group-hover:text-accent transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 6.628 5.374 12 12 12 6.627 0 12-5.372 12-12 0-6.627-5.373-12-12-12zm7.369 5.338c1.297 1.561 2.097 3.545 2.123 5.707-2.87-.611-5.497-.524-7.888.093-.226-.532-.46-1.055-.706-1.564 2.612-1.072 4.666-2.607 6.471-4.236zM12 2.077c2.136 0 4.1.726 5.664 1.927-1.688 1.536-3.637 2.982-6.102 3.966C10.43 5.782 9.09 3.77 7.737 2.28A10.085 10.085 0 0112 2.077zM5.593 3.326c1.398 1.492 2.765 3.515 3.877 5.731-2.818.72-5.948.886-8.81.545A10.017 10.017 0 015.593 3.326zm-3.517 8.84l.023-.467c3.14.406 6.562.19 9.594-.65.192.389.376.781.55 1.176-3.35 1.008-6.123 3.124-8.17 5.876a9.903 9.903 0 01-2-5.935zm4.006 7.534c1.93-2.685 4.637-4.75 7.862-5.692.827 2.145 1.404 4.388 1.698 6.694A9.903 9.903 0 0112 21.923a9.958 9.958 0 01-5.918-2.223zm8.068 1.484a31.785 31.785 0 00-1.614-6.366c2.108-.38 4.467-.2 7.03.488a9.96 9.96 0 01-5.416 5.878z"/></svg>
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

<!-- ── Map ───────────────────────────────────── -->
<section class="bg-paper py-10" aria-label="Office location map">
    <div class="container-site">
        <div class="rounded-2xl overflow-hidden bg-fog/30 aspect-[16/5] flex items-center justify-center border border-cloud/40">
            <?php if (!empty($map_embed)) : ?>
                <?php echo wp_kses($map_embed, ['iframe' => ['src' => [], 'width' => [], 'height' => [], 'style' => [], 'allowfullscreen' => [], 'loading' => [], 'referrerpolicy' => [], 'title' => []]]); ?>
            <?php else : ?>
            <p class="text-muted/40 text-sm font-display">Embedded Map — Google Maps or Mapbox</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
