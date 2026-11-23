<?php
/**
 * EndoFlow v5.0 — Unified Symptom Database
 * Single source of truth for all symptom IDs, display names, categories.
 */

$allSymptoms = [
    // Vital Signs
    'hypertension'            => 'Hypertension (BP > 140/90)',
    'hypotension'             => 'Hypotension (BP < 90/60)',
    'orthostatic_hypotension' => 'Orthostatic Hypotension',
    'tachycardia'             => 'Tachycardia (HR > 100)',
    'bradycardia'             => 'Bradycardia (HR < 60)',

    // Electrolytes
    'hyponatremia'  => 'Hyponatremia (Na < 135)',
    'hypernatremia' => 'Hypernatremia (Na > 145)',
    'hypokalemia'   => 'Hypokalemia (K < 3.5)',
    'hyperkalemia'  => 'Hyperkalemia (K > 5.0)',
    'hypocalcemia'  => 'Hypocalcemia (Ca < 8.5)',
    'hypercalcemia' => 'Hypercalcemia (Ca > 10.5)',

    // Neurological
    'headache'          => 'Headache',
    'seizure'           => 'Seizure',
    'confusion'         => 'Confusion / Altered Sensorium',
    'fatigue'           => 'Fatigue',
    'weakness'          => 'Generalised Muscle Weakness',
    'proximal_weakness' => 'Proximal Muscle Weakness',
    'muscle_cramps'     => 'Muscle Cramps',
    'muscle_weakness'   => 'Muscle Weakness (general)',
    'anxiety'           => 'Anxiety / Nervousness',
    'tremor'            => 'Fine Tremor',
    'pallor'            => 'Pallor',

    // Endocrine Specific
    'weight_loss'      => 'Weight Loss',
    'weight_gain'      => 'Weight Gain',
    'central_obesity'  => 'Central Obesity (apple-shaped)',
    'heat_intolerance' => 'Heat Intolerance',
    'cold_intolerance' => 'Cold Intolerance',
    'sweating'         => 'Excessive Sweating (Hyperhidrosis)',
    'palpitations'     => 'Palpitations',
    'polyuria'         => 'Polyuria (> 3 L/day)',
    'polydipsia'       => 'Polydipsia (Excessive Thirst)',
    'nocturia'         => 'Nocturia',
    'anorexia'         => 'Loss of Appetite',
    'salt_craving'     => 'Salt Craving',
    'dehydration'      => 'Signs of Dehydration',
    'dry_mouth'        => 'Dry Mouth',

    // Physical Signs
    'goiter'                  => 'Goiter (Thyroid Enlargement)',
    'proptosis'               => 'Proptosis / Exophthalmos',
    'acral_enlargement'       => 'Acral Enlargement (large hands/feet)',
    'coarse_facies'           => 'Coarse Facial Features',
    'macroglossia'            => 'Macroglossia (Large Tongue)',
    'prognathism'             => 'Prognathism (Protruding Jaw)',
    'moon_face'               => 'Moon Face (Facial Rounding)',
    'buffalo_hump'            => 'Buffalo Hump (Dorsocervical Fat Pad)',
    'purple_striae'           => 'Purple / Violaceous Striae',
    'hirsutism'               => 'Hirsutism (Excess Hair Growth)',
    'acne'                    => 'Acne',
    'easy_bruising'           => 'Easy Bruising',
    'hyperpigmentation'       => 'Hyperpigmentation (skin darkening)',
    'dry_skin'                => 'Dry Skin',
    'hair_loss'               => 'Hair Loss (Alopecia)',
    'hoarseness'              => 'Hoarseness of Voice',
    'snoring'                 => 'Snoring',
    'sleep_apnea'             => 'Sleep Apnea',
    'arthralgia'              => 'Arthralgia (Joint Pain)',
    'carpal_tunnel'           => 'Carpal Tunnel Syndrome',
    'visual_field_defect'     => 'Visual Field Defect (Hemianopia)',
    'chest_pain'              => 'Chest Pain',

    // Reproductive
    'amenorrhea'     => 'Amenorrhea (Absent Periods)',
    'oligomenorrhea' => 'Oligomenorrhea (Infrequent Periods)',
    'menorrhagia'    => 'Menorrhagia (Heavy Periods)',
    'galactorrhea'   => 'Galactorrhea (Breast Milk Secretion)',
    'infertility'    => 'Infertility',
    'libido_loss'    => 'Loss of Libido',
    'impotence'      => 'Erectile Dysfunction / Impotence',

    // GI
    'nausea'         => 'Nausea',
    'vomiting'       => 'Vomiting',
    'abdominal_pain' => 'Abdominal Pain',
    'constipation'   => 'Constipation',
    'diarrhea'       => 'Diarrhea',

    // ── NEW SYMPTOMS — v5.0 ─────────────────────────────────────
    'blurred_vision'        => 'Blurred Vision',
    'numbness_tingling'     => 'Numbness / Tingling (Paresthesias)',
    'recurrent_infections'  => 'Recurrent Infections (UTI / Skin / Candida)',
    'hypocalcemia'          => 'Hypocalcemia Signs (Tetany / Trousseau / Chvostek)',
    'hypoglycemia'          => 'Hypoglycemic Episodes / Fasting Hypoglycemia',
    'nephrolithiasis'       => 'Nephrolithiasis (Kidney Stones)',
    'bone_pain'             => 'Bone Pain / Skeletal Tenderness',
    'back_pain'             => 'Back Pain (Vertebral)',
    'fragility_fracture'    => 'Fragility Fracture (Low-trauma)',
    'height_loss'           => 'Height Loss / Kyphosis',
    'depression'            => 'Depression / Low Mood',
    'gynecomastia'          => 'Gynecomastia (Male Breast Enlargement)',
    'virilization'          => 'Virilization / Clitoromegaly (Female)',
    'flushing'              => 'Episodic Flushing (Face / Neck)',
    'wheezing'              => 'Wheezing / Bronchospasm',
    'fever'                 => 'Fever / Pyrexia',
    'thyroid_pain'          => 'Painful / Tender Thyroid Gland',
    'neck_mass'             => 'Neck Mass / Thyroid Nodule',
    'dysphagia'             => 'Dysphagia (Difficulty Swallowing)',
    'lymphadenopathy'       => 'Cervical Lymphadenopathy',
    'tracheal_pressure'     => 'Tracheal Pressure / Stridor',
    'peptic_ulcer_pain'     => 'Peptic Ulcer / Epigastric Pain (ZES-type)',
    'sweating'              => 'Profuse Sweating / Diaphoresis',
];

