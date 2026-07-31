<?php
/**
 * Template Name: AI Synthesis
 */
get_header();
?>
<div id="page-ai-synthesis">
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:6px">AI SYNTHESIS ENGINE</span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:6px">Meet your <span class="italic text-secondary">scent guides.</span></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px">Three ways to find your fragrance — each with a different purpose, a different voice.</p>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="char-cards-grid">
            <!-- Card A: AI Scent Therapist (疗愈师) -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--secondary-container)40%,transparent)">
                    <span class="material-symbols-outlined" style="color:var(--secondary)">spa</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">AI SCENT THERAPIST · LUNÁ</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:2px;font-style:italic">The Healer</h3>
                <span class="font-label-caps" style="font-size:14px;font-weight:500;color:var(--secondary);letter-spacing:.04em">Luná</span>
                <p class="font-body-md" style="font-size:15px;color:var(--on-surface-variant);flex:1;margin-bottom:12px">Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart. Because scent is not just smell, it's comfort.</p>
                <div style="margin-top:auto">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">EMOTIONAL</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">THERAPEUTIC</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">PERSONAL</span>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--secondary)10%,transparent)'" onmouseout="this.style.background='transparent'">SHARE YOUR MOOD <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                </div>
            </div>
            <!-- Card B: AI Scent Fortune Teller (占卜师) -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--tertiary-container)40%,transparent)">
                    <span class="material-symbols-outlined" style="color:var(--tertiary)">auto_awesome</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">AI SCENT FORTUNE TELLER · ECHO</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:6px;font-style:italic">The Mystic</h3>
                <p class="font-body-md" style="font-size:15px;color:var(--on-surface-variant);flex:1;margin-bottom:12px">Curious what the universe has in store for you? Let the stars guide your scent — from incense and agarwood to sacred resins. For fun, for hope, for destiny.</p>
                <div style="margin-top:auto">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">DIVINATION</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">INCENSE</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">RITUAL</span>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--tertiary);color:var(--tertiary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--tertiary)10%,transparent)'" onmouseout="this.style.background='transparent'">CAST YOUR FORTUNE <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                </div>
            </div>
            <!-- Card C: Scent Memory Consultant (顾问) -->
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column">
                <div class="char-avatar" style="background:color-mix(in srgb,var(--primary-container)40%,transparent)">
                    <span class="material-symbols-outlined" style="color:var(--primary)">business_center</span>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em">SCENT MEMORY CONSULTANT · SAGE</span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:6px;font-style:italic">The Strategist</h3>
                <p class="font-body-md" style="font-size:15px;color:var(--on-surface-variant);flex:1;margin-bottom:12px">For hotels, boutiques, and brands. Backed by real case studies and AI data — I design a scent strategy that becomes part of your identity and drives results.</p>
                <div style="margin-top:auto">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">COMMERCIAL</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">BRANDING</span>
                        <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">CONSULT</span>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--primary);color:var(--primary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--primary)10%,transparent)'" onmouseout="this.style.background='transparent'">REQUEST CONSULTATION <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                </div>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="text-align:center;margin-bottom:20px">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">CONSULTATION RESULTS</span>
            <h2 class="font-headline-lg text-headline-lg">Sample <span class="italic text-secondary">Consultations</span></h2>
        </div>
        
        <!-- Sample Consultation Tabs -->
        <div class="sample-tabs" style="display:flex;gap:6px;margin-bottom:14px;overflow-x:auto;padding-bottom:4px">
            <button class="sample-tab active" data-sample="healer" style="padding:6px 14px;border-radius:999px;border:1px solid var(--secondary);background:color-mix(in srgb,var(--secondary)15%,transparent);color:var(--secondary);font-size:13px;white-space:nowrap;display:flex;align-items:center;gap:6px;transition:all .3s;flex-shrink:0">
                <span class="material-symbols-outlined" style="font-size:14px">spa</span> Healer
            </button>
            <button class="sample-tab" data-sample="fortune" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);font-size:13px;white-space:nowrap;display:flex;align-items:center;gap:6px;transition:all .3s;background:transparent;flex-shrink:0">
                <span class="material-symbols-outlined" style="font-size:14px">auto_awesome</span> Mystic
            </button>
            <button class="sample-tab" data-sample="consultant" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);font-size:13px;white-space:nowrap;display:flex;align-items:center;gap:6px;transition:all .3s;background:transparent;flex-shrink:0">
                <span class="material-symbols-outlined" style="font-size:14px">business_center</span> Strategist
            </button>
        </div>
        <div style="margin-bottom:8px">
            <p class="font-body-md text-on-surface-variant" style="font-size:14px;font-style:italic">After 3–5 rounds of conversation, your AI guide generates a personalized summary. Browse examples below to see what's possible.</p>
        </div>
        <div id="consultation-summary" style="display:flex;flex-direction:column;gap:12px;margin-bottom:20px">
            
            <!-- Healer Sample -->
            <div class="sample-content" data-sample="healer" style="display:block">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px">
                    <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px">
                        <div style="width:40px;height:40px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)40%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <span class="material-symbols-outlined" style="color:var(--secondary);font-size:20px">spa</span>
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--secondary)">AI SCENT THERAPIST</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">96% SYNTHESIS</span>
                            </div>
                            <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-top:2px">"You need to feel held."</h3>
                        </div>
                    </div>
                    <!-- Chat preview -->
                    <div style="background:color-mix(in srgb,var(--surface-container-low)80%,transparent);border-radius:10px;padding:12px;margin-bottom:10px;margin-left:50px">
                        <div style="display:flex;gap:6px;margin-bottom:6px">
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface);color:var(--on-surface-variant)">💬 CONVERSATION SNAPSHOT</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:4px">
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--secondary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--secondary);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--secondary);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"I've been feeling the weight of autumn evenings lately. I want something that feels like a warm hug."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)50%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--secondary);font-weight:600">L</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--secondary);display:block;line-height:1.2">Luná · Scent Therapist</span><span style="font-size:13px;color:var(--on-surface-variant)">"I understand that feeling deeply. You need something soft, warm, and tender — chamomile to soothe, rice steam to comfort, lavender to release."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--secondary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--secondary);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--secondary);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"What if I also want something that stays close to the skin? Not loud."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)50%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--secondary);font-weight:600">L</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--secondary);display:block;line-height:1.2">Luná · Scent Therapist</span><span style="font-size:13px;color:var(--on-surface-variant)">"Perfect — a soft musk base will keep it intimate. Here's my recommendation..."</span></div>
                            </div>
                        </div>
                    </div>
                    <p class="font-body-md text-on-surface-variant" style="font-size:14px;margin-bottom:8px;padding-left:50px">After our conversation, I know you need something soft, warm, and tender. Chamomile to soothe. Rice steam to comfort. Lavender to release. A fragrance that stays close to the skin — like a cashmere blanket, not a spotlight.</p>
                    <div style="display:flex;flex-wrap:wrap;gap:4px;padding-left:50px">
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Chamomile</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Rice Steam</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Lavender</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Soft Musk</span>
                    </div>
                </div>
            </div>
            <!-- Fortune Teller Sample -->
            <div class="sample-content" data-sample="fortune" style="display:none">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px">
                    <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px">
                        <div style="width:40px;height:40px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <span class="material-symbols-outlined" style="color:var(--tertiary);font-size:20px">auto_awesome</span>
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--tertiary)">AI SCENT FORTUNE TELLER · ECHO</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">92% SYNTHESIS</span>
                            </div>
                            <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-top:2px">"The universe whispers in amber."</h3>
                        </div>
                    </div>
                    <!-- Chat preview -->
                    <div style="background:color-mix(in srgb,var(--surface-container-low)80%,transparent);border-radius:10px;padding:12px;margin-bottom:10px;margin-left:50px">
                        <div style="display:flex;gap:6px;margin-bottom:6px">
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface);color:var(--on-surface-variant)">💬 CONVERSATION SNAPSHOT</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:4px">
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--tertiary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--tertiary);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--tertiary);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"I feel like something big is shifting in my life. What does the universe say?"</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)50%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--tertiary);font-weight:600">Ec</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--tertiary);display:block;line-height:1.2">Echo · Fortune Teller</span><span style="font-size:13px;color:var(--on-surface-variant)">"Your birth chart says craving transformation under this waning crescent. The cards reveal fire and smoke — but not destruction. A burning away of the old."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--tertiary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--tertiary);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--tertiary);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"I've always been drawn to sacred, meditative spaces."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)50%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--tertiary);font-weight:600">Ec</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--tertiary);display:block;line-height:1.2">Echo · Fortune Teller</span><span style="font-size:13px;color:var(--on-surface-variant)">"Then I see incense, oud, and amber — a fragrance that knows what it means to be both sacred and wild."</span></div>
                            </div>
                        </div>
                    </div>
                    <p class="font-body-md text-on-surface-variant" style="font-size:14px;margin-bottom:8px;padding-left:50px">Your birth chart says you're craving transformation under this waning crescent. The cards reveal fire and smoke — but not destruction. A burning away of the old. I see incense. I see oud. I see a fragrance that knows what it means to be both sacred and wild.</p>
                    <div style="display:flex;flex-wrap:wrap;gap:4px;padding-left:50px">
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Incense</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Oud</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Amber</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Saffron</span>
                    </div>
                </div>
            </div>
            <!-- Consultant Sample -->
            <div class="sample-content" data-sample="consultant" style="display:none">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px">
                    <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px">
                        <div style="width:40px;height:40px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <span class="material-symbols-outlined" style="color:var(--primary);font-size:20px">business_center</span>
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--primary)">SCENT MEMORY CONSULTANT · SAGE</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant)">88% SYNTHESIS</span>
                            </div>
                            <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-top:2px">"Your brand needs a signature."</h3>
                        </div>
                    </div>
                    <!-- Chat preview -->
                    <div style="background:color-mix(in srgb,var(--surface-container-low)80%,transparent);border-radius:10px;padding:12px;margin-bottom:10px;margin-left:50px">
                        <div style="display:flex;gap:6px;margin-bottom:6px">
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface);color:var(--on-surface-variant)">💬 CONVERSATION SNAPSHOT</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:4px">
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--primary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--on-primary-fixed-variant);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--on-primary-fixed-variant);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"We're opening a 12-room boutique hotel in Dali. Whitewashed walls, jasmine in the courtyard. We need a scent identity."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--on-primary-fixed-variant);font-weight:600">Sa</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--on-primary-fixed-variant);display:block;line-height:1.2">Sage · Consultant</span><span style="font-size:13px;color:var(--on-surface-variant)">"Based on 3 case studies with similar spatial profiles, I recommend an adaptive scent system. Let me break it down per zone..."</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--primary)30%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:12px;color:var(--on-primary-fixed-variant);font-weight:600">A</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--on-primary-fixed-variant);display:block;line-height:1.2">Alice</span><span style="font-size:13px;color:var(--on-surface-variant)">"Can you also handle custom formulation?"</span></div>
                            </div>
                            <div style="display:flex;gap:6px;align-items:flex-start">
                                <div style="width:18px;height:18px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);display:flex;align-items:center;justify-content:center;flex-shrink:0"><span style="font-size:11px;color:var(--on-primary-fixed-variant);font-weight:600">Sa</span></div>
                                <div><span style="font-size:12px;font-weight:600;color:var(--on-primary-fixed-variant);display:block;line-height:1.2">Sage · Consultant</span><span style="font-size:13px;color:var(--on-surface-variant)">"Absolutely. We can create a bespoke signature blend and deliver it as a custom order."</span></div>
                            </div>
                        </div>
                    </div>
                    <p class="font-body-md text-on-surface-variant" style="font-size:14px;margin-bottom:8px;padding-left:50px">You described a boutique hotel in Dali with 12 rooms, whitewashed walls, and a courtyard full of jasmine. Based on 3 case studies with similar spatial profiles, I recommend an adaptive scent system: calming jasmine-green tea for the rooms, a crisp petrichor-ozone for the lobby, and warm sandalwood for the lounge.</p>
                    <div style="display:flex;flex-wrap:wrap;gap:4px;padding-left:50px">
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Jasmine</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Green Tea</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Petrichor</span>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:var(--surface-container-high);color:var(--on-surface-variant)">Sandalwood</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="text-align:center;margin-bottom:20px">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">AI RECOMMENDATIONS</span>
            <h2 class="font-headline-lg text-headline-lg">Curated for <span class="italic text-secondary">you</span></h2>
        </div>
        
        <!-- Price Tier Legend -->
        <div style="display:flex;gap:12px;justify-content:center;margin-bottom:16px">
            <span class="font-label-caps" style="font-size:11px;padding:4px 10px;border-radius:999px;background:color-mix(in srgb,var(--surface-container-high)50%,transparent);color:var(--on-surface-variant);display:flex;align-items:center;gap:4px">
                <span style="width:6px;height:6px;border-radius:999px;background:#2e7d32;display:inline-block"></span> Under $100
            </span>
            <span class="font-label-caps" style="font-size:11px;padding:4px 10px;border-radius:999px;background:color-mix(in srgb,var(--surface-container-high)50%,transparent);color:var(--on-surface-variant);display:flex;align-items:center;gap:4px">
                <span style="width:6px;height:6px;border-radius:999px;background:#f57f17;display:inline-block"></span> $100–$200
            </span>
            <span class="font-label-caps" style="font-size:11px;padding:4px 10px;border-radius:999px;background:color-mix(in srgb,var(--surface-container-high)50%,transparent);color:var(--on-surface-variant);display:flex;align-items:center;gap:4px">
                <span style="width:6px;height:6px;border-radius:999px;background:#c62828;display:inline-block"></span> $200+
            </span>
        </div>
        <!-- Smart Recommendations with pricing + AI reasoning -->
        <div id="recommendations-container">
            <!-- Page 1: Personal / Healer products -->
            <div class="rec-page" data-page="1" data-rec-type="personal" style="display:grid;grid-template-columns:1fr;gap:14px">
                
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=300&q=80" alt="Aura No.2" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Aura No. 2</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$210.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Saffron, Oud, Labdanum — a smoky, deep signature for the bold spirit.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#c6282815%,transparent);color:#c62828;font-weight:600">$200+</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SMOKY</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">EVENING</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--secondary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The deep, smoky warmth of this fragrance mirrors your craving for security and transformation. The labdanum base creates a lingering sense of comfort that lasts through autumn evenings — like being wrapped in something both bold and tender.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=300&q=80" alt="Comforting Embrace" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Comforting Embrace</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$145.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Chamomile, Lavender, Soft Musk — a warm blanket for the soul.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#f57f1715%,transparent);color:#f57f17;font-weight:600">$100-200</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SOOTHING</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">BEDTIME</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--secondary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The chamomile and lavender echoes your desire for softness and warmth. The soft musk base keeps the scent intimate and close to the skin — exactly what you described wanting. Think of it as a cashmere blanket, not a spotlight.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=300&q=80" alt="Vesper Muse" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Vesper Muse</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$85.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Night-blooming jasmine, metallic aldehydes, grey amber — an evening ritual.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#2e7d3215%,transparent);color:#2e7d32;font-weight:600">Under $100</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">INTIMATE</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">NIGHT</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--secondary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The night-blooming jasmine speaks to the introspective side of your autumn mood, while the grey amber adds a touch of mystery. An affordable option that still carries emotional depth — perfect for your quiet evening rituals.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
            </div>
            <!-- Page 2: Fortune / Mystic products -->
            <div class="rec-page" data-page="2" data-rec-type="fortune" style="display:none;grid-template-columns:1fr;gap:14px">
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1587017539504-67cfbddac569?w=300&q=80" alt="Aura No.1" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Aura No. 1</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$185.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Ozone, white musk, sea salt — a morning walk through coastal mist.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#f57f1715%,transparent);color:#f57f17;font-weight:600">$100-200</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SERENE</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">MORNING</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--tertiary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--tertiary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The cleansing ozone and white musk align with the cards' message of renewal — a burning away of the old. This scent clears the energy and opens the heart to new beginnings, like walking through coastal mist at dawn after a spiritual practice.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--tertiary);color:var(--on-tertiary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=300&q=80" alt="Mystic Oud" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Mystic Oud</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$94.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Incense, agarwood, saffron — a ritual wrapped in a bottle.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#2e7d3215%,transparent);color:#2e7d32;font-weight:600">Under $100</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">INCENSE</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">SACRED</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--tertiary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--tertiary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The incense and agarwood directly mirror the cards' divination of fire and smoke. This fragrance embodies the sacred-wild duality — affordable enough to explore without commitment, deep enough to ground your spiritual practice.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--tertiary);color:var(--on-tertiary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=300&q=80" alt="Sacred Night" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2px">
                                <h4 class="font-headline-md" style="font-size:16px;font-style:italic">Sacred Night</h4>
                                <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface);white-space:nowrap">$245.00</span>
                            </div>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:4px">Black amber, labdanum, benzoin — the scent of midnight prayers.</p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:2px">
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#c6282815%,transparent);color:#c62828;font-weight:600">$200+</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">AMBER</span>
                                <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)">RITUAL</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--tertiary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;letter-spacing:.08em;color:var(--tertiary);display:flex;align-items:center;gap:4px;margin-bottom:4px">
                            <span class="material-symbols-outlined" style="font-size:14px;font-variation-settings:'FILL' 1">psychology</span>
                            WHY THIS MATCHES YOU
                        </span>
                        <p class="font-body-md" style="font-size:13px;color:var(--on-surface-variant);line-height:1.4">The black amber and benzoin align with your craving for transformation. This is the invest-in-yourself option — a premium ritual scent that matches the depth of the shift you're experiencing. The universe whispers yes.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--tertiary);color:var(--on-tertiary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
            </div>
            <!-- Page 3-5: More products (same structure, abbreviated for preview) -->
            <div class="rec-page" data-page="3" data-rec-type="personal" style="display:none;grid-template-columns:1fr;gap:14px">
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=300&q=80" alt="Morning Aura" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <h4 style="font-family:'Playfair Display',serif;font-size:16px;font-style:italic;margin:0 0 2px">Morning Aura</h4>
                            <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface)">$129.00</span>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin:2px 0">Bergamot, linen, white tea — a clean slate.</p>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#f57f1715%,transparent);color:#f57f17;font-weight:600">$100-200</span>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;color:var(--secondary)">🧠 WHY THIS MATCHES YOU</span>
                        <p style="font-size:13px;color:var(--on-surface-variant);margin:2px 0 0">The clean, fresh notes balance the heaviness of autumn — a bright counterpoint to your reflective mood. Think of it as a morning breath after a long night.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=300&q=80" alt="Twilight Veil" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <h4 style="font-family:'Playfair Display',serif;font-size:16px;font-style:italic;margin:0 0 2px">Twilight Veil</h4>
                            <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface)">$178.00</span>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin:2px 0">Fig, black tea, leather — contemplative depths.</p>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#f57f1715%,transparent);color:#f57f17;font-weight:600">$100-200</span>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;color:var(--secondary)">🧠 WHY THIS MATCHES YOU</span>
                        <p style="font-size:13px;color:var(--on-surface-variant);margin:2px 0 0">The fig and black tea evoke quiet afternoons with a book — perfect for the introspective season you're in. Leather adds a grounded, sensual touch.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
                <div class="aura-glass" style="border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:80px;height:80px;border-radius:10px;overflow:hidden;flex-shrink:0">
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=300&q=80" alt="Aura No. 2" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                        </div>
                        <div style="flex:1;min-width:0">
                            <h4 style="font-family:'Playfair Display',serif;font-size:16px;font-style:italic;margin:0 0 2px">Aura No. 3</h4>
                            <span style="font-family:'Hanken Grotesk',sans-serif;font-size:15px;font-weight:600;color:var(--on-surface)">$52.00</span>
                            <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin:2px 0">Pear, freesia, white cedar — fresh and approachable.</p>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:color-mix(in srgb,#2e7d3215%,transparent);color:#2e7d32;font-weight:600">Under $100</span>
                        </div>
                    </div>
                    <div style="background:color-mix(in srgb,var(--secondary-container)10%,transparent);border-radius:8px;padding:10px">
                        <span class="font-label-caps" style="font-size:11px;color:var(--secondary)">🧠 WHY THIS MATCHES YOU</span>
                        <p style="font-size:13px;color:var(--on-surface-variant);margin:2px 0 0">A great entry point if you're not ready to commit to a heavy scent. Bright, uplifting, and effortless — like a gentle nudge toward joy on grey days.</p>
                    </div>
                    <button class="font-label-caps text-label-caps" style="padding:6px 12px;border-radius:999px;background:var(--secondary);color:var(--on-secondary);border:none;font-size:12px;align-self:flex-end;display:flex;align-items:center;gap:4px;transition:opacity .3s" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">View on Amazon <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span></button>
                </div>
            </div>
            <!-- Page 5: B2B / Consultant (service-focused, not product retails) -->
            <div class="rec-page" data-page="4" data-rec-type="commercial" style="display:none;grid-template-columns:1fr;gap:14px">
                <div class="aura-glass" style="border-radius:14px;padding:20px;text-align:center">
                    <div style="width:48px;height:48px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
                        <span class="material-symbols-outlined" style="color:var(--primary);font-size:24px;font-variation-settings:'FILL' 1">handshake</span>
                    </div>
                    <h3 class="font-headline-md" style="font-size:16px;font-style:italic;margin-bottom:4px">Custom Scent Strategy</h3>
                    <p class="font-body-md text-on-surface-variant" style="font-size:13px;margin-bottom:12px">Your business needs a unique scent identity. Our memory consultant will craft a bespoke fragrance system — from room-by-room diffusion to signature brand scent.</p>
                    <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap">
                        <button class="font-label-caps text-label-caps" style="padding:8px 16px;border-radius:999px;background:var(--primary);color:var(--on-primary);border:none;font-size:13px">Request Free Consultation</button>
                        <button class="font-label-caps text-label-caps" style="padding:8px 16px;border-radius:999px;border:1px solid var(--primary);color:var(--primary);background:none;font-size:13px">Browse Case Studies</button>
                    </div>
                    <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--outline-variant)">
                        <p class="font-body-md text-on-surface-variant" style="font-size:13px">Not what you're looking for? <a href="<?php echo esc_url(home_url('/the-atelier/')); ?>" style="color:var(--secondary);text-decoration:underline">Browse the Atelier</a> for ready-to-ship designer scents.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination (smart: auto-hides if < 3 products) -->
        <div id="page-counter-wrapper" style="text-align:center;margin-bottom:8px;display:none">
            <span class="font-label-caps" style="font-size:13px;color:var(--on-surface-variant);letter-spacing:.04em">Showing <span id="page-counter-start">1</span>–<span id="page-counter-end">3</span> of <span id="page-counter-total">9</span> recommendations</span>
        </div>
        <div id="pagination-wrapper" style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:4px;flex-wrap:wrap">
            <button class="pagination-btn" onclick="changePage(-1)" style="padding:8px 14px;border-radius:999px;border:1px solid var(--outline-variant);background:var(--surface);color:var(--on-surface-variant);font-size:13px;display:flex;align-items:center;gap:4px;transition:all .3s" onmouseover="this.style.borderColor='var(--secondary)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                <span class="material-symbols-outlined" style="font-size:16px">chevron_left</span>
            </button>
            <div id="pagination-dots" style="display:flex;gap:6px"></div>
            <button class="pagination-btn" onclick="changePage(1)" style="padding:8px 14px;border-radius:999px;border:1px solid var(--outline-variant);background:var(--surface);color:var(--on-surface-variant);font-size:13px;display:flex;align-items:center;gap:4px;transition:all .3s" onmouseover="this.style.borderColor='var(--secondary)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                <span class="material-symbols-outlined" style="font-size:16px">chevron_right</span>
            </button>
        </div>
        <div id="page-indicator-wrapper" style="text-align:center;margin-top:8px">
            <span class="font-label-caps" style="font-size:11px;color:var(--on-surface-variant);letter-spacing:.06em">Page <span id="page-indicator">1</span> of <span id="total-pages">4</span></span>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block">AI CONCIERGE</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:4px;font-style:italic">Not sure where to start?</h2>
            <p class="font-body-md" style="margin-bottom:12px;color:var(--surface-variant);font-size:15px">Tell us a little about yourself — your mood, your curiosity, or your business. One of our guides will find the perfect match.</p>
            <input type="text" class="font-body-md" style="width:100%;background:color-mix(in srgb,var(--surface)10%,transparent);border:none;border-bottom:1px solid color-mix(in srgb,var(--surface)30%,transparent);padding:8px 12px;outline:none;margin-bottom:10px;font-size:15px;color:var(--surface)" placeholder="Describe your ideal scent...">
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 24px;border-radius:999px;font-size:13px" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">Start Your Brief</a>
        </div>
    </section>
</div>
<!-- ===== ARCHIVE (Browse by Category) ===== -->

<?php get_footer(); ?>
