<?php
/**
 * Template Name: AI Synthesis
 * Description: AI Scent Finder — 3-path recommendation system
 */

get_header();
?>

<!-- Hero / Intro -->
<section class="px-margin-desktop container-max mb-24 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block">AI SYNTHESIS ENGINE</span>
            <h1 class="font-headline-xl text-headline-xl mb-6">Three paths to <span class="italic text-secondary">your signature.</span></h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Choose how you want to be guided. Our neural engine adapts to your preference—mood, curiosity, or data-driven precision.</p>
        </div>
    </div>
</section>

<!-- Three Recommendation Paths -->
<section class="px-margin-desktop container-max mb-32">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">

        <!-- Path 1: Mood Match -->
        <div class="aura-glass rounded-xl p-8 flex flex-col group cursor-pointer transition-all hover:shadow-lg">
            <div class="flex items-center justify-between mb-8">
                <span class="w-12 h-12 rounded-full bg-secondary-container/40 flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary">psychology</span>
                </span>
                <span class="font-label-caps text-label-caps text-secondary">01</span>
            </div>
            <h3 class="font-headline-md text-headline-md mb-4 italic">Mood Match</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 leading-relaxed">Describe how you feel—our AI translates emotion into molecular composition. <em>"Rainy afternoon melancholy"</em> becomes a blend of vetiver, grey amber, and petrichor.</p>
            <div class="mt-auto">
                <span class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 group-hover:gap-1 transition-all inline-flex items-center">
                    BEGIN MOOD SCAN <span class="material-symbols-outlined text-[14px] ml-1">chevron_right</span>
                </span>
            </div>
        </div>

        <!-- Path 2: Scent Twin -->
        <div class="aura-glass rounded-xl p-8 flex flex-col group cursor-pointer transition-all hover:shadow-lg">
            <div class="flex items-center justify-between mb-8">
                <span class="w-12 h-12 rounded-full bg-tertiary-container/40 flex items-center justify-center">
                    <span class="material-symbols-outlined text-tertiary">search_insights</span>
                </span>
                <span class="font-label-caps text-label-caps text-secondary">02</span>
            </div>
            <h3 class="font-headline-md text-headline-md mb-4 italic">Scent Twin Finder</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 leading-relaxed">Enter a fragrance you love. Our neural network finds its spiritual successor—or an exact molecular twin—from our database of 12,000+ profiles.</p>
            <div class="mt-auto">
                <span class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 group-hover:gap-1 transition-all inline-flex items-center">
                    SEARCH YOUR TWIN <span class="material-symbols-outlined text-[14px] ml-1">chevron_right</span>
                </span>
            </div>
        </div>

        <!-- Path 3: Data Profile -->
        <div class="aura-glass rounded-xl p-8 flex flex-col group cursor-pointer transition-all hover:shadow-lg">
            <div class="flex items-center justify-between mb-8">
                <span class="w-12 h-12 rounded-full bg-primary-container/40 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">neurology</span>
                </span>
                <span class="font-label-caps text-label-caps text-secondary">03</span>
            </div>
            <h3 class="font-headline-md text-headline-md mb-4 italic">Data Profile</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 leading-relaxed">Connect your biometric data (heart rate, sleep, location) for a scent that adapts to your circadian rhythm and environment in real-time.</p>
            <div class="mt-auto">
                <span class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 group-hover:gap-1 transition-all inline-flex items-center">
                    CONNECT DEVICE <span class="material-symbols-outlined text-[14px] ml-1">chevron_right</span>
                </span>
            </div>
        </div>

    </div>
</section>

