<?php
/**
 * Template Name: Boutique
 * Description: The Atelier — Product showcase grid
 */

get_header();
?>

<!-- Hero Section -->
<section class="px-margin-desktop container-max mb-24 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block">THE ATELIER</span>
            <h1 class="font-headline-xl text-headline-xl mb-6">Signature Molecules</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Curated for your DNA. Every bottle, an echo of your digital aura.</p>
        </div>
    </div>
</section>

<!-- Category Tabs (Filter by Mood) -->
<div class="sticky top-[72px] z-40 bg-surface/40 backdrop-blur-md py-4 mb-16 border-y border-outline-variant/10">
    <div class="px-margin-desktop container-max flex gap-12 overflow-x-auto no-scrollbar">
        <button class="font-label-caps text-label-caps whitespace-nowrap text-secondary border-b-2 border-secondary pb-1 transition-colors filter-btn active" data-filter="all">ALL</button>
        <button class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors pb-1 filter-btn" data-filter="personal">01. FOR PERSONAL</button>
        <button class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors pb-1 filter-btn" data-filter="home">02. FOR HOME</button>
        <button class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors pb-1 filter-btn" data-filter="commercial">03. FOR COMMERCIAL</button>
    </div>
</div>

<!-- Product Grid -->
<section class="px-margin-desktop container-max mb-32">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter" id="product-grid">
        <!-- Product Card 1 -->
        <div class="flex flex-col group product-card" data-category="personal">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=600&q=80" alt="Aura No. 1" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">Aura No. 1</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$185.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">OZONIC</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">SERENE</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">A whisper of morning ozone and fresh white linen. For the quiet start.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>

        <!-- Product Card 2 -->
        <div class="flex flex-col group product-card" data-category="personal">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=600&q=80" alt="Aura No. 2" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">Aura No. 2</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$210.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">OUD</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">SEDUCTIVE</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">Deep agarwood and aged leather. An evening silhouette in a bottle.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>

        <!-- Product Card 3 -->
        <div class="flex flex-col group product-card" data-category="personal">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1615639070588-8e152bf1f0b0?w=600&q=80" alt="Aura No. 3" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">Aura No. 3</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$165.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">CITRUS</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">VIBRANT</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">Bright Calabrian bergamot and sun-drenched vetiver. Joy captured.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>

        <!-- Product Card 4 - Home -->
        <div class="flex flex-col group product-card" data-category="home">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1602524007746-5be3c1d8e0f0?w=600&q=80" alt="Morning at the Villa" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">Morning at the Villa</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$145.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">COTTON</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">CITRUS</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">Linen, sun-bleached stone, and Meyer lemon. Atmospheric calm.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>

        <!-- Product Card 5 - Home -->
        <div class="flex flex-col group product-card" data-category="home">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1600612253971-422e7f7faeb6?w=600&q=80" alt="Archive No. 4" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">Archive No. 4</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$190.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">WOODY</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">LEATHER</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">Aged parchment, cedar wood, and a hint of dark tobacco leaf.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>

        <!-- Product Card 6 - Commercial -->
        <div class="flex flex-col group product-card" data-category="commercial">
            <div class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1597863595557-10026da0e4b2?w=600&q=80" alt="The Velvet Lobby" loading="lazy">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
            </div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary">AuraAI</span>
                    <h3 class="font-headline-md text-[20px] italic">The Velvet Lobby</h3>
                </div>
                <span class="font-body-md text-primary whitespace-nowrap">$980.00</span>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">SANDALWOOD</span>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant">LUXURY</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mb-4">18% dwell increase. Designed for luxury boutiques and hotel lobbies.</p>
            <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="#">DISCOVER</a>
        </div>
    </div>
</section>

<!-- Custom Synthesis CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-24 rounded-3xl relative overflow-hidden">
        <div class="relative z-10 text-center max-w-2xl mx-auto">
            <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">THE ATELIER STUDIO</span>
            <h2 class="font-headline-lg text-headline-lg mb-6 italic">Can't find your signature?</h2>
            <p class="font-body-lg text-body-lg mb-8 text-surface-variant">Commission a bespoke synthesis. Our perfumers and AI engineers co-create a scent that belongs only to you.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <input class="bg-surface/10 border-b border-surface/30 px-6 py-4 font-body-md text-surface focus:outline-none focus:border-secondary transition-colors w-full md:w-96 placeholder:text-surface/40" placeholder="Describe your ideal scent..." type="text">
                <button class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase">Start Your Brief</button>
            </div>
        </div>
    </div>
</section>

<!-- Category Filter Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productCards = document.querySelectorAll('.product-card');

        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                filterBtns.forEach(function(b) {
                    b.classList.remove('text-secondary', 'border-b-2', 'border-secondary');
                    b.classList.add('text-on-surface');
                });
                this.classList.add('text-secondary', 'border-b-2', 'border-secondary');
                this.classList.remove('text-on-surface');

                const filter = this.getAttribute('data-filter');
                productCards.forEach(function(card) {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?php
get_footer();
