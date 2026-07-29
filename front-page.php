<?php
/**
 * Front Page — AllScented "Discover"
 * Brand: AllScented — AI-Powered Fragrance
 * Design: Digital Romanticism
 */

get_header();
?>

<!-- ============================================ -->
<!-- HERO BANNER                                  -->
<!-- ============================================ -->
<section class="relative w-full overflow-hidden scroll-reveal" style="min-height:70vh;display:flex;align-items:center">
    <!-- Background image -->
    <div class="absolute inset-0 z-0">
        <img
            class="w-full h-full object-cover"
            src="https://images.unsplash.com/photo-1607349919526-3c42d1a43f3f?w=1600&q=80"
            alt="AllScented — AI Fragrance"
            loading="eager"
            style="filter:brightness(0.6)"
        >
        <!-- Gradient overlay -->
        <div class="absolute inset-0" style="background:linear-gradient(to top,rgb(252,249,248) 0%,rgba(252,249,248,0.15) 100%);"></div>
    </div>

    <div class="relative z-10 container-max px-margin-desktop w-full" style="padding-top:60px;padding-bottom:100px;">
        <div class="max-w-3xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block" style="color:var(--secondary);text-shadow:0 2px 8px rgba(0,0,0,0.2);">ALLSCENTED · SENSORY INTELLIGENCE</span>
            <h1 class="font-headline-xl text-headline-xl mb-6" style="color:#fff;text-shadow:0 4px 20px rgba(0,0,0,0.3);font-size:clamp(2.5rem,8vw,6rem);">
                Where Memory<br class="mobile-only"> Becomes Scent
            </h1>
            <p class="font-body-lg text-body-lg mb-8 max-w-xl" style="color:rgba(255,255,255,0.85);text-shadow:0 2px 8px rgba(0,0,0,0.2);">
                Describe the scent of your deepest memory, and our neural alchemy engine renders it into molecular reality — a fragrance built by AI, for your aura.
            </p>
            <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn font-label-caps text-label-caps tracking-widest uppercase" style="padding:16px 40px;border-radius:9999px;font-size:13px;">
                BEGIN YOUR AI SYNTHESIS
                <span class="material-symbols-outlined ml-2" style="font-size:16px;">auto_awesome</span>
            </a>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- SENSORY INTELLIGENCE — Input Section        -->
<!-- ============================================ -->
<section class="px-margin-desktop container-max scroll-reveal" style="margin-top:-40px;margin-bottom:80px;position:relative;z-index:20;">
    <div class="aura-glass rounded-2xl p-8 md:p-12">
        <div class="flex flex-wrap gap-3 mb-8">
            <?php
            $tags = array(
                array('label' => 'Mood Match', 'icon' => 'psychology'),
                array('label' => 'Scent Twin Finder', 'icon' => 'search_insights'),
                array('label' => 'Data Profile', 'icon' => 'neurology'),
            );
            foreach ($tags as $tag) : ?>
                <span class="font-label-caps text-label-caps category-tag inline-flex items-center gap-2 px-4 py-2 rounded-full border" style="border-color:var(--outline-variant);color:var(--on-surface-variant);cursor:pointer;transition:all 0.3s ease;">
                    <span class="material-symbols-outlined" style="font-size:14px;"><?php echo esc_attr($tag['icon']); ?></span>
                    <?php echo esc_html($tag['label']); ?>
                </span>
            <?php endforeach; ?>
        </div>

        <textarea
            class="w-full bg-transparent border-none outline-none resize-none font-body-lg text-body-lg"
            style="min-height:100px;color:var(--on-surface);"
            placeholder="<?php echo esc_attr(get_field('allscented_hero_placeholder') ?: 'Tell me a story... \'A rainy afternoon in Kyoto, cedarwood and wet stone...\''); ?>"
        ></textarea>

        <div class="flex items-center justify-between mt-6 flex-wrap gap-4">
            <span class="font-label-caps text-label-caps" style="color:var(--on-surface-variant);">Powered by neural alchemy engine &bull; 12,000+ molecular profiles</span>
            <button class="iridescent-btn px-6 py-3 rounded-full font-label-caps text-label-caps tracking-widest uppercase" style="font-size:12px;">
                Synthesize
                <span class="material-symbols-outlined ml-1" style="font-size:14px;">auto_awesome</span>
            </button>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- THE ARCHIVE — Section Preview               -->
<!-- ============================================ -->
<section class="scroll-reveal" style="background:color-mix(in srgb,var(--surface) 40%,transparent);padding:80px 0;margin-bottom:80px;">
    <div class="px-margin-desktop container-max">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter mb-12">
            <div>
                <span class="font-label-caps text-label-caps text-secondary mb-2 block">THE ARCHIVE</span>
                <h2 class="font-headline-lg text-headline-lg">Curated Synthetics</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/archive/')); ?>" class="font-label-caps text-label-caps tracking-widest iridescent-btn px-6 py-3 rounded-full" style="flex-shrink:0;font-size:12px;text-decoration:none;">
                Explore More
                <span class="material-symbols-outlined ml-1" style="font-size:14px;">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php
            $archive_items = array(
                array('title' => 'Dark Alchemy', 'cat' => 'FOR HOME', 'img' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80'),
                array('title' => 'Vesper Muse', 'cat' => 'FOR PERSONAL', 'img' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80'),
                array('title' => 'Synthetic Dawn', 'cat' => 'FOR COMMERCIAL', 'img' => 'https://images.unsplash.com/photo-1615639070588-8e152bf1f0b0?w=400&q=80'),
                array('title' => 'Nocturne Waves', 'cat' => 'FOR HOME', 'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&q=80'),
            );
            foreach ($archive_items as $item) : ?>
                <div class="relative rounded-xl overflow-hidden group cursor-pointer aspect-square">
                    <img
                        class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105"
                        src="<?php echo esc_url($item['img']); ?>"
                        alt="<?php echo esc_attr($item['title']); ?>"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <div>
                            <span class="font-label-caps text-label-caps text-secondary-fixed-dim"><?php echo esc_html($item['cat']); ?></span>
                            <h3 class="font-headline-md text-headline-md text-surface" style="font-size:18px;"><?php echo esc_html($item['title']); ?></h3>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
get_footer();
