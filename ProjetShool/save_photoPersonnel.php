<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'db.php';

$school_id = $_POST['school_id'] ?? null;
$personnel_prenom = $_POST['personnel_prenom'] ?? null; 
$personnel_nom = $_POST['personnel_nom'] ?? null;   
$personnel_poste = $_POST['personnel_poste'] ?? null;   
$imported_photo = $_FILES['imported_photo'] ?? null;

if (!is_numeric($school_id) || !$personnel_prenom || !$personnel_nom || !$personnel_poste || !$imported_photo) {
    echo json_encode(['error' => 'Paramètres invalides ou manquants.']);
    exit;
}

$stmt = $pdo->prepare("SELECT nom FROM ecoles WHERE id = :school_id");
$stmt->execute(['school_id' => $school_id]);
$school_nom = $stmt->fetchColumn();

if (!$school_nom) {
    echo json_encode(['error' => 'École introuvable.']);
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($imported_photo['type'], $allowedTypes)) {
    echo json_encode(['error' => 'Type de fichier non autorisé.']);
    exit;
}

$targetDir = "uploads/$school_nom/";
if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true)) {
    echo json_encode(['error' => 'Impossible de créer le dossier cible.']);
    exit;
}

$uniqueId = uniqid();
$fileExtension = pathinfo($imported_photo['name'], PATHINFO_EXTENSION);
$targetFile = $targetDir . $personnel_prenom . '_' . $personnel_nom . '_' . $personnel_poste .  '.' . $fileExtension;

if (!move_uploaded_file($imported_photo['tmp_name'], $targetFile)) {
    echo json_encode(['error' => 'Erreur lors de l\'importation de l\'image.']);
    exit;
}

$jsonFile = "uploads/$school_nom/datas.json";
$data = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) ?? [] : [];

$newEntry = [
    'firstname' => $personnel_prenom,
    'lastname' => $personnel_nom,
    'poste' => $personnel_poste,
    'photo' => basename($targetFile)
];
$data[] = $newEntry;

if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT)) === false) {
    echo json_encode(['error' => 'Erreur lors de l\'écriture du fichier JSON.']);
    exit;
}

echo json_encode(['success' => 'Image importée avec succès.']);
?>
