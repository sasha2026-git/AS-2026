<?php
/**
 * Template Name: Archive
 */
get_header();
?>
<div id="page-archive">
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">FRAGRANCE ARCHIVE</span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:4px">Browse by <span class="italic text-secondary">Category</span></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px">Explore our complete library of AI-synthesized scents, curated for every space and experience.</p>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="display:flex;gap:8px;overflow-x:auto;-webkit-overflow-scrolling:touch;padding-bottom:4px;margin-bottom:20px">
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;white-space:nowrap;font-size:10px" data-filter="all">All</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="personal">Personal</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="home">Home</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:10px" data-filter="commercial">Commercial</button>
        </div>
        <div id="archive-personal" style="margin-bottom:24px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:10px">FOR PERSONAL</span>
                <div style="flex:1;height:1px;background:color-mix(in srgb,var(--outline-variant)30%,transparent)"></div>
            </div>
            <div class="archive-items-grid">
                <div class="aura-glass archive-item" style="border-radius:12px;padding:14px;display:flex;gap:12px" data-category="personal">
                    <div style="width:80px;height:80px;border-radius:8px;overflow:hidden;flex-shrink:0">
                        <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=300&q=80" alt="Vesper Muse" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                    </div>
                    <div style="flex:1;min-width:0">
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-bottom:2px">Vesper Muse</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:11px;margin-bottom:4px">Night-blooming jasmine, metallic aldehydes, grey amber.</p>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:4px">
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">INTIMATE</span>
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">EVENING</span>
                        </div>
                        <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$185.00</span>
                    </div>
                </div>
                <div class="aura-glass archive-item" style="border-radius:12px;padding:14px;display:flex;gap:12px" data-category="personal">
                    <div style="width:80px;height:80px;border-radius:8px;overflow:hidden;flex-shrink:0">
                        <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=300&q=80" alt="Aura No.1" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                    </div>
                    <div style="flex:1;min-width:0">
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-bottom:2px">Aura No. 1</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:11px;margin-bottom:4px">Ozone, white musk, sea salt. A morning walk through coastal mist.</p>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:4px">
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SERENE</span>
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">MORNING</span>
                        </div>
                        <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$185.00</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="archive-home" style="margin-bottom:24px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:10px">FOR HOME</span>
                <div style="flex:1;height:1px;background:color-mix(in srgb,var(--outline-variant)30%,transparent)"></div>
            </div>
            <div class="archive-items-grid">
                <div class="aura-glass archive-item" style="border-radius:12px;padding:14px;display:flex;gap:12px" data-category="home">
                    <div style="width:80px;height:80px;border-radius:8px;overflow:hidden;flex-shrink:0">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=300&q=80" alt="Atmospheric Flux" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                    </div>
                    <div style="flex:1;min-width:0">
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-bottom:2px">Atmospheric Flux</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:11px;margin-bottom:4px">Cedarwood, amber, petrichor. Adapts to light cycles and biometric data.</p>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:4px">
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">ADAPTIVE</span>
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SPACE</span>
                        </div>
                        <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$240.00</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="archive-commercial" style="margin-bottom:24px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:10px">FOR COMMERCIAL</span>
                <div style="flex:1;height:1px;background:color-mix(in srgb,var(--outline-variant)30%,transparent)"></div>
            </div>
            <div class="archive-items-grid">
                <div class="aura-glass archive-item" style="border-radius:12px;padding:14px;display:flex;gap:12px" data-category="commercial">
                    <div style="width:80px;height:80px;border-radius:8px;overflow:hidden;flex-shrink:0">
                        <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=300&q=80" alt="Brand Osmosis" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                    </div>
                    <div style="flex:1;min-width:0">
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-bottom:2px">Brand Osmosis</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:11px;margin-bottom:4px">Saffron, leather, smoke. Architectural scenting for luxury retail environments.</p>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:4px">
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">LUXURY</span>
                            <span class="font-label-caps" style="font-size:8px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">RETAIL</span>
                        </div>
                        <span class="font-label-caps" style="font-size:9px;padding:2px 8px;border-radius:4px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">CUSTOM</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block">CURIOUS?</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:6px;font-style:italic">Can't find what you're looking for?</h2>
            <p class="font-body-md" style="margin-bottom:12px;color:var(--surface-variant);font-size:13px">Our AI can create a bespoke scent from a single word. Describe what you imagine.</p>
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 24px;border-radius:999px;font-size:10px" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Begin Your Brief</a>
        </div>
    </section>
</div>
<!-- ===== THE ATELIER ===== -->

<?php get_footer(); ?>
