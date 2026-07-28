<?php
/**
 * Template Name: Allscented AI Scent Finder
 * Digital Romanticism – Interactive Quiz + Radar Chart Results
 */

get_header('allscented');
?>

<section class="ai-finder-section" style="padding: 140px 20px 80px; max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 48px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('AI SCENT ANALYSIS', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl" style="margin-bottom: 16px;">
            <?php esc_html_e('What does your aura smell like?', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 0 auto;">
            <?php esc_html_e('Answer a few questions and our AI will decode your olfactory fingerprint.', 'allscents'); ?>
        </p>
    </div>

    <!-- Quiz Form -->
    <form class="scent-quiz-form" id="scentQuizForm">
        <!-- Step 1: Mood -->
        <div class="quiz-step active">
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 24px;">
                <?php esc_html_e('How do you want to feel today?', 'allscents'); ?>
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <?php
                $moods = [
                    ['icon' => 'ac_unit',      'label' => __('Fresh & Clean', 'allscents')],
                    ['icon' => 'whatshot',     'label' => __('Warm & Cozy', 'allscents')],
                    ['icon' => 'nature',       'label' => __('Earthy & Grounded', 'allscents')],
                    ['icon' => 'nights_stay',  'label' => __('Mysterious & Deep', 'allscents')],
                ];
                foreach ($moods as $mood) :
                ?>
                <label class="quiz-option glass-card" style="display: flex; align-items: center; gap: 12px; padding: 20px; border-radius: var(--radius-xl); cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="mood" value="<?php echo esc_attr($mood['label']); ?>" style="accent-color: var(--color-secondary);">
                    <span class="material-symbols-outlined" style="color: var(--color-secondary);"><?php echo esc_html($mood['icon']); ?></span>
                    <span class="font-body-md text-body-md"><?php echo esc_html($mood['label']); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn-primary btn-next" style="margin-top: 32px; width: 100%;">
                <?php esc_html_e('Next', 'allscents'); ?>
                <span class="material-symbols-outlined" style="margin-left: 8px; font-size: 18px;">arrow_forward</span>
            </button>
        </div>

        <!-- Step 2: Season -->
        <div class="quiz-step">
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 24px;">
                <?php esc_html_e('Which season speaks to you most?', 'allscents'); ?>
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <?php
                $seasons = [
                    ['icon' => 'ac_unit',    'label' => __('Winter', 'allscents')],
                    ['icon' => 'local_florist', 'label' => __('Spring', 'allscents')],
                    ['icon' => 'wb_sunny',   'label' => __('Summer', 'allscents')],
                    ['icon' => 'ecg_icon',   'label' => __('Autumn', 'allscents')],
                ];
                foreach ($seasons as $season) :
                ?>
                <label class="quiz-option glass-card" style="display: flex; align-items: center; gap: 12px; padding: 20px; border-radius: var(--radius-xl); cursor: pointer;">
                    <input type="radio" name="season" value="<?php echo esc_attr($season['label']); ?>" style="accent-color: var(--color-secondary);">
                    <span class="material-symbols-outlined" style="color: var(--color-secondary);"><?php echo esc_html($season['icon']); ?></span>
                    <span class="font-body-md text-body-md"><?php echo esc_html($season['label']); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="button" class="btn-outline btn-prev" style="flex: 1;">
                    <span class="material-symbols-outlined" style="margin-right: 8px; font-size: 18px;">arrow_back</span>
                    <?php esc_html_e('Back', 'allscents'); ?>
                </button>
                <button type="button" class="btn-primary btn-next" style="flex: 3;">
                    <?php esc_html_e('Next', 'allscents'); ?>
                    <span class="material-symbols-outlined" style="margin-left: 8px; font-size: 18px;">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Step 3: Notes Preference -->
        <div class="quiz-step">
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 24px;">
                <?php esc_html_e('Pick your favorite note family', 'allscents'); ?>
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <?php
                $notes = [
                    ['icon' => 'local_florist', 'label' => __('Floral', 'allscents')],
                    ['icon' => 'forest',         'label' => __('Woody', 'allscents')],
                    ['icon' => 'blur_on',        'label' => __('Fresh / Aquatic', 'allscents')],
                    ['icon' => 'cookies',        'label' => __('Gourmand', 'allscents')],
                    ['icon' => 'whatshot',       'label' => __('Spicy', 'allscents')],
                    ['icon' => 'landslide',      'label' => __('Mineral / Earthy', 'allscents')],
                ];
                foreach ($notes as $note) :
                ?>
                <label class="quiz-option glass-card" style="display: flex; align-items: center; gap: 12px; padding: 20px; border-radius: var(--radius-xl); cursor: pointer;">
                    <input type="radio" name="note" value="<?php echo esc_attr($note['label']); ?>" style="accent-color: var(--color-secondary);">
                    <span class="material-symbols-outlined" style="color: var(--color-secondary);"><?php echo esc_html($note['icon']); ?></span>
                    <span class="font-body-md text-body-md"><?php echo esc_html($note['label']); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="button" class="btn-outline btn-prev" style="flex: 1;">
                    <span class="material-symbols-outlined" style="margin-right: 8px; font-size: 18px;">arrow_back</span>
                    <?php esc_html_e('Back', 'allscents'); ?>
                </button>
                <button type="button" class="btn-primary btn-next" style="flex: 3;">
                    <?php esc_html_e('Analyze My Aura', 'allscents'); ?>
                </button>
            </div>
        </div>
    </form>
</section>

<!-- Results Section (hidden until quiz complete) -->
<section class="ai-finder-section" id="aiResults" style="display: none; padding: 80px 20px;">
    <!-- Top 3 Recommendations -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6" style="max-width: 1280px; margin: 0 auto;">
        <!-- Card 1: Perfect Match -->
        <div class="glass-card iridescent-aura" style="padding: 40px; border-radius: var(--radius-2xl); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 32px;">
                    <span class="font-label-caps text-label-caps" style="padding: 8px 16px; background: var(--color-secondary-container); border-radius: var(--radius-full);">
                        <?php esc_html_e('Perfect Match', 'allscents'); ?>
                    </span>
                    <span class="material-symbols-outlined" style="color: var(--color-primary);">auto_awesome</span>
                </div>
                <div style="aspect-ratio: 3/4; margin-bottom: 32px; overflow: hidden; border-radius: var(--radius-xl); background: var(--color-surface-container-low); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.4);">
                    <div style="color: var(--color-outline); text-align: center; padding: 20px;">
                        <span class="material-symbols-outlined" style="font-size: 48px; display: block; margin-bottom: 8px;">spa</span>
                        <span class="font-label-caps text-label-caps"><?php esc_html_e('Product Image', 'allscents'); ?></span>
                    </div>
                </div>
                <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Aura №1', 'allscents'); ?></h3>
                <p class="font-label-caps text-label-caps" style="color: var(--color-on-surface-variant); margin-bottom: 24px;"><?php esc_html_e('Allscented Exclusive', 'allscents'); ?></p>
                <div style="background: var(--color-secondary-container); padding: 16px; border-radius: var(--radius-xl); margin-bottom: 24px;">
                    <p style="font-style: italic; color: var(--color-on-secondary-container);">
                        "<?php esc_html_e('A molecular amber base meets moonflower — a perfect match for your aura.', 'allscents'); ?>"
                    </p>
                </div>
            </div>
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-primary" style="width: 100%;"><?php esc_html_e('Shop Now — $185', 'allscents'); ?></a>
        </div>

        <!-- Card 2 -->
        <div class="glass-card" style="padding: 40px; border-radius: var(--radius-2xl); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 32px;">
                    <span class="font-label-caps text-label-caps" style="padding: 8px 16px; background: var(--color-surface-container-high); border-radius: var(--radius-full);">
                        <?php esc_html_e('Top Recommendation', 'allscents'); ?>
                    </span>
                    <span class="material-symbols-outlined icon-fill" style="color: var(--color-primary);">favorite</span>
                </div>
                <div style="aspect-ratio: 3/4; margin-bottom: 32px; overflow: hidden; border-radius: var(--radius-xl); background: var(--color-surface-container-low); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.4);">
                    <div style="color: var(--color-outline); text-align: center; padding: 20px;">
                        <span class="material-symbols-outlined" style="font-size: 48px; display: block; margin-bottom: 8px;">spa</span>
                        <span class="font-label-caps text-label-caps"><?php esc_html_e('Product Image', 'allscents'); ?></span>
                    </div>
                </div>
                <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Ethereal Silk', 'allscents'); ?></h3>
                <p class="font-label-caps text-label-caps" style="color: var(--color-on-surface-variant); margin-bottom: 24px;"><?php esc_html_e('Limited Edition', 'allscents'); ?></p>
                <div style="background: var(--color-surface-container-low); padding: 16px; border-radius: var(--radius-xl); margin-bottom: 24px;">
                    <p style="font-style: italic; color: var(--color-on-surface-variant);">
                        "<?php esc_html_e('Iris butter and cashmere — a sophisticated second skin.', 'allscents'); ?>"
                    </p>
                </div>
            </div>
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-outline" style="width: 100%; text-align: center;"><?php esc_html_e('Shop Now — $210', 'allscents'); ?></a>
        </div>

        <!-- Card 3 -->
        <div class="glass-card" style="padding: 40px; border-radius: var(--radius-2xl); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 32px;">
                    <span class="font-label-caps text-label-caps" style="padding: 8px 16px; background: var(--color-surface-container-high); border-radius: var(--radius-full);">
                        <?php esc_html_e('Top Recommendation', 'allscents'); ?>
                    </span>
                    <span class="material-symbols-outlined" style="color: var(--color-primary);">temp_preferences_custom</span>
                </div>
                <div style="aspect-ratio: 3/4; margin-bottom: 32px; overflow: hidden; border-radius: var(--radius-xl); background: var(--color-surface-container-low); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.4);">
                    <div style="color: var(--color-outline); text-align: center; padding: 20px;">
                        <span class="material-symbols-outlined" style="font-size: 48px; display: block; margin-bottom: 8px;">spa</span>
                        <span class="font-label-caps text-label-caps"><?php esc_html_e('Product Image', 'allscents'); ?></span>
                    </div>
                </div>
                <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Oceanic Vapor', 'allscents'); ?></h3>
                <p class="font-label-caps text-label-caps" style="color: var(--color-on-surface-variant); margin-bottom: 24px;"><?php esc_html_e('Aqueous Elements', 'allscents'); ?></p>
                <div style="background: var(--color-surface-container-low); padding: 16px; border-radius: var(--radius-xl); margin-bottom: 24px;">
                    <p style="font-style: italic; color: var(--color-on-surface-variant);">
                        "<?php esc_html_e('Sea mist and driftwood — grounded mineral contrast.', 'allscents'); ?>"
                    </p>
                </div>
            </div>
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-outline" style="width: 100%; text-align: center;"><?php esc_html_e('Shop Now — $160', 'allscents'); ?></a>
        </div>
    </section>

    <!-- Radar Chart Breakdown -->
    <section style="max-width: 900px; margin: 96px auto 0; text-align: center;">
        <h2 class="font-headline-lg text-headline-lg" style="margin-bottom: 16px;">
            <?php esc_html_e('Scent Profile Breakdown', 'allscents'); ?>
        </h2>
        <p class="font-body-md text-body-md" style="color: var(--color-on-surface-variant); margin-bottom: 48px;">
            <?php esc_html_e('Your olfactory fingerprint decoded.', 'allscents'); ?>
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;">
            <div class="radar-chart-container">
                <div style="position: absolute; inset: 0; background: var(--color-secondary); opacity: 0.05; border-radius: 50%; animation: pulse 3s infinite;"></div>
                <canvas id="scentRadar" data-values="60,40,50,90,85,30" width="400" height="400" style="width: 100%; height: auto;"></canvas>
            </div>
            <div style="text-align: left;">
                <h4 class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 8px;"><?php esc_html_e('DOMINANT NOTE', 'allscents'); ?></h4>
                <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Mineral Ethereal', 'allscents'); ?></h3>
                <p class="font-body-md text-body-md" style="color: var(--color-on-surface-variant); margin-bottom: 32px;">
                    <?php esc_html_e('Your profile resonates with clean, expansive mineral notes — like fresh air and open space.', 'allscents'); ?>
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="glass-card" style="padding: 24px; border-radius: var(--radius-xl); text-align: center;">
                        <span class="font-headline-md text-headline-md" style="color: var(--color-secondary); display: block;">88%</span>
                        <span class="font-label-caps text-label-caps"><?php esc_html_e('Modernity', 'allscents'); ?></span>
                    </div>
                    <div class="glass-card" style="padding: 24px; border-radius: var(--radius-xl); text-align: center;">
                        <span class="font-headline-md text-headline-md" style="color: var(--color-tertiary); display: block;">12%</span>
                        <span class="font-label-caps text-label-caps"><?php esc_html_e('Heritage', 'allscents'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<?php get_footer('allscented'); ?>
