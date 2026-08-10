<?php
/**
 * Template Name: AI Synthesis
 */
get_header();

// ===== v2.0 guide card copy (safe fallbacks replace old v1 wording) =====
$s_eyebrow = allscented_field('allscented_ai_eyebrow', 'AI SYNTHESIS');
$s_title   = allscented_field('allscented_ai_title', 'Meet your scent guides.');
$s_desc_default = 'Five professional rounds with each guide. Choose from the options provided, then receive a synthesis and product direction.';
$s_desc    = allscented_ai_safe_copy(allscented_field('allscented_ai_desc', $s_desc_default), $s_desc_default);

function allscented_ai_safe_copy($value, $default) {
    if (!is_string($value)) {
        return $default;
    }
    $bad = array('How are you ' . 'feeling today', 'I hear ' . 'you saying', 'That must be really ' . 'hard', 'The universe has a ' . 'plan', 'Tell me how you ' . 'feel today', 'universe has in ' . 'store');
    foreach ($bad as $needle) {
        if (stripos($value, $needle) !== false) {
            return $default;
        }
    }
    return $value;
}

$g1_name_default = 'Luná The Healer';
$g1_desc_default = 'Clinical aromatherapy intake: I read energy state, timing, craving, format, and sensitivity before recommending anything.';
$g2_name_default = 'Echo The Mystic';
$g2_desc_default = 'Tarot-based scent reflection: I read the symbols you choose and translate them into fragrance without predicting your future.';
$g3_name_default = 'Sage The Strategist';
$g3_desc_default = 'Commercial scent branding: I diagnose space type, personality, emotional goal, constraints, and scope before recommending a system.';

$g1_name   = allscented_field('allscented_ai_g1_name', $g1_name_default);
$g1_desc   = allscented_ai_safe_copy(allscented_field('allscented_ai_g1_desc', $g1_desc_default), $g1_desc_default);
$g2_name   = allscented_field('allscented_ai_g2_name', $g2_name_default);
$g2_desc   = allscented_ai_safe_copy(allscented_field('allscented_ai_g2_desc', $g2_desc_default), $g2_desc_default);
$g3_name   = allscented_field('allscented_ai_g3_name', $g3_name_default);
$g3_desc   = allscented_ai_safe_copy(allscented_field('allscented_ai_g3_desc', $g3_desc_default), $g3_desc_default);

$s_cta_title = allscented_field('allscented_ai_cta_title', 'Not sure where to start?');
$s_cta_desc  = allscented_ai_safe_copy(allscented_field('allscented_ai_cta_desc', 'Choose a guide to begin a five-round professional conversation. No free text needed.'), 'Choose a guide to begin a five-round professional conversation. No free text needed.');

// ===== 数字人头像 & 对话/案例头像（v1.4.2 新增，可后台修改）=====
$g1_avatar = allscented_image_url('allscented_ai_g1_avatar', '');
$g1_role   = allscented_field('allscented_ai_g1_role', 'CLINICAL AROMATHERAPIST · LUNÁ');
$g1_short  = allscented_field('allscented_ai_g1_shortname', 'Luná');
$g1_cta    = allscented_field('allscented_ai_g1_cta', 'START INTAKE');
$g2_avatar = allscented_image_url('allscented_ai_g2_avatar', '');
$g2_role   = allscented_field('allscented_ai_g2_role', 'TAROT SCENT READER · ECHO');
$g2_short  = allscented_field('allscented_ai_g2_shortname', 'Echo');
$g2_cta    = allscented_field('allscented_ai_g2_cta', 'DRAW YOUR READING');
$g3_avatar = allscented_image_url('allscented_ai_g3_avatar', '');
$g3_role   = allscented_field('allscented_ai_g3_role', 'COMMERCIAL SCENT CONSULTANT · SAGE');
$g3_short  = allscented_field('allscented_ai_g3_shortname', 'Sage');
$g3_cta    = allscented_field('allscented_ai_g3_cta', 'START CONSULTATION');

$chat_user = allscented_image_url('allscented_ai_chat_user_avatar', '');
$chat_g1   = allscented_image_url('allscented_ai_chat_g1_avatar', '');
$chat_g2   = allscented_image_url('allscented_ai_chat_g2_avatar', '');
$chat_g3   = allscented_image_url('allscented_ai_chat_g3_avatar', '');

$case1_avatar = allscented_image_url('allscented_ai_case1_avatar', '');
$case1_label  = allscented_field('allscented_ai_case1_label', 'CLINICAL AROMATHERAPY INTAKE');
$case1_pct    = allscented_field('allscented_ai_case1_pct', '94% SYNTHESIS');
$case1_title  = allscented_field('allscented_ai_case1_title', '"A regulated evening ritual"');
$case1_summary = allscented_field('allscented_ai_case1_summary', 'Your intake reads restless energy peaking in the evening, with a craving for comfort and a preference for a candle ritual. The shortlist leans toward gentle, low-intensity notes delivered close to the body.');
$case2_avatar = allscented_image_url('allscented_ai_case2_avatar', '');
$case2_label  = allscented_field('allscented_ai_case2_label', 'TAROT SCENT REFLECTION · ECHO');
$case2_pct    = allscented_field('allscented_ai_case2_pct', '91% SYNTHESIS');
$case2_title  = allscented_field('allscented_ai_case2_title', '"A reflective water-and-air signature"');
$case2_summary = allscented_field('allscented_ai_case2_summary', 'The Star card and Water element reflect a desire for renewal and openness. This maps to fresh, hopeful notes without predicting a fixed outcome.');
$case3_avatar = allscented_image_url('allscented_ai_case3_avatar', '');
$case3_label  = allscented_field('allscented_ai_case3_label', 'COMMERCIAL SCENT STRATEGY · SAGE');
$case3_pct    = allscented_field('allscented_ai_case3_pct', '89% SYNTHESIS');
$case3_title  = allscented_field('allscented_ai_case3_title', '"A scalable commercial scent identity"');
$case3_summary = allscented_field('allscented_ai_case3_summary', 'For a boutique hotel with a natural personality and an elevated arrival goal, the strategy favors continuous diffusion with a signature blend.');

