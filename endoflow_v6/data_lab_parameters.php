<?php
/**
 * EndoFlow v5.0 — Lab Parameter Database
 * Clinical parameters for all 10 disorders with weights and reference ranges.
 * Source: Endocrine Society Clinical Practice Guidelines (JCEM)
 */

$labParameters = [

    // ── GROUPED LAB PANELS ─────────────────────────────────────
    // Each lab param has: id, label, unit, normal_low, normal_high,
    // direction (low/high = abnormal), weight per disorder

    'cortisol_morning' => [
        'label'      => 'Morning Serum Cortisol',
        'unit'       => 'mcg/dL',
        'normal_low' => 5,
        'normal_high'=> 25,
        'hint'       => 'Draw at 8 AM. Normal: 5–25 mcg/dL',
    ],
    'cortisol_24h_urine' => [
        'label'      => '24-Hour Urinary Free Cortisol',
        'unit'       => 'mcg/day',
        'normal_low' => 0,
        'normal_high'=> 50,
        'hint'       => 'Normal < 50 mcg/day',
    ],
    'cortisol_salivary' => [
        'label'      => 'Late Night Salivary Cortisol',
        'unit'       => 'mcg/dL',
        'normal_low' => 0,
        'normal_high'=> 0.13,
        'hint'       => 'Normal < 0.13 mcg/dL (collected at midnight)',
    ],
    'acth' => [
        'label'      => 'Plasma ACTH',
        'unit'       => 'pg/mL',
        'normal_low' => 10,
        'normal_high'=> 65,
        'hint'       => 'Normal: 10–65 pg/mL. Elevated in Addison\'s (>100)',
    ],
    'tsh' => [
        'label'      => 'TSH (Thyroid Stimulating Hormone)',
        'unit'       => 'mIU/L',
        'normal_low' => 0.4,
        'normal_high'=> 4.5,
        'hint'       => 'Normal: 0.4–4.5 mIU/L. High = Hypothyroid. Low = Hyperthyroid',
    ],
    'free_t4' => [
        'label'      => 'Free T4',
        'unit'       => 'ng/dL',
        'normal_low' => 0.8,
        'normal_high'=> 1.8,
        'hint'       => 'Normal: 0.8–1.8 ng/dL',
    ],
    'free_t3' => [
        'label'      => 'Free T3',
        'unit'       => 'pg/mL',
        'normal_low' => 2.3,
        'normal_high'=> 4.2,
        'hint'       => 'Normal: 2.3–4.2 pg/mL',
    ],
    'trab' => [
        'label'      => 'TSH Receptor Antibodies (TRAb)',
        'unit'       => 'IU/L',
        'normal_low' => 0,
        'normal_high'=> 1.75,
        'hint'       => 'Normal < 1.75 IU/L. Elevated in Graves\' Disease',
    ],
    'anti_tpo' => [
        'label'      => 'Anti-TPO Antibodies',
        'unit'       => 'IU/mL',
        'normal_low' => 0,
        'normal_high'=> 35,
        'hint'       => 'Normal < 35 IU/mL. Elevated in Hashimoto\'s / Graves\'',
    ],
    'serum_na' => [
        'label'      => 'Serum Sodium (Na+)',
        'unit'       => 'mEq/L',
        'normal_low' => 135,
        'normal_high'=> 145,
        'hint'       => 'Normal: 135–145 mEq/L',
    ],
    'serum_k' => [
        'label'      => 'Serum Potassium (K+)',
        'unit'       => 'mEq/L',
        'normal_low' => 3.5,
        'normal_high'=> 5.0,
        'hint'       => 'Normal: 3.5–5.0 mEq/L',
    ],
    'serum_aldosterone' => [
        'label'      => 'Serum Aldosterone',
        'unit'       => 'ng/dL',
        'normal_low' => 2,
        'normal_high'=> 15,
        'hint'       => 'Normal: 2–15 ng/dL (upright). Elevated in Conn\'s',
    ],
    'plasma_renin' => [
        'label'      => 'Plasma Renin Activity (PRA)',
        'unit'       => 'ng/mL/hr',
        'normal_low' => 0.5,
        'normal_high'=> 4.0,
        'hint'       => 'Normal: 0.5–4.0 ng/mL/hr. Low in Conn\'s',
    ],
    'aldo_renin_ratio' => [
        'label'      => 'Aldosterone:Renin Ratio (ARR)',
        'unit'       => '',
        'normal_low' => 0,
        'normal_high'=> 20,
        'hint'       => 'Normal < 20. ARR > 30 strongly suggests Conn\'s',
    ],
    'plasma_metanephrines' => [
        'label'      => 'Plasma Metanephrines',
        'unit'       => 'nmol/L',
        'normal_low' => 0,
        'normal_high'=> 0.5,
        'hint'       => 'Normal < 0.5 nmol/L. Elevated in Pheo',
    ],
    'urine_metanephrines' => [
        'label'      => '24h Urine Metanephrines',
        'unit'       => 'mcg/day',
        'normal_low' => 0,
        'normal_high'=> 400,
        'hint'       => 'Normal < 400 mcg/day',
    ],
    'igf1' => [
        'label'      => 'IGF-1 (Insulin-like Growth Factor 1)',
        'unit'       => 'ng/mL',
        'normal_low' => 75,
        'normal_high'=> 250,
        'hint'       => 'Age/gender dependent. Elevated in Acromegaly',
    ],
    'gh_ogtt' => [
        'label'      => 'GH after Oral Glucose Tolerance Test',
        'unit'       => 'ng/mL',
        'normal_low' => 0,
        'normal_high'=> 1.0,
        'hint'       => 'Normal < 1 ng/mL after glucose load. Fails to suppress in Acromegaly',
    ],
    'serum_osmolality' => [
        'label'      => 'Serum Osmolality',
        'unit'       => 'mOsm/kg',
        'normal_low' => 280,
        'normal_high'=> 295,
        'hint'       => 'Normal: 280–295 mOsm/kg',
    ],
    'urine_osmolality' => [
        'label'      => 'Urine Osmolality',
        'unit'       => 'mOsm/kg',
        'normal_low' => 300,
        'normal_high'=> 900,
        'hint'       => 'Normal: 300–900 mOsm/kg. Low in DI (<300), High in SIADH (>100)',
    ],
    'urine_sodium' => [
        'label'      => 'Urine Sodium',
        'unit'       => 'mEq/L',
        'normal_low' => 20,
        'normal_high'=> 40,
        'hint'       => 'Elevated (>40) in SIADH',
    ],
    'serum_prolactin' => [
        'label'      => 'Serum Prolactin',
        'unit'       => 'ng/mL',
        'normal_low' => 2,
        'normal_high'=> 29,
        'hint'       => 'Normal: 2–29 ng/mL (female). >200 ng/mL strongly suggests Prolactinoma',
    ],
    'serum_glucose' => [
        'label'      => 'Fasting Serum Glucose',
        'unit'       => 'mg/dL',
        'normal_low' => 70,
        'normal_high'=> 100,
        'hint'       => 'Normal fasting: 70–100 mg/dL',
    ],
    'urine_specific_gravity' => [
        'label'      => 'Urine Specific Gravity',
        'unit'       => '',
        'normal_low' => 1.005,
        'normal_high'=> 1.030,
        'hint'       => 'Low (<1.005) in Diabetes Insipidus',
    ],

    // ── NEW PARAMETERS — v5.0 Expansion ─────────────────────────

    'hba1c' => [
        'label'      => 'HbA1c (Glycated Haemoglobin)',
        'unit'       => '%',
        'normal_low' => 4.0,
        'normal_high'=> 5.6,
        'hint'       => 'Normal < 5.7%. Prediabetes: 5.7–6.4%. Diabetes ≥ 6.5%',
    ],
    'fasting_insulin' => [
        'label'      => 'Fasting Serum Insulin',
        'unit'       => 'µIU/mL',
        'normal_low' => 2,
        'normal_high'=> 25,
        'hint'       => 'Normal: 2–25 µIU/mL. Elevated in T2DM/insulin resistance; Low/undetectable in T1DM',
    ],
    'c_peptide' => [
        'label'      => 'C-Peptide',
        'unit'       => 'ng/mL',
        'normal_low' => 0.6,
        'normal_high'=> 3.1,
        'hint'       => 'Normal: 0.6–3.1 ng/mL. Low in T1DM (< 0.6); Normal/High in T2DM; Elevated in insulinoma',
    ],
    'serum_calcium' => [
        'label'      => 'Serum Calcium (Total)',
        'unit'       => 'mg/dL',
        'normal_low' => 8.5,
        'normal_high'=> 10.5,
        'hint'       => 'Normal: 8.5–10.5 mg/dL. Corrected Ca = Total Ca + 0.8 × (4 – albumin)',
    ],
    'intact_pth' => [
        'label'      => 'Intact PTH (Parathyroid Hormone)',
        'unit'       => 'pg/mL',
        'normal_low' => 10,
        'normal_high'=> 65,
        'hint'       => 'Normal: 10–65 pg/mL. Elevated in PHPT/VitD def. Low in hypoparathyroidism',
    ],
    'serum_phosphate' => [
        'label'      => 'Serum Phosphate',
        'unit'       => 'mg/dL',
        'normal_low' => 2.5,
        'normal_high'=> 4.5,
        'hint'       => 'Normal: 2.5–4.5 mg/dL. Low in PHPT; High in hypoparathyroidism/CKD',
    ],
    'vitamin_d_25oh' => [
        'label'      => '25-OH Vitamin D',
        'unit'       => 'ng/mL',
        'normal_low' => 30,
        'normal_high'=> 100,
        'hint'       => 'Normal: 30–100 ng/mL. Deficient < 20; Insufficient 20–29; Toxic > 150',
    ],
    'serum_testosterone' => [
        'label'      => 'Total Serum Testosterone (AM)',
        'unit'       => 'ng/dL',
        'normal_low' => 264,
        'normal_high'=> 916,
        'hint'       => 'Normal (adult male): 264–916 ng/dL. Draw at 8 AM. < 264 = hypogonadal. Repeat to confirm',
    ],
    'lh' => [
        'label'      => 'Luteinising Hormone (LH)',
        'unit'       => 'IU/L',
        'normal_low' => 1.7,
        'normal_high'=> 8.6,
        'hint'       => 'Normal (male): 1.7–8.6 IU/L. High in primary; Low in secondary hypogonadism',
    ],
    'fsh' => [
        'label'      => 'Follicle Stimulating Hormone (FSH)',
        'unit'       => 'IU/L',
        'normal_low' => 1.5,
        'normal_high'=> 12.4,
        'hint'       => 'Normal (male): 1.5–12.4 IU/L. High in primary; Low in secondary hypogonadism',
    ],
    'serum_17ohp' => [
        'label'      => '17-Hydroxyprogesterone (17-OHP)',
        'unit'       => 'ng/dL',
        'normal_low' => 0,
        'normal_high'=> 200,
        'hint'       => 'Normal (AM follicular): < 200 ng/dL. Classic CAH: > 1000–10,000. NC-CAH post-ACTH > 1000',
    ],
    'serum_testosterone_free' => [
        'label'      => 'Free Testosterone',
        'unit'       => 'pg/mL',
        'normal_low' => 65,
        'normal_high'=> 225,
        'hint'       => 'Normal (adult male): 65–225 pg/mL. Better index than total T when SHBG abnormal',
    ],
    'serum_calcitonin' => [
        'label'      => 'Serum Calcitonin',
        'unit'       => 'pg/mL',
        'normal_low' => 0,
        'normal_high'=> 10,
        'hint'       => 'Normal < 10 pg/mL. > 100 pg/mL strongly suggests medullary thyroid carcinoma',
    ],
    'chromogranin_a' => [
        'label'      => 'Plasma Chromogranin A (CgA)',
        'unit'       => 'U/L',
        'normal_low' => 0,
        'normal_high'=> 100,
        'hint'       => 'Normal < 100 U/L. Elevated in NETs/carcinoid; note PPI use raises CgA',
    ],
    'urine_5hiaa' => [
        'label'      => '24h Urine 5-HIAA',
        'unit'       => 'mg/day',
        'normal_low' => 0,
        'normal_high'=> 8,
        'hint'       => 'Normal < 8 mg/day. Elevated in carcinoid syndrome (>15 mg/day). Avoid serotonin-rich foods 3 days prior',
    ],
    'serum_gastrin' => [
        'label'      => 'Fasting Serum Gastrin',
        'unit'       => 'pg/mL',
        'normal_low' => 0,
        'normal_high'=> 115,
        'hint'       => 'Normal < 115 pg/mL. > 1000 pg/mL diagnostic of ZES. Stop PPI 2 weeks before test',
    ],
    'esr' => [
        'label'      => 'Erythrocyte Sedimentation Rate (ESR)',
        'unit'       => 'mm/hr',
        'normal_low' => 0,
        'normal_high'=> 20,
        'hint'       => 'Normal < 20 mm/hr (males); < 30 (females). Markedly elevated (>50) in subacute thyroiditis',
    ],
    'amh' => [
        'label'      => 'Anti-Müllerian Hormone (AMH)',
        'unit'       => 'ng/mL',
        'normal_low' => 1.0,
        'normal_high'=> 3.4,
        'hint'       => 'Normal: 1.0–3.4 ng/mL (reproductive age). Elevated >3.4 in PCOS',
    ],
    'dheas' => [
        'label'      => 'DHEAS (Dehydroepiandrosterone Sulfate)',
        'unit'       => 'mcg/dL',
        'normal_low' => 65,
        'normal_high'=> 380,
        'hint'       => 'Normal (adult female): 65–380 mcg/dL. Elevated in CAH/adrenal tumor; Suppressed in Cushing\'s',
    ],
];