$symptomCategories = [
    'vitals' => [
        'label'    => 'Vital Signs & Hemodynamics',
        'icon'     => 'fa-heart-pulse',
        'symptoms' => ['hypertension','hypotension','orthostatic_hypotension','tachycardia','bradycardia'],
    ],
    'electrolytes' => [
        'label'    => 'Electrolyte Disturbances',
        'icon'     => 'fa-flask',
        'symptoms' => ['hyponatremia','hypernatremia','hypokalemia','hyperkalemia','hypocalcemia','hypercalcemia'],
    ],
    'neuro' => [
        'label'    => 'Neurological / General',
        'icon'     => 'fa-brain',
        'symptoms' => ['headache','seizure','confusion','fatigue','weakness','proximal_weakness','muscle_cramps','anxiety','tremor'],
    ],
    'endocrine' => [
        'label'    => 'Metabolic / Endocrine',
        'icon'     => 'fa-atom',
        'symptoms' => ['weight_loss','weight_gain','central_obesity','heat_intolerance','cold_intolerance','sweating','palpitations','polyuria','polydipsia','nocturia','anorexia','salt_craving','dehydration','dry_mouth'],
    ],
    'physical' => [
        'label'    => 'Physical / Examination Signs',
        'icon'     => 'fa-person',
        'symptoms' => ['goiter','proptosis','acral_enlargement','coarse_facies','macroglossia','prognathism','moon_face','buffalo_hump','purple_striae','hirsutism','acne','easy_bruising','hyperpigmentation','dry_skin','hair_loss','hoarseness','snoring','sleep_apnea','arthralgia','carpal_tunnel','visual_field_defect','chest_pain','pallor'],
    ],
    'reproductive' => [
        'label'    => 'Reproductive / Hormonal',
        'icon'     => 'fa-venus-mars',
        'symptoms' => ['amenorrhea','oligomenorrhea','menorrhagia','galactorrhea','infertility','libido_loss','impotence'],
    ],
    'gi' => [
        'label'    => 'Gastrointestinal',
        'icon'     => 'fa-utensils',
        'symptoms' => ['nausea','vomiting','abdominal_pain','constipation','diarrhea','peptic_ulcer_pain','dysphagia'],
    ],
    'metabolic_new' => [
        'label'    => 'Metabolic / Glucose',
        'icon'     => 'fa-droplet',
        'symptoms' => ['hypoglycemia','blurred_vision','numbness_tingling','recurrent_infections','sweating'],
    ],
    'bone_calcium' => [
        'label'    => 'Bone, Calcium & Mineral',
        'icon'     => 'fa-bone',
        'symptoms' => ['hypocalcemia','hypercalcemia','nephrolithiasis','bone_pain','back_pain','fragility_fracture','height_loss'],
    ],
    'skin_other' => [
        'label'    => 'Skin / Other Signs',
        'icon'     => 'fa-stethoscope',
        'symptoms' => ['flushing','wheezing','fever','thyroid_pain','neck_mass','tracheal_pressure','lymphadenopathy','gynecomastia','virilization','depression'],
    ],
];

function getSymptomName(string $id): string {
    global $allSymptoms;
    return $allSymptoms[$id] ?? ucwords(str_replace('_', ' ', $id));
}
?>
