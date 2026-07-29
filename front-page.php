<?php
/**
 * Template Name: AuraAI Home
 * Description: Front page - Discover
 */

get_header();
?>

<!-- Hero Section: AI Recommendation Entry -->
<section class="px-margin-desktop container-max mb-32 relative min-h-[70vh] flex flex-col justify-center">
    <div class="max-w-3xl">
        <span class="font-label-caps text-label-caps text-secondary mb-4 block">SENSORY INTELLIGENCE</span>
        <h1 class="font-headline-xl text-headline-xl mb-8 leading-tight">Describe the scent of your <span class="italic text-secondary">deepest memory.</span></h1>
        <div class="aura-glass p-8 rounded-xl">
            <div class="flex flex-col gap-6">
                <div class="flex gap-4">
                    <button class="px-6 py-2 rounded-full border border-secondary text-secondary font-label-caps text-label-caps hover:bg-secondary/10 transition-all">Personal</button>
                    <button class="px-6 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-caps text-label-caps hover:bg-surface-variant/50 transition-all">Home</button>
                    <button class="px-6 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-caps text-label-caps hover:bg-surface-variant/50 transition-all">Commercial</button>
                </div>
                <div class="relative">
                    <textarea class="w-full bg-transparent border-b border-on-surface/20 focus:border-secondary outline-none py-4 text-body-lg font-body-lg resize-none min-h-[100px] transition-all" placeholder="Tell me a story... 'A rainy afternoon in Kyoto, cedarwood and wet stone...'"></textarea>
                    <div class="absolute bottom-4 right-0">
                        <button class="iridescent-btn flex items-center justify-center w-12 h-12 rounded-full shadow-lg transition-all" aria-label="Generate">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 flex items-center justify-between">
            <p class="font-body-md text-on-surface-variant max-w-md italic">Our AI analyzes emotive prose to synthesize fragrance notes that echo your internal landscape.</p>
            <a class="font-label-caps text-label-caps border-b border-primary text-primary pb-1 hover:text-secondary hover:border-secondary transition-all" href="#">EXPLORE MORE</a>
        </div>
    </div>
</section>

