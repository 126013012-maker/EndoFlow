<?php
/**
 * EndoFlow v4.0 — Symptom + Lab Parameter Matching API
 * POST JSON: { "symptoms": [...], "age": 35, "gender": "female", "labs": { "tsh": 8.2, ... } }
 */

require_once 'data_patterns.php';
require_once 'data_symptoms.php';
require_once 'data_lab_parameters.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST method required']);
    exit;
}

$input            = json_decode(file_get_contents('php://input'), true);
$selectedSymptoms = array_filter(array_map('strval', (array)($input['symptoms'] ?? [])));
$patientAge       = intval($input['age'] ?? 0);
$patientGender    = strtolower(trim($input['gender'] ?? ''));
$enteredLabs      = (array)($input['labs'] ?? []);

if (empty($selectedSymptoms)) {
    echo json_encode(['error' => 'No symptoms provided', 'results' => []]);
    exit;
}

$results = findDiagnosesBySymptoms(array_values($selectedSymptoms), $patientAge, $patientGender);
$hasLabs = !empty(array_filter($enteredLabs, fn($v) => $v !== '' && $v !== null));

foreach ($results as &$r) {
    $labResult = scoreLabsForDisorder($r['id'], $enteredLabs);
    $r['lab_score']       = $labResult['score'];
    $r['lab_max_score']   = $labResult['max_score'];
    $r['matched_labs']    = $labResult['matched'];
    $r['missing_labs']    = $labResult['missing'];

    if ($hasLabs && $labResult['max_score'] > 0) {
        $labPct  = round(($labResult['score'] / $labResult['max_score']) * 100);
        $symPct  = $r['match_percentage'];
        $combined = round(($symPct * 0.60) + ($labPct * 0.40));
        $r['lab_match_percentage'] = $labPct;
        $r['combined_percentage']  = min(100, $combined);
        if ($combined >= 75)     $r['combined_confidence'] = 'High';
        elseif ($combined >= 50) $r['combined_confidence'] = 'Moderate';
        else                      $r['combined_confidence'] = 'Low';
    } else {
        $r['lab_match_percentage'] = 0;
        $r['combined_percentage']  = $r['match_percentage'];
        $r['combined_confidence']  = $r['confidence'];
    }
}
unset($r);

usort($results, function($a, $b) {
    if ($b['combined_percentage'] !== $a['combined_percentage'])
        return $b['combined_percentage'] - $a['combined_percentage'];
    return $b['cardinal_hits'] - $a['cardinal_hits'];
});

$response = [
    'count'             => count($results),
    'has_labs'          => $hasLabs,
    'selected_symptoms' => array_map('getSymptomName', array_values($selectedSymptoms)),
    'patient'           => ['age' => $patientAge, 'gender' => $patientGender],
    'results'           => array_map(function($r) {
        return [
            'id'                     => $r['id'],
            'name'                   => $r['name'],
            'organ'                  => $r['organ'],
            'priority'               => $r['priority'],
            'icd10'                  => $r['icd10'],
            'guideline_ref'          => $r['guideline_ref'],
            'guideline_url'          => $r['guideline_url'],
            'clinical_pattern'       => $r['clinical_pattern'],
            'match_percentage'       => $r['match_percentage'],
            'lab_match_percentage'   => $r['lab_match_percentage'],
            'combined_percentage'    => $r['combined_percentage'],
            'confidence'             => $r['confidence'],
            'combined_confidence'    => $r['combined_confidence'],
            'cardinal_hits'          => $r['cardinal_hits'],
            'matching_symptoms'      => $r['matching_symptoms'],
            'missing_symptoms'       => $r['missing_symptoms'],
            'matched_labs'           => $r['matched_labs'],
            'missing_labs'           => $r['missing_labs'],
            'lab_findings'           => $r['lab_findings'],
            'management'             => $r['management'],
            'differential_diagnosis' => $r['differential_diagnosis'],
        ];
    }, $results),
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