// ── PER-DISORDER LAB WEIGHT RULES ─────────────────────────────
// weight 3 = confirmatory, 2 = supportive, 1 = non-specific
// abnormal_direction: 'high' = above normal_high is abnormal
//                     'low'  = below normal_low is abnormal

$disorderLabWeights = [

    'primary_hyperaldosteronism' => [
        ['lab' => 'serum_k',           'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'serum_aldosterone',  'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'plasma_renin',       'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'aldo_renin_ratio',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_na',           'abnormal_direction' => 'high', 'weight' => 1],
        ['lab' => 'serum_glucose',      'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'addisons_disease' => [
        ['lab' => 'cortisol_morning',   'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'acth',               'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_na',           'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_k',            'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_glucose',      'abnormal_direction' => 'low',  'weight' => 2],
    ],

    'pheochromocytoma' => [
        ['lab' => 'plasma_metanephrines','abnormal_direction'=> 'high', 'weight' => 3],
        ['lab' => 'urine_metanephrines', 'abnormal_direction'=> 'high', 'weight' => 3],
        ['lab' => 'serum_glucose',       'abnormal_direction'=> 'high', 'weight' => 1],
    ],

    'siadh' => [
        ['lab' => 'serum_na',           'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'serum_osmolality',   'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'urine_osmolality',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'urine_sodium',       'abnormal_direction' => 'high', 'weight' => 2],
    ],

    'acromegaly' => [
        ['lab' => 'igf1',               'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'gh_ogtt',            'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_glucose',      'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'graves_disease' => [
        ['lab' => 'tsh',                'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'free_t4',            'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'free_t3',            'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'trab',               'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'anti_tpo',           'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'hypothyroidism' => [
        ['lab' => 'tsh',                'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'free_t4',            'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'free_t3',            'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'anti_tpo',           'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_na',           'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'cushings_syndrome' => [
        ['lab' => 'cortisol_24h_urine', 'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'cortisol_salivary',  'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'acth',               'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_k',            'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_glucose',      'abnormal_direction' => 'high', 'weight' => 1],
    ],

    // alias for data_patterns.php key (cushing_syndrome without trailing s)
    'cushing_syndrome' => [
        ['lab' => 'cortisol_24h_urine', 'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'cortisol_salivary',  'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'acth',               'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_k',            'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_glucose',      'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'diabetes_insipidus' => [
        ['lab' => 'serum_na',           'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_osmolality',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'urine_osmolality',   'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'urine_specific_gravity','abnormal_direction'=>'low', 'weight' => 2],
    ],

    'prolactinoma' => [
        ['lab' => 'serum_prolactin',    'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'igf1',               'abnormal_direction' => 'high', 'weight' => 1],
        ['lab' => 'free_t4',            'abnormal_direction' => 'low',  'weight' => 1],
    ],

    // ── NEW DISORDERS — v5.0 ──────────────────────────────────────

    'type2_diabetes' => [
        ['lab' => 'serum_glucose',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'hba1c',           'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'fasting_insulin', 'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'c_peptide',       'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'type1_diabetes' => [
        ['lab' => 'serum_glucose',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'hba1c',           'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'c_peptide',       'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'fasting_insulin', 'abnormal_direction' => 'low',  'weight' => 2],
    ],

    'hyperparathyroidism' => [
        ['lab' => 'serum_calcium',    'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'intact_pth',       'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_phosphate',  'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'vitamin_d_25oh',   'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'hypoparathyroidism' => [
        ['lab' => 'serum_calcium',    'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'intact_pth',       'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'serum_phosphate',  'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'vitamin_d_25oh',   'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'congenital_adrenal_hyperplasia' => [
        ['lab' => 'serum_17ohp',     'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'acth',            'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_na',        'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_k',         'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'dheas',           'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'cortisol_morning','abnormal_direction' => 'low',  'weight' => 2],
    ],

    'polycystic_ovary_syndrome' => [
        ['lab' => 'serum_testosterone_free', 'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'lh',              'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'amh',             'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'dheas',           'abnormal_direction' => 'high', 'weight' => 1],
        ['lab' => 'fasting_insulin', 'abnormal_direction' => 'high', 'weight' => 2],
    ],

    'male_hypogonadism' => [
        ['lab' => 'serum_testosterone', 'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'serum_testosterone_free', 'abnormal_direction' => 'low', 'weight' => 3],
        ['lab' => 'lh',                 'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'fsh',                'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_prolactin',    'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'vitamin_d_deficiency' => [
        ['lab' => 'vitamin_d_25oh',   'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'intact_pth',       'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_calcium',    'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_phosphate',  'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'osteoporosis' => [
        ['lab' => 'vitamin_d_25oh',   'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'intact_pth',       'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_calcium',    'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'serum_phosphate',  'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'thyroid_nodule_cancer' => [
        ['lab' => 'serum_calcitonin', 'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'chromogranin_a',   'abnormal_direction' => 'high', 'weight' => 1],
        ['lab' => 'tsh',              'abnormal_direction' => 'low',  'weight' => 1],
    ],

    'subclinical_hypothyroidism' => [
        ['lab' => 'tsh',              'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'free_t4',          'abnormal_direction' => 'low',  'weight' => 1],
        ['lab' => 'anti_tpo',         'abnormal_direction' => 'high', 'weight' => 2],
    ],

    'multiple_endocrine_neoplasia_type1' => [
        ['lab' => 'serum_calcium',    'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'intact_pth',       'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_gastrin',    'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_prolactin',  'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'igf1',             'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'serum_glucose',    'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'chromogranin_a',   'abnormal_direction' => 'high', 'weight' => 2],
    ],

    'carcinoid_syndrome' => [
        ['lab' => 'urine_5hiaa',      'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'chromogranin_a',   'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'serum_glucose',    'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'insulinoma' => [
        ['lab' => 'serum_glucose',    'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'fasting_insulin',  'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'c_peptide',        'abnormal_direction' => 'high', 'weight' => 3],
        ['lab' => 'chromogranin_a',   'abnormal_direction' => 'high', 'weight' => 1],
    ],

    'thyroiditis_subacute' => [
        ['lab' => 'tsh',              'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'free_t4',          'abnormal_direction' => 'high', 'weight' => 2],
        ['lab' => 'esr',              'abnormal_direction' => 'high', 'weight' => 3],
    ],

    'central_hypothyroidism' => [
        ['lab' => 'free_t4',          'abnormal_direction' => 'low',  'weight' => 3],
        ['lab' => 'tsh',              'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'cortisol_morning', 'abnormal_direction' => 'low',  'weight' => 2],
        ['lab' => 'igf1',             'abnormal_direction' => 'low',  'weight' => 1],
        ['lab' => 'serum_prolactin',  'abnormal_direction' => 'high', 'weight' => 1],
    ],
];

/**
 * Score lab parameters for a given disorder
 * Returns: [ score, max_score, matched_labs[], missing_labs[] ]
 */
function scoreLabsForDisorder(string $disorderId, array $enteredLabs): array {
    global $disorderLabWeights, $labParameters;

    $rules = $disorderLabWeights[$disorderId] ?? [];
    if (empty($rules)) return ['score'=>0,'max_score'=>0,'matched'=>[],'missing'=>[]];

    $score    = 0;
    $maxScore = 0;
    $matched  = [];
    $missing  = [];

    foreach ($rules as $rule) {
        $labId    = $rule['lab'];
        $dir      = $rule['abnormal_direction'];
        $weight   = $rule['weight'];
        $maxScore += $weight;
        $labInfo  = $labParameters[$labId] ?? null;
        if (!$labInfo) continue;

        if (isset($enteredLabs[$labId]) && $enteredLabs[$labId] !== '') {
            $val = floatval($enteredLabs[$labId]);
            $isAbnormal = false;
            if ($dir === 'high' && $val > $labInfo['normal_high']) $isAbnormal = true;
            if ($dir === 'low'  && $val < $labInfo['normal_low'])  $isAbnormal = true;

            if ($isAbnormal) {
                $score += $weight;
                $matched[] = [
                    'lab'    => $labId,
                    'label'  => $labInfo['label'],
                    'value'  => $val,
                    'unit'   => $labInfo['unit'],
                    'weight' => $weight,
                    'direction' => $dir,
                ];
            } else {
                $missing[] = [
                    'lab'   => $labId,
                    'label' => $labInfo['label'],
                    'value' => $val,
                    'unit'  => $labInfo['unit'],
                    'normal'=> $labInfo['normal_low'].' – '.$labInfo['normal_high'],
                ];
            }
        } else {
            $missing[] = [
                'lab'   => $labId,
                'label' => $labInfo['label'],
                'value' => null,
                'unit'  => $labInfo['unit'],
                'normal'=> $labInfo['normal_low'].' – '.$labInfo['normal_high'],
            ];
        }
    }

    return [
        'score'     => $score,
        'max_score' => $maxScore,
        'matched'   => $matched,
        'missing'   => $missing,
    ];
}
?>

// ── PRIORITY LABS: First-line + Confirmatory per disorder ──────────────────
// initial: The 1-2 tests a doctor orders FIRST in real clinical practice
// confirmatory: Follow-up tests if initial is borderline/positive
// rationale: Why this test is ordered first (shown to doctor)

$disorderPriorityLabs = [
    'primary_hyperaldosteronism' => [
        'initial'       => ['serum_k', 'aldo_renin_ratio'],
        'confirmatory'  => ['serum_aldosterone', 'plasma_renin'],
        'rationale'     => 'ARR is the recommended screening test per Endocrine Society 2016 guidelines. Serum K+ confirms hypokalemia.',
        'can_diagnose_with_initial' => true,
    ],
    'addisons_disease' => [
        'initial'       => ['cortisol_morning', 'acth'],
        'confirmatory'  => ['serum_na', 'serum_k'],
        'rationale'     => '8 AM serum cortisol < 5 mcg/dL is highly suggestive. ACTH differentiates primary vs secondary.',
        'can_diagnose_with_initial' => true,
    ],
    'pheochromocytoma' => [
        'initial'       => ['plasma_metanephrines'],
        'confirmatory'  => ['urine_metanephrines'],
        'rationale'     => 'Plasma metanephrines are first-line (99% sensitivity). Urine metanephrines confirm.',
        'can_diagnose_with_initial' => true,
    ],
    'siadh' => [
        'initial'       => ['serum_na', 'serum_osmolality'],
        'confirmatory'  => ['urine_osmolality', 'urine_sodium'],
        'rationale'     => 'Hyponatremia with low serum osmolality is the diagnostic entry point for SIADH.',
        'can_diagnose_with_initial' => false,
    ],
    'acromegaly' => [
        'initial'       => ['igf1'],
        'confirmatory'  => ['gh_ogtt'],
        'rationale'     => 'IGF-1 is the best single screening test (stable, no fasting needed). GH suppression by OGTT confirms.',
        'can_diagnose_with_initial' => false,
    ],
    'graves_disease' => [
        'initial'       => ['tsh', 'free_t4'],
        'confirmatory'  => ['trab'],
        'rationale'     => 'TSH + Free T4 establish hyperthyroidism. TRAb confirms Graves\' autoimmunity.',
        'can_diagnose_with_initial' => false,
    ],
    'hypothyroidism' => [
        'initial'       => ['tsh'],
        'confirmatory'  => ['free_t4', 'anti_tpo'],
        'rationale'     => 'TSH alone is first-line. If elevated, Free T4 confirms overt hypothyroidism; Anti-TPO identifies autoimmune cause.',
        'can_diagnose_with_initial' => false,
    ],
    'cushing_syndrome' => [
        'initial'       => ['cortisol_24h_urine'],
        'confirmatory'  => ['cortisol_salivary', 'acth'],
        'rationale'     => '24-hour urinary free cortisol is a standard first-line screening test. Two abnormal results are required.',
        'can_diagnose_with_initial' => false,
    ],
    'diabetes_insipidus' => [
        'initial'       => ['serum_na', 'serum_osmolality'],
        'confirmatory'  => ['urine_osmolality', 'urine_specific_gravity'],
        'rationale'     => 'Hypernatremia + high serum osmolality establishes the diagnosis entry point.',
        'can_diagnose_with_initial' => false,
    ],
    'prolactinoma' => [
        'initial'       => ['serum_prolactin'],
        'confirmatory'  => ['free_t4', 'igf1'],
        'rationale'     => 'A single serum prolactin test is diagnostic. > 250 ng/mL is almost always a prolactinoma.',
        'can_diagnose_with_initial' => true,
    ],
    'type2_diabetes' => [
        'initial'       => ['serum_glucose', 'hba1c'],
        'confirmatory'  => ['fasting_insulin'],
        'rationale'     => 'Fasting glucose + HbA1c together establish diagnosis per ADA criteria. HbA1c ≥ 6.5% is diagnostic.',
        'can_diagnose_with_initial' => true,
    ],
    'type1_diabetes' => [
        'initial'       => ['serum_glucose', 'hba1c'],
        'confirmatory'  => ['c_peptide', 'fasting_insulin'],
        'rationale'     => 'Glucose + HbA1c establish DM. Low C-peptide differentiates Type 1 from Type 2.',
        'can_diagnose_with_initial' => false,
    ],
    'hyperparathyroidism' => [
        'initial'       => ['serum_calcium', 'intact_pth'],
        'confirmatory'  => ['serum_phosphate', 'vitamin_d_25oh'],
        'rationale'     => 'Hypercalcemia + elevated PTH is the classic diagnostic pair. Usually found incidentally.',
        'can_diagnose_with_initial' => true,
    ],
    'hypoparathyroidism' => [
        'initial'       => ['serum_calcium', 'intact_pth'],
        'confirmatory'  => ['serum_phosphate'],
        'rationale'     => 'Low calcium + inappropriately low PTH is diagnostic. Often post-surgical.',
        'can_diagnose_with_initial' => true,
    ],
    'congenital_adrenal_hyperplasia' => [
        'initial'       => ['serum_17ohp', 'acth'],
        'confirmatory'  => ['dheas', 'cortisol_morning'],
        'rationale'     => 'Elevated 17-OHP (especially post-ACTH stimulation) is the hallmark of 21-hydroxylase deficiency.',
        'can_diagnose_with_initial' => true,
    ],
    'polycystic_ovary_syndrome' => [
        'initial'       => ['serum_testosterone_free', 'lh'],
        'confirmatory'  => ['amh', 'fasting_insulin'],
        'rationale'     => 'Free testosterone + LH:FSH ratio are first-line. Elevated AMH supports PCOS diagnosis.',
        'can_diagnose_with_initial' => false,
    ],
    'male_hypogonadism' => [
        'initial'       => ['serum_testosterone'],
        'confirmatory'  => ['lh', 'fsh'],
        'rationale'     => 'Total testosterone (drawn 8–10 AM) is the mandatory first test. LH/FSH distinguishes primary from secondary.',
        'can_diagnose_with_initial' => false,
    ],
    'osteoporosis' => [
        'initial'       => ['vitamin_d_25oh', 'serum_calcium'],
        'confirmatory'  => ['intact_pth', 'serum_phosphate'],
        'rationale'     => 'Vitamin D + calcium are the foundational metabolic bone labs. PTH evaluates secondary causes.',
        'can_diagnose_with_initial' => false,
    ],
    'vitamin_d_deficiency' => [
        'initial'       => ['vitamin_d_25oh'],
        'confirmatory'  => ['intact_pth', 'serum_calcium'],
        'rationale'     => '25-OH Vitamin D is the single definitive test. < 20 ng/mL = deficiency per Endocrine Society.',
        'can_diagnose_with_initial' => true,
    ],
    'thyroid_nodule_cancer' => [
        'initial'       => ['tsh', 'serum_calcitonin'],
        'confirmatory'  => ['chromogranin_a'],
        'rationale'     => 'TSH + calcitonin is the initial lab panel. Elevated calcitonin suggests medullary thyroid cancer.',
        'can_diagnose_with_initial' => false,
    ],
    'subclinical_hypothyroidism' => [
        'initial'       => ['tsh', 'free_t4'],
        'confirmatory'  => ['anti_tpo'],
        'rationale'     => 'High TSH with normal Free T4 defines subclinical hypothyroidism. Anti-TPO identifies progression risk.',
        'can_diagnose_with_initial' => true,
    ],
    'multiple_endocrine_neoplasia_type1' => [
        'initial'       => ['serum_calcium', 'intact_pth', 'serum_prolactin'],
        'confirmatory'  => ['serum_gastrin', 'igf1', 'chromogranin_a'],
        'rationale'     => 'MEN1 triad: hyperparathyroidism (Ca²⁺/PTH), pituitary tumor (prolactin), pancreatic NET (gastrin). Screen all three glands.',
        'can_diagnose_with_initial' => false,
    ],
    'carcinoid_syndrome' => [
        'initial'       => ['urine_5hiaa', 'chromogranin_a'],
        'confirmatory'  => [],
        'rationale'     => '24-hour urine 5-HIAA + plasma chromogranin A are the diagnostic pair for carcinoid syndrome.',
        'can_diagnose_with_initial' => true,
    ],
    'insulinoma' => [
        'initial'       => ['serum_glucose', 'fasting_insulin'],
        'confirmatory'  => ['c_peptide'],
        'rationale'     => 'Whipple\'s triad: hypoglycemia during fasting + insulin + symptoms relieved by glucose. 72-hour fast is gold standard.',
        'can_diagnose_with_initial' => false,
    ],
    'thyroiditis_subacute' => [
        'initial'       => ['tsh', 'free_t4'],
        'confirmatory'  => ['esr'],
        'rationale'     => 'Transient hyperthyroidism pattern (low TSH/high T4). Very high ESR (>50 mm/hr) is characteristic.',
        'can_diagnose_with_initial' => false,
    ],
    'central_hypothyroidism' => [
        'initial'       => ['free_t4', 'tsh'],
        'confirmatory'  => ['cortisol_morning', 'igf1'],
        'rationale'     => 'Low Free T4 with low/normal TSH (failure of pituitary). Evaluate other pituitary axes.',
        'can_diagnose_with_initial' => false,
    ],
];

function getPriorityLabsForDisorder(string $disorderId): array {
    global $disorderPriorityLabs;
    return $disorderPriorityLabs[$disorderId] ?? [
        'initial' => [], 'confirmatory' => [], 
        'rationale' => 'Standard workup as per Endocrine Society guidelines.',
        'can_diagnose_with_initial' => false
    ];
}
