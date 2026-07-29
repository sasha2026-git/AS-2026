<?php
/**
 * Template Name: Archive
 * Description: AllScented Archive — Browse by Category
 */

get_header();
?>

<section class="px-margin-desktop container-max scroll-reveal mb-12">
    <span class="font-label-caps text-label-caps text-secondary mb-2 block">THE ARCHIVE</span>
    <h1 class="font-headline-lg text-headline-lg mb-4">Browse by Category</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">Explore our complete library of AI-crafted fragrance profiles, sorted by aura and intention.</p>
</section>

<!-- Filter Tabs -->
<section class="px-margin-desktop container-max scroll-reveal mb-12">
    <div class="flex gap-3 flex-wrap overflow-x-auto no-scrollbar pb-2">
        <?php
        $archive_filters = array(
            'all' => 'All',
            'personal' => 'FOR PERSONAL',
            'home' => 'FOR HOME',
            'commercial' => 'FOR COMMERCIAL',
        );
        foreach ($archive_filters as $key => $label) : ?>
            <button
                class="filter-btn font-label-caps text-label-caps px-5 py-2 rounded-full border transition-all duration-300"
                data-filter="<?php echo esc_attr($key); ?>"
                style="border-color:var(--outline-variant);color:var(--on-surface-variant);cursor:pointer;flex-shrink:0;font-size:11px;<?php echo $key === 'all' ? 'border-color:var(--secondary);color:var(--secondary);' : ''; ?>"
            ><?php echo esc_html($label); ?></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- Archive Items -->
<section class="px-margin-desktop container-max scroll-reveal mb-32">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="archive-grid">
        <?php
        $archive_items = array(
            array('title' => 'Vesper Muse', 'cat' => 'personal', 'tag' => 'MOODY & COMPLEX', 'price' => '$180', 'desc' => 'A transient blend of night-blooming jasmine and cold metallic aldehydes.', 'img' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=500&q=80'),
            array('title' => 'Dark Alchemy', 'cat' => 'home', 'tag' => 'WARM & RESINOUS', 'price' => '$220', 'desc' => 'Vetiver, grey amber, and petrichor for introspective interior spaces.', 'img' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500&q=80'),
            array('title' => 'Synthetic Dawn', 'cat' => 'commercial', 'tag' => 'FRESH & MINERAL', 'price' => '$350', 'desc' => 'Aldehydic freshness with transparent florals for luxury retail environments.', 'img' => 'https://images.unsplash.com/photo-1615639070588-8e152bf1f0b0?w=500&q=80'),
            array('title' => 'Nocturne Waves', 'cat' => 'personal', 'tag' => 'DARK & AQUATIC', 'price' => '$195', 'desc' => 'Sea salt, black amber, and midnight orchid — an evening signature.', 'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=500&q=80'),
            array('title' => 'Gilded Chamber', 'cat' => 'home', 'tag' => 'OPULENT & BOLD', 'price' => '$260', 'desc' => 'Saffron, oud, and tonka for spaces that demand presence.', 'img' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=500&q=80'),
            array('title' => 'Cipher Aura', 'cat' => 'commercial', 'tag' => 'NEUTRAL & MODERN', 'price' => '$380', 'desc' => 'Clean musks with iso e super for sophisticated brand environments.', 'img' => 'https://images.unsplash.com/photo-1563170351-be82bc888aa4?w=500&q=80'),
        );
        foreach ($archive_items as $item) : ?>
            <div class="archive-item flex flex-col md:flex-row gap-4 aura-glass rounded-xl p-4 transition-all hover:shadow-lg cursor-pointer"
                 data-category="<?php echo esc_attr($item['cat']); ?>">
                <div class="w-full md:w-28 h-28 flex-shrink-0 rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover" src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="font-label-caps text-label-caps text-secondary"><?php echo esc_html($item['tag']); ?></span>
                            <h3 class="font-headline-md text-headline-md" style="font-size:20px;"><?php echo esc_html($item['title']); ?></h3>
                        </div>
                        <span class="font-headline-md text-headline-md text-on-surface-variant whitespace-nowrap" style="font-size:18px;"><?php echo esc_html($item['price']); ?></span>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2"><?php echo esc_html($item['desc']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-16 rounded-3xl text-center">
        <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">AI CONCIERGE</span>
        <h2 class="font-headline-lg text-headline-lg mb-6 italic">Not sure where to start?</h2>
        <p class="font-body-lg text-body-lg mb-8 text-surface-variant max-w-xl mx-auto">Tell our AI about your space, your mood, or your brand — we'll curate a selection of molecules tailored to you.</p>
        <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase" style="text-decoration:none;">
            Start AI Consultation
        </a>
    </div>
</section>

<?php
get_footer();