<!-- Section 2: AI Fragrance Archive Preview (Bento Grid) -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="flex justify-between items-end mb-12">
        <div>
            <span class="font-label-caps text-label-caps text-secondary mb-2 block">THE ARCHIVE</span>
            <h2 class="font-headline-lg text-headline-lg">Curated Synthetics</h2>
        </div>
        <a class="font-label-caps text-label-caps text-primary border-b border-primary pb-1 hover:text-secondary hover:border-secondary transition-all mb-2" href="#">VIEW ALL CASE STUDIES</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Personal -->
        <div class="md:col-span-7 group cursor-pointer">
            <div class="relative h-[500px] overflow-hidden rounded-xl aura-glass">
                <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&q=80" alt="Luxury perfume bottle on marble surface with lavender lighting" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-surface/80 to-transparent p-12 flex flex-col justify-end">
                    <span class="font-label-caps text-label-caps text-secondary mb-2">FOR PERSONAL</span>
                    <h3 class="font-headline-md text-headline-md mb-4 italic">The Intimate Narrative</h3>
                    <p class="font-body-md text-on-surface-variant max-w-md">How AI decoded the scent of childhood nostalgia for a private collection.</p>
                </div>
            </div>
        </div>
        <!-- Home & Commercial Column -->
        <div class="md:col-span-5 flex flex-col gap-gutter">
            <div class="aura-glass p-8 flex flex-col justify-between h-64 rounded-xl group cursor-pointer">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary mb-2 block">FOR HOME</span>
                    <h3 class="font-headline-md text-headline-md mb-2">Atmospheric Flux</h3>
                    <p class="font-body-md text-on-surface-variant">Adaptive scents that change based on light cycles and biometric data.</p>
                </div>
                <div class="w-full h-32 mt-4 rounded-lg overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-700">
                    <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&q=80" alt="Minimalist interior with diffuser and natural lighting" loading="lazy">
                </div>
            </div>
            <div class="aura-glass p-8 flex flex-col justify-between h-64 rounded-xl group cursor-pointer">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary mb-2 block">FOR COMMERCIAL</span>
                    <h3 class="font-headline-md text-headline-md mb-2">Brand Osmosis</h3>
                    <p class="font-body-md text-on-surface-variant">Architectural scenting for the 2025 Neo-Parisian Retail Experience.</p>
                </div>
                <div class="flex items-center gap-2 mt-4">
                    <span class="px-3 py-1 rounded-full bg-secondary-container/30 text-secondary font-label-caps text-label-caps">LUXURY</span>
                    <span class="px-3 py-1 rounded-full bg-secondary-container/30 text-secondary font-label-caps text-label-caps">TECH-RETAIL</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: Official Boutique Preview -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="text-center mb-16">
        <span class="font-label-caps text-label-caps text-secondary mb-2 block">THE COLLECTION</span>
        <h2 class="font-headline-lg text-headline-lg">Signature Molecules</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Product 1 -->
        <div class="flex flex-col items-center group">
            <div class="relative w-full aspect-[4/5] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=600&q=80" alt="Aura No. 1 perfume bottle" loading="lazy">
                <div class="absolute top-4 right-4">
                    <span class="material-symbols-outlined text-secondary opacity-0 group-hover:opacity-100 transition-opacity">favorite</span>
                </div>
            </div>
            <div class="text-center">
                <h4 class="font-headline-md text-headline-md mb-2 italic">Aura No. 1</h4>
                <div class="flex justify-center gap-2 mb-4 flex-wrap px-4">
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">MOOD: SERENE</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">SCENE: MORNING</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">NOTE: OZONIC</span>
                </div>
                <span class="font-body-md text-primary">$185.00</span>
            </div>
        </div>
        <!-- Product 2 -->
        <div class="flex flex-col items-center group">
            <div class="relative w-full aspect-[4/5] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=600&q=80" alt="Aura No. 2 perfume bottle" loading="lazy">
                <div class="absolute top-4 right-4">
                    <span class="material-symbols-outlined text-secondary opacity-0 group-hover:opacity-100 transition-opacity">favorite</span>
                </div>
            </div>
            <div class="text-center">
                <h4 class="font-headline-md text-headline-md mb-2 italic">Aura No. 2</h4>
                <div class="flex justify-center gap-2 mb-4 flex-wrap px-4">
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">MOOD: SEDUCTIVE</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">SCENE: TWILIGHT</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">NOTE: OUD</span>
                </div>
                <span class="font-body-md text-primary">$210.00</span>
            </div>
        </div>
        <!-- Product 3 -->
        <div class="flex flex-col items-center group">
            <div class="relative w-full aspect-[4/5] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center">
                <img class="w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1615639070588-8e152bf1f0b0?w=600&q=80" alt="Aura No. 3 perfume bottle" loading="lazy">
                <div class="absolute top-4 right-4">
                    <span class="material-symbols-outlined text-secondary opacity-0 group-hover:opacity-100 transition-opacity">favorite</span>
                </div>
            </div>
            <div class="text-center">
                <h4 class="font-headline-md text-headline-md mb-2 italic">Aura No. 3</h4>
                <div class="flex justify-center gap-2 mb-4 flex-wrap px-4">
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">MOOD: VIBRANT</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">SCENE: ATELIER</span>
                    <span class="font-label-caps text-[10px] tracking-widest px-2 py-1 bg-surface-container-high rounded text-on-surface-variant">NOTE: CITRUS</span>
                </div>
                <span class="font-body-md text-primary">$165.00</span>
            </div>
        </div>
    </div>
    <div class="mt-20 flex justify-center">
        <a href="<?php echo esc_url(home_url('/boutique/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest transition-all">
            SHOP THE ATELIER
        </a>
    </div>
</section>

<?php
get_footer();
