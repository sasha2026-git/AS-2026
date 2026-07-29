<?php
/**
 * Template Name: Archive
 * Description: Fragrance Archive — Scent Encyclopedia
 */

get_header();
?>

<!-- Hero -->
<section class="px-margin-desktop container-max mb-24 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block">SCENT REPOSITORY</span>
            <h1 class="font-headline-xl text-headline-xl mb-6">The Fragrance Archive</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">A curated digital encyclopedia where sensory heritage meets machine intelligence. Explore deep olfactory profiles for every dimension of modern life.</p>
        </div>
        <button class="iridescent-btn px-8 py-3 rounded-full font-label-caps text-label-caps uppercase tracking-widest flex-shrink-0">Filter by Aura</button>
    </div>
</section>

<!-- Category Nav -->
<div class="sticky top-[72px] z-40 bg-surface/40 backdrop-blur-md py-4 mb-16 border-y border-outline-variant/10">
    <div class="px-margin-desktop container-max flex gap-12 overflow-x-auto no-scrollbar">
        <a class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors" href="#personal">01. FOR PERSONAL</a>
        <a class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors" href="#home">02. FOR HOME</a>
        <a class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors" href="#commercial">03. FOR COMMERCIAL</a>
    </div>
</div>

<!-- Personal Section -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal" id="personal">
    <div class="flex items-baseline gap-4 mb-12">
        <h2 class="font-headline-lg text-headline-lg">For Personal</h2>
        <span class="font-body-md text-body-md text-outline-variant italic">Lifestyle & Skin Scents</span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Large Editorial Card -->
        <div class="md:col-span-8 group relative overflow-hidden rounded-xl glass-card p-1">
            <div class="relative h-[500px] rounded-lg overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&q=80" alt="Vesper Muse perfume in editorial lighting" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-on-surface/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-12 text-surface">
                    <span class="font-label-caps text-label-caps text-secondary-fixed mb-2 block uppercase">Current Selection</span>
                    <h3 class="font-headline-md text-headline-md mb-4 italic">Vesper Muse</h3>
                    <p class="max-w-md font-body-md text-body-md opacity-90">A transient blend of night-blooming jasmine and cold metallic aldehydes. Designed for intimate evening settings.</p>
                </div>
            </div>
            <div class="p-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Top Notes</span>
                    <span class="font-body-md text-body-md">Saffron, Aldehyde</span>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Sillage</span>
                    <span class="font-body-md text-body-md">Moderate-Intimate</span>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">AI Match</span>
                    <span class="font-body-md text-body-md text-secondary">98% Synergy</span>
                </div>
                <div>
                    <a class="text-on-surface-variant font-label-caps text-label-caps hover:text-secondary flex items-center gap-1" href="#">
                        TWIN FINDER <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Side Panel -->
        <div class="md:col-span-4">
            <div class="glass-card p-8 rounded-xl h-full flex flex-col">
                <div>
                    <h4 class="font-headline-md text-headline-md mb-4">AI Scent Analysis</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Our neural engine analyzes molecular structures to find your perfect 'skin twin'. Vesper Muse is optimized for high-humidity evening environments.</p>
                    <div class="space-y-3">
                        <div class="bg-secondary-container/20 p-4 rounded-lg flex justify-between items-center">
                            <span class="font-body-md">Bergamot Mist</span>
                            <span class="font-label-caps text-label-caps text-secondary">ACTIVE</span>
                        </div>
                        <div class="bg-primary-container p-4 rounded-lg flex justify-between items-center opacity-60">
                            <span class="font-body-md">Oud Synthesis</span>
                            <span class="font-label-caps text-label-caps">LOCKED</span>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-outline-variant/10">
                    <button class="w-full text-center border border-on-surface py-4 font-label-caps text-label-caps hover:bg-on-surface hover:text-surface transition-all">ACCESS AFFILIATE VAULT</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Home Section -->
