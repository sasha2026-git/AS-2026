<?php
/**
 * Template Name: Contact
 */

defined('ABSPATH') || exit;

get_header();

$contact_label  = allscented_field('allscented_contact_label', 'GET IN TOUCH');
$contact_heading = allscented_field('allscented_contact_heading', 'Contact');
$contact_intro   = allscented_field('allscented_contact_intro', 'Questions about our fragrances, orders, or collaborations — we\'d love to hear from you.');
$contact_info_label = allscented_field('allscented_contact_info_label', 'CONTACT DETAILS');
$contact_email   = allscented_field('allscented_contact_email', 'info@allscented.com');
$contact_phone   = allscented_field('allscented_contact_phone', '+852 46090901');
$contact_address = allscented_field('allscented_contact_address', '');
$contact_image   = allscented_image_url('allscented_contact_image', '');
$contact_form_label = allscented_field('allscented_contact_form_label', 'SEND A MESSAGE');
        $contact_form_intro = allscented_field('allscented_contact_form_intro', '');
$contact_name_label = allscented_field('allscented_contact_name_label', 'Name');
$contact_email_label = allscented_field('allscented_contact_email_label', 'Email');
$contact_message_label = allscented_field('allscented_contact_message_label', 'Message');
$contact_submit_label = allscented_field('allscented_contact_submit_label', 'Send Message');
        $contact_success_message = allscented_field('allscented_contact_success_message', 'Thank you. Your message has been sent.');
        $contact_error_message = allscented_field('allscented_contact_error_message', 'Sorry, your message could not be sent. Please try again.');
$facebook_url    = allscented_field('allscented_contact_facebook_url', '');
$instagram_url   = allscented_field('allscented_contact_instagram_url', '');
$contact_status  = isset($_GET['contact_status']) ? sanitize_key(wp_unslash($_GET['contact_status'])) : '';
?>

<div id="page-contact" class="contact-page px-margin-desktop container-max">
    <section class="contact-hero">
        <span class="font-label-caps text-label-caps text-secondary block contact-label"><?php echo esc_html($contact_label); ?></span>
        <h1 class="font-headline-lg text-headline-lg contact-title"><?php echo esc_html($contact_heading); ?></h1>
        <p class="contact-intro font-body-lg text-body-lg"><?php echo esc_html($contact_intro); ?></p>
    </section>

    <div class="contact-layout">
        <aside class="aura-glass contact-info-card">
            <span class="font-label-caps text-label-caps contact-section-label"><?php echo esc_html($contact_info_label); ?></span>
            <?php if ($contact_image !== '') : ?>
            <div class="contact-info-image" style="margin-bottom:20px">
                <img src="<?php echo esc_url($contact_image); ?>" alt="" loading="lazy" style="width:100%;border-radius:10px;display:block">
            </div>
            <?php endif; ?>
            <div class="contact-info-list">
                <a class="contact-meta-link" href="mailto:<?php echo esc_attr($contact_email); ?>">
                    <span class="material-symbols-outlined" aria-hidden="true">mail</span>
                    <span><?php echo esc_html($contact_email); ?></span>
                </a>
                <a class="contact-meta-link" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>">
                    <span class="material-symbols-outlined" aria-hidden="true">call</span>
                    <span><?php echo esc_html($contact_phone); ?></span>
                </a>
                <?php if ($contact_address !== '') : ?>
                <div class="contact-meta-link">
                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                    <span><?php echo nl2br(esc_html($contact_address)); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </aside>

        <section class="aura-glass contact-form-card">
            <span class="font-label-caps text-label-caps contact-section-label"><?php echo esc_html($contact_form_label); ?></span>
            <?php if ($contact_form_intro !== '') : ?>
            <p class="contact-form-intro font-body-md"><?php echo esc_html($contact_form_intro); ?></p>
            <?php endif; ?>

            <?php if ($contact_status === 'success') : ?>
                <div class="contact-status contact-status-success" role="status"><?php echo esc_html($contact_success_message); ?></div>
            <?php elseif ($contact_status === 'failed') : ?>
                <div class="contact-status contact-status-error" role="alert"><?php echo esc_html($contact_error_message); ?></div>
            <?php endif; ?>

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
                <input type="hidden" name="action" value="allscented_contact">
                <?php wp_nonce_field('allscented_contact_action', 'allscented_contact_nonce'); ?>
                <div class="contact-honeypot" aria-hidden="true">
                    <label for="allscented-website">Website</label>
                    <input type="text" name="allscented_website" id="allscented-website" tabindex="-1" autocomplete="off">
                </div>
                <div class="contact-field">
                    <label for="allscented-name"><?php echo esc_html($contact_name_label); ?></label>
                    <input type="text" id="allscented-name" name="allscented_name" required autocomplete="name">
                </div>
                <div class="contact-field">
                    <label for="allscented-email"><?php echo esc_html($contact_email_label); ?></label>
                    <input type="email" id="allscented-email" name="allscented_email" required autocomplete="email">
                </div>
                <div class="contact-field">
                    <label for="allscented-message"><?php echo esc_html($contact_message_label); ?></label>
                    <textarea id="allscented-message" name="allscented_message" rows="6" required></textarea>
                </div>
                <button class="iridescent-btn contact-submit font-label-caps text-label-caps" type="submit">
                    <span><?php echo esc_html($contact_submit_label); ?></span>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </button>
            </form>

            <?php if ($facebook_url !== '' || $instagram_url !== '') : ?>
            <div class="contact-social">
                <?php if ($facebook_url !== '') : ?>
                <a class="contact-social-icon" href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7h2.4l.4-3h-2.8V9.1c0-.9.3-1.6 1.7-1.6h1.3V4.8c-.6-.1-1.5-.2-2.5-.2-2.5 0-4.2 1.5-4.2 4.2v2.2H7.4v3h2.4v7h3.7Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($instagram_url !== '') : ?>
                <a class="contact-social-icon" href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 8.2a3.8 3.8 0 1 0 0 7.6 3.8 3.8 0 0 0 0-7.6Zm0 6.1a2.3 2.3 0 1 1 0-4.6 2.3 2.3 0 0 1 0 4.6Zm4.6-6.2a.9.9 0 1 1-1.8 0 .9.9 0 0 1 1.8 0Zm2.6-.5c0-1.5-.3-2.6-1-3.3-.7-.7-1.8-1-3.3-1H9.1c-1.5 0-2.6.3-3.3 1-.7.7-1 1.8-1 3.3v5.8c0 1.5.3 2.6 1 3.3.7.7 1.8 1 3.3 1h5.8c1.5 0 2.6-.3 3.3-1 .7-.7 1-1.8 1-3.3V7.6Zm-1.4 5.8c0 1.4-.3 2.2-.7 2.7-.5.5-1.3.7-2.7.7H9.6c-1.4 0-2.2-.2-2.7-.7-.5-.5-.7-1.3-.7-2.7V7.6c0-1.4.2-2.2.7-2.7.5-.5 1.3-.7 2.7-.7h5.8c1.4 0 2.2.2 2.7.7.5.5.7 1.3.7 2.7v5.8Z"/></svg>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php
get_footer();
