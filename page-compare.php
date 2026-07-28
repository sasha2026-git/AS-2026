<?php
/**
 * Template Name: Allscented Comparison Hub
 * Digital Romanticism – Side-by-side scent comparison
 */

get_header('allscented');
?>

<section style="padding: 140px var(--margin-desktop) 64px; max-width: var(--container-max); margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 64px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('THE SCENT DUEL', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl">
            <?php esc_html_e('Comparison Arena', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 16px auto 0;">
            <?php esc_html_e('Select two scents. We analyze molecular metrics, sillage, longevity, and flavor profile. The AI declares a winner.', 'allscents'); ?>
        </p>
    </div>

    <!-- Comparison Selectors -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--gutter); margin-bottom: 48px;">
        <div class="glass-card" style="padding: 32px; border-radius: var(--radius-xl);">
            <label class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block;">
                <?php esc_html_e('SCENT A', 'allscents'); ?>
            </label>
            <select style="width: 100%; padding: 16px; border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); background: rgba(255,255,255,0.8); font-family: var(--font-body); font-size: var(--text-body-md);">
                <option><?php esc_html_e('Select a scent...', 'allscents'); ?></option>
                <option><?php esc_html_e('Aura №1 — Molecular Amber', 'allscents'); ?></option>
                <option><?php esc_html_e('Ethereal Silk — White Iris', 'allscents'); ?></option>
                <option><?php esc_html_e('Oceanic Vapor — Sea Mist', 'allscents'); ?></option>
                <option><?php esc_html_e('Midnight Oxide — Dark Mineral', 'allscents'); ?></option>
                <option><?php esc_html_e('Liquid Amber — Warm Resin', 'allscents'); ?></option>
            </select>
        </div>
        <div class="glass-card" style="padding: 32px; border-radius: var(--radius-xl);">
            <label class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block;">
                <?php esc_html_e('SCENT B', 'allscents'); ?>
            </label>
            <select style="width: 100%; padding: 16px; border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); background: rgba(255,255,255,0.8); font-family: var(--font-body); font-size: var(--text-body-md);">
                <option><?php esc_html_e('Select a scent...', 'allscents'); ?></option>
                <option><?php esc_html_e('Aura №1 — Molecular Amber', 'allscents'); ?></option>
                <option><?php esc_html_e('Ethereal Silk — White Iris', 'allscents'); ?></option>
                <option><?php esc_html_e('Oceanic Vapor — Sea Mist', 'allscents'); ?></option>
                <option><?php esc_html_e('Midnight Oxide — Dark Mineral', 'allscents'); ?></option>
                <option><?php esc_html_e('Liquid Amber — Warm Resin', 'allscents'); ?></option>
            </select>
        </div>
    </div>

    <!-- Comparison Bar Chart (sample) -->
    <div class="compare-grid">
        <!-- Scent A Card -->
        <div class="compare-card-red" style="border-radius: var(--radius-2xl); padding: 40px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 32px;">
                <h2 class="font-headline-md text-headline-md" style="color: var(--color-on-surface);">Aura №1</h2>
                <span class="font-label-caps text-label-caps" style="padding: 8px 16px; background: rgba(255,100,100,0.2); border-radius: var(--radius-full); color: #b33a3a;">
                    <?php esc_html_e('RED TEAM', 'allscents'); ?>
                </span>
            </div>
            <?php
            $metrics_red = [
                ['label' => 'Longevity', 'value' => 65],
                ['label' => 'Sillage',   'value' => 42],
                ['label' => 'Complexity', 'value' => 80],
                ['label' => 'Freshness',  'value' => 30],
                ['label' => 'Warmth',     'value' => 75],
            ];
            foreach ($metrics_red as $m) :
            ?>
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span class="font-label-caps text-label-caps"><?php echo esc_html($m['label']); ?></span>
                    <span class="font-label-caps text-label-caps"><?php echo esc_html($m['value']); ?>%</span>
                </div>
                <div style="width: 100%; height: 6px; background: rgba(255,100,100,0.15); border-radius: var(--radius-full); overflow: hidden;">
                    <div style="width: <?php echo esc_attr($m['value']); ?>%; height: 100%; background: linear-gradient(90deg, #e57373, #ef5350); border-radius: var(--radius-full); transition: width 1s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Scent B Card -->
        <div class="compare-card-green" style="border-radius: var(--radius-2xl); padding: 40px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 32px;">
                <h2 class="font-headline-md text-headline-md" style="color: var(--color-on-surface);">Ethereal Silk</h2>
                <span class="font-label-caps text-label-caps" style="padding: 8px 16px; background: rgba(100,200,100,0.2); border-radius: var(--radius-full); color: #2e7d32;">
                    <?php esc_html_e('GREEN TEAM', 'allscents'); ?>
                </span>
            </div>
            <?php
            $metrics_green = [
                ['label' => 'Longevity', 'value' => 78],
                ['label' => 'Sillage',   'value' => 65],
                ['label' => 'Complexity', 'value' => 55],
                ['label' => 'Freshness',  'value' => 90],
                ['label' => 'Warmth',     'value' => 35],
            ];
            foreach ($metrics_green as $m) :
            ?>
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span class="font-label-caps text-label-caps"><?php echo esc_html($m['label']); ?></span>
                    <span class="font-label-caps text-label-caps"><?php echo esc_html($m['value']); ?>%</span>
                </div>
                <div style="width: 100%; height: 6px; background: rgba(100,200,100,0.15); border-radius: var(--radius-full); overflow: hidden;">
                    <div style="width: <?php echo esc_attr($m['value']); ?>%; height: 100%; background: linear-gradient(90deg, #81c784, #66bb6a); border-radius: var(--radius-full); transition: width 1s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- AI Sentiment Verdict -->
    <div class="glass-card iridescent-aura" style="margin-top: 48px; padding: 48px; border-radius: var(--radius-2xl); text-align: center;">
        <span class="material-symbols-outlined icon-fill" style="font-size: 40px; color: var(--color-secondary); margin-bottom: 16px;">auto_awesome</span>
        <h2 class="font-headline-md text-headline-md" style="margin-bottom: 12px;">
            <?php esc_html_e('AI Verdict: Ethereal Silk Wins', 'allscents'); ?>
        </h2>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 0 auto;">
            <?php esc_html_e('Based on 12,400 global data points, Ethereal Silk outperforms in freshness and sillage. Its iris-butter base provides superior versatility across seasons.', 'allscents'); ?>
        </p>
        <div style="display: flex; gap: 32px; justify-content: center; margin-top: 24px;">
            <div>
                <div class="font-headline-md" style="color: var(--color-secondary);">76%</div>
                <div class="font-label-caps text-label-caps"><?php esc_html_e('SCENT A MATCH', 'allscents'); ?></div>
            </div>
            <div>
                <div class="font-headline-md" style="color: var(--color-secondary);">92%</div>
                <div class="font-label-caps text-label-caps"><?php esc_html_e('SCENT B MATCH', 'allscents'); ?></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer('allscented'); ?>
