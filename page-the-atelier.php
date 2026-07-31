<?php
/**
 * Template Name: The Atelier
 */
get_header();
?>
id="page-the-atelier">
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">THE ATELIER</span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:4px">Shop the <span class="italic text-secondary">Collection</span></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px">Each fragrance is AI-synthesized and hand-finished. Free shipping on all orders.</p>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="display:flex;gap:8px;overflow-x:auto;-webkit-overflow-scrolling:touch;padding-bottom:4px;margin-bottom:20px">
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;white-space:nowrap;font-size:10px" data-filter="all">All</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="personal">Personal</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="home">Home</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="commercial">Commercial</button>
        </div>
        <!-- Uniform 2-col mobile / 3-col desktop grid -->
        <div id="atelier-grid">
            <div class="shop-item" data-category="personal" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80" alt="Aura No.1" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Aura No. 1</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Personal · Ozone</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$185.00</span>
            </div>
            <div class="shop-item" data-category="personal" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80" alt="Aura No.2" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Aura No. 2</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Personal · Oud</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$210.00</span>
            </div>
            <div class="shop-item" data-category="home" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&q=80" alt="Atmospheric Flux" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Atmospheric Flux</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Home · Adaptive</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$240.00</span>
            </div>
            <div class="shop-item" data-category="commercial" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400&q=80" alt="Spatial Bloom" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Spatial Bloom</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Commercial · Ambient</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$320.00</span>
            </div>
            <div class="shop-item" data-category="personal" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=400&q=80" alt="Vesper Muse" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Vesper Muse</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Personal · Floral</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$185.00</span>
            </div>
            <div class="shop-item" data-category="commercial" style="text-align:center">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&q=80" alt="Nordic Noir" style="width:55%;height:55%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Nordic Noir</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:8px;margin-bottom:4px">Commercial · Forest</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$280.00</span>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block">WHOLESALE</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:6px;font-style:italic">For Your Space</h2>
            <p class="font-body-md" style="margin-bottom:12px;color:var(--surface-variant);font-size:13px">Curate a signature scent for your boutique, hotel, or private residence.</p>
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 24px;border-radius:999px;font-size:10px" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Request Consultation</a>
        </div>
    </section>
</div>

<?php get_footer(); ?>
