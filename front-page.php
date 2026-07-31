<?php
/**
 * Template Name: Front Page
 */
get_header();
?>
<div id="page-discover">
    <section class="hero-section" style="position:relative;width:100%;overflow:hidden;margin-bottom:12px">
        <div class="hero-bg" style="width:100%;height:clamp(240px,50vh,500px);position:relative;display:flex;align-items:center;justify-content:center">
            <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=1500&q=85" alt="Artisanal fragrance concept" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" class="hero-image">
            <div style="position:absolute;inset:0;background:linear-gradient(135deg, rgba(28,27,27,0.55) 0%, rgba(28,27,27,0.2) 50%, rgba(28,27,27,0.55) 100%);z-index:1"></div>
            <div style="position:relative;z-index:2;text-align:center;padding:24px 16px;max-width:600px">
                <span class="font-label-caps" style="font-size:clamp(10px,2vw,13px);letter-spacing:.15em;color:rgba(255,255,255,0.7);display:block;margin-bottom:8px;text-transform:uppercase">ALLSCENTED · SENSORY INTELLIGENCE</span>
                <h1 class="hero-title" style="font-family:'Playfair Display',serif;font-weight:500;font-style:italic;font-size:clamp(28px,5vw,56px);line-height:1.1;color:#fff;margin:0 0 12px">Where Memory<br class="mobile-only"> <span class="desktop-only"> </span>Becomes Scent</h1>
                <p class="hero-subtitle" style="font-family:'Hanken Grotesk',sans-serif;font-weight:300;font-size:clamp(13px,1.5vw,16px);color:rgba(255,255,255,0.8);margin:0 0 20px;max-width:480px;margin-left:auto;margin-right:auto">AI-powered fragrance synthesis from your most intimate narratives</p>
                <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap">
                    <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn" style="padding:10px 28px;border-radius:999px;font-family:'Hanken Grotesk',sans-serif;font-size:13px;font-weight:500;letter-spacing:.06em;color:#fff;text-decoration:none">
                        BEGIN YOUR AI SYNTHESIS
                    </a>
                </div>
            </div>
        </div>
        <div style="position:relative;z-index:3;margin-top:-2px;line-height:0">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" style="width:100%;height:clamp(24px,4vw,60px);display:block">
                <path d="M0,40 C240,0 480,60 720,30 C960,0 1200,60 1440,30 L1440,60 L0,60 Z" fill="var(--surface)"/>
            </svg>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-top:12px;padding-bottom:12px">
        <div class="max-w-3xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px;font-size:11px;letter-spacing:.12em">MEET YOUR GUIDES</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:16px">Three ways to <span class="italic text-secondary">find your scent.</span></h2>
        </div>
        <div class="char-cards-grid" style="margin-bottom:0">
            <!-- Card A: Healer -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column;cursor:pointer">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--secondary-container)40%,transparent);width:48px;height:48px;border-radius:999px;display:flex;align-items:center;justify-content:center;margin-bottom:10px">
                    <span class="material-symbols-outlined" style="color:var(--secondary);font-size:24px">spa</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">AI SCENT THERAPIST · LUNÁ</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">The Healer</h3>
                <p class="font-body-md" style="font-size:12px;color:var(--on-surface-variant);flex:1;margin-bottom:10px">Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart.</p>
                <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px">
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">EMOTIONAL</span>
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">THERAPEUTIC</span>
                </div>
                <a class="font-label-caps" style="font-size:12px;color:var(--secondary);display:inline-flex;align-items:center;gap:4px;margin-top:auto;cursor:pointer" aria-label="Start AI scent therapy consultation with Luná" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Start consultation <span class="material-symbols-outlined" style="font-size:12px">arrow_forward</span></a>
            </div>
            <!-- Card B: Mystic -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column;cursor:pointer">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--tertiary-container)40%,transparent);width:48px;height:48px;border-radius:999px;display:flex;align-items:center;justify-content:center;margin-bottom:10px">
                    <span class="material-symbols-outlined" style="color:var(--tertiary);font-size:24px">auto_awesome</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">AI SCENT FORTUNE TELLER · ECHO</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">The Mystic</h3>
                <p class="font-body-md" style="font-size:12px;color:var(--on-surface-variant);flex:1;margin-bottom:10px">Curious what the universe has in store for you? Let the stars guide your scent — for fun, for hope, for destiny.</p>
                <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px">
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">DIVINATION</span>
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">RITUAL</span>
                </div>
                <a class="font-label-caps" style="font-size:12px;color:var(--tertiary);display:inline-flex;align-items:center;gap:4px;margin-top:auto;cursor:pointer" aria-label="Cast your scent fortune with Echo" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Cast your fortune <span class="material-symbols-outlined" style="font-size:12px">arrow_forward</span></a>
            </div>
            <!-- Card C: Strategist -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column;cursor:pointer">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--primary-container)40%,transparent);width:48px;height:48px;border-radius:999px;display:flex;align-items:center;justify-content:center;margin-bottom:10px">
                    <span class="material-symbols-outlined" style="color:var(--primary);font-size:24px">business_center</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">SCENT MEMORY CONSULTANT · SAGE</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">The Strategist</h3>
                <p class="font-body-md" style="font-size:12px;color:var(--on-surface-variant);flex:1;margin-bottom:10px">For hotels, boutiques, and brands. I design a scent strategy that becomes part of your identity and drives results.</p>
                <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px">
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">COMMERCIAL</span>
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">BRANDING</span>
                </div>
                <a class="font-label-caps" style="font-size:12px;color:var(--primary);display:inline-flex;align-items:center;gap:4px;margin-top:auto;cursor:pointer" aria-label="Request commercial scent consultation with Sage" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Request consultation <span class="material-symbols-outlined" style="font-size:12px">arrow_forward</span></a>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="background:color-mix(in srgb,var(--secondary-container)8%,transparent);border-radius:24px;padding:32px 16px 24px;margin-top:4px;margin-bottom:24px">
            <div style="text-align:center">
                <span class="font-label-caps" style="color:var(--secondary);font-size:14px;letter-spacing:.08em;display:block;margin-bottom:4px">THE ARCHIVE</span>
                <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4.5vw,48px);font-weight:600;color:var(--on-background);margin-top:6px">Curated <span class="italic" style="color:var(--secondary)">Synthetics</span></h2>
            </div>
            <div style="text-align:center;margin-bottom:16px">
                <a href="<?php echo esc_url(home_url('/archive/')); ?>" style="display:inline-flex;align-items:center;gap:6px;padding:12px 28px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);text-decoration:none;font-family:'Hanken Grotesk',sans-serif;font-size:13px;font-weight:500;letter-spacing:.03em;transition:all .3s" onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'">
                    Explore More
                    <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">arrow_forward</span>
                </a>
            </div>
            <div id="home-archive-grid">
                <div class="aura-glass archive-card" style="border-radius:12px;overflow:hidden;cursor:pointer">
                    <div style="aspect-ratio:4/3;overflow:hidden" class="group">
                        <img style="width:100%;height:100%;object-fit:cover;transition:transform .8s" class="group-hover:scale-105" src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&q=80" alt="Perfume bottles" loading="lazy">
                    </div>
                    <div class="archive-card-body" style="padding:16px 18px 18px">
                        <span class="font-label-caps text-label-caps text-secondary" style="display:block;margin-bottom:4px">FOR PERSONAL</span>
                        <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">The Intimate Narrative</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:12px;line-height:1.5">How AI decoded the scent of childhood nostalgia for a private collection.</p>
                    </div>
                </div>
                <div class="aura-glass archive-card" style="border-radius:12px;overflow:hidden;cursor:pointer">
                    <div style="aspect-ratio:4/3;overflow:hidden" class="group">
                        <img style="width:100%;height:100%;object-fit:cover;transition:transform .8s" class="group-hover:scale-105" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80" alt="Home diffuser" loading="lazy">
                    </div>
                    <div class="archive-card-body" style="padding:16px 18px 18px">
                        <span class="font-label-caps text-label-caps text-secondary" style="display:block;margin-bottom:4px">FOR HOME</span>
                        <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">Atmospheric Flux</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:12px;line-height:1.5">Scents that adapt to light cycles and biometric data.</p>
                    </div>
                </div>
                <div class="aura-glass archive-card" style="border-radius:12px;overflow:hidden;cursor:pointer">
                    <div style="aspect-ratio:4/3;overflow:hidden" class="group">
                        <img style="width:100%;height:100%;object-fit:cover;transition:transform .8s" class="group-hover:scale-105" src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=800&q=80" alt="Brand Osmosis commercial scenting" loading="lazy">
                    </div>
                    <div class="archive-card-body" style="padding:16px 18px 18px">
                        <span class="font-label-caps text-label-caps text-secondary" style="display:block;margin-bottom:4px">FOR COMMERCIAL</span>
                        <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic">Brand Osmosis</h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:12px;line-height:1.5">Architectural scenting for luxury retail.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="text-align:center;margin-bottom:24px">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">THE COLLECTION</span>
            <h2 class="font-headline-lg text-headline-lg">Signature Molecules</h2>
        </div>
        <div class="collection-layout">
            <div class="collection-main" style="border-radius:16px;overflow:hidden;position:relative">
                <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&q=80" alt="AllScented Collection" style="width:100%;height:100%;object-fit:cover;display:block" loading="lazy">
                <div style="position:absolute;inset:0;background:linear-gradient(to top,color-mix(in srgb,var(--surface)70%,transparent)0%,transparent 50%)"></div>
                <div style="position:absolute;bottom:16px;left:16px;right:16px">
                    <span class="font-label-caps text-label-caps" style="color:var(--surface);font-size:12px;letter-spacing:.12em">THE ATELIER</span>
                    <h3 class="font-headline-lg text-headline-lg" style="color:var(--surface);font-style:italic;font-size:20px">AI-Designed for You</h3>
                </div>
            </div>
            <div class="collection-side">
            <div style="text-align:center" class="group">
                <div class="aura-glass" style="aspect-ratio:3/4;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80" alt="Aura No.1" style="width:60%;height:60%;object-fit:contain;transition:transform .6s" class="group-hover:scale-110" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:16px;margin-bottom:4px;font-style:italic">Aura No. 1</h4>
                <div style="display:flex;gap:4px;justify-content:center;flex-wrap:wrap;margin-bottom:4px">
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)">SERENE</span>
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)">MORNING</span>
                </div>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$185.00</span>
            </div>
            <div style="text-align:center" class="group">
                <div class="aura-glass" style="aspect-ratio:3/4;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80" alt="Aura No.2" style="width:60%;height:60%;object-fit:contain;transition:transform .6s" class="group-hover:scale-110" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:16px;margin-bottom:4px;font-style:italic">Aura No. 2</h4>
                <div style="display:flex;gap:4px;justify-content:center;flex-wrap:wrap;margin-bottom:4px">
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)">SEDUCTIVE</span>
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)">TWILIGHT</span>
                </div>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">$210.00</span>
            </div>
            </div>
        </div>
        <div style="text-align:center;margin-top:24px">
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 28px;border-radius:999px;display:inline-block" href="<?php echo esc_url(home_url('/the-atelier/')); ?>">SHOP THE ATELIER</a>
        </div>
    </section>
</div>
<!-- ===== AI SYNTHESIS (Three Characters) ===== -->

<?php get_footer(); ?>
