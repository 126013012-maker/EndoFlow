<?php
/**
 * EndoFlow v5.0 — Unified Clinical Pattern Database
 * Each disorder includes: guideline_ref, gender_bias, age_range for demographic scoring.
 */

$patterns = [

    'primary_hyperaldosteronism' => [
        'id'               => 'primary_hyperaldosteronism',
        'name'             => "Primary Hyperaldosteronism (Conn's Syndrome)",
        'organ'            => 'Adrenal',
        'clinical_pattern' => 'Hypertension + Hypokalemia + Suppressed Renin',
        'priority'         => 'high',
        'icd10'            => 'E26.0',
        'guideline_ref'    => 'Endocrine Society CPG — Primary Aldosteronism, JCEM 2016 (Updated 2025)',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26934393/',

        // Demographics for scoring boost
        'age_range'   => [30, 55],
        'gender_bias' => 'female', // slightly more common in females

        'epidemiology' => [
            'prevalence' => '5–15% of hypertensive patients',
            'age'        => '30–55 years',
            'gender'     => 'Slightly more common in women',
            'peak_age'   => '40s',
        ],

        'pathophysiology' => 'Autonomous aldosterone secretion from adrenal adenoma (60%) or bilateral hyperplasia (40%) → sodium retention → potassium wasting → volume expansion → renin suppression → hypertension.',

        'key_symptoms' => [
            'Hypertension'      => 'Often resistant; BP > 160/100 in 70%',
            'Hypokalemia'       => 'Spontaneous K+ < 3.5; muscle weakness, cramps, fatigue',
            'Polyuria/Nocturia' => 'Nephrogenic diabetes insipidus from hypokalemia',
            'Headache'          => 'Common; related to hypertension',
        ],

        'lab_findings' => [
            ['test' => 'Serum K+',               'value' => '< 3.5 mEq/L',         'direction' => 'low'],
            ['test' => 'Serum Aldosterone',       'value' => '> 15 ng/dL',          'direction' => 'high'],
            ['test' => 'Plasma Renin Activity',   'value' => '< 1.0 ng/mL/hr',      'direction' => 'low'],
            ['test' => 'Aldo:Renin Ratio (ARR)',  'value' => '> 20–30',             'direction' => 'high'],
            ['test' => '24h Urinary K+',          'value' => '> 30 mEq/day',        'direction' => 'high'],
            ['test' => 'Serum Bicarbonate',       'value' => 'Elevated (alkalosis)', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Screen: ARR (stop interfering meds 4 wks prior)',
            'Step 2' => 'Confirm: Saline infusion test OR fludrocortisone suppression test',
            'Step 3' => 'Subtype: Adrenal CT (not alone sufficient)',
            'Step 4' => 'Adrenal Vein Sampling (if age < 40 or uncertain lateralization)',
            'Step 5' => 'Treat: Unilateral → laparoscopic adrenalectomy; Bilateral → spironolactone/eplerenone',
        ],

        'differential_diagnosis' => [
            'Secondary hyperaldosteronism' => 'Elevated renin; due to renal artery stenosis',
            'Liddle syndrome'              => 'Genetic ENaC gain-of-function; low aldosterone',
            'Cushing syndrome'             => 'Cortisol excess; different phenotype',
            'Diuretic use'                 => 'Medication history; renin elevated',
        ],

        'management' => [
            'Unilateral adenoma: Laparoscopic adrenalectomy (curative in 50%)',
            'Bilateral/Medical: Spironolactone 50–400 mg/day (first-line) or eplerenone',
            'K+ supplementation during medical management',
            'BP target < 130/80 mmHg',
        ],

        'symptom_weights' => [
            'hypertension'    => 3,
            'hypokalemia'     => 3,
            'muscle_weakness' => 2,
            'muscle_cramps'   => 2,
            'polyuria'        => 2,
            'polydipsia'      => 2,
            'nocturia'        => 2,
            'fatigue'         => 1,
            'headache'        => 1,
        ],
        'symptom_map' => ['hypertension','hypokalemia','muscle_weakness','muscle_cramps','polyuria','polydipsia','nocturia','fatigue','headache'],
    ],

    'addisons_disease' => [
        'id'               => 'addisons_disease',
        'name'             => "Primary Adrenal Insufficiency (Addison's Disease)",
        'organ'            => 'Adrenal',
        'clinical_pattern' => 'Hyponatremia + Hyperkalemia + Hypotension + Hyperpigmentation',
        'priority'         => 'emergency',
        'icd10'            => 'E27.1',
        'guideline_ref'    => 'Endocrine Society CPG — Primary Adrenal Insufficiency, JCEM 2016',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26760044/',

        'age_range'   => [30, 50],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '93–140 per million',
            'age'        => '30–50 years',
            'gender'     => 'Female predominance (70%)',
            'cause'      => 'Autoimmune 80–90% (21-hydroxylase Ab)',
        ],

        'pathophysiology' => 'Destruction of adrenal cortex → cortisol and aldosterone deficiency → loss of negative feedback on ACTH (rises) → hyperpigmentation via MSH co-secretion → electrolyte disturbance (hyponatremia + hyperkalemia) → cardiovascular collapse in crisis.',

        'key_symptoms' => [
            'Fatigue/Weakness'  => 'Profound; present in virtually all patients (99%)',
            'Hyperpigmentation' => 'Palmar creases, buccal mucosa, scars — pathognomonic',
            'Hypotension'       => 'Orthostatic; volume depletion from salt wasting',
            'GI Symptoms'       => 'Nausea, vomiting, abdominal pain; key early features',
            'Salt Craving'      => 'Classic and specific',
        ],

        'lab_findings' => [
            ['test' => 'Serum Na+',        'value' => '< 135 mEq/L',       'direction' => 'low'],
            ['test' => 'Serum K+',         'value' => '> 5.0 mEq/L',       'direction' => 'high'],
            ['test' => 'Morning Cortisol', 'value' => '< 3 µg/dL (dx)',     'direction' => 'low'],
            ['test' => 'ACTH',             'value' => '> 100 pg/mL',        'direction' => 'high'],
            ['test' => 'Plasma Renin',     'value' => 'Elevated',           'direction' => 'high'],
            ['test' => 'Blood Glucose',    'value' => 'Low (hypoglycemia)', 'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Morning cortisol: < 3 µg/dL is diagnostic; > 18 µg/dL excludes',
            'Step 2' => 'ACTH stimulation test: 250 µg cosyntropin IV; cortisol < 18 µg/dL at 60 min = FAIL',
            'Step 3' => 'Plasma ACTH: > 100 pg/mL confirms primary AI',
            'Step 4' => '21-OH antibodies: positive in autoimmune (most common)',
            'Step 5' => 'Adrenal CT if antibodies negative (TB, hemorrhage, metastasis)',
        ],

        'differential_diagnosis' => [
            'Secondary AI'   => 'Low/normal ACTH; no hyperkalemia; no hyperpigmentation',
            'SIADH'          => 'Euvolemic; no hyperkalemia; normal ACTH/cortisol',
            'Renal failure'  => 'Elevated creatinine; no cortisol deficiency',
            'Hypothyroidism' => 'Bradycardia; constipation; low TSH/T4',
        ],

        'management' => [
            'CRISIS: Hydrocortisone 100 mg IV bolus → 50–100 mg q6–8h + NS resuscitation',
            'Chronic: Hydrocortisone 15–25 mg/day (2/3 morning, 1/3 afternoon)',
            'Mineralocorticoid: Fludrocortisone 0.05–0.2 mg/day',
            'Sick day rules: Double/triple dose during illness, fever, surgery',
            'Medical alert ID mandatory',
        ],

        'symptom_weights' => [
            'hyperpigmentation'       => 3,
            'hyponatremia'            => 3,
            'hyperkalemia'            => 3,
            'hypotension'             => 3,
            'orthostatic_hypotension' => 2,
            'fatigue'                 => 2,
            'weakness'                => 2,
            'salt_craving'            => 2,
            'nausea'                  => 2,
            'vomiting'                => 2,
            'anorexia'                => 1,
            'abdominal_pain'          => 1,
            'weight_loss'             => 1,
        ],
        'symptom_map' => ['hyperpigmentation','hyponatremia','hyperkalemia','hypotension','orthostatic_hypotension','fatigue','weakness','salt_craving','nausea','vomiting','anorexia','abdominal_pain','weight_loss'],
    ],

    'pheochromocytoma' => [
        'id'               => 'pheochromocytoma',
        'name'             => 'Pheochromocytoma / Paraganglioma',
        'organ'            => 'Adrenal',
        'clinical_pattern' => 'Paroxysmal HTN + Headache + Sweating + Palpitations (Classic Triad)',
        'priority'         => 'high',
        'icd10'            => 'D35.0 / C74.1',
        'guideline_ref'    => 'Endocrine Society CPG — Pheochromocytoma & Paraganglioma, JCEM 2014',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/24893135/',

        'age_range'   => [30, 60],
        'gender_bias' => 'none',

        'epidemiology' => [
            'prevalence' => '0.1–0.6% of hypertensive patients',
            'age'        => '40–50 years',
            'gender'     => 'Equal distribution',
            'rule_of_10' => '10% bilateral, 10% extra-adrenal, 10% malignant, 10% familial',
        ],

        'pathophysiology' => 'Catecholamine-secreting chromaffin tumor → episodic/sustained epinephrine and norepinephrine release → paroxysmal hypertension, tachycardia, metabolic effects.',

        'key_symptoms' => [
            'Classic Triad' => 'Headache (90%), diaphoresis (70%), palpitations (70%) — all paroxysmal',
            'Hypertension'  => 'Paroxysmal in 45%; sustained in 50%',
            'Spells'        => 'Last minutes to hours; triggered by tumor manipulation',
            'Metabolic'     => 'Weight loss, hyperglycemia (catecholamines suppress insulin)',
        ],

        'lab_findings' => [
            ['test' => 'Plasma Free Metanephrines', 'value' => '> 2× ULN (99% sensitive)', 'direction' => 'high'],
            ['test' => '24h Urinary Metanephrines', 'value' => '> 2× ULN',                 'direction' => 'high'],
            ['test' => 'Plasma Catecholamines',     'value' => 'Elevated during spell',     'direction' => 'high'],
            ['test' => 'Blood Glucose',             'value' => 'Often elevated',            'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Biochemical: Plasma free metanephrines (first-line; highest sensitivity)',
            'Step 2' => 'Imaging: CT/MRI abdomen (adrenal localization)',
            'Step 3' => 'Functional scan: MIBG or FDG-PET for extra-adrenal/malignant',
            'Step 4' => 'Genetic testing: SDHx, VHL, RET, NF1',
            'Step 5' => 'Pre-op: α-blocker first (phenoxybenzamine), THEN β-blocker if needed',
        ],

        'differential_diagnosis' => [
            'Essential hypertension' => 'No spells; normal metanephrines',
            'Panic disorder'         => 'Normal BP during attack; normal metanephrines',
            'Hyperthyroidism'        => 'TSH low; T4 high; diffuse goiter',
            'Carcinoid syndrome'     => 'Flushing + diarrhea; 5-HIAA elevated',
        ],

        'management' => [
            'Pre-op: Phenoxybenzamine 10 mg BD → titrate; high-salt diet',
            'Surgery: Laparoscopic adrenalectomy (preferred)',
            'Malignant: 131I-MIBG therapy, sunitinib',
            'Lifelong annual biochemical surveillance',
        ],

        'symptom_weights' => [
            'hypertension'   => 3,
            'headache'       => 3,
            'sweating'       => 3,
            'palpitations'   => 3,
            'tachycardia'    => 2,
            'anxiety'        => 2,
            'pallor'         => 2,
            'tremor'         => 2,
            'weight_loss'    => 1,
            'chest_pain'     => 1,
            'abdominal_pain' => 1,
        ],
        'symptom_map' => ['hypertension','headache','sweating','palpitations','tachycardia','anxiety','pallor','tremor','weight_loss','chest_pain','abdominal_pain'],
    ],

    'siadh' => [
        'id'               => 'siadh',
        'name'             => 'Syndrome of Inappropriate ADH Secretion (SIADH)',
        'organ'            => 'Pituitary / Other',
        'clinical_pattern' => 'Euvolemic Hyponatremia + Low Serum Osmolality + High Urine Osmolality',
        'priority'         => 'medium',
        'icd10'            => 'E22.2',
        'guideline_ref'    => 'Endocrine Society CPG — Hyponatremia, JCEM 2013',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/23535805/',

        'age_range'   => [0, 100],
        'gender_bias' => 'none',

        'epidemiology' => [
            'prevalence' => 'Most common cause of hyponatremia in hospitalized patients',
            'age'        => 'Any age; elderly at higher risk',
            'causes'     => 'CNS disease, malignancy (SCLC), pulmonary disease, drugs',
        ],

        'pathophysiology' => 'Persistent ADH secretion inappropriate to plasma osmolality → renal free water retention → dilutional hyponatremia → euvolemia.',

        'key_symptoms' => [
            'Mild (Na 130–135)'  => 'Often asymptomatic; nausea, malaise',
            'Moderate (125–130)' => 'Headache, confusion, lethargy',
            'Severe (< 125)'     => 'Seizures, coma, respiratory arrest',
            'Volume status'      => 'Euvolemic — no edema, no hypovolemia',
        ],

        'lab_findings' => [
            ['test' => 'Serum Sodium',    'value' => '< 135 mEq/L',              'direction' => 'low'],
            ['test' => 'Serum Osmolality','value' => '< 275 mOsm/kg',            'direction' => 'low'],
            ['test' => 'Urine Osmolality','value' => '> 100 mOsm/kg',            'direction' => 'high'],
            ['test' => 'Urine Sodium',    'value' => '> 40 mEq/L',               'direction' => 'high'],
            ['test' => 'Serum Uric Acid', 'value' => 'Low (< 4 mg/dL)',          'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Confirm hyponatremia is hypotonic (serum osm < 275)',
            'Step 2' => 'Assess volume status: SIADH = euvolemic',
            'Step 3' => 'Urine osmolality > 100 AND urine Na > 40',
            'Step 4' => 'Exclude: Hypothyroidism, adrenal insufficiency, renal disease',
            'Step 5' => 'Find cause: CT chest/brain, drug review',
        ],

        'differential_diagnosis' => [
            'Hypovolemic hyponatremia' => 'Urine Na < 20; clinically dehydrated',
            'Heart failure'            => 'Edema; elevated JVP; BNP high',
            'Cirrhosis'                => 'Ascites; low albumin; jaundice',
            'Primary polydipsia'       => 'Urine osmolality < 100 mOsm/kg',
        ],

        'management' => [
            'Acute symptomatic: 3% hypertonic saline 1–2 mL/kg/h',
            'Chronic: Fluid restriction 500–1000 mL/day',
            'Rate limit: < 10–12 mEq/L per 24h (osmotic demyelination risk)',
            'Medications: Tolvaptan (V2-antagonist)',
            'Treat underlying cause',
        ],

        'symptom_weights' => [
            'hyponatremia' => 3,
            'confusion'    => 2,
            'headache'     => 2,
            'seizure'      => 2,
            'nausea'       => 2,
            'vomiting'     => 1,
            'fatigue'      => 1,
            'weakness'     => 1,
        ],
        'symptom_map' => ['hyponatremia','confusion','headache','seizure','nausea','vomiting','fatigue','weakness'],
    ],

    'acromegaly' => [
        'id'               => 'acromegaly',
        'name'             => 'Acromegaly',
        'organ'            => 'Pituitary',
        'clinical_pattern' => 'Acral Enlargement + Coarse Facies + Elevated IGF-1',
        'priority'         => 'medium',
        'icd10'            => 'E22.0',
        'guideline_ref'    => 'Endocrine Society CPG — Acromegaly, JCEM 2014',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/25356808/',

        'age_range'   => [30, 60],
        'gender_bias' => 'none',

        'epidemiology' => [
            'prevalence' => '40–70 per million',
            'age'        => '40–45 years (mean diagnosis)',
            'gender'     => 'Equal distribution',
            'delay'      => 'Mean diagnostic delay 8–10 years',
        ],

        'pathophysiology' => 'GH-secreting pituitary adenoma (99%) → continuous GH hypersecretion → liver produces excess IGF-1 → acral and soft tissue overgrowth, organomegaly.',

        'key_symptoms' => [
            'Acral Changes'   => 'Increased ring/shoe size; spade-like hands; broad feet',
            'Facial Features' => 'Coarse facies; prognathism; macroglossia; frontal bossing',
            'Systemic'        => 'Snoring/sleep apnea (60%); arthralgias (70%); carpal tunnel (50%)',
            'Metabolic'       => 'IGT/Diabetes (25%); hypertension (35%)',
        ],

        'lab_findings' => [
            ['test' => 'IGF-1',          'value' => '> 2 SD above normal',     'direction' => 'high'],
            ['test' => 'OGTT GH nadir',  'value' => '> 1 ng/mL',              'direction' => 'high'],
            ['test' => 'Basal GH',       'value' => '> 5 ng/mL',              'direction' => 'high'],
            ['test' => 'Fasting Glucose','value' => 'Often elevated',          'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Screen: Age/sex-adjusted IGF-1 (single best test)',
            'Step 2' => 'Confirm: OGTT with GH; GH nadir > 1 ng/mL = acromegaly',
            'Step 3' => 'MRI pituitary with gadolinium contrast',
            'Step 4' => 'Assess complications: Colonoscopy, echocardiogram, sleep study',
            'Step 5' => 'Treat: Transsphenoidal surgery (first-line)',
        ],

        'differential_diagnosis' => [
            'Physiological'             => 'Puberty, pregnancy; normal IGF-1',
            'Pachydermoperiostosis'     => 'Primary hypertrophic osteoarthropathy; no GH excess',
            'Severe hypothyroidism'     => 'Myxedema causing coarse features; TSH elevated',
            'Ectopic GH/GHRH secretion'=> 'Rare; carcinoid/SCLC',
        ],

        'management' => [
            'Surgery: Transsphenoidal adenomectomy',
            'Medical: Somatostatin analogues (octreotide LAR, lanreotide)',
            'Radiotherapy: Stereotactic radiosurgery for residual disease',
            'Target: IGF-1 normal for age; GH < 1 ng/mL on OGTT',
        ],

        'symptom_weights' => [
            'acral_enlargement'   => 3,
            'coarse_facies'       => 3,
            'macroglossia'        => 3,
            'prognathism'         => 2,
            'snoring'             => 2,
            'sleep_apnea'         => 2,
            'arthralgia'          => 2,
            'carpal_tunnel'       => 2,
            'headache'            => 1,
            'visual_field_defect' => 1,
            'sweating'            => 1,
            'hypertension'        => 1,
        ],
        'symptom_map' => ['acral_enlargement','coarse_facies','macroglossia','prognathism','snoring','sleep_apnea','arthralgia','carpal_tunnel','headache','visual_field_defect','sweating','hypertension'],
    ],

    'graves_disease' => [
        'id'               => 'graves_disease',
        'name'             => "Graves' Disease (Autoimmune Hyperthyroidism)",
        'organ'            => 'Thyroid',
        'clinical_pattern' => 'Thyrotoxicosis + Diffuse Goiter + Eye Signs (TRAb+)',
        'priority'         => 'high',
        'icd10'            => 'E05.0',
        'guideline_ref'    => 'Endocrine Society CPG — Hyperthyroidism, JCEM 2016',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/27048299/',

        'age_range'   => [20, 50],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '0.5% of population; 80% of all hyperthyroidism',
            'age'        => '20–50 years',
            'gender'     => 'Female:Male = 7–10:1',
            'trigger'    => 'Stress, pregnancy, iodine load, smoking',
        ],

        'pathophysiology' => 'TSH-receptor stimulating antibodies (TRAb) bind TSH receptors → continuous thyroid hormone synthesis → thyrotoxicosis.',

        'key_symptoms' => [
            'Hypermetabolic'   => 'Weight loss despite increased appetite; heat intolerance',
            'Neuropsychiatric' => 'Anxiety; irritability; fine tremor; hyperreflexia',
            'Cardiovascular'   => 'Palpitations; tachycardia; AF (10%)',
            'Eye Signs'        => 'Lid lag; proptosis; ophthalmoplegia (20–40%)',
        ],

        'lab_findings' => [
            ['test' => 'TSH',     'value' => '< 0.01 mIU/L (suppressed)', 'direction' => 'low'],
            ['test' => 'Free T4', 'value' => '> 1.8 ng/dL',              'direction' => 'high'],
            ['test' => 'Free T3', 'value' => '> 4.5 pg/mL',              'direction' => 'high'],
            ['test' => 'TRAb',    'value' => 'Positive (90% sensitive)',  'direction' => 'high'],
            ['test' => 'TPO Ab',  'value' => 'Often positive',            'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Confirm thyrotoxicosis: suppressed TSH + elevated free T4/T3',
            'Step 2' => 'TRAb positive → diagnosis confirmed',
            'Step 3' => 'If TRAb negative: RAIU — diffuse elevated uptake = Graves',
            'Step 4' => 'Assess severity: AF? Heart failure? Severe ophthalmopathy?',
            'Step 5' => 'Treat: ATD (methimazole/PTU) + β-blocker',
        ],

        'differential_diagnosis' => [
            'Toxic multinodular goiter'  => 'Nodular gland; older patients; no TRAb',
            'Subacute thyroiditis'       => 'Painful gland; low RAIU; self-limiting',
            'Factitious hyperthyroidism' => 'Low thyroglobulin; history of thyroid hormone',
            'TSH-secreting adenoma'      => 'Elevated/normal TSH with high T4',
        ],

        'management' => [
            'Anti-thyroid drugs: Methimazole 10–40 mg/day (preferred)',
            'β-blocker: Propranolol or atenolol for symptomatic relief',
            'Definitive: RAI (most common) or total thyroidectomy',
            'Eye disease: Selenium; teprotumumab; IV glucocorticoids',
            'Thyroid storm: PTU + SSKI + hydrocortisone + propranolol',
        ],

        'symptom_weights' => [
            'weight_loss'      => 3,
            'heat_intolerance' => 3,
            'tachycardia'      => 3,
            'palpitations'     => 3,
            'goiter'           => 2,
            'proptosis'        => 2,
            'sweating'         => 2,
            'tremor'           => 2,
            'anxiety'          => 2,
            'fatigue'          => 1,
            'weakness'         => 1,
            'diarrhea'         => 1,
        ],
        'symptom_map' => ['weight_loss','heat_intolerance','tachycardia','palpitations','goiter','proptosis','sweating','tremor','anxiety','fatigue','weakness','diarrhea'],
    ],

    'hypothyroidism' => [
        'id'               => 'hypothyroidism',
        'name'             => 'Hypothyroidism (Primary)',
        'organ'            => 'Thyroid',
        'clinical_pattern' => 'Fatigue + Weight Gain + Cold Intolerance + Elevated TSH',
        'priority'         => 'low',
        'icd10'            => 'E03.9',
        'guideline_ref'    => 'Endocrine Society CPG — Hypothyroidism in Adults, JCEM 2012',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/22442344/',

        'age_range'   => [40, 80],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '2–4% women; 0.1–0.2% men',
            'age'        => 'Any age; peaks 40–60 years',
            'gender'     => 'Female:Male = 8:1',
            'cause'      => 'Hashimoto thyroiditis (most common)',
        ],

        'pathophysiology' => 'Autoimmune destruction (Hashimoto) or iodine deficiency → reduced T3/T4 → TSH rises → slowed metabolism in all organ systems.',

        'key_symptoms' => [
            'Constitutional'   => 'Fatigue; weight gain; cold intolerance; constipation',
            'Skin/Hair'        => 'Dry skin; coarse hair; hair loss; periorbital puffiness',
            'Neuropsychiatric' => 'Depression; cognitive slowing; carpal tunnel syndrome',
            'Cardiovascular'   => 'Bradycardia; pericardial effusion; diastolic hypertension',
        ],

        'lab_findings' => [
            ['test' => 'TSH',             'value' => '> 4.5 mIU/L',        'direction' => 'high'],
            ['test' => 'Free T4',         'value' => '< 0.8 ng/dL',        'direction' => 'low'],
            ['test' => 'TPO Antibodies',  'value' => 'Positive (Hashimoto)','direction' => 'high'],
            ['test' => 'Total Cholesterol','value' => 'Elevated',           'direction' => 'high'],
            ['test' => 'CK',              'value' => 'May be elevated',     'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'TSH: Single best screening test; if > 4.5 → check free T4',
            'Step 2' => 'Primary hypothyroidism: High TSH + Low free T4',
            'Step 3' => 'Subclinical: High TSH + Normal free T4',
            'Step 4' => 'Etiology: TPO-Ab (Hashimoto), drug history',
            'Step 5' => 'Treat if TSH > 10 mIU/L or symptomatic with TSH 4.5–10',
        ],

        'differential_diagnosis' => [
            'Central hypothyroidism' => 'Low/normal TSH + low T4; pituitary cause',
            'Sick euthyroid'         => 'Low T3/T4; normal TSH; resolves with recovery',
            'Depression'             => 'Overlapping symptoms; check TSH',
            'Medication effect'      => 'Lithium, amiodarone, interferon',
        ],

        'management' => [
            'Levothyroxine (T4): 1.6 µg/kg/day; adjust every 6 weeks',
            'Elderly/cardiac: Start 12.5–25 µg/day; titrate slowly',
            'Target: TSH 0.5–2.5 mIU/L',
            'Myxedema coma: IV T4 + T3 + hydrocortisone + supportive care',
            'Pregnancy: TSH target < 2.5 mIU/L in first trimester',
        ],

        'symptom_weights' => [
            'fatigue'          => 3,
            'weight_gain'      => 3,
            'cold_intolerance' => 3,
            'constipation'     => 2,
            'bradycardia'      => 2,
            'dry_skin'         => 2,
            'hair_loss'        => 2,
            'hoarseness'       => 2,
            'menorrhagia'      => 1,
            'weakness'         => 1,
            'pallor'           => 1,
        ],
        'symptom_map' => ['fatigue','weight_gain','cold_intolerance','constipation','bradycardia','dry_skin','hair_loss','hoarseness','menorrhagia','weakness','pallor'],
    ],

    'cushing_syndrome' => [
        'id'               => 'cushing_syndrome',
        'name'             => "Cushing's Syndrome",
        'organ'            => 'Adrenal / Pituitary',
        'clinical_pattern' => 'Centripetal Obesity + HTN + Purple Striae + Hypokalemia',
        'priority'         => 'high',
        'icd10'            => 'E24.9',
        'guideline_ref'    => "Endocrine Society CPG — Cushing's Syndrome Diagnosis 2008 / Treatment 2015",
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26222757/',

        'age_range'   => [25, 55],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '10–15 per million per year',
            'age'        => '25–45 years',
            'gender'     => 'Female:Male = 3:1',
            'causes'     => "Cushing's disease (pituitary ACTH) 68%; adrenal adenoma 17%",
        ],

        'pathophysiology' => "Excess cortisol → protein catabolism (striae, bruising, proximal myopathy) → fat redistribution (central obesity, moon face, buffalo hump) → mineralocorticoid effects (HTN, hypokalemia).",

        'key_symptoms' => [
            'Appearance'  => 'Moon face; plethora; buffalo hump; central obesity',
            'Skin'        => 'Purple striae > 1 cm wide; easy bruising; acne; hirsutism',
            'Muscle/Bone' => 'Proximal muscle weakness; osteoporosis',
            'Metabolic'   => 'Hypertension (80%); glucose intolerance (50%)',
        ],

        'lab_findings' => [
            ['test' => '24h UFC',                      'value' => '> 3× ULN',              'direction' => 'high'],
            ['test' => 'Late-night Salivary Cortisol', 'value' => '> 2× normal',           'direction' => 'high'],
            ['test' => '1mg Overnight DST',            'value' => 'Cortisol > 1.8 µg/dL', 'direction' => 'high'],
            ['test' => 'Serum Potassium',              'value' => 'Low in ectopic ACTH',   'direction' => 'low'],
            ['test' => 'Plasma ACTH',                  'value' => 'Differential',          'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Screen (≥2 tests): 24h UFC + late-night salivary cortisol + 1mg DST',
            'Step 2' => 'If 2+ positive → confirmed Cushing syndrome',
            'Step 3' => 'ACTH level: > 20 = ACTH-dependent; < 5 = ACTH-independent',
            'Step 4' => "If ACTH-dependent: MRI pituitary → Cushing's disease vs ectopic",
            'Step 5' => 'If ACTH-independent: CT/MRI adrenal',
        ],

        'differential_diagnosis' => [
            'Pseudo-Cushing'          => 'Alcoholism, depression, obesity',
            'Exogenous glucocorticoid' => 'History of steroid use; low ACTH',
            'Ectopic ACTH'            => 'Rapid onset; severe hypokalemia; look for SCLC',
            'Adrenal carcinoma'       => 'Virilization; very high androgens',
        ],

        'management' => [
            "Cushing's disease: Transsphenoidal adenomectomy (remission 70–80%)",
            'Adrenal adenoma: Laparoscopic adrenalectomy',
            'Medical: Ketoconazole, metyrapone, osilodrostat',
            'Post-op: Hydrocortisone replacement until HPA axis recovers',
        ],

        'symptom_weights' => [
            'central_obesity'   => 3,
            'moon_face'         => 3,
            'buffalo_hump'      => 3,
            'purple_striae'     => 3,
            'easy_bruising'     => 2,
            'hypertension'      => 2,
            'proximal_weakness' => 2,
            'hirsutism'         => 2,
            'acne'              => 1,
            'weight_gain'       => 1,
            'hypokalemia'       => 1,
        ],
        'symptom_map' => ['central_obesity','moon_face','buffalo_hump','purple_striae','easy_bruising','hypertension','proximal_weakness','hirsutism','acne','weight_gain','hypokalemia'],
    ],

    'diabetes_insipidus' => [
        'id'               => 'diabetes_insipidus',
        'name'             => 'Diabetes Insipidus',
        'organ'            => 'Pituitary / Renal',
        'clinical_pattern' => 'Massive Polyuria + Polydipsia + Dilute Urine',
        'priority'         => 'medium',
        'icd10'            => 'E23.2',
        'guideline_ref'    => 'European Endocrine Society Consensus — Diabetes Insipidus, Eur J Endocrinol 2023',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/37000567/',

        'age_range'   => [0, 100],
        'gender_bias' => 'none',

        'epidemiology' => [
            'prevalence' => '1 in 25,000',
            'types'      => 'Central (ADH deficiency 90%) vs Nephrogenic (ADH resistance 10%)',
            'causes'     => 'Head trauma, pituitary surgery, lithium, hypercalcemia',
        ],

        'pathophysiology' => 'Central DI: ADH deficiency → kidneys cannot concentrate urine → massive free water loss. Nephrogenic DI: ADH resistance at renal tubule.',

        'key_symptoms' => [
            'Primary'     => 'Polyuria (3–20 L/day); polydipsia; ice-cold water preference',
            'Nocturia'    => 'Severe; sleep disruption',
            'Dehydration' => 'If water access restricted → hypernatremia',
            'Other'       => 'Fatigue; headache (if hypothalamic cause)',
        ],

        'lab_findings' => [
            ['test' => 'Urine Osmolality',      'value' => '< 300 mOsm/kg (dilute)', 'direction' => 'low'],
            ['test' => 'Serum Osmolality',      'value' => '> 295 mOsm/kg',          'direction' => 'high'],
            ['test' => 'Serum Sodium',          'value' => 'Normal or high',          'direction' => 'high'],
            ['test' => 'Urine Specific Gravity','value' => '< 1.005',                 'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Confirm polyuria: Urine output > 3 L/day',
            'Step 2' => 'Water deprivation test: Urine osm < 300 after dehydration → DI',
            'Step 3' => 'DDAVP test: > 50% rise → Central DI; < 50% → Nephrogenic DI',
            'Step 4' => 'Copeptin measurement (emerging gold standard)',
            'Step 5' => 'MRI pituitary: Loss of posterior pituitary bright spot',
        ],

        'differential_diagnosis' => [
            'Primary polydipsia' => 'Low-normal serum osm; urine osm > 500 after dehydration',
            'Diabetes mellitus'  => 'Glucosuria; hyperglycemia; osmotic diuresis',
            'Hypercalcemia'      => 'Causes nephrogenic DI; check serum calcium',
            'Hypokalemia'        => 'Impairs renal concentrating ability',
        ],

        'management' => [
            'Central DI: Desmopressin (DDAVP) intranasal/oral/SC',
            'Nephrogenic DI: Low-salt diet; thiazide diuretics',
            'Inpatient: Careful free water replacement',
            'Treat underlying cause',
        ],

        'symptom_weights' => [
            'polyuria'   => 3,
            'polydipsia' => 3,
            'nocturia'   => 2,
            'fatigue'    => 1,
            'headache'   => 1,
            'dry_mouth'  => 1,
            'dehydration'=> 1,
        ],
        'symptom_map' => ['polyuria','polydipsia','nocturia','fatigue','headache','dry_mouth','dehydration'],
    ],

    'prolactinoma' => [
        'id'               => 'prolactinoma',
        'name'             => 'Prolactinoma',
        'organ'            => 'Pituitary',
        'clinical_pattern' => 'Galactorrhea + Amenorrhea + Infertility + Elevated Prolactin',
        'priority'         => 'medium',
        'icd10'            => 'D35.2',
        'guideline_ref'    => 'Endocrine Society CPG — Hyperprolactinemia, JCEM 2011',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/21296991/',

        'age_range'   => [20, 50],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => 'Most common functional pituitary adenoma (50%)',
            'age'        => '20–50 years',
            'gender'     => 'F:M = 10:1 for microadenoma',
        ],

        'pathophysiology' => 'Prolactin-secreting pituitary adenoma → hyperprolactinemia → dopamine suppression of GnRH → hypogonadotropic hypogonadism → amenorrhea/galactorrhea in women.',

        'key_symptoms' => [
            'Women'        => 'Galactorrhea (60%); amenorrhea/oligomenorrhea; infertility',
            'Men'          => 'Impotence; decreased libido; infertility; gynecomastia',
            'Mass effects' => 'Headache; visual field defect (bitemporal hemianopia)',
            'Bone'         => 'Osteoporosis from prolonged hypogonadism',
        ],

        'lab_findings' => [
            ['test' => 'Serum Prolactin',        'value' => '> 100 ng/mL',   'direction' => 'high'],
            ['test' => 'FSH/LH',                 'value' => 'Low',           'direction' => 'low'],
            ['test' => 'Estradiol/Testosterone', 'value' => 'Low',           'direction' => 'low'],
            ['test' => 'Pregnancy test',         'value' => 'Negative',      'direction' => 'negative'],
            ['test' => 'TSH',                    'value' => 'Normal',        'direction' => 'normal'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Serum prolactin (fasting): > 100 ng/mL = adenoma until proven otherwise',
            'Step 2' => 'Rule out: Pregnancy, medications, hypothyroidism, renal failure',
            'Step 3' => 'MRI pituitary with gadolinium',
            'Step 4' => 'Visual fields if macroadenoma',
            'Step 5' => 'Full pituitary function panel',
        ],

        'differential_diagnosis' => [
            'Drug-induced'   => 'Antipsychotics, metoclopramide; prolactin rarely > 100',
            'Hypothyroidism' => 'Elevated TRH stimulates prolactin; TSH elevated',
            'Renal failure'  => 'Decreased clearance; mildly elevated',
            'Stalk effect'   => 'Non-functioning adenoma; prolactin rarely > 100',
        ],

        'management' => [
            'Medical (first-line): Cabergoline 0.5–3 mg/week (> 90% response)',
            'Alternative: Bromocriptine 2.5–15 mg/day',
            'Surgery: Transsphenoidal resection for drug-resistant cases',
            'Follow-up: Prolactin every 3–6 months; MRI after 1 year',
        ],

        'symptom_weights' => [
            'galactorrhea'        => 3,
            'amenorrhea'          => 3,
            'infertility'         => 3,
            'libido_loss'         => 2,
            'impotence'           => 2,
            'headache'            => 1,
            'visual_field_defect' => 1,
            'oligomenorrhea'      => 1,
        ],
        'symptom_map' => ['galactorrhea','amenorrhea','infertility','libido_loss','impotence','headache','visual_field_defect','oligomenorrhea'],
    ],

    // ══════════════════════════════════════════════════════════════
    // NEW DISORDERS — EndoFlow v5.0 Expansion
    // Source: Endocrine Society Clinical Practice Guidelines (JCEM)
    // ══════════════════════════════════════════════════════════════

    'type2_diabetes' => [
        'id'               => 'type2_diabetes',
        'name'             => 'Type 2 Diabetes Mellitus',
        'organ'            => 'Pancreas',
        'clinical_pattern' => 'Hyperglycemia + Insulin Resistance + Polyuria + Polydipsia',
        'priority'         => 'high',
        'icd10'            => 'E11.9',
        'guideline_ref'    => 'Endocrine Society CPG — Type 2 Diabetes Mellitus, JCEM 2015 (ADA 2024 Standards)',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26450986/',

        'age_range'   => [35, 70],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => '~11% of adults worldwide; 537 million globally (2021)',
            'age'        => 'Most >35 years; increasing in youth',
            'gender'     => 'Equal prevalence; men diagnosed earlier',
            'risk'       => 'Obesity, family history, sedentary lifestyle, South Asian ethnicity',
        ],

        'pathophysiology' => 'Progressive insulin secretory defect on a background of insulin resistance → relative insulin deficiency → chronic hyperglycemia → glucotoxicity and lipotoxicity → beta-cell exhaustion. Often associated with metabolic syndrome.',

        'key_symptoms' => [
            'Polyuria/Polydipsia' => 'Osmotic diuresis from glycosuria; classic triad',
            'Fatigue'             => 'Due to impaired glucose utilisation in cells',
            'Weight Loss'         => 'Present in severe/uncontrolled cases; otherwise weight gain',
            'Blurred Vision'      => 'Lens osmotic changes from hyperglycemia',
            'Recurrent Infections'=> 'Particularly UTIs, skin infections, candidiasis',
        ],

        'lab_findings' => [
            ['test' => 'Fasting Glucose',     'value' => '≥ 126 mg/dL (x2)',   'direction' => 'high'],
            ['test' => 'HbA1c',               'value' => '≥ 6.5%',             'direction' => 'high'],
            ['test' => '2h OGTT Glucose',     'value' => '≥ 200 mg/dL',        'direction' => 'high'],
            ['test' => 'Fasting Insulin',     'value' => 'Elevated (IR)',       'direction' => 'high'],
            ['test' => 'C-Peptide',           'value' => 'Normal or elevated',  'direction' => 'high'],
            ['test' => 'Lipid Panel',         'value' => 'TG↑, HDL↓ (dyslipidemia)', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'FPG ≥ 126 mg/dL on 2 occasions OR HbA1c ≥ 6.5% OR 2h OGTT ≥ 200 mg/dL',
            'Step 2' => 'Rule out T1DM: C-peptide, GAD65 Ab, IA-2 Ab',
            'Step 3' => 'Screen for complications: eGFR, urine ACR, retinal exam, foot exam',
            'Step 4' => 'Assess ASCVD risk: lipids, BP, smoking history',
            'Step 5' => 'Initiate metformin + lifestyle + SGLT2i/GLP-1RA if ASCVD/CKD',
        ],

        'differential_diagnosis' => [
            'Type 1 DM'    => 'Younger, ketosis-prone, low C-peptide, positive Ab',
            'MODY'         => 'Monogenic; family history; specific gene mutations',
            'Steroid DM'   => 'Medication history; post-prandial predominant',
            'LADA'         => 'Slow-onset T1DM in adults; GAD Ab positive',
        ],

        'management' => [
            'Lifestyle: Medical nutrition therapy + ≥150 min/week moderate exercise',
            'First-line: Metformin (if tolerated) + lifestyle',
            'Add SGLT2 inhibitor or GLP-1 RA if ASCVD, HF, or CKD',
            'HbA1c target < 7% (individualised: 7.5–8% in elderly/comorbid)',
            'Screen and treat hypertension (< 130/80) and dyslipidemia',
        ],

        'symptom_weights' => [
            'polyuria'        => 3,
            'polydipsia'      => 3,
            'fatigue'         => 2,
            'weight_loss'     => 2,
            'weight_gain'     => 1,
            'blurred_vision'  => 2,
            'nocturia'        => 2,
            'recurrent_infections' => 2,
            'numbness_tingling' => 2,
        ],
        'symptom_map' => ['polyuria','polydipsia','fatigue','weight_loss','weight_gain','blurred_vision','nocturia','recurrent_infections','numbness_tingling'],
    ],

    'type1_diabetes' => [
        'id'               => 'type1_diabetes',
        'name'             => 'Type 1 Diabetes Mellitus',
        'organ'            => 'Pancreas',
        'clinical_pattern' => 'Absolute Insulin Deficiency + Ketosis-Prone + Autoimmune',
        'priority'         => 'emergency',
        'icd10'            => 'E10.9',
        'guideline_ref'    => 'Endocrine Society CPG — Type 1 Diabetes Mellitus, JCEM 2021',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/33544842/',

        'age_range'   => [5, 30],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => '5–10% of all diabetes; incidence rising ~3% per year',
            'age'        => 'Peak onset: 5–7 yrs and 10–14 yrs; can occur at any age',
            'gender'     => 'Slight male predominance in some populations',
            'cause'      => 'Autoimmune destruction of beta cells (HLA-DR3/DR4 association)',
        ],

        'pathophysiology' => 'T-cell mediated autoimmune destruction of pancreatic β-cells → absolute insulin deficiency → unopposed glucagon → hyperglycemia → lipolysis → ketogenesis → diabetic ketoacidosis (DKA). Preclinical stage detectable by autoantibodies.',

        'key_symptoms' => [
            'Classic Triad'   => 'Polyuria, polydipsia, weight loss over days-weeks',
            'DKA Presentation'=> 'Nausea, vomiting, abdominal pain, fruity breath, Kussmaul respirations',
            'Rapid Onset'     => 'Acute presentation, often requiring hospitalisation',
            'Ketosis'         => 'Urine/serum ketones positive',
        ],

        'lab_findings' => [
            ['test' => 'Fasting Glucose',     'value' => '≥ 126 mg/dL',        'direction' => 'high'],
            ['test' => 'HbA1c',               'value' => '≥ 6.5% (often >10%)', 'direction' => 'high'],
            ['test' => 'C-Peptide',           'value' => 'Low/undetectable',    'direction' => 'low'],
            ['test' => 'GAD65 Antibodies',    'value' => 'Positive (>80%)',     'direction' => 'high'],
            ['test' => 'IA-2 Antibodies',     'value' => 'Positive (60–70%)',   'direction' => 'high'],
            ['test' => 'Serum Ketones',        'value' => 'Elevated in DKA',    'direction' => 'high'],
            ['test' => 'Arterial pH',          'value' => '< 7.3 in DKA',       'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Glucose criteria + check serum/urine ketones',
            'Step 2' => 'C-peptide: < 0.6 ng/mL confirms insulin deficiency',
            'Step 3' => 'Autoantibodies: GAD65, IA-2, ZnT8, IAA (1+ positive = T1DM)',
            'Step 4' => 'If DKA: ABG, electrolytes, anion gap; IV insulin + fluids',
            'Step 5' => 'CGM + MDI insulin or insulin pump therapy',
        ],

        'differential_diagnosis' => [
            'Type 2 DM' => 'Older, obese, C-peptide normal/high, antibody negative',
            'MODY'      => 'Family history; gene mutation; C-peptide present',
            'DKA in T2DM (kdAD)' => 'African American; obese; antibody negative',
            'Starvation ketosis'  => 'Normal glucose',
        ],

        'management' => [
            'Insulin: Basal-bolus regimen (MDI) or continuous subcutaneous insulin infusion (CSII)',
            'CGM strongly recommended for all T1DM',
            'Carbohydrate counting; insulin-to-carb ratio individualisation',
            'HbA1c target < 7% (adults); < 7.5% (children)',
            'DKA: 0.9% NS resuscitation → 0.1 U/kg/h insulin → K+ replacement → dextrose when glucose < 250',
        ],

        'symptom_weights' => [
            'polyuria'        => 3,
            'polydipsia'      => 3,
            'weight_loss'     => 3,
            'nausea'          => 2,
            'vomiting'        => 2,
            'abdominal_pain'  => 2,
            'fatigue'         => 2,
            'blurred_vision'  => 1,
        ],
        'symptom_map' => ['polyuria','polydipsia','weight_loss','nausea','vomiting','abdominal_pain','fatigue','blurred_vision'],
    ],

    'hyperparathyroidism' => [
        'id'               => 'hyperparathyroidism',
        'name'             => 'Primary Hyperparathyroidism (PHPT)',
        'organ'            => 'Parathyroid',
        'clinical_pattern' => 'Hypercalcemia + Elevated PTH + Nephrolithiasis',
        'priority'         => 'high',
        'icd10'            => 'E21.0',
        'guideline_ref'    => 'Endocrine Society CPG — Primary Hyperparathyroidism, JCEM 2022',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/35100440/',

        'age_range'   => [45, 70],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '1–7 per 1000 adults; most common cause of hypercalcemia (outpatient)',
            'age'        => 'Peak 50–70 years (post-menopausal women)',
            'gender'     => 'Female:male = 3:1',
            'cause'      => 'Single adenoma (80%), double adenoma (5%), hyperplasia (15%), carcinoma (<1%)',
        ],

        'pathophysiology' => 'Autonomous PTH secretion → increased osteoclastic bone resorption → hypercalcemia → suppressed calcitonin → phosphaturia → nephrolithiasis. Most cases (80%) are asymptomatic and detected incidentally.',

        'key_symptoms' => [
            '"Bones, Stones, Groans, Psychic Moans"' => 'Classic mnemonic',
            'Nephrolithiasis'   => 'Calcium oxalate/phosphate stones; 15–20%',
            'Osteoporosis'      => 'Preferentially cortical bone (distal radius)',
            'Fatigue/Depression'=> 'Neuromuscular; cognitive dysfunction',
            'GI Symptoms'       => 'Constipation, nausea, PUD (rare hypercalcemia-induced)',
        ],

        'lab_findings' => [
            ['test' => 'Serum Calcium',           'value' => '> 10.5 mg/dL',        'direction' => 'high'],
            ['test' => 'Intact PTH',              'value' => 'Elevated (or high-normal)', 'direction' => 'high'],
            ['test' => 'Serum Phosphate',         'value' => '< 2.5 mg/dL',         'direction' => 'low'],
            ['test' => 'Urine Calcium (24h)',     'value' => '> 250 mg/day (F)',     'direction' => 'high'],
            ['test' => 'Serum Chloride',          'value' => '> 102 mEq/L',         'direction' => 'high'],
            ['test' => 'Serum Bicarbonate',       'value' => '< 24 mEq/L (mild met. acidosis)', 'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Confirmed hypercalcemia (albumin-corrected or ionised Ca2+)',
            'Step 2' => 'Intact PTH: elevated or inappropriately normal in PHPT',
            'Step 3' => 'Rule out FHH: 24h urine Ca/Cr ratio < 0.01 suggests FHH',
            'Step 4' => 'Imaging: Technetium-sestamibi scan + neck ultrasound for localization',
            'Step 5' => 'Bone density (DXA) + renal imaging (stone assessment)',
        ],

        'differential_diagnosis' => [
            'Malignancy-associated hypercalcemia' => 'PTH low; PTHrP may be elevated',
            'Familial Hypocalciuric Hypercalcemia (FHH)' => 'Urine Ca:Cr ratio < 0.01; CASR mutation',
            'Vitamin D toxicity' => 'PTH suppressed; 25-OH-VitD elevated',
            'Sarcoidosis'        => 'PTH low; elevated 1,25-OH2-VitD',
        ],

        'management' => [
            'Surgery: Parathyroidectomy — curative; indicated if Ca >1 mg/dL above ULN, age <50, T-score <−2.5, 24h urine Ca >400 mg/day, or eGFR <60',
            'Medical surveillance if asymptomatic and not meeting surgical criteria',
            'Cinacalcet: for non-surgical candidates with elevated Ca',
            'Bisphosphonates: for osteoporosis management',
            'Adequate hydration; avoid thiazide diuretics and lithium',
        ],

        'symptom_weights' => [
            'hypercalcemia'  => 3,
            'nephrolithiasis'=> 3,
            'fatigue'        => 2,
            'constipation'   => 2,
            'muscle_weakness'=> 2,
            'bone_pain'      => 2,
            'depression'     => 1,
            'nausea'         => 1,
            'polyuria'       => 1,
            'polydipsia'     => 1,
        ],
        'symptom_map' => ['hypercalcemia','nephrolithiasis','fatigue','constipation','muscle_weakness','bone_pain','depression','nausea','polyuria','polydipsia'],
    ],

    'hypoparathyroidism' => [
        'id'               => 'hypoparathyroidism',
        'name'             => 'Hypoparathyroidism',
        'organ'            => 'Parathyroid',
        'clinical_pattern' => 'Hypocalcemia + Low PTH + Tetany + Hyperphosphatemia',
        'priority'         => 'high',
        'icd10'            => 'E20.9',
        'guideline_ref'    => 'Endocrine Society CPG — Hypoparathyroidism, JCEM 2016',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/27222162/',

        'age_range'   => [20, 60],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '37 per 100,000; post-surgical most common cause',
            'age'        => 'Any age; post-surgical or autoimmune',
            'gender'     => 'Female predominance (post-thyroid surgery)',
            'cause'      => 'Post-surgical (75%), autoimmune, genetic (DiGeorge), hypomagnesemia',
        ],

        'pathophysiology' => 'Deficient PTH secretion → reduced osteoclastic activity → hypocalcemia + hyperphosphatemia → increased neuromuscular excitability → tetany, seizures. Decreased 1,25-OH2-VitD production → reduced intestinal Ca absorption.',

        'key_symptoms' => [
            'Tetany'           => 'Carpopedal spasm, Trousseau sign, Chvostek sign',
            'Paresthesias'     => 'Perioral, fingertip numbness and tingling',
            'Seizures'         => 'Focal or generalised; refractory if untreated',
            'Muscle Cramps'    => 'Laryngospasm in severe cases (emergency)',
            'Neuropsychiatric' => 'Anxiety, depression, cognitive impairment',
        ],

        'lab_findings' => [
            ['test' => 'Serum Calcium (corrected)', 'value' => '< 8.5 mg/dL',   'direction' => 'low'],
            ['test' => 'Intact PTH',                'value' => 'Low/undetectable','direction' => 'low'],
            ['test' => 'Serum Phosphate',           'value' => '> 4.5 mg/dL',    'direction' => 'high'],
            ['test' => 'Serum Magnesium',           'value' => 'Check; if low → treat first', 'direction' => 'low'],
            ['test' => '25-OH Vitamin D',           'value' => 'May be low',      'direction' => 'low'],
            ['test' => '24h Urine Calcium',         'value' => 'Low',             'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Confirm hypocalcemia (corrected Ca = total Ca + 0.8 × [4 – albumin])',
            'Step 2' => 'Intact PTH: low/undetectable confirms hypoparathyroidism',
            'Step 3' => 'Check Mg2+ (hypomagnesemia causes functional hypoparathyroidism)',
            'Step 4' => 'If PTH elevated → pseudohypoparathyroidism (Albright hereditary osteodystrophy)',
            'Step 5' => 'Genetic testing if non-surgical, young age, associated features',
        ],

        'differential_diagnosis' => [
            'Vitamin D deficiency'      => 'PTH elevated; low 25-OH-VitD; hypophosphatemia',
            'Pseudohypoparathyroidism'  => 'PTH elevated; same electrolyte pattern; Albright features',
            'Hypomagnesemia'            => 'Correct Mg first; PTH partially recovers',
            'Hungry bone syndrome'      => 'Post-parathyroidectomy/thyroidectomy; severe',
        ],

        'management' => [
            'Acute: 10% calcium gluconate IV infusion (1–2 g over 20 min for tetany)',
            'Chronic: Calcium carbonate 1–3 g/day elemental Ca in divided doses',
            'Active Vitamin D: Calcitriol 0.5–2 mcg/day (required; PTH absent)',
            'PTH replacement: Recombinant PTH 1-84 (Natpara) — for poorly controlled cases',
            'Target Ca: low-normal range (8.0–8.5 mg/dL) to avoid hypercalciuria',
        ],

        'symptom_weights' => [
            'hypocalcemia'   => 3,
            'muscle_cramps'  => 3,
            'numbness_tingling' => 3,
            'seizure'        => 2,
            'anxiety'        => 1,
            'fatigue'        => 1,
            'depression'     => 1,
        ],
        'symptom_map' => ['hypocalcemia','muscle_cramps','numbness_tingling','seizure','anxiety','fatigue','depression'],
    ],

    'congenital_adrenal_hyperplasia' => [
        'id'               => 'congenital_adrenal_hyperplasia',
        'name'             => 'Congenital Adrenal Hyperplasia (CAH — 21-Hydroxylase Deficiency)',
        'organ'            => 'Adrenal',
        'clinical_pattern' => 'Virilization + Cortisol Deficiency + Salt-Wasting + Elevated 17-OHP',
        'priority'         => 'high',
        'icd10'            => 'E25.0',
        'guideline_ref'    => 'Endocrine Society CPG — Congenital Adrenal Hyperplasia, JCEM 2018',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/29272810/',

        'age_range'   => [0, 30],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '1:10,000–15,000 live births; most common adrenal disorder in children',
            'age'        => 'Neonatal to early adulthood; non-classic in adults',
            'gender'     => 'Affects both; virilisation more apparent in females',
            'cause'      => '21-hydroxylase deficiency (CYP21A2 mutation) in 95% of cases',
        ],

        'pathophysiology' => 'CYP21A2 deficiency → impaired cortisol and aldosterone synthesis → elevated ACTH (via feedback) → adrenal hyperplasia → cortisol precursors shunted into androgen pathway → excess androgens → virilization. Salt-wasting form also lacks aldosterone.',

        'key_symptoms' => [
            'Classic salt-wasting (neonatal)'  => 'Vomiting, poor feeding, hyperkalemia, hyponatremia, shock in 2nd week of life',
            'Simple virilizing'                => 'Ambiguous genitalia (female), early pubic hair, accelerated growth then early fusion',
            'Non-classic (adult)'              => 'Hirsutism, oligomenorrhea, acne, infertility in women',
            'Adrenal crisis'                   => 'Life-threatening; precipitated by illness/stress',
        ],

        'lab_findings' => [
            ['test' => '17-Hydroxyprogesterone (17-OHP)', 'value' => '> 200 ng/dL (classic); > 200 after ACTH stim (NC)', 'direction' => 'high'],
            ['test' => 'Serum Na+',            'value' => '< 135 mEq/L (salt-wasting)', 'direction' => 'low'],
            ['test' => 'Serum K+',             'value' => '> 5.0 mEq/L (salt-wasting)', 'direction' => 'high'],
            ['test' => 'Plasma ACTH',          'value' => 'Elevated',                   'direction' => 'high'],
            ['test' => 'Androstenedione',       'value' => 'Elevated',                  'direction' => 'high'],
            ['test' => 'Morning Cortisol',      'value' => 'Low',                        'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Newborn screen: 17-OHP filter paper (NBS); recall for serum confirmation',
            'Step 2' => 'Serum 17-OHP: >200 ng/dL in classic; borderline → ACTH stimulation test',
            'Step 3' => 'Electrolytes + renin + aldosterone to assess salt-wasting',
            'Step 4' => 'CYP21A2 genotyping for prognosis and family counselling',
            'Step 5' => 'Adrenal and pelvic US in females; bone age in older children',
        ],

        'differential_diagnosis' => [
            'Addison\'s Disease'         => 'No virilisation; older age; 21-OH antibodies',
            '11β-hydroxylase deficiency' => 'Hypertension + virilisation; elevated 11-deoxycortisol',
            'PCOS'                       => 'Mildly elevated androgens; 17-OHP normal post-stim',
            'Adrenal tumor'              => 'Unilateral; DHEAS markedly elevated',
        ],

        'management' => [
            'Glucocorticoid replacement: Hydrocortisone 10–15 mg/m2/day (3 divided doses)',
            'Mineralocorticoid: Fludrocortisone 0.05–0.2 mg/day for salt-wasting',
            'Salt supplements in infants (1–2 g NaCl/day)',
            'Stress dosing: Double/triple HC during illness/fever/surgery',
            'Non-classic: Treat only if symptomatic (hirsutism, infertility)',
        ],

        'symptom_weights' => [
            'hyponatremia'   => 3,
            'hyperkalemia'   => 3,
            'hirsutism'      => 3,
            'virilization'   => 3,
            'oligomenorrhea' => 2,
            'acne'           => 2,
            'hypotension'    => 2,
            'fatigue'        => 1,
            'salt_craving'   => 2,
        ],
        'symptom_map' => ['hyponatremia','hyperkalemia','hirsutism','virilization','oligomenorrhea','acne','hypotension','fatigue','salt_craving'],
    ],

    'polycystic_ovary_syndrome' => [
        'id'               => 'polycystic_ovary_syndrome',
        'name'             => 'Polycystic Ovary Syndrome (PCOS)',
        'organ'            => 'Ovary / Endocrine',
        'clinical_pattern' => 'Oligo-anovulation + Hyperandrogenism + Polycystic Ovaries',
        'priority'         => 'high',
        'icd10'            => 'E28.2',
        'guideline_ref'    => 'Endocrine Society CPG — Diagnosis and Treatment of PCOS, JCEM 2013',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/23942861/',

        'age_range'   => [15, 40],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '6–20% of reproductive-age women (most common endocrine disorder in women)',
            'age'        => 'Reproductive years; often diagnosed 20–35 years',
            'gender'     => 'Affects females exclusively (as classic form)',
            'risk'       => 'Insulin resistance, obesity, family history',
        ],

        'pathophysiology' => 'Insulin resistance → hyperinsulinemia → increased LH pulsatility → theca cell androgen overproduction → impaired follicular maturation → anovulation → oligomenorrhea. Hyperandrogenism causes hirsutism, acne. Long-term risks: T2DM, cardiovascular disease, endometrial cancer.',

        'key_symptoms' => [
            'Oligomenorrhea/Amenorrhea' => 'Cycles >35 days or <8 per year',
            'Hirsutism'                 => 'Ferriman-Gallwey score ≥ 6 (racial variation)',
            'Acne / Oily Skin'          => 'Androgen-mediated',
            'Infertility'               => 'Anovulatory; most common cause in women',
            'Weight/Metabolic'          => 'Obesity in 50%; insulin resistance; dyslipidemia',
        ],

        'lab_findings' => [
            ['test' => 'Total/Free Testosterone', 'value' => 'Elevated (>50 ng/dL total)', 'direction' => 'high'],
            ['test' => 'LH:FSH Ratio',            'value' => '> 2:1 (supportive)',          'direction' => 'high'],
            ['test' => 'SHBG',                    'value' => 'Low (increases free androgen)', 'direction' => 'low'],
            ['test' => 'Fasting Insulin',         'value' => 'Elevated (insulin resistance)', 'direction' => 'high'],
            ['test' => 'DHEAS',                   'value' => 'Mildly elevated or normal',    'direction' => 'high'],
            ['test' => 'AMH',                     'value' => 'Elevated (≥3.4 ng/mL)',       'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Rotterdam criteria (2 of 3): oligo-anovulation, clinical/biochemical hyperandrogenism, polycystic ovaries on USS',
            'Step 2' => 'Exclude mimics: TSH, PRL, 17-OHP (CAH), cortisol (Cushing), DHEAS (adrenal tumor)',
            'Step 3' => 'Metabolic screen: FPG, HbA1c or OGTT, lipid panel',
            'Step 4' => 'Pelvic USS: ≥12 follicles (2–9 mm) per ovary OR volume >10 mL',
            'Step 5' => 'Endometrial assessment if prolonged amenorrhea (>3 months)',
        ],

        'differential_diagnosis' => [
            'Non-classic CAH'          => 'Elevated 17-OHP after ACTH stimulation',
            'Hyperprolactinemia'       => 'Elevated PRL; galactorrhea; low LH/FSH',
            'Hypothyroidism'           => 'TSH elevated; amenorrhea; no hyperandrogenism',
            'Cushing syndrome'         => 'Hypercortisolism; specific physical features',
            'Androgen-secreting tumor' => 'Rapid virilization; very high testosterone',
        ],

        'management' => [
            'Lifestyle: Weight loss 5–10% → restores ovulation in obese PCOS',
            'OCP (COCP): First-line for hirsutism/acne/cycle regulation',
            'Metformin: For metabolic risk reduction and ovulation induction',
            'Letrozole/Clomiphene: For ovulation induction when fertility desired',
            'Spironolactone: For hirsutism in women not seeking pregnancy',
        ],

        'symptom_weights' => [
            'oligomenorrhea' => 3,
            'amenorrhea'     => 3,
            'hirsutism'      => 3,
            'acne'           => 2,
            'infertility'    => 3,
            'weight_gain'    => 2,
            'hair_loss'      => 1,
            'libido_loss'    => 1,
        ],
        'symptom_map' => ['oligomenorrhea','amenorrhea','hirsutism','acne','infertility','weight_gain','hair_loss','libido_loss'],
    ],

    'male_hypogonadism' => [
        'id'               => 'male_hypogonadism',
        'name'             => 'Male Hypogonadism (Testosterone Deficiency)',
        'organ'            => 'Testis / Hypothalamic-Pituitary',
        'clinical_pattern' => 'Low Testosterone + Hypogonadal Symptoms + Low/Normal LH/FSH',
        'priority'         => 'moderate',
        'icd10'            => 'E29.1',
        'guideline_ref'    => 'Endocrine Society CPG — Testosterone Therapy in Men with Hypogonadism, JCEM 2018',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/29562364/',

        'age_range'   => [18, 80],
        'gender_bias' => 'male',

        'epidemiology' => [
            'prevalence' => '~2–6% men (all ages); 20–30% in men >60 years (late-onset)',
            'age'        => 'Primary: any age; Secondary/late-onset: middle-older age',
            'gender'     => 'Males exclusively',
            'cause'      => 'Primary: Klinefelter, orchitis, chemotherapy; Secondary: pituitary tumor, obesity, opioids',
        ],

        'pathophysiology' => 'Primary: testicular failure → low testosterone → elevated LH/FSH. Secondary (hypogonadotropic): hypothalamic/pituitary defect → low LH/FSH → low testosterone. Late-onset: age-related Leydig cell decline + hypothalamic dysfunction.',

        'key_symptoms' => [
            'Sexual'        => 'Decreased libido, erectile dysfunction, reduced morning erections',
            'Body Composition' => 'Decreased muscle mass, increased body fat (central)',
            'Mood/Cognitive'   => 'Depression, fatigue, poor concentration',
            'Physical Signs'   => 'Reduced body/pubic hair, small soft testes, gynecomastia',
            'Bone'             => 'Osteoporosis, fragility fractures',
        ],

        'lab_findings' => [
            ['test' => 'Total Testosterone (8 AM)',  'value' => '< 264–300 ng/dL',    'direction' => 'low'],
            ['test' => 'Free Testosterone',          'value' => '< 65 pg/mL',         'direction' => 'low'],
            ['test' => 'LH',                         'value' => 'High (1°) or Low/Normal (2°)', 'direction' => 'low'],
            ['test' => 'FSH',                        'value' => 'High (1°) or Low/Normal (2°)', 'direction' => 'low'],
            ['test' => 'SHBG',                       'value' => 'Elevated (reduces free T)', 'direction' => 'high'],
            ['test' => 'Prolactin',                  'value' => 'Check if secondary (may be elevated)', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Two morning fasting total testosterone (< 264 ng/dL = low)',
            'Step 2' => 'LH/FSH: high = primary; low/normal = secondary hypogonadism',
            'Step 3' => 'If secondary: MRI pituitary, prolactin, full pituitary panel',
            'Step 4' => 'Karyotype if primary with unknown cause (Klinefelter: 47,XXY)',
            'Step 5' => 'Semen analysis if fertility desired',
        ],

        'differential_diagnosis' => [
            'Late-onset hypogonadism' => 'Symptoms + low T in aging men without organic cause',
            'Hyperprolactinemia'      => 'Elevated PRL suppresses GnRH',
            'Hemochromatosis'         => 'Iron deposits in pituitary; LH/FSH low',
            'Kallmann syndrome'       => 'GnRH deficiency + anosmia; congenital',
        ],

        'management' => [
            'Testosterone replacement therapy (TRT): gel, IM injection, pellet',
            'Monitor Hct (< 54%), PSA annually, bone density',
            'Fertility preservation: hCG + FSH (do NOT use TRT if fertility desired)',
            'Treat underlying cause in secondary hypogonadism (e.g., dopamine agonist for PRL)',
            'Lifestyle: weight loss, exercise, stop opioids (may reverse late-onset)',
        ],

        'symptom_weights' => [
            'libido_loss'   => 3,
            'impotence'     => 3,
            'fatigue'       => 2,
            'depression'    => 2,
            'infertility'   => 2,
            'gynecomastia'  => 2,
            'muscle_weakness'=> 1,
            'weight_gain'   => 1,
            'hair_loss'     => 1,
        ],
        'symptom_map' => ['libido_loss','impotence','fatigue','depression','infertility','gynecomastia','muscle_weakness','weight_gain','hair_loss'],
    ],

    'osteoporosis' => [
        'id'               => 'osteoporosis',
        'name'             => 'Osteoporosis / Metabolic Bone Disease',
        'organ'            => 'Bone / Endocrine',
        'clinical_pattern' => 'Low Bone Density (T-score ≤ −2.5) + Fragility Fractures + Calcium-VitD Dysregulation',
        'priority'         => 'moderate',
        'icd10'            => 'M81.0',
        'guideline_ref'    => 'Endocrine Society CPG — Pharmacological Management of Osteoporosis, JCEM 2019',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/31593296/',

        'age_range'   => [50, 85],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '10% of adults >50; 200 million worldwide',
            'age'        => 'Post-menopausal women; men >70 years',
            'gender'     => 'Women 3–4× more affected (post-menopause estrogen loss)',
            'risk'       => 'Corticosteroids, hypogonadism, malabsorption, smoking, low BMI',
        ],

        'pathophysiology' => 'Imbalance of bone resorption > formation → reduced bone mineral density. In post-menopause: estrogen loss → RANKL upregulation → osteoclast activation. Secondary causes: glucocorticoid excess, hypogonadism, hyperparathyroidism, malabsorption.',

        'key_symptoms' => [
            'Often Silent'       => 'Detected incidentally on DXA or after fragility fracture',
            'Fragility Fracture' => 'Vertebral, hip, wrist (Colles), humerus after minimal trauma',
            'Back Pain'          => 'Vertebral compression fractures → acute or chronic pain',
            'Height Loss'        => '> 4 cm loss; kyphosis (dowager\'s hump)',
        ],

        'lab_findings' => [
            ['test' => 'Serum Calcium',       'value' => 'Usually normal',             'direction' => 'low'],
            ['test' => '25-OH Vitamin D',     'value' => '< 30 ng/mL (insufficiency)', 'direction' => 'low'],
            ['test' => 'Serum PTH',           'value' => 'May be elevated (secondary hyperPTH)', 'direction' => 'high'],
            ['test' => 'Serum Phosphate',     'value' => 'Low in osteomalacia',        'direction' => 'low'],
            ['test' => 'CTX (bone resorption marker)', 'value' => 'Elevated in active resorption', 'direction' => 'high'],
            ['test' => 'P1NP (bone formation marker)', 'value' => 'May be elevated',  'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'DXA scan: T-score ≤ −2.5 = osteoporosis; −1.0 to −2.5 = osteopenia',
            'Step 2' => 'FRAX score: 10-year fracture probability (treat if hip Fx risk ≥ 3%, major ≥ 20%)',
            'Step 3' => 'Secondary cause workup: CBC, CMP, 25-OH-VitD, PTH, TFTs, SPEP, 24h urine Ca',
            'Step 4' => 'Vertebral fracture assessment on DXA or lateral spine X-ray',
            'Step 5' => 'Pharmacotherapy decision based on T-score + FRAX + secondary causes',
        ],

        'differential_diagnosis' => [
            'Osteomalacia'    => 'Low Ca/P; low VitD; pseudofractures; different histology',
            'Multiple myeloma'=> 'Lytic lesions; SPEP abnormal; anemia',
            'Paget disease'   => 'Elevated ALP; bony deformity; specific X-ray features',
            'Metastatic bone disease' => 'Cancer history; raised ALP and Ca',
        ],

        'management' => [
            'Calcium: 1000–1200 mg/day; Vitamin D 800–2000 IU/day',
            'First-line anti-resorptive: Bisphosphonates (alendronate, risedronate, zoledronic acid)',
            'Anabolic therapy: Teriparatide or abaloparatide (high-risk, severe osteoporosis)',
            'Denosumab: 60 mg SC every 6 months (alternative to bisphosphonates)',
            'Falls prevention: exercise, vision correction, home hazard reduction',
        ],

        'symptom_weights' => [
            'bone_pain'     => 3,
            'back_pain'     => 3,
            'fragility_fracture' => 3,
            'height_loss'   => 2,
            'fatigue'       => 1,
            'muscle_weakness'=> 1,
            'hypocalcemia'  => 1,
        ],
        'symptom_map' => ['bone_pain','back_pain','fragility_fracture','height_loss','fatigue','muscle_weakness','hypocalcemia'],
    ],

    'vitamin_d_deficiency' => [
        'id'               => 'vitamin_d_deficiency',
        'name'             => 'Vitamin D Deficiency / Insufficiency',
        'organ'            => 'Bone / Endocrine / Immune',
        'clinical_pattern' => 'Low 25-OH-Vitamin D + Bone Pain + Proximal Myopathy + Secondary Hyperparathyroidism',
        'priority'         => 'moderate',
        'icd10'            => 'E55.9',
        'guideline_ref'    => 'Endocrine Society CPG — Evaluation, Treatment, and Prevention of Vitamin D Deficiency, JCEM 2011',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/21646368/',

        'age_range'   => [10, 80],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => '> 1 billion people worldwide; deficiency in up to 40% of populations',
            'age'        => 'All ages; highest risk in infants, elderly, dark-skinned individuals',
            'gender'     => 'Equal; veiled women at higher risk',
            'risk'       => 'Sunlight deprivation, malabsorption, chronic kidney disease, obesity, dark skin',
        ],

        'pathophysiology' => 'Insufficient UVB exposure or dietary intake → low 25-OH-VitD → reduced intestinal Ca absorption → hypocalcemia → secondary hyperparathyroidism → PTH-mediated bone resorption → osteomalacia in adults (rickets in children). VitD also has immune, cardiovascular, and anti-cancer roles.',

        'key_symptoms' => [
            'Bone Pain / Tenderness'  => 'Diffuse; especially tibia, ribs; may mimic fibromyalgia',
            'Proximal Muscle Weakness'=> 'Waddling gait; difficulty climbing stairs/standing',
            'Fatigue'                 => 'Generalised; often attributed to other causes',
            'Rickets (children)'      => 'Bowing of legs, rachitic rosary, delayed dentition',
            'Often Asymptomatic'      => 'Especially mild insufficiency',
        ],

        'lab_findings' => [
            ['test' => '25-OH Vitamin D',  'value' => '< 20 ng/mL (deficiency); <30 (insufficiency)', 'direction' => 'low'],
            ['test' => 'Intact PTH',       'value' => 'Elevated (secondary hyperPTH)',                 'direction' => 'high'],
            ['test' => 'Serum Calcium',    'value' => 'Normal or low (mild deficiency)',               'direction' => 'low'],
            ['test' => 'Serum Phosphate',  'value' => 'Low (in severe osteomalacia)',                  'direction' => 'low'],
            ['test' => 'ALP',              'value' => 'Elevated (bone ALP in osteomalacia)',           'direction' => 'high'],
            ['test' => '1,25-OH2 Vit D',  'value' => 'May be normal or low',                         'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Serum 25-OH-VitD: < 20 ng/mL = deficient; 20–29 = insufficient; ≥ 30 = sufficient',
            'Step 2' => 'PTH, calcium, phosphate, ALP to assess severity',
            'Step 3' => 'Bone X-ray if symptomatic (Looser zones/pseudofractures suggest osteomalacia)',
            'Step 4' => 'Address underlying cause: malabsorption, CKD, medications',
            'Step 5' => 'DXA if high risk for osteoporosis',
        ],

        'differential_diagnosis' => [
            'Fibromyalgia'           => 'Normal VitD; tender points; no ALP elevation',
            'Primary hyperPTH'       => 'Hypercalcemia; PTH autonomous; normal VitD possible',
            'Osteomalacia (other)'   => 'Hypophosphatemia due to FGF-23 excess (oncogenic, XLH)',
            'Polymyalgia rheumatica' => 'Elevated ESR/CRP; responds to steroids',
        ],

        'management' => [
            'Deficiency (< 20 ng/mL): Cholecalciferol (VitD3) 50,000 IU weekly × 8–12 weeks',
            'Maintenance: 1500–2000 IU VitD3/day after repletion',
            'Monitor: 25-OH-VitD in 3 months; PTH and Ca as indicated',
            'Malabsorption: Higher doses (10,000–50,000 IU/day) or IM preparation',
            'CKD: Use activated VitD (calcitriol) — 25-OH-VitD not converted effectively',
        ],

        'symptom_weights' => [
            'bone_pain'        => 3,
            'proximal_weakness'=> 3,
            'fatigue'          => 2,
            'muscle_cramps'    => 2,
            'depression'       => 1,
            'hypocalcemia'     => 2,
            'back_pain'        => 1,
        ],
        'symptom_map' => ['bone_pain','proximal_weakness','fatigue','muscle_cramps','depression','hypocalcemia','back_pain'],
    ],

    'thyroid_nodule_cancer' => [
        'id'               => 'thyroid_nodule_cancer',
        'name'             => 'Thyroid Nodule / Differentiated Thyroid Cancer',
        'organ'            => 'Thyroid',
        'clinical_pattern' => 'Thyroid Mass + Cervical Lymphadenopathy + FNA-Confirmed Malignancy',
        'priority'         => 'high',
        'icd10'            => 'C73',
        'guideline_ref'    => 'Endocrine Society / ATA CPG — Thyroid Nodules and Differentiated Thyroid Cancer, JCEM 2016',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26462967/',

        'age_range'   => [20, 65],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => 'Nodules: 50–70% of adults; Cancer: ~5% of nodules; 43,000 new cases/year (USA)',
            'age'        => 'Papillary: 30–50 years; Follicular: 40–60; Medullary: any age (MEN2)',
            'gender'     => 'Female:male = 3:1 for DTC',
            'cause'      => 'Papillary (80%), Follicular (10%), Medullary (5%), Anaplastic (2%)',
        ],

        'pathophysiology' => 'Papillary thyroid cancer (PTC): BRAF/RAS mutations → nuclear atypia, psammoma bodies, cervical LN spread. Follicular: RAS/PAX8-PPARγ → vascular/capsular invasion. Medullary: RET proto-oncogene mutation (parafollicular C-cells) → calcitonin excess.',

        'key_symptoms' => [
            'Thyroid Mass'         => 'Usually incidental; firm, irregular, non-tender',
            'Hoarseness'           => 'Recurrent laryngeal nerve invasion (advanced)',
            'Dysphagia'            => 'Tracheal/esophageal compression',
            'Cervical Lymphadenopathy' => 'Lateral neck; common in papillary',
            'Often Asymptomatic'   => 'Majority detected by USS or incidentally',
        ],

        'lab_findings' => [
            ['test' => 'TSH',               'value' => 'Low → evaluate for hot nodule first',  'direction' => 'low'],
            ['test' => 'Serum Calcitonin',  'value' => '> 100 pg/mL (medullary cancer)',       'direction' => 'high'],
            ['test' => 'Thyroglobulin (Tg)','value' => 'Post-surgery marker; should be < 0.1 ng/mL if ablated', 'direction' => 'high'],
            ['test' => 'Anti-Tg Antibodies','value' => 'Interfere with Tg assay interpretation','direction' => 'high'],
            ['test' => 'CEA',               'value' => 'Elevated in medullary thyroid cancer', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'TSH + thyroid USS: stratify by TIRADS (ATA/EU-TIRADS) for FNA indication',
            'Step 2' => 'FNA cytology (Bethesda system I–VI) for nodules ≥ 1 cm with suspicious features',
            'Step 3' => 'Molecular testing (ThyroSeq, Afirma): Bethesda III/IV indeterminate lesions',
            'Step 4' => 'Staging CT chest/neck if clinically malignant or calcitonin elevated',
            'Step 5' => 'Post-surgery: RAI ablation (if indicated) → TSH suppression → Tg monitoring',
        ],

        'differential_diagnosis' => [
            'Benign colloid nodule'  => 'Bethesda II; no malignant features',
            'Hashimoto thyroiditis'  => 'Diffuse; anti-TPO elevated; pseudo-nodular',
            'Thyroid lymphoma'       => 'Rapid growth; Hashimoto background',
            'Metastases to thyroid'  => 'Rare; known primary cancer history',
        ],

        'management' => [
            'Thyroidectomy: Total (if >4 cm, bilateral, N1, M1) or hemithyroidectomy (low risk)',
            'RAI (I-131) ablation: ATA intermediate/high-risk post-thyroidectomy',
            'TSH suppression: Levothyroxine (T4); target TSH per risk (<0.1 high-risk)',
            'Surveillance: Tg + anti-Tg q6–12mo; neck USS annually',
            'Medullary: Total thyroidectomy + central dissection; no RAI; genetic counselling (RET)',
        ],

        'symptom_weights' => [
            'goiter'           => 3,
            'hoarseness'       => 3,
            'dysphagia'        => 2,
            'lymphadenopathy'  => 3,
            'weight_loss'      => 1,
            'neck_mass'        => 3,
            'tracheal_pressure'=> 2,
        ],
        'symptom_map' => ['goiter','hoarseness','dysphagia','lymphadenopathy','weight_loss','neck_mass','tracheal_pressure'],
    ],

    'subclinical_hypothyroidism' => [
        'id'               => 'subclinical_hypothyroidism',
        'name'             => 'Subclinical Hypothyroidism',
        'organ'            => 'Thyroid',
        'clinical_pattern' => 'Elevated TSH + Normal Free T4 + Mild/No Symptoms',
        'priority'         => 'moderate',
        'icd10'            => 'E02',
        'guideline_ref'    => 'Endocrine Society CPG — Subclinical Hypothyroidism in Non-Pregnant Adults, JCEM 2015',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/25913605/',

        'age_range'   => [30, 75],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '4–8% of general population; up to 20% in women >60 years',
            'age'        => 'Increases with age; common post-menopausal',
            'gender'     => 'Female:male = 8:1',
            'cause'      => 'Hashimoto thyroiditis, post-RAI, post-surgery, iodine, medications',
        ],

        'pathophysiology' => 'Reduced thyroid hormone secretion (early/compensated failure) → pituitary senses low T4 → TSH rises to maintain normal peripheral T4 → compensated state. Risk of progression to overt hypothyroidism ~4% per year (higher with anti-TPO positivity).',

        'key_symptoms' => [
            'Often Asymptomatic'  => 'Majority; found incidentally on screening',
            'Mild Symptoms'       => 'Fatigue, cold intolerance, constipation, dry skin (non-specific)',
            'Dyslipidemia'        => 'LDL elevation (TSH > 10)',
            'Pregnancy Risk'      => 'Impaired fetal brain development if untreated in pregnant women',
        ],

        'lab_findings' => [
            ['test' => 'TSH',        'value' => '4.5–10 mIU/L (mild); >10 (severe)',   'direction' => 'high'],
            ['test' => 'Free T4',    'value' => 'Normal (0.8–1.8 ng/dL)',               'direction' => 'low'],
            ['test' => 'Anti-TPO',   'value' => 'Elevated in Hashimoto (positive in 80%)', 'direction' => 'high'],
            ['test' => 'Lipid Panel','value' => 'LDL elevated if TSH > 10',             'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'TSH 4.5–10 with normal FT4: confirm with repeat in 2–3 months',
            'Step 2' => 'Anti-TPO Ab: predicts progression (TPO+ = 4–8%/year progression)',
            'Step 3' => 'Treat if: TSH > 10, symptoms, pregnancy planned, age < 65, dyslipidemia',
            'Step 4' => 'In elderly (>70 yrs): TSH 7–10 may be physiological — treat only if symptomatic',
            'Step 5' => 'Annual TSH monitoring if not treated',
        ],

        'differential_diagnosis' => [
            'Laboratory error'         => 'Repeat TSH before treating',
            'Recovery from sick euthyroid' => 'Transient elevation; re-check in 6 weeks',
            'Overt hypothyroidism'     => 'Low FT4; clear clinical features',
            'Drug effect'              => 'Amiodarone, lithium, sunitinib, immune checkpoint inhibitors',
        ],

        'management' => [
            'Levothyroxine: Start if TSH > 10, symptomatic, or pregnant/planning',
            'Starting dose: 25–50 mcg/day (lower in elderly/cardiac patients)',
            'Target TSH: 0.5–2.5 mIU/L (younger adults); 1–4 mIU/L (elderly)',
            'Monitor TSH 6–8 weeks after dose change, then annually once stable',
            'Observation: Annual TSH if asymptomatic + TSH 4.5–10 + TPO negative',
        ],

        'symptom_weights' => [
            'fatigue'         => 2,
            'cold_intolerance'=> 2,
            'constipation'    => 1,
            'dry_skin'        => 1,
            'weight_gain'     => 1,
            'bradycardia'     => 1,
            'depression'      => 1,
        ],
        'symptom_map' => ['fatigue','cold_intolerance','constipation','dry_skin','weight_gain','bradycardia','depression'],
    ],

    'multiple_endocrine_neoplasia_type1' => [
        'id'               => 'multiple_endocrine_neoplasia_type1',
        'name'             => 'Multiple Endocrine Neoplasia Type 1 (MEN1)',
        'organ'            => 'Parathyroid / Pituitary / Pancreas',
        'clinical_pattern' => '3 P\'s: Parathyroid + Pituitary + Pancreatic Tumors + MEN1 Gene Mutation',
        'priority'         => 'high',
        'icd10'            => 'D44.8',
        'guideline_ref'    => 'Endocrine Society CPG — Multiple Endocrine Neoplasia Type 1, JCEM 2012',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/22723327/',

        'age_range'   => [20, 50],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => '1:30,000; autosomal dominant; high penetrance',
            'age'        => 'Parathyroid manifestations by age 50 in 95%; pancreatic by 40; pituitary by 30',
            'gender'     => 'Equal; autosomal dominant',
            'cause'      => 'Germline MEN1 tumor suppressor gene mutation (11q13); 90% penetrance by age 50',
        ],

        'pathophysiology' => 'MEN1 (menin) is a tumor suppressor → loss of function → hyperplasia and adenoma formation in parathyroid (95%), enteropancreatic islet cells (gastrinoma most common, 40%), pituitary (prolactinoma most common, 20%), adrenal, foregut carcinoids.',

        'key_symptoms' => [
            'Hyperparathyroidism (95%)' => 'Hypercalcemia symptoms; multi-gland disease',
            'ZES / Gastrinoma'          => 'Refractory peptic ulcer, diarrhea, Zollinger-Ellison syndrome',
            'Insulinoma'                => 'Hypoglycemia; Whipple\'s triad',
            'Pituitary (20%)'           => 'Prolactinoma (most common), acromegaly, Cushing\'s',
        ],

        'lab_findings' => [
            ['test' => 'Serum Calcium',     'value' => '> 10.5 mg/dL',                    'direction' => 'high'],
            ['test' => 'Intact PTH',        'value' => 'Elevated',                         'direction' => 'high'],
            ['test' => 'Fasting Gastrin',   'value' => '> 1000 pg/mL (ZES diagnostic)',    'direction' => 'high'],
            ['test' => 'Serum Prolactin',   'value' => 'Elevated (if prolactinoma)',        'direction' => 'high'],
            ['test' => 'IGF-1',             'value' => 'Elevated (if acromegaly)',          'direction' => 'high'],
            ['test' => 'Fasting Glucose',   'value' => 'Low (insulinoma)',                 'direction' => 'low'],
            ['test' => 'Chromogranin A',    'value' => 'Elevated (neuroendocrine marker)', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Clinical diagnosis: 2 of 3 MEN1 tumors OR 1 tumor + family history',
            'Step 2' => 'Genetic testing: MEN1 germline mutation (menin gene)',
            'Step 3' => 'Biochemical screening: Ca, PTH, gastrin, PRL, IGF-1, fasting glucose, CgA',
            'Step 4' => 'Imaging: MRI pituitary; CT/MRI pancreas/abdomen; parathyroid sestamibi',
            'Step 5' => 'Family screening: first-degree relatives from age 5–10 years',
        ],

        'differential_diagnosis' => [
            'Sporadic PHPT'          => 'Single-gland; MEN1 mutation negative',
            'MEN2'                   => 'Medullary thyroid cancer + pheo + PHPT; RET mutation',
            'MEN4'                   => 'CDKN1B mutation; PHPT + pituitary',
            'Sporadic gastrinoma'    => 'No family history; no other MEN1 features',
        ],

        'management' => [
            'PHPT: Subtotal parathyroidectomy (3.5 glands) or total parathyroidectomy + auto-transplant',
            'Gastrinoma: High-dose PPI; surgery if localized and non-metastatic',
            'Insulinoma: Surgical resection; diazoxide for unresectable',
            'Pituitary: Dopamine agonist (prolactinoma); somatostatin analog (acromegaly)',
            'Surveillance: Annual biochemistry + imaging per site-specific protocol',
        ],

        'symptom_weights' => [
            'hypercalcemia'    => 3,
            'nephrolithiasis'  => 2,
            'peptic_ulcer_pain'=> 3,
            'diarrhea'         => 2,
            'hypoglycemia'     => 3,
            'headache'         => 1,
            'visual_field_defect' => 1,
            'galactorrhea'     => 1,
        ],
        'symptom_map' => ['hypercalcemia','nephrolithiasis','peptic_ulcer_pain','diarrhea','hypoglycemia','headache','visual_field_defect','galactorrhea'],
    ],

    'carcinoid_syndrome' => [
        'id'               => 'carcinoid_syndrome',
        'name'             => 'Carcinoid Syndrome (Neuroendocrine Tumor)',
        'organ'            => 'GI / Lung / Neuroendocrine',
        'clinical_pattern' => 'Episodic Flushing + Diarrhea + Bronchospasm + Elevated 5-HIAA',
        'priority'         => 'high',
        'icd10'            => 'E34.0',
        'guideline_ref'    => 'Endocrine Society CPG — Neuroendocrine Tumors, JCEM 2015',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26502395/',

        'age_range'   => [40, 70],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => 'NETs: 6.98/100,000; carcinoid syndrome in 10% of NETs (liver mets required)',
            'age'        => 'Peak 50–70 years',
            'gender'     => 'Slightly more common in women',
            'site'       => 'Small intestine (40%), rectum (15%), lung (10%), appendix (10%)',
        ],

        'pathophysiology' => 'Neuroendocrine tumor (enterochromaffin cells) → serotonin, histamine, bradykinin, tachykinins → when liver metastases present → bypass first-pass hepatic metabolism → systemic circulation → flushing (bradykinin/prostaglandins), diarrhea (serotonin), carcinoid heart disease (serotonin → tricuspid/pulmonary valve fibrosis).',

        'key_symptoms' => [
            'Episodic Flushing' => 'Face/neck; dry, warm; triggered by alcohol, food, stress; seconds to minutes',
            'Diarrhea'          => 'Secretory; watery; ≥ 4 stools/day; no nocturnal',
            'Wheezing'          => 'Bronchospasm (histamine/bradykinin-mediated)',
            'Carcinoid Heart Disease' => 'Right-sided valvular lesions (Hedinger syndrome) — late feature',
            'Pellagra-like symptoms'  => 'Dermatitis, dementia, diarrhea (niacin depletion)',
        ],

        'lab_findings' => [
            ['test' => '24h Urine 5-HIAA',     'value' => '> 15 mg/day (elevated)',    'direction' => 'high'],
            ['test' => 'Plasma Chromogranin A', 'value' => '> 100 U/L',                'direction' => 'high'],
            ['test' => 'Serum Serotonin',       'value' => '> 200 ng/mL',              'direction' => 'high'],
            ['test' => 'Plasma Neurokinin A',   'value' => 'Elevated (poor prognosis)', 'direction' => 'high'],
            ['test' => 'BNP / NT-proBNP',       'value' => 'Elevated if cardiac involvement', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => '24h urine 5-HIAA (avoid serotonin-rich foods 3 days prior)',
            'Step 2' => 'Plasma CgA (elevated in >80% NETs; affected by PPI use)',
            'Step 3' => 'Imaging: CT chest/abdomen/pelvis; somatostatin receptor scintigraphy (DOTATE PET)',
            'Step 4' => 'Echocardiography: assess carcinoid heart disease',
            'Step 5' => 'Tissue biopsy for grade (Ki-67 index) and Ki67-based classification (G1/G2/G3)',
        ],

        'differential_diagnosis' => [
            'Mastocytosis'       => 'Urticaria pigmentosa; tryptase elevated',
            'VIPoma'             => 'Profuse watery diarrhea; VIP elevated; no flushing',
            'Pheochromocytoma'   => 'Paroxysmal hypertension; catecholamines elevated',
            'Medullary thyroid cancer' => 'Calcitonin elevated; RET mutation',
        ],

        'management' => [
            'Somatostatin analogs: Octreotide LAR or lanreotide (first-line; symptom control + anti-tumor)',
            'PRRT (177Lu-DOTATATE): For SST receptor-positive, progressive NET',
            'Surgical resection: If localised or liver debulking possible',
            'Carcinoid crisis prevention: Octreotide 500 mcg IV before any surgery/procedure',
            'Everolimus or sunitinib: For advanced NETs refractory to SSA',
        ],

        'symptom_weights' => [
            'flushing'       => 3,
            'diarrhea'       => 3,
            'wheezing'       => 2,
            'abdominal_pain' => 2,
            'weight_loss'    => 1,
            'tachycardia'    => 1,
            'chest_pain'     => 1,
        ],
        'symptom_map' => ['flushing','diarrhea','wheezing','abdominal_pain','weight_loss','tachycardia','chest_pain'],
    ],

    'insulinoma' => [
        'id'               => 'insulinoma',
        'name'             => 'Insulinoma (Endogenous Hyperinsulinism)',
        'organ'            => 'Pancreas (Beta Cell)',
        'clinical_pattern' => 'Whipple\'s Triad: Hypoglycemia + Neuroglycopenic Symptoms + Relief with Glucose',
        'priority'         => 'emergency',
        'icd10'            => 'D13.7',
        'guideline_ref'    => 'Endocrine Society CPG — Hypoglycemic Disorders, JCEM 2009',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/19088155/',

        'age_range'   => [30, 60],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '4 per 1 million population per year; most common pancreatic NET',
            'age'        => '40–60 years; 10% MEN1 association',
            'gender'     => 'Female predominance (60%)',
            'cause'      => 'Benign solitary adenoma in 90%; malignant in 10%; MEN1 (5–10%)',
        ],

        'pathophysiology' => 'Beta-cell tumor → autonomous insulin secretion → hypoglycemia → Whipple\'s triad. Counter-regulatory response (glucagon, epinephrine) → adrenergic symptoms. Chronic hypoglycemia → neuroglycopenia → cognitive symptoms, seizures.',

        'key_symptoms' => [
            'Neuroglycopenic'  => 'Confusion, amnesia, bizarre behavior, seizures, unconsciousness',
            'Adrenergic'       => 'Sweating, palpitations, tremor, anxiety (can be absent in chronic cases)',
            'Timing'           => 'Fasting episodes; worse with exercise; occur in early morning',
            'Paradoxical Weight Gain' => 'Due to frequent food intake to prevent hypoglycemia',
        ],

        'lab_findings' => [
            ['test' => 'Fasting Glucose',    'value' => '< 55 mg/dL during episode',     'direction' => 'low'],
            ['test' => 'Serum Insulin',      'value' => '≥ 3 µIU/mL during hypoglycemia', 'direction' => 'high'],
            ['test' => 'C-Peptide',          'value' => '≥ 0.6 ng/mL during hypoglycemia','direction' => 'high'],
            ['test' => 'Proinsulin',         'value' => '≥ 5 pmol/L',                    'direction' => 'high'],
            ['test' => 'Beta-hydroxybutyrate','value' => '< 2.7 mmol/L (suppressed)',    'direction' => 'low'],
            ['test' => 'Sulfonylurea screen', 'value' => 'Negative (to exclude exogenous)', 'direction' => 'low'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => '72-hour supervised fast in hospital; monitor glucose q4-6h',
            'Step 2' => 'At glucose < 55 mg/dL: glucose + insulin + C-peptide + proinsulin + beta-OH-butyrate',
            'Step 3' => 'Confirm Whipple\'s triad; sulfonylurea screen to exclude factitious',
            'Step 4' => 'Localisation: CT/MRI pancreas; endoscopic USS (EUS — 90% sensitivity)',
            'Step 5' => 'Selective arterial calcium stimulation if imaging negative',
        ],

        'differential_diagnosis' => [
            'Factitious hypoglycemia (insulin/SU)' => 'Low C-peptide (insulin); SU screen positive',
            'Non-insulinoma pancreatogenous hypoglycemia (NIPHS)' => 'Post-prandial; diffuse beta-cell hyperplasia',
            'Adrenal insufficiency' => 'Low cortisol; elevated ACTH; no insulin excess',
            'IGF-2 secreting tumor'  => 'Large mesenchymal tumor; low insulin; low GH/IGF-1',
        ],

        'management' => [
            'Definitive: Surgical enucleation or distal pancreatectomy (if localised)',
            'Medical bridge: Diazoxide 150–400 mg/day; frequent small meals',
            'Everolimus: For unresectable/malignant insulinoma',
            'Octreotide: Only if somatostatin receptor-positive (can worsen hypoglycemia)',
            'Intraoperative USS to locate small adenomas',
        ],

        'symptom_weights' => [
            'hypoglycemia'   => 3,
            'sweating'       => 3,
            'confusion'      => 3,
            'tremor'         => 2,
            'palpitations'   => 2,
            'seizure'        => 2,
            'weight_gain'    => 1,
            'anxiety'        => 1,
        ],
        'symptom_map' => ['hypoglycemia','sweating','confusion','tremor','palpitations','seizure','weight_gain','anxiety'],
    ],

    'thyroiditis_subacute' => [
        'id'               => 'thyroiditis_subacute',
        'name'             => 'Subacute (De Quervain\'s) Thyroiditis',
        'organ'            => 'Thyroid',
        'clinical_pattern' => 'Painful Thyroid + Transient Hyperthyroidism → Hypothyroidism + Elevated ESR',
        'priority'         => 'moderate',
        'icd10'            => 'E06.1',
        'guideline_ref'    => 'Endocrine Society / ATA CPG — Thyroiditis, JCEM 2019',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/31436804/',

        'age_range'   => [20, 50],
        'gender_bias' => 'female',

        'epidemiology' => [
            'prevalence' => '4.9 per 100,000 person-years; seasonal clusters',
            'age'        => 'Most common 30–50 years',
            'gender'     => 'Female:male = 3–4:1',
            'cause'      => 'Post-viral (Coxsackievirus, Adenovirus, Mumps, COVID-19); HLA-B35 association',
        ],

        'pathophysiology' => 'Viral infection → granulomatous inflammation of thyroid → follicular destruction → thyroid hormone leak → transient hyperthyroidism (weeks) → gland exhaustion → transient hypothyroidism → recovery in 85–90%. 10–15% develop permanent hypothyroidism.',

        'key_symptoms' => [
            'Thyroid Pain'           => 'Pathognomonic; anterior neck; radiates to jaw/ear; exquisite tenderness',
            'Phase 1 (Thyrotoxic)'   => 'Palpitations, heat intolerance, weight loss, anxiety (2–8 weeks)',
            'Phase 2 (Hypothyroid)'  => 'Fatigue, cold intolerance, weight gain, constipation (weeks–months)',
            'Phase 3 (Recovery)'     => 'Euthyroid; 85–90% recover; preceded by viral URTI',
            'Systemic'               => 'Fever, malaise, sore throat prodrome',
        ],

        'lab_findings' => [
            ['test' => 'TSH',           'value' => 'Low (thyrotoxic phase); High (hypothyroid phase)', 'direction' => 'low'],
            ['test' => 'Free T4',       'value' => 'Elevated (thyrotoxic); Low (hypothyroid)',          'direction' => 'high'],
            ['test' => 'ESR',           'value' => '> 50 mm/hr (often > 100)',                         'direction' => 'high'],
            ['test' => 'CRP',           'value' => 'Markedly elevated',                                'direction' => 'high'],
            ['test' => 'Thyroid RAI Uptake', 'value' => '< 2% (key: suppressed in active phase)',     'direction' => 'low'],
            ['test' => 'Anti-TPO/TG',   'value' => 'Usually negative or transiently mildly positive', 'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Clinical: painful thyroid + TSH suppressed + elevated ESR/CRP',
            'Step 2' => 'RAI uptake: < 2% distinguishes from Graves\' (> 25%) — critical step',
            'Step 3' => 'Thyroid USS + colour Doppler: hypoechoic painful areas; reduced vascularity',
            'Step 4' => 'FNA only if needed to exclude malignancy (rarely needed)',
            'Step 5' => 'TSH monitoring: 4–6 weekly until euthyroid; annually for life (5–10% permanent hypothyroidism)',
        ],

        'differential_diagnosis' => [
            'Graves\' Disease'       => 'No pain; RAI uptake elevated; TRAb positive',
            'Suppurative thyroiditis'=> 'Bacterial; fever; abscess; neutrophilia; rare',
            'Hashimoto thyroiditis'  => 'Painless; anti-TPO high; RAI normal',
            'Thyroid hemorrhage'     => 'Into nodule; sudden pain; USS diagnostic',
        ],

        'management' => [
            'Pain: NSAIDs (aspirin/ibuprofen) for mild-moderate; prednisone 40 mg/day if severe',
            'Thyrotoxic phase: Beta-blocker (propranolol) for symptom relief; NO antithyroid drugs (no synthesis)',
            'Hypothyroid phase: Levothyroxine if symptomatic or TSH > 10 (usually temporary)',
            'Do NOT give RAI or antithyroid drugs (thyrotoxicosis is destructive, not synthetic)',
            'Monitor TSH 6 weeks, 3 months, 6 months, then annually',
        ],

        'symptom_weights' => [
            'thyroid_pain'    => 3,
            'fever'           => 2,
            'tachycardia'     => 2,
            'heat_intolerance'=> 2,
            'palpitations'    => 2,
            'fatigue'         => 1,
            'weight_loss'     => 1,
            'cold_intolerance'=> 1,
        ],
        'symptom_map' => ['thyroid_pain','fever','tachycardia','heat_intolerance','palpitations','fatigue','weight_loss','cold_intolerance'],
    ],

    'central_hypothyroidism' => [
        'id'               => 'central_hypothyroidism',
        'name'             => 'Central Hypothyroidism (Secondary/Tertiary)',
        'organ'            => 'Pituitary / Hypothalamus',
        'clinical_pattern' => 'Low Free T4 + Low/Normal TSH + Pituitary/Hypothalamic Pathology',
        'priority'         => 'high',
        'icd10'            => 'E03.1',
        'guideline_ref'    => 'Endocrine Society CPG — Hypopituitarism, JCEM 2016',
        'guideline_url'    => 'https://pubmed.ncbi.nlm.nih.gov/26649180/',

        'age_range'   => [20, 65],
        'gender_bias' => 'neutral',

        'epidemiology' => [
            'prevalence' => '1:80,000–120,000; accounts for ~5% of all hypothyroidism',
            'age'        => 'Any age depending on cause',
            'gender'     => 'Depends on etiology',
            'cause'      => 'Pituitary adenoma, craniopharyngioma, Sheehan syndrome, radiation, TBI, pituitary surgery',
        ],

        'pathophysiology' => 'Deficient TSH secretion (pituitary) or TRH secretion (hypothalamus) → inadequate TSH → reduced T4/T3 synthesis. TSH may be structurally abnormal (biologically inactive) → normal or mildly elevated immunoassay TSH despite low T4. Associated with other pituitary hormone deficiencies.',

        'key_symptoms' => [
            'Hypothyroid Features'    => 'Fatigue, cold intolerance, constipation, weight gain, dry skin',
            'Often Milder'            => 'Less severe than primary hypothyroidism',
            'Mass Effect'             => 'Headache, visual field defects from pituitary tumor',
            'Other Pituitary Deficiencies' => 'Hypogonadism, GH deficiency, adrenal insufficiency, DI',
            'Sheehan Syndrome'        => 'Postpartum hemorrhage → pituitary infarction',
        ],

        'lab_findings' => [
            ['test' => 'Free T4',      'value' => 'Low (< 0.8 ng/dL) — key diagnostic',             'direction' => 'low'],
            ['test' => 'TSH',          'value' => 'Low, normal, or mildly elevated (< 5); not elevated > 10', 'direction' => 'low'],
            ['test' => 'Cortisol (8 AM)', 'value' => 'May be low (co-existing ACTH deficiency)',    'direction' => 'low'],
            ['test' => 'LH/FSH',       'value' => 'May be low (hypogonadotropic hypogonadism)',     'direction' => 'low'],
            ['test' => 'IGF-1',        'value' => 'May be low (GH deficiency)',                     'direction' => 'low'],
            ['test' => 'Prolactin',    'value' => 'May be elevated (stalk compression)',            'direction' => 'high'],
        ],

        'diagnostic_algorithm' => [
            'Step 1' => 'Low FT4 + low/normal TSH (not elevated): diagnose central hypothyroidism',
            'Step 2' => 'Full pituitary panel: cortisol, ACTH, LH, FSH, testosterone/estradiol, IGF-1, PRL',
            'Step 3' => 'MRI pituitary (gadolinium enhanced): structural cause',
            'Step 4' => 'TRH stimulation test (if available) to distinguish pituitary vs hypothalamic',
            'Step 5' => 'Assess ACTH/cortisol BEFORE starting LT4 (can precipitate adrenal crisis)',
        ],

        'differential_diagnosis' => [
            'Primary hypothyroidism'      => 'TSH elevated > 10; no pituitary pathology',
            'Euthyroid sick syndrome'     => 'Low T4 in critical illness; TSH variable; transient',
            'Drug effect (dopamine, steroids)' => 'Medication review; TSH suppressed',
            'Subclinical hypothyroidism'  => 'TSH 4.5–10; normal FT4',
        ],

        'management' => [
            'CRITICAL: Rule out and treat ACTH deficiency BEFORE starting LT4',
            'Levothyroxine: Titrate to FT4 in upper half of reference range (NOT by TSH)',
            'Starting dose: 25–50 mcg/day (increase cautiously in elderly/cardiac)',
            'Monitor FT4 (not TSH) for dose adjustment, every 6–8 weeks',
            'Address all pituitary hormone deficiencies comprehensively',
        ],

        'symptom_weights' => [
            'fatigue'         => 3,
            'cold_intolerance'=> 2,
            'weight_gain'     => 2,
            'headache'        => 2,
            'visual_field_defect' => 2,
            'libido_loss'     => 2,
            'constipation'    => 1,
            'dry_skin'        => 1,
            'bradycardia'     => 1,
        ],
        'symptom_map' => ['fatigue','cold_intolerance','weight_gain','headache','visual_field_defect','libido_loss','constipation','dry_skin','bradycardia'],
    ],

];

// ─────────────────────────────────────────────────────────────────
// CORE MATCHING ENGINE v3.0 — Weighted scoring + Demographic boost
// ─────────────────────────────────────────────────────────────────

function findDiagnosesBySymptoms(array $selectedSymptoms, int $patientAge = 0, string $patientGender = ''): array {
    global $patterns;
    if (empty($selectedSymptoms)) return [];

    $results = [];

    foreach ($patterns as $patternId => $pattern) {
        $weights    = $pattern['symptom_weights'] ?? [];
        $symptomMap = $pattern['symptom_map'] ?? [];
        if (empty($symptomMap)) continue;

        $maxScore = array_sum($weights);
        if ($maxScore === 0) continue;

        $scored      = 0;
        $matchedList = [];
        $missedList  = [];

        foreach ($symptomMap as $symptom) {
            $w = $weights[$symptom] ?? 1;
            if (in_array($symptom, $selectedSymptoms, true)) {
                $scored += $w;
                $matchedList[] = $symptom;
            } else {
                $missedList[] = $symptom;
            }
        }

        if ($scored === 0) continue;

        $matchPct = round(($scored / $maxScore) * 100);

        // Demographic boost (max +10%)
        $demoBoost = 0;
        if ($patientAge > 0) {
            $ageRange = $pattern['age_range'] ?? [0, 100];
            if ($patientAge >= $ageRange[0] && $patientAge <= $ageRange[1]) {
                $demoBoost += 5;
            }
        }
        if (!empty($patientGender) && !empty($pattern['gender_bias'])) {
            if ($pattern['gender_bias'] === $patientGender || $pattern['gender_bias'] === 'none') {
                $demoBoost += 5;
            }
        }

        $adjustedPct = min(100, $matchPct + $demoBoost);

        // Confidence level
        if ($adjustedPct >= 75) $confidence = 'High';
        elseif ($adjustedPct >= 50) $confidence = 'Moderate';
        else $confidence = 'Low';

        $cardinalHits = 0;
        foreach ($matchedList as $s) {
            if (($weights[$s] ?? 0) >= 3) $cardinalHits++;
        }

        $results[] = array_merge($pattern, [
            'match_score'       => $scored,
            'max_score'         => $maxScore,
            'match_percentage'  => $adjustedPct,
            'base_percentage'   => $matchPct,
            'demo_boost'        => $demoBoost,
            'confidence'        => $confidence,
            'cardinal_hits'     => $cardinalHits,
            'matching_symptoms' => $matchedList,
            'missing_symptoms'  => $missedList,
        ]);
    }

    usort($results, function($a, $b) {
        if ($b['cardinal_hits'] !== $a['cardinal_hits']) {
            return $b['cardinal_hits'] <=> $a['cardinal_hits'];
        }
        return $b['match_percentage'] <=> $a['match_percentage'];
    });

    return $results;
}

function filterPatterns(array $patterns, $search = '', $symptoms = []): array {
    $filtered = [];
    foreach ($patterns as $id => $pattern) {
        if ($search) {
            $text = strtolower($pattern['name'] . ' ' . $pattern['clinical_pattern'] . ' ' . $pattern['organ']);
            if (strpos($text, strtolower($search)) === false) continue;
        }
        if (!empty($symptoms)) {
            $overlap = array_intersect($symptoms, $pattern['symptom_map'] ?? []);
            if (empty($overlap)) continue;
        }
        $filtered[$id] = $pattern;
    }
    return $filtered;
}

function getPatternById(string $id): ?array {
    global $patterns;
    return $patterns[$id] ?? null;
}
?>
