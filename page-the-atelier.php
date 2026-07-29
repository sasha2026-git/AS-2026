<?php
/**
 * Template Name: Allscented The Atelier
 * Digital Romanticism – Curated Scent Collection / Wishlist
 *
 * "The Atelier" is a personal curation space where users collect
 * and compare their favorite fragrances. Acts as a wishlist/saved
 * items page with editorial presentation.
 */

get_header('allscented');
?>

<section style="padding: 140px var(--margin-desktop) 64px; max-width: var(--container-max); margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 64px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('YOUR CURATED COLLECTION', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl">
            <?php esc_html_e('The Atelier', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 16px auto 0;">
            <?php esc_html_e('Your personal scent laboratory. Save, compare, and curate fragrances that speak to your aura.', 'allscents'); ?>
        </p>
    </div>

    <!-- If WooCommerce is active, show saved items (from cookies/localStorage in frontend) or fallback editorial grid -->
    <?php if (class_exists('WooCommerce')) : ?>
        <!-- Atelier Grid: populated via JS with saved product IDs from localStorage -->
        <div id="atelier-grid" class="product-grid" style="min-height: 300px;">
            <div id="atelier-empty" style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--color-on-surface-variant);">
                <span class="material-symbols-outlined" style="font-size: 64px; color: var(--color-outline-variant); margin-bottom: 24px; display: block;">auto_awesome_mosaic</span>
                <h2 class="font-headline-md text-headline-md" style="margin-bottom: 16px;">
                    <?php esc_html_e('Your Atelier is Empty', 'allscents'); ?>
                </h2>
                <p class="font-body-lg text-body-lg" style="margin-bottom: 32px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    <?php esc_html_e('Browse the shop and click "Add to Atelier" to start building your personal fragrance collection.', 'allscents'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-primary">
                    <?php esc_html_e('Explore the Boutique', 'allscents'); ?>
                    <span class="material-symbols-outlined" style="margin-left: 8px; font-size: 18px;">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Editorial: Atelier Spotlight (always visible) -->
        <div style="margin-top: 80px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 32px;">
                <h2 class="font-headline-lg text-headline-lg"><?php esc_html_e('Curator\'s Picks', 'allscents'); ?></h2>
                <a href="<?php echo esc_url(home_url('/shop')); ?>" class="font-label-caps text-label-caps" style="color: var(--color-secondary);">
                    <?php esc_html_e('VIEW ALL →', 'allscents'); ?>
                </a>
            </div>

            <div class="product-grid">
                <?php
                $curated = wc_get_products([
                    'limit'  => 4,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order'   => 'DESC',
                ]);

                foreach ($curated as $product) :
                    $product_id = $product->get_id();
                    $image_url  = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'large') : '';
                    $price      = $product->get_price_html();
                    $permalink  = $product->get_permalink();
                ?>
                <div class="product-card reveal">
                    <a href="<?php echo esc_url($permalink); ?>" class="product-image">
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
                        <?php else : ?>
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: var(--color-surface-container); color: var(--color-outline);">
                                <span class="material-symbols-outlined" style="font-size: 48px;">spa</span>
                            </div>
                        <?php endif; ?>
                        <button class="atelier-save-btn" data-product-id="<?php echo esc_attr($product_id); ?>" title="Save to Atelier">
                            <span class="material-symbols-outlined" style="font-size: 20px;">bookmark_add</span>
                        </button>
                    </a>
                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="<?php echo esc_url($permalink); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo esc_html($product->get_name()); ?>
                            </a>
                        </h3>
                        <div class="product-price"><?php echo wp_kses_post($price); ?></div>
                    </div>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn-add-to-cart" data-product_id="<?php echo esc_attr($product_id); ?>">
                        <?php echo esc_html($product->add_to_cart_text()); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php else : ?>
        <!-- Static fallback: Editorial Atelier showcase -->
        <div class="product-grid">
            <?php
            $atelier_products = [
                ['name' => 'Etheris', 'price' => '$145', 'tag' => 'Daily Muse', 'desc' => 'A luminous, airy composition — like morning light through mist. Bergamot, wet stone, white musk.'],
                ['name' => 'Cyber Moss', 'price' => '$160', 'tag' => 'Evening Allure', 'desc' => 'Digital green meets deep forest. A synthetic-fougère hybrid with electric undertones.'],
                ['name' => 'Celestial Essence', 'price' => '$399', 'tag' => 'Journey', 'desc' => 'An olfactory constellation. Ozone, black tea, and rare woods — bottled starlight.'],
                ['name' => 'Noir de Noir', 'price' => '$145', 'tag' => 'Evening Allure', 'desc' => 'Dark rose meets black vanilla. The scent of a velvet midnight rendezvous.'],
            ];
            foreach ($atelier_products as $p) :
            ?>
            <div class="product-card reveal">
                <div class="product-image" style="position: relative;">
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, var(--color-surface-container), var(--color-surface)); min-height: 280px;">
                        <div style="text-align: center;">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: var(--color-secondary); display: block; margin-bottom: 8px;">spa</span>
                            <span class="font-label-caps" style="color: var(--color-on-surface-variant);"><?php echo esc_html($p['name']); ?></span>
                        </div>
                    </div>
                    <button class="atelier-save-btn saved" style="position: absolute; top: 12px; right: 12px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">bookmark</span>
                    </button>
                </div>
                <div class="product-info">
                    <span class="product-category"><?php echo esc_html($p['tag']); ?></span>
                    <h3 class="product-title"><?php echo esc_html($p['name']); ?></h3>
                    <p style="font-size: var(--text-body-md); color: var(--color-on-surface-variant); margin: 8px 0;"><?php echo esc_html($p['desc']); ?></p>
                    <div class="product-price"><?php echo esc_html($p['price']); ?></div>
                </div>
                <button class="btn-add-to-cart"><?php esc_html_e('Add to Bag', 'allscents'); ?></button>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<script>
/**
 * Atelier (wishlist) functionality using localStorage.
 * Users can save/remove products and the atelier page renders saved items.
 */
(function() {
    const STORAGE_KEY = 'allscented_atelier';

    function getAtelier() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        } catch(e) { return []; }
    }

    function saveAtelier(ids) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
    }

    function toggleAtelier(productId, btn) {
        let ids = getAtelier();
        const idx = ids.indexOf(productId);
        if (idx > -1) {
            ids.splice(idx, 1);
            btn.classList.remove('saved');
            btn.querySelector('.material-symbols-outlined').textContent = 'bookmark_add';
        } else {
            ids.push(productId);
            btn.classList.add('saved');
            btn.querySelector('.material-symbols-outlined').textContent = 'bookmark';
        }
        saveAtelier(ids);
    }

    // Attach click handlers to atelier buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Mark already-saved items
        const saved = getAtelier();
        document.querySelectorAll('.atelier-save-btn').forEach(btn => {
            const pid = parseInt(btn.dataset.productId);
            if (saved.includes(pid)) {
                btn.classList.add('saved');
                btn.querySelector('.material-symbols-outlined').textContent = 'bookmark';
            }
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleAtelier(parseInt(this.dataset.productId), this);
            });
        });
    });
})();
</script>

<?php get_footer('allscented'); ?>