$avatar_html = function ($url, $fallback, $bg, $fg, $size, $is_letter = false) {
    $sz = $size . 'px';
    if ($url) {
        return '<img src="' . esc_url($url) . '" alt="Allscented AI consultant avatar" style="width:' . $sz . ';height:' . $sz . ';border-radius:999px;object-fit:cover;flex-shrink:0;display:block">';
    }
    if ($is_letter) {
        $inner = '<span style="font-size:12px;color:' . $fg . ';font-weight:600;line-height:1">' . esc_html($fallback) . '</span>';
    } else {
        $inner = '<span class="material-symbols-outlined" style="color:' . $fg . ';font-size:' . ($size >= 40 ? 20 : 14) . 'px">' . esc_html($fallback) . '</span>';
    }
    return '<div style="width:' . $sz . ';height:' . $sz . ';border-radius:999px;background:' . $bg . ';display:flex;align-items:center;justify-content:center;flex-shrink:0">' . $inner . '</div>';
};

// ===== v2.0 conversation engine defaults =====
$ai_engine_defaults = array(
    'luna' => array(
        'id'      => 'luna',
        'name'    => 'Luná The Healer',
        'role'    => 'Clinical Aromatherapist · Intake',
        'icon'    => 'spa',
        'avatar'  => $g1_avatar,
        'greeting' => "Hi, I'm Luná. No formalities here — let's just begin wherever you are. Think of this as a gentle chat over tea: a few easy questions, no right or wrong answers, and together we'll find the scent that truly feels like you.",
        'safety_note' => 'For general wellness use only — please consult a professional if you have specific health concerns.',
        'summary_template' => 'Your synthesis reads {state} energy that peaks {time}. You are craving {craving}, delivered as {format}, with {sensitivity} as your boundary. I am narrowing the shortlist toward a scent ritual that supports your nervous system rather than overpowering it.',
        'why_lines' => array(
            'Your {state} state maps to olfactory notes that support regulation instead of overstimulation.',
            'The {time} timing tells us this needs to integrate with your daily rhythm, not fight it.',
            'Craving {craving} and choosing {format} points to {sensitivity} as the guiding constraint.',
        ),
        'closing' => 'Your intake is complete. I have translated the five signals into a synthesis and product direction.',
        'slots' => array('state', 'time', 'craving', 'format', 'sensitivity'),
        'fallback_categories' => array('home', 'personal'),
        'fallback_reason' => 'Best available match for your aromatherapy intake.',
        'rounds' => array(
            array(
                'question' => 'Intake one: where is your energy right now?',
                'options' => array('Racing (overstimulated)', 'Dragging (depleted)', 'Numb (shut down)', 'Restless (can\'t settle)', 'Even (balanced)', 'Curious (open)'),
                'knowledge' => 'Scent reaches the limbic system before your thinking brain gets a vote — that is why a single note can shift your state in seconds. (What the Nose Knows)',
            ),
            array(
                'question' => 'When does this state hit you hardest?',
                'options' => array('Morning', 'Midday', 'Late afternoon', 'Evening', 'Night', 'All day'),
                'knowledge' => 'Your body runs on a circadian rhythm; the same note can read as wake at 8am and calm at 10pm.',
            ),
            array(
                'question' => 'What are you craving more of right now?',
                'options' => array('Calm', 'Focus', 'Energy', 'Comfort', 'Grounding', 'Escape', 'Clarity'),
                'knowledge' => 'In clinical aromatherapy, calming and uplifting oils work through different pathways — matching the craving matters. (Clinical Aromatherapy)',
            ),
            array(
                'question' => 'How do you want this scent to live with you?',
                'options' => array('A candle ritual', 'A constant diffuser', 'Close to skin', 'In my space', 'On the go', 'A mix'),
                'knowledge' => 'Format changes the experience: a candle is a ceremony, a diffuser is an atmosphere, a roller is a companion.',
            ),
            array(
                'question' => 'Last check — any sensitivities or preferences?',
                'options' => array('Sensitive to strong scents', 'Prefer sweet', 'Prefer fresh', 'Prefer woody', 'No limits', 'Surprise me'),
                'knowledge' => 'Good — I will keep it gentle. Essential oils are potent; we always respect your boundaries. (safety guardrail)',
            ),
        ),
        'mappings' => array(
            array(
                'keywords' => array('racing', 'restless', 'overstimulated', 'calm', 'grounding', 'comfort'),
                'categories' => array('home', 'personal'),
                'products' => array('Leopard Glass Candle', 'Dessert Candle'),
                'reason' => 'A contained flame ritual supports the nervous system with a gentle, non-demanding scent.',
            ),
            array(
                'keywords' => array('dragging', 'depleted', 'focus', 'energy', 'clarity', 'midday', 'morning'),
                'categories' => array('home', 'commercial'),
                'products' => array('Cinnamon & Brandy Refill', 'Nutmeg & Freesia Refill'),
                'reason' => 'Warm, lifting notes work with circadian dips rather than adding more stimulation.',
            ),
            array(
                'keywords' => array('numb', 'shut', 'close to skin', 'sensitive', 'sweet', 'woody', 'on the go', 'skin'),
                'categories' => array('personal'),
                'products' => array("Puppy Salon Candle — I'm Your Eyes", 'Vesper Muse', 'Puppy Salon Reed Diffuser — Elephants'),
                'reason' => 'Smaller, close-worn formats are ideal when the scent should be a gentle companion.',
            ),
            array(
                'keywords' => array('diffuser', 'constant', 'in my space', 'mix', 'all day'),
                'categories' => array('home', 'commercial'),
                'products' => array('Leopard Diffuser Vessel', 'Steel Diffuser Bottle', 'Extra Large Reed Diffuser'),
                'reason' => 'Continuous diffusion suits atmosphere-building more than a short ceremony.',
            ),
            array(
                'keywords' => array('evening', 'night', 'escape', 'candle ritual', 'sweet'),
                'categories' => array('home'),
                'products' => array('Dessert Candle', 'Puppy Salon Candle — Whale Song'),
                'reason' => 'Evening rituals pair best with lower-intensity, slower-burning formats.',
            ),
        ),
    ),
    'echo' => array(
        'id'      => 'echo',
        'name'    => 'Echo The Mystic',
        'role'    => 'Tarot & Symbolic Scent Reader · Reflection',
        'icon'    => 'auto_awesome',
        'avatar'  => $g2_avatar,
        'greeting' => "I'm Echo. I read the symbols you're drawn to, and translate them into scent. A quick note before we begin: the cards don't predict — they reflect. Choose what resonates, and we'll find the fragrance that matches your archetype.",
        'safety_note' => 'The cards reflect, not predict — treat the reading as a symbolic mirror for your own choices.',
        'summary_template' => 'Your reading begins at {card}, moves through {element}, and circles back to the {symbol} symbol. In this {cycle}, you are asking for {delivery}. I am translating that constellation into a scent signature that mirrors the symbolism without inventing a fixed future.',
        'why_lines' => array(
            'The {card} card frames the core theme; the scent should carry that mood without promising an outcome.',
            'Your {element} element points to a specific olfactory family.',
            'The {symbol} symbol and {cycle} phase shape how the fragrance should be worn.',
        ),
        'closing' => 'The cards have spoken in symbols. Here is your scent reflection and the product direction it suggests.',
        'slots' => array('card', 'element', 'symbol', 'cycle', 'delivery'),
        'fallback_categories' => array('personal', 'home'),
        'fallback_reason' => 'Best available match for your reflected card reading.',
        'meanings' => array(
            'The Fool (new start)' => 'A step into the unknown with the willingness to begin.',
            'The Tower (upheaval)' => 'A sudden disruption that clears space for rebuilding.',
            'Death (transformation)' => 'An ending that enables transformation.',
            'The Star (hope)' => 'Hope, clarity, and quiet restoration after difficulty.',
            'The Chariot (momentum)' => 'Direction, will, and momentum moving a choice forward.',
            'The Moon (uncertainty)' => 'Uncertainty, intuition, and what is not yet fully visible.',
        ),
        'rounds' => array(
            array(
                'question' => 'The Major Arcana has 22 doors. Which one are you standing in front of?',
                'options' => array('The Fool (new start)', 'The Tower (upheaval)', 'Death (transformation)', 'The Star (hope)', 'The Chariot (momentum)', 'The Moon (uncertainty)'),
                'knowledge' => 'The Major Arcana is a symbolic journey rather than a fixed destiny; each card carries a core meaning from the Pictorial Key tradition. (A.E. Waite)',
            ),
            array(
                'question' => 'Draw your element.',
                'options' => array('Fire', 'Water', 'Earth', 'Air', 'Aether'),
                'knowledge' => 'Each element carries its own scent signature: fire burns amber, water runs to sea salt, earth grounds in vetiver, air lifts to ozone. (78 Card Meanings)',
            ),
            array(
                'question' => 'Which symbol has been circling you lately?',
                'options' => array('Key', 'Feather', 'Eye', 'Spiral', 'Mirror', 'Compass'),
                'knowledge' => 'Symbols repeat because the unconscious speaks in images. (Jung, Psychology of the Unconscious)',
            ),
            array(
                'question' => 'Where are you in the cycle?',
                'options' => array('New moon (planting)', 'Waxing (building)', 'Full moon (peak)', 'Waning (releasing)'),
                'knowledge' => 'New moon is a fresh start, waxing builds momentum, full moon is peak intensity, waning releases. The scent direction follows the phase.',
            ),
            array(
                'question' => 'How do you want the answer delivered?',
                'options' => array('A signature scent', 'A daily ritual', 'Something for special nights', 'A gift for someone', 'Show me everything'),
                'knowledge' => 'The cards reflect, not predict; the notes follow the symbolic direction you chose.',
            ),
        ),
        'mappings' => array(
            array(
                'keywords' => array('fool', 'new start', 'star', 'hope', 'chariot', 'momentum', 'tower', 'upheaval', 'death', 'transformation', 'moon', 'uncertainty'),
                'categories' => array('personal', 'home'),
                'products' => array('Aura No. 1', 'Nutmeg & Freesia Refill', 'Nordic Noir'),
                'reason' => 'The card symbolic tone maps to a scent direction without claiming to predict an outcome.',
            ),
            array(
                'keywords' => array('fire', 'water', 'earth', 'air', 'aether'),
                'categories' => array('personal', 'home', 'commercial'),
                'products' => array('Cinnamon & Brandy Refill', 'Aura No. 1', 'Leopard Glass Candle'),
                'reason' => 'Elemental symbolism narrows the olfactory family: warm, marine, rooted, fresh, or ethereal.',
            ),
            array(
                'keywords' => array('key', 'feather', 'eye', 'spiral', 'mirror', 'compass'),
                'categories' => array('personal', 'home'),
                'products' => array('Puppy Salon Candle — Cat Series', 'Vesper Muse'),
                'reason' => 'Recurring symbols are mirrors for the unconscious, so the scent should feel personally resonant.',
            ),
            array(
                'keywords' => array('new moon', 'planting', 'waxing', 'building', 'full moon', 'peak', 'waning', 'releasing'),
                'categories' => array('home'),
                'products' => array('Dessert Candle', 'Leopard Glass Candle'),
                'reason' => 'The cycle shapes whether the scent is fresh and beginning, fuller, or releasing.',
            ),
            array(
                'keywords' => array('signature', 'daily ritual', 'special nights', 'gift', 'show me'),
                'categories' => array('home', 'personal'),
                'products' => array('Puppy Salon Candle — Whale Song', 'Leopard Diffuser Vessel'),
                'reason' => 'Delivery format determines whether this becomes a personal signature or an ambient ritual.',
            ),
        ),
    ),
    'sage' => array(
        'id'      => 'sage',
        'name'    => 'Sage The Strategist',
        'role'    => 'Commercial Scent Branding Consultant · Intake',
        'icon'    => 'business_center',
        'avatar'  => $g3_avatar,
        'greeting' => "I'm Sage. I design scent identities for commercial spaces. To recommend the right system, I need five quick answers: your space, its personality, the feeling you're engineering, your constraints, and the scope. Let's start.",
        'safety_note' => '',
        'summary_template' => 'For a {space} with a {personality} personality, you are engineering a {feeling} arrival. Given the {constraint} constraint and {scope} scope, the strategy should favor repeatable, measurable scent delivery over a one-off product.',
        'why_lines' => array(
            '{space} defines the diffusion method and intensity ceiling.',
            '{personality} personality means the scent should reinforce the brand language, not compete with it.',
            '{feeling} arrival is the emotional KPI; {constraint} and {scope} decide the system.',
        ),
        'closing' => 'Consultation intake complete. I have translated your space and constraints into a scent strategy and product direction.',
        'slots' => array('space', 'personality', 'feeling', 'constraint', 'scope'),
        'fallback_categories' => array('commercial', 'home'),
        'fallback_reason' => 'Best available match for your commercial scent brief.',
        'rounds' => array(
            array(
                'question' => 'What kind of space are we scenting?',
                'options' => array('Boutique hotel', 'Retail store', 'Spa & wellness', 'Café & restaurant', 'Office', 'Showroom', 'Private residence'),
                'knowledge' => 'Commercial scent design starts with the space type — each has its own diffusion and intensity profile.',
            ),
            array(
                'question' => 'Describe the personality of the space.',
                'options' => array('Minimalist', 'Warm', 'Luxurious', 'Natural', 'Bold', 'Serene', 'Industrial'),
                'knowledge' => 'A signature scent should match brand personality — consistency builds recognition.',
            ),
            array(
                'question' => 'The moment someone walks in, they should feel…',
                'options' => array('Welcomed', 'Impressed', 'Relaxed', 'Inspired', 'Trusting', 'Energized', 'Elevated'),
                'knowledge' => 'Scent is the fastest shortcut to an emotional state — it frames the experience before a word is spoken.',
            ),
            array(
                'question' => 'What is your practical constraint?',
                'options' => array('Coverage area', 'Maintenance', 'Budget', 'Longevity', 'Hypoallergenic', 'Signature uniqueness'),
                'knowledge' => 'For large areas we think in diffusion systems, not candles — different tools for different jobs.',
            ),
            array(
                'question' => 'What is the scope of this project?',
                'options' => array('A single room', 'A whole floor', 'The entire venue', 'Trial first', 'Seasonal rotation', 'Full brand identity'),
                'knowledge' => 'Scope defines the solution: a trial lets you test before you commit.',
            ),
        ),
        'mappings' => array(
            array(
                'keywords' => array('hotel', 'spa', 'wellness', 'retail', 'café', 'restaurant', 'office', 'showroom', 'residence'),
                'categories' => array('commercial', 'home'),
                'products' => array('Extra Large Reed Diffuser', 'Spatial Bloom', 'Leopard Diffuser Vessel'),
                'reason' => 'Space type drives system selection and scent intensity.',
            ),
            array(
                'keywords' => array('minimalist', 'warm', 'luxurious', 'natural', 'bold', 'serene', 'industrial'),
                'categories' => array('commercial', 'home'),
                'products' => array('Steel Diffuser Bottle', 'Honey & Currant Refill'),
                'reason' => 'The brand personality should be reinforced by the scent signature.',
            ),
            array(
                'keywords' => array('welcomed', 'impressed', 'relaxed', 'inspired', 'trusting', 'energized', 'elevated'),
                'categories' => array('commercial', 'home'),
                'products' => array('Cinnamon & Brandy Refill', 'Nutmeg & Freesia Refill', 'Leopard Glass Candle'),
                'reason' => 'The arrival emotion is the measurable outcome the scent is engineered to create.',
            ),
            array(
                'keywords' => array('coverage', 'maintenance', 'budget', 'longevity', 'hypoallergenic', 'signature'),
                'categories' => array('commercial', 'home'),
                'products' => array('Extra Large Reed Diffuser', 'Steel Diffuser Bottle'),
                'reason' => 'Practical constraints separate a scalable system from a decorative product.',
            ),
            array(
                'keywords' => array('single room', 'floor', 'venue', 'trial', 'seasonal', 'brand identity'),
                'categories' => array('commercial', 'home'),
                'products' => array('Extra Large Reed Diffuser', 'Honey & Currant Refill'),
                'reason' => 'Scope defines whether to start with a trial, rotate seasonally, or build a full brand identity.',
            ),
        ),
    ),
);