<!-- AI Profile Card: Mood Match Result Preview -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="text-center mb-16">
        <span class="font-label-caps text-label-caps text-secondary mb-2 block">SIMULATION PREVIEW</span>
        <h2 class="font-headline-lg text-headline-lg">Your AI-Generated Profile</h2>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="aura-glass rounded-2xl p-12 relative">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary mb-1 block">AURA PROFILE</span>
                    <h3 class="font-headline-md text-headline-md italic">Vesper Muse</h3>
                </div>
                <span class="font-label-caps text-label-caps px-3 py-1 bg-secondary-container/30 rounded-full text-secondary">98% SYNERGY</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Top Notes</span>
                    <span class="font-body-md text-body-md">Saffron, Aldehyde</span>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Heart</span>
                    <span class="font-body-md text-body-md">Jasmine, Heliotrope</span>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Base</span>
                    <span class="font-body-md text-body-md">Sand, Musk</span>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-primary/60 mb-1 block uppercase">Sillage</span>
                    <span class="font-body-md text-body-md">Moderate-Intimate</span>
                </div>
            </div>

            <div class="bg-surface-container-low rounded-xl p-6 mb-8">
                <p class="font-body-md text-body-md text-on-surface-variant italic">"A transient blend of night-blooming jasmine and cold metallic aldehydes. Designed for intimate evening settings. Optimized for high-humidity environments."</p>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <input class="flex-1 bg-transparent border-b border-on-surface/20 focus:border-secondary outline-none py-3 font-body-md placeholder:text-primary/60" placeholder="Enter a fragrance name or mood..." type="text">
                <button class="iridescent-btn px-8 py-3 rounded-full font-label-caps text-label-caps tracking-widest uppercase">Analyze Now</button>
            </div>
        </div>
    </div>
</section>

<!-- Product Recommendations -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="text-center mb-16">
        <span class="font-label-caps text-label-caps text-secondary mb-2 block">MATCHING PRODUCTS</span>
        <h2 class="font-headline-lg text-headline-lg">Your Scent Twins</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Rec 1 -->
        <div class="text-center group">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full aura-glass flex items-center justify-center overflow-hidden">
                <img class="w-32 h-32 object-contain transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80" alt="Byredo Gypsy Water" loading="lazy">
            </div>
            <h4 class="font-headline-md text-[20px] mb-1 italic">Gypsy Water</h4>
            <p class="font-label-caps text-label-caps text-secondary mb-2">Byredo</p>
            <p class="font-body-md text-body-md text-on-surface-variant mb-2">Match: 94% — Pine, Lemon, Vanilla</p>
            <a class="font-label-caps text-label-caps text-primary/60 hover:text-secondary transition-colors" href="#" target="_blank">VIEW ON NORDSTROM →</a>
        </div>

        <!-- Rec 2 -->
        <div class="text-center group">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full aura-glass flex items-center justify-center overflow-hidden">
                <img class="w-32 h-32 object-contain transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80" alt="Le Labo Santal 33" loading="lazy">
            </div>
            <h4 class="font-headline-md text-[20px] mb-1 italic">Santal 33</h4>
            <p class="font-label-caps text-label-caps text-secondary mb-2">Le Labo</p>
            <p class="font-body-md text-body-md text-on-surface-variant mb-2">Match: 91% — Sandalwood, Cedar, Leather</p>
            <a class="font-label-caps text-label-caps text-primary/60 hover:text-secondary transition-colors" href="#" target="_blank">VIEW ON SAKS →</a>
        </div>

        <!-- Rec 3 -->
        <div class="text-center group">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full aura-glass flex items-center justify-center overflow-hidden">
                <img class="w-32 h-32 object-contain transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1615639070588-8e152bf1f0b0?w=400&q=80" alt="Jo Malone Wood Sage" loading="lazy">
            </div>
            <h4 class="font-headline-md text-[20px] mb-1 italic">Wood Sage & Sea Salt</h4>
            <p class="font-label-caps text-label-caps text-secondary mb-2">Jo Malone</p>
            <p class="font-body-md text-body-md text-on-surface-variant mb-2">Match: 89% — Sage, Mineral, Marine</p>
            <a class="font-label-caps text-label-caps text-primary/60 hover:text-secondary transition-colors" href="#" target="_blank">VIEW ON SEPHORA →</a>
        </div>
    </div>
</section>

<!-- Digital Mist Consultation CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-24 rounded-3xl text-center">
        <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">AI CONCIERGE</span>
        <h2 class="font-headline-lg text-headline-lg mb-6 italic">Need a second opinion?</h2>
        <p class="font-body-lg text-body-lg mb-8 text-surface-variant max-w-xl mx-auto">Our digital perfumer is available 24/7. Describe a moment, a memory, or a mood—and receive a personalized fragrance map within seconds.</p>
        <button class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase">Start AI Consultation</button>
    </div>
</section>

<?php
get_footer();
