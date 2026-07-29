<?php
/**
 * Template Name: AI Synthesis
 * Description: AllScented AI Scent Finder — Neural Alchemy Engine
 */

get_header();
?>

<section class="px-margin-desktop container-max scroll-reveal mb-12">
    <span class="font-label-caps text-label-caps text-secondary mb-2 block">ALLSCENTED · NEURAL ALCHEMY</span>
    <h1 class="font-headline-lg text-headline-lg mb-4">AI Scent Synthesis</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">Describe your memory, mood, or vision — our engine analyzes 12,000+ molecular profiles to create your signature fragrance.</p>
</section>

<!-- Steps -->
<section class="px-margin-desktop container-max scroll-reveal mb-32">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $steps = array(
            array('num' => '01', 'title' => 'Describe', 'desc' => 'Tell us about the scent you envision — a memory, a mood, a place, a feeling. The more vivid, the better.', 'icon' => 'edit_note'),
            array('num' => '02', 'title' => 'Analyze', 'desc' => 'Our neural alchemy engine cross-references your description against thousands of molecular profiles and olfactory notes.', 'icon' => 'neurology'),
            array('num' => '03', 'title' => 'Synthesize', 'desc' => 'Receive your custom fragrance formula, ready to be brought to life. Iterate until it\'s perfect.', 'icon' => 'auto_awesome'),
        );
        foreach ($steps as $step) : ?>
            <div class="aura-glass rounded-xl p-8 text-center hover:shadow-lg transition-all duration-300">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center mx-auto mb-6">
                    <span class="font-label-caps text-label-caps text-secondary"><?php echo esc_html($step['num']); ?></span>
                </div>
                <span class="material-symbols-outlined text-3xl text-secondary mb-4 block"><?php echo esc_html($step['icon']); ?></span>
                <h3 class="font-headline-md text-headline-md mb-4"><?php echo esc_html($step['title']); ?></h3>
                <p class="font-body-md text-body-md text-on-surface-variant"><?php echo esc_html($step['desc']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-16 rounded-3xl text-center">
        <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">READY?</span>
        <h2 class="font-headline-lg text-headline-lg mb-6 italic">Begin your synthesis.</h2>
        <p class="font-body-lg text-body-lg mb-8 text-surface-variant max-w-xl mx-auto">Head to the Discover page to start your first fragrance creation with our AI concierge.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase" style="text-decoration:none;">
            Start Creating
            <span class="material-symbols-outlined ml-2" style="font-size:16px;">auto_awesome</span>
        </a>
    </div>
</section>

<?php
get_footer();