// ===== ACF overrides, with v2.0 fallbacks preserved =====
function allscented_ai_parse_acf_persona($row, $fallback) {
    if (!is_array($row)) {
        return $fallback;
    }
    $persona = $fallback;
    $text_fields = array('name', 'role', 'greeting', 'safety_note', 'summary_template', 'closing');
    foreach ($text_fields as $field) {
        $key = 'ai_conv_persona_' . $field;
        if (!empty($row[$key])) {
            $persona[$field] = (string) $row[$key];
        }
    }
    if (!empty($row['ai_conv_persona_why_lines'])) {
        $lines = preg_split('/\R/', (string) $row['ai_conv_persona_why_lines']);
        $lines = array_values(array_filter(array_map('trim', $lines), 'strlen'));
        if (count($lines) >= 2) {
            $persona['why_lines'] = $lines;
        }
    }
    if (!empty($row['ai_conv_rounds']) && is_array($row['ai_conv_rounds'])) {
        $rounds = array();
        foreach ($row['ai_conv_rounds'] as $round) {
            if (!is_array($round)) {
                continue;
            }
            $options = array();
            if (!empty($round['ai_conv_round_options'])) {
                $options = preg_split('/\R/', (string) $round['ai_conv_round_options']);
                $options = array_values(array_filter(array_map('trim', $options), 'strlen'));
            }
            $rounds[] = array(
                'question' => isset($round['ai_conv_round_question']) ? (string) $round['ai_conv_round_question'] : '',
                'options'  => $options,
                'knowledge' => isset($round['ai_conv_round_knowledge']) ? (string) $round['ai_conv_round_knowledge'] : '',
            );
        }
        $valid_rounds = true;
        if (count($rounds) < 5) {
            $valid_rounds = false;
        }
        foreach ($rounds as $round) {
            if (empty($round['question']) || count($round['options']) < 2) {
                $valid_rounds = false;
                break;
            }
        }
        if ($valid_rounds) {
            $persona['rounds'] = array_slice($rounds, 0, 5);
        }
    }
    if (!empty($row['ai_conv_mappings']) && is_array($row['ai_conv_mappings'])) {
        $mappings = array();
        foreach ($row['ai_conv_mappings'] as $mapping) {
            if (!is_array($mapping)) {
                continue;
            }
            $keywords = array();
            if (!empty($mapping['ai_conv_mapping_keywords'])) {
                $keywords = array_values(array_filter(array_map('trim', explode(',', (string) $mapping['ai_conv_mapping_keywords'])), 'strlen'));
            }
            if (!$keywords) {
                continue;
            }
            $categories = array();
            if (!empty($mapping['ai_conv_mapping_categories'])) {
                $categories = array_values(array_filter(array_map('trim', explode(',', (string) $mapping['ai_conv_mapping_categories'])), 'strlen'));
            }
            $mappings[] = array(
                'keywords'   => $keywords,
                'categories' => $categories,
                'products'   => !empty($mapping['ai_conv_mapping_product']) ? array_map('trim', explode(',', (string) $mapping['ai_conv_mapping_product'])) : array(),
                'reason'     => isset($mapping['ai_conv_mapping_reason']) ? (string) $mapping['ai_conv_mapping_reason'] : '',
            );
        }
        if ($mappings) {
            $persona['mappings'] = $mappings;
        }
    }
    return $persona;
}