<section class="bg-surface-container-low py-32 scroll-reveal" id="home">
    <div class="px-margin-desktop container-max">
        <div class="flex items-baseline gap-4 mb-16">
            <h2 class="font-headline-lg text-headline-lg">For Home</h2>
            <span class="font-body-md text-body-md text-outline-variant italic">Ambient Environments</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <!-- Card 1 -->
            <div class="group cursor-pointer">
                <div class="aspect-[4/5] mb-6 overflow-hidden rounded-lg bg-surface relative">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&q=80" alt="Morning at the Villa diffuser" loading="lazy">
                    <div class="absolute top-4 right-4 bg-surface/80 backdrop-blur px-3 py-1 rounded-full">
                        <span class="font-label-caps text-[10px] uppercase text-secondary">Diffuser Fluid</span>
                    </div>
                </div>
                <h3 class="font-headline-md text-[24px] mb-2 italic">Morning at the Villa</h3>
                <p class="font-body-md text-on-surface-variant mb-4">Linen, sun-bleached stone, and Meyer lemon. Atmospheric calm.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">COTTON</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">CITRUS</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">MINERAL</span>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="group cursor-pointer">
                <div class="aspect-[4/5] mb-6 overflow-hidden rounded-lg bg-surface relative">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1600612253971-422e7f7faeb6?w=600&q=80" alt="Archive No. 4 candle" loading="lazy">
                    <div class="absolute top-4 right-4 bg-surface/80 backdrop-blur px-3 py-1 rounded-full">
                        <span class="font-label-caps text-[10px] uppercase text-secondary">Soy Candle</span>
                    </div>
                </div>
                <h3 class="font-headline-md text-[24px] mb-2 italic">Archive No. 4</h3>
                <p class="font-body-md text-on-surface-variant mb-4">Aged parchment, cedar wood, and a hint of dark tobacco leaf.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">WOODY</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">LEATHER</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">ANTIQUE</span>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="group cursor-pointer">
                <div class="aspect-[4/5] mb-6 overflow-hidden rounded-lg bg-surface relative">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1602524007746-5be3c1d8e0f0?w=600&q=80" alt="Cleanse & Float aerosol" loading="lazy">
                    <div class="absolute top-4 right-4 bg-surface/80 backdrop-blur px-3 py-1 rounded-full">
                        <span class="font-label-caps text-[10px] uppercase text-secondary">Aerosol</span>
                    </div>
                </div>
                <h3 class="font-headline-md text-[24px] mb-2 italic">Cleanse & Float</h3>
                <p class="font-body-md text-on-surface-variant mb-4">Ozone, white musk, and distilled glacier water. Pure purity.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">OZONE</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">MUSK</span>
                    <span class="px-3 py-1 bg-surface-variant/40 rounded-full font-label-caps text-[10px]">AQUATIC</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Commercial Section -->
<section class="px-margin-desktop container-max my-32 scroll-reveal" id="commercial">
    <div class="flex items-baseline gap-4 mb-16">
        <h2 class="font-headline-lg text-headline-lg">For Commercial</h2>
        <span class="font-body-md text-body-md text-outline-variant italic">Retail & Office Atmospheres</span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="order-2 lg:order-1">
            <div class="space-y-12">
                <div class="border-l-2 border-secondary pl-8">
                    <span class="font-label-caps text-label-caps text-primary/60 block mb-2">RETAIL STRATEGY</span>
                    <h3 class="font-headline-md text-headline-md mb-4 italic">The Velvet Lobby</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Designed for luxury fashion boutiques and boutique hotel lobbies. This scent uses psychology-backed notes of sandalwood to increase dwell time by 18%.</p>
                    <div class="flex gap-6">
                        <div class="flex flex-col">
                            <span class="font-headline-md text-[28px]">18%</span>
                            <span class="font-label-caps text-[10px]">DWELL INCREASE</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline-md text-[28px]">92%</span>
                            <span class="font-label-caps text-[10px]">LUXURY PERCEPTION</span>
                        </div>
                    </div>
                </div>
                <div class="border-l-2 border-outline-variant/30 pl-8 opacity-60">
                    <span class="font-label-caps text-label-caps text-primary/60 block mb-2">PRODUCTIVITY MODE</span>
                    <h3 class="font-headline-md text-headline-md mb-4 italic">Focus Synthesis</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">Sharp eucalyptus and Japanese peppermint for modern open-plan offices.</p>
                </div>
            </div>
        </div>
        <div class="order-1 lg:order-2 glass-card p-4 rounded-2xl relative">
            <div class="aspect-square rounded-xl overflow-hidden">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1597863595557-10026da0e4b2?w=800&q=80" alt="Luxury hotel lobby with modern design" loading="lazy">
            </div>
            <div class="absolute -bottom-8 -left-8 glass-card p-6 rounded-xl shadow-lg border border-white/50 max-w-[240px]">
                <p class="font-label-caps text-[11px] text-secondary mb-2 italic">"The scent is the invisible architecture of our brand identity."</p>
                <p class="font-body-md text-[14px]">— Creative Director, H&Agrave;N</p>
            </div>
        </div>
    </div>
</section>

<!-- Scent Twin Finder CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-24 rounded-3xl relative overflow-hidden text-center">
        <div class="relative z-10 text-center max-w-3xl mx-auto">
            <h2 class="font-headline-lg text-headline-lg mb-8 italic">Can't find your scent?</h2>
            <p class="font-body-lg text-body-lg mb-12 text-surface-variant">Our AuraAI engine can reverse-engineer any profile to find its spiritual successor or a perfect twin for your specific environment.</p>
            <div class="flex flex-col md:flex-row justify-center gap-6">
                <input class="bg-surface/10 border-b border-surface/30 px-6 py-4 font-body-md text-surface focus:outline-none focus:border-secondary transition-colors w-full md:w-96 placeholder:text-surface/40" placeholder="Enter a fragrance name..." type="text">
                <button class="iridescent-btn px-12 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase">Analyze Now</button>
            </div>
        </div>
    </div>
</section>

<script>
    // Smooth scroll for category navigation
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 120,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>

<?php
get_footer();