if (function_exists('get_field')) {
    $acf_personas = get_field('ai_conv_personas', get_the_ID());
    if (is_array($acf_personas)) {
        foreach ($acf_personas as $acf_row) {
            $id = is_array($acf_row) && !empty($acf_row['ai_conv_persona_id']) ? (string) $acf_row['ai_conv_persona_id'] : '';
            if ($id && isset($ai_engine_defaults[$id])) {
                $ai_engine_defaults[$id] = allscented_ai_parse_acf_persona($acf_row, $ai_engine_defaults[$id]);
            }
        }
    }
}

$ai_affiliates = array();
if (function_exists('get_field')) {
    $acf_affiliates = get_field('ai_conv_affiliates', get_the_ID());
    if (is_array($acf_affiliates)) {
        foreach ($acf_affiliates as $affiliate) {
            if (!is_array($affiliate)) {
                continue;
            }
            $image = '';
            if (!empty($affiliate['ai_conv_affiliate_image'])) {
                if (is_array($affiliate['ai_conv_affiliate_image'])) {
                    $image = !empty($affiliate['ai_conv_affiliate_image']['url']) ? $affiliate['ai_conv_affiliate_image']['url'] : '';
                } elseif (is_numeric($affiliate['ai_conv_affiliate_image'])) {
                    $image = wp_get_attachment_image_url((int) $affiliate['ai_conv_affiliate_image'], 'medium');
                } else {
                    $image = (string) $affiliate['ai_conv_affiliate_image'];
                }
            }
            $ai_affiliates[] = array(
                'name'  => isset($affiliate['ai_conv_affiliate_name']) ? (string) $affiliate['ai_conv_affiliate_name'] : '',
                'image' => $image,
                'price' => isset($affiliate['ai_conv_affiliate_price']) ? (string) $affiliate['ai_conv_affiliate_price'] : '',
                'url'   => isset($affiliate['ai_conv_affiliate_url']) ? (string) $affiliate['ai_conv_affiliate_url'] : '',
                'note'  => isset($affiliate['ai_conv_affiliate_note']) ? (string) $affiliate['ai_conv_affiliate_note'] : '',
            );
        }
    }
}

// ===== WooCommerce product catalog =====
$ai_products = array();
if (class_exists('WooCommerce')) {
    $ai_product_query = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ));
    foreach ($ai_product_query->posts as $ai_p) {
        $cat_terms = wp_get_post_terms($ai_p->ID, 'product_cat', array('fields' => 'slugs'));
        $cat = 'home';
        if (in_array('personal', $cat_terms, true)) {
            $cat = 'personal';
        } elseif (in_array('home', $cat_terms, true)) {
            $cat = 'home';
        } elseif (in_array('commercial', $cat_terms, true)) {
            $cat = 'commercial';
        }
        $price_raw = get_post_meta($ai_p->ID, '_regular_price', true);
        $price = '';
        if ($price_raw !== '' && $price_raw !== false && $price_raw !== null) {
            $price = '$' . number_format((float) $price_raw, 2);
        }
        $img_id = get_post_thumbnail_id($ai_p->ID);
        $img = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
        $ai_products[] = array(
            'id'         => (int) $ai_p->ID,
            'name'       => $ai_p->post_title,
            'slug'       => $ai_p->post_name,
            'excerpt'    => $ai_p->post_excerpt,
            'price'      => $price,
            'img'        => $img,
            'link'       => get_permalink($ai_p->ID),
            'categories' => $cat_terms,
            'cat'        => $cat,
        );
    }
}

$ai_products_json = wp_json_encode($ai_products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
if (!$ai_products_json) {
    $ai_products_json = '[]';
}
$ai_engine_json = wp_json_encode($ai_engine_defaults, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
if (!$ai_engine_json) {
    $ai_engine_json = '{}';
}
$ai_affiliates_json = wp_json_encode($ai_affiliates, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
if (!$ai_affiliates_json) {
    $ai_affiliates_json = '[]';
}
?>

<div id="page-ai-synthesis">
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:6px"><?php echo esc_html($s_eyebrow); ?></span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:6px"><?php echo esc_html($s_title); ?></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px"><?php echo esc_html($s_desc); ?></p>
        </div>
    </section>

    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="char-cards-grid">
            <div class="aura-glass char-card<?php echo $g1_avatar ? ' guide-hero-card' : ''; ?>" style="border-radius:16px;overflow:hidden;display:flex;flex-direction:column;<?php echo $g1_avatar ? 'padding:0' : 'padding:20px'; ?>">
                <?php if ($g1_avatar): ?>
                <div class="guide-hero-media" style="position:relative;width:100%;aspect-ratio:3/4;overflow:hidden;flex-shrink:0">
                    <img src="<?php echo esc_url($g1_avatar); ?>" alt="Luná — Allscented AI scent therapist" style="width:100%;height:100%;object-fit:cover;object-position:center 15%;transition:transform .6s">
                </div>
                <?php endif; ?>
                <div class="guide-hero-body" style="padding:20px 20px 22px;display:flex;flex-direction:column;flex:1">
                    <div class="char-avatar" style="background:color-mix(in srgb,var(--secondary-container)40%,transparent);overflow:hidden;margin-bottom:10px;<?php echo $g1_avatar ? 'display:none' : ''; ?>">
                        <span class="material-symbols-outlined" style="color:var(--secondary)">spa</span>
                    </div>
                    <span class="font-label-caps text-label-caps" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em;color:var(--secondary)"><?php echo esc_html($g1_role); ?></span>
                    <h3 class="font-headline-md" style="font-size:20px;margin-bottom:2px;font-style:italic;"><?php echo esc_html($g1_name); ?></h3>
                    <span class="font-label-caps" style="font-size:14px;font-weight:500;color:var(--secondary);letter-spacing:.04em"><?php echo esc_html($g1_short); ?></span>
                    <p class="font-body-md" style="font-size:14px;margin:6px 0 12px;color:var(--on-surface-variant)"><?php echo esc_html($g1_desc); ?></p>
                    <div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">AROMATHERAPY</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">INTAKE</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)">PERSONAL</span>
                        </div>
                        <button type="button" class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--secondary)10%,transparent)'" onmouseout="this.style.background='transparent'" onclick="startChat('luna')"><?php echo esc_html($g1_cta); ?> <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                    </div>
                </div>
            </div>

            <div class="aura-glass char-card<?php echo $g2_avatar ? ' guide-hero-card' : ''; ?>" style="border-radius:16px;overflow:hidden;display:flex;flex-direction:column;<?php echo $g2_avatar ? 'padding:0' : 'padding:20px'; ?>">
                <?php if ($g2_avatar): ?>
                <div class="guide-hero-media" style="position:relative;width:100%;aspect-ratio:3/4;overflow:hidden;flex-shrink:0">
                    <img src="<?php echo esc_url($g2_avatar); ?>" alt="Echo — Allscented AI diviner" style="width:100%;height:100%;object-fit:cover;object-position:center 15%;transition:transform .6s">
                </div>
                <?php endif; ?>
                <div class="guide-hero-body" style="padding:20px 20px 22px;display:flex;flex-direction:column;flex:1">
                    <div class="char-avatar" style="background:color-mix(in srgb,var(--tertiary-container)40%,transparent);overflow:hidden;margin-bottom:10px;<?php echo $g2_avatar ? 'display:none' : ''; ?>">
                        <span class="material-symbols-outlined" style="color:var(--tertiary)">auto_awesome</span>
                    </div>
                    <span class="font-label-caps text-label-caps" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em;color:var(--secondary)"><?php echo esc_html($g2_role); ?></span>
                    <h3 class="font-headline-md" style="font-size:20px;margin-bottom:2px;font-style:italic;"><?php echo esc_html($g2_name); ?></h3>
                    <span class="font-label-caps" style="font-size:14px;font-weight:500;color:var(--tertiary);letter-spacing:.04em"><?php echo esc_html($g2_short); ?></span>
                    <p class="font-body-md" style="font-size:14px;margin:6px 0 12px;color:var(--on-surface-variant)"><?php echo esc_html($g2_desc); ?></p>
                    <div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">TAROT</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">SYMBOL</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary)">RITUAL</span>
                        </div>
                        <button type="button" class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--tertiary);color:var(--tertiary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--tertiary)10%,transparent)'" onmouseout="this.style.background='transparent'" onclick="startChat('echo')"><?php echo esc_html($g2_cta); ?> <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                    </div>
                </div>
            </div>

            <div class="aura-glass char-card<?php echo $g3_avatar ? ' guide-hero-card' : ''; ?>" style="border-radius:16px;overflow:hidden;display:flex;flex-direction:column;<?php echo $g3_avatar ? 'padding:0' : 'padding:20px'; ?>">
                <?php if ($g3_avatar): ?>
                <div class="guide-hero-media" style="position:relative;width:100%;aspect-ratio:3/4;overflow:hidden;flex-shrink:0">
                    <img src="<?php echo esc_url($g3_avatar); ?>" alt="Sage — Allscented AI commercial scent strategist" style="width:100%;height:100%;object-fit:cover;object-position:center 15%;transition:transform .6s">
                </div>
                <?php endif; ?>
                <div class="guide-hero-body" style="padding:20px 20px 22px;display:flex;flex-direction:column;flex:1">
                    <div class="char-avatar" style="background:color-mix(in srgb,var(--primary-container)40%,transparent);overflow:hidden;margin-bottom:10px;<?php echo $g3_avatar ? 'display:none' : ''; ?>">
                        <span class="material-symbols-outlined" style="color:var(--primary)">business_center</span>
                    </div>
                    <span class="font-label-caps text-label-caps" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em;color:var(--secondary)"><?php echo esc_html($g3_role); ?></span>
                    <h3 class="font-headline-md" style="font-size:20px;margin-bottom:2px;font-style:italic;"><?php echo esc_html($g3_name); ?></h3>
                    <span class="font-label-caps" style="font-size:14px;font-weight:500;color:var(--primary);letter-spacing:.04em"><?php echo esc_html($g3_short); ?></span>
                    <p class="font-body-md" style="font-size:14px;margin:6px 0 12px;color:var(--on-surface-variant)"><?php echo esc_html($g3_desc); ?></p>
                    <div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px">
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);color:var(--primary)">COMMERCIAL</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);color:var(--primary)">BRANDING</span>
                            <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary-container)40%,transparent);color:var(--primary)">CONSULT</span>
                        </div>
                        <button type="button" class="font-label-caps text-label-caps" style="padding:8px 20px;border-radius:999px;border:1px solid var(--primary);color:var(--primary);background:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;transition:all .3s" onmouseover="this.style.background='color-mix(in srgb,var(--primary)10%,transparent)'" onmouseout="this.style.background='transparent'" onclick="startChat('sage')"><?php echo esc_html($g3_cta); ?> <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ai-chat-section" class="px-margin-desktop container-max" style="display:none;padding-bottom:40px;scroll-margin-top:24px" aria-label="AI conversation">
        <div id="ai-chat-shell" class="aura-glass ai-chat-shell">
            <div id="ai-chat-header" class="ai-chat-header">
                <div id="ai-chat-avatar" class="ai-chat-avatar" aria-hidden="true"></div>
                <div class="ai-chat-identity">
                    <div id="ai-chat-name" class="font-headline-md ai-chat-name"></div>
                    <div id="ai-chat-role" class="font-label-caps ai-chat-role"></div>
                </div>
                <div id="ai-chat-progress" class="font-label-caps ai-chat-progress"></div>
            </div>
            <div id="ai-chat-bubbles" class="ai-chat-bubbles" role="log" aria-live="polite" aria-label="AI Synthesis conversation"></div>
            <div id="ai-chat-options" class="ai-chat-options" aria-label="Conversation options"></div>
        </div>
    </section>

    <section id="ai-summary-section" class="px-margin-desktop container-max" style="display:none;padding-bottom:48px" aria-label="Synthesis result">
        <div id="ai-summary-card" class="ai-summary-card"></div>
    </section>

    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="text-align:center;margin-bottom:20px">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px">EXAMPLE CONVERSATIONS</span>
            <h2 class="font-headline-lg text-headline-lg">Sample <span class="italic text-secondary">Consultations</span></h2>
        </div>

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
        <p class="font-body-md text-on-surface-variant" style="font-size:14px;font-style:italic;margin-bottom:16px">After five rounds of choices, your guide generates a synthesis with on-site and affiliate recommendations. Browse examples below.</p>
        <div id="consultation-summary" style="display:flex;flex-direction:column;gap:12px">
            <div class="sample-content" data-sample="healer" style="display:block">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px;display:flex;gap:12px;align-items:flex-start">
                    <?php echo $avatar_html($case1_avatar, 'spa', 'color-mix(in srgb,var(--secondary-container)40%,transparent)', 'var(--secondary)', 40); ?>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:4px">
                            <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--secondary)"><?php echo esc_html($case1_label); ?></span>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary);white-space:nowrap"><?php echo esc_html($case1_pct); ?></span>
                        </div>
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin:0 0 6px"><?php echo esc_html($case1_title); ?></h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:14px;line-height:1.55;margin:0"><?php echo esc_html($case1_summary); ?></p>
                    </div>
                </div>
            </div>
            <div class="sample-content" data-sample="fortune" style="display:none">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px;display:flex;gap:12px;align-items:flex-start">
                    <?php echo $avatar_html($case2_avatar, 'auto_awesome', 'color-mix(in srgb,var(--tertiary-container)40%,transparent)', 'var(--tertiary)', 40); ?>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:4px">
                            <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--tertiary)"><?php echo esc_html($case2_label); ?></span>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--tertiary-container)40%,transparent);color:var(--tertiary);white-space:nowrap"><?php echo esc_html($case2_pct); ?></span>
                        </div>
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin:0 0 6px"><?php echo esc_html($case2_title); ?></h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:14px;line-height:1.55;margin:0"><?php echo esc_html($case2_summary); ?></p>
                    </div>
                </div>
            </div>
            <div class="sample-content" data-sample="consultant" style="display:none">
                <div class="aura-glass summary-card" style="border-radius:16px;padding:18px;display:flex;gap:12px;align-items:flex-start">
                    <?php echo $avatar_html($case3_avatar, 'business_center', 'color-mix(in srgb,var(--primary-container)40%,transparent)', 'var(--primary)', 40); ?>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:4px">
                            <span class="font-label-caps text-label-caps" style="font-size:12px;letter-spacing:.12em;color:var(--secondary)"><?php echo esc_html($case3_label); ?></span>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary)20%,transparent);color:var(--on-primary-fixed-variant);white-space:nowrap"><?php echo esc_html($case3_pct); ?></span>
                        </div>
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin:0 0 6px"><?php echo esc_html($case3_title); ?></h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:14px;line-height:1.55;margin:0"><?php echo esc_html($case3_summary); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-margin-desktop container-max" style="padding-bottom:48px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block">AI CONCIERGE</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:4px;font-style:italic"><?php echo esc_html($s_cta_title); ?></h2>
            <p class="font-body-md" style="margin-bottom:18px;color:var(--surface-variant);font-size:15px"><?php echo esc_html($s_cta_desc); ?></p>
            <div class="ai-concierge-launch">
                <button type="button" class="ai-concierge-btn" onclick="startChat('luna')">
                    <span class="material-symbols-outlined" aria-hidden="true">spa</span>
                    <span class="ai-concierge-btn-title">Luná</span>
                    <span class="ai-concierge-btn-sub">Healer</span>
                </button>
                <button type="button" class="ai-concierge-btn" onclick="startChat('echo')">
                    <span class="material-symbols-outlined" aria-hidden="true">auto_awesome</span>
                    <span class="ai-concierge-btn-title">Echo</span>
                    <span class="ai-concierge-btn-sub">Mystic</span>
                </button>
                <button type="button" class="ai-concierge-btn" onclick="startChat('sage')">
                    <span class="material-symbols-outlined" aria-hidden="true">business_center</span>
                    <span class="ai-concierge-btn-title">Sage</span>
                    <span class="ai-concierge-btn-sub">Strategist</span>
                </button>
            </div>
        </div>
    </section>
</div>

<script id="ai-engine-defaults" type="application/json"><?php echo $ai_engine_json; ?></script>
<script id="ai-wc-products" type="application/json"><?php echo $ai_products_json; ?></script>
<script id="ai-affiliates" type="application/json"><?php echo $ai_affiliates_json; ?></script>

<?php get_footer(); ?>
