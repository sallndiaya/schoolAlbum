<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Connexion à la base de données
include 'db.php';

// Récupération des paramètres
$school_id = $_POST['school_id'] ?? null;
$class_id = $_POST['class_id'] ?? null;
$student_prenom = $_POST['student_prenom'] ?? null; // Prénom de l'élève
$student_nom = $_POST['student_nom'] ?? null;   // Nom de l'élève
$imported_photo = $_FILES['imported_photo'] ?? null;

// Vérification si les paramètres nécessaires sont présents
if (!$school_id || !$class_id || !$student_prenom || !$student_nom || !$imported_photo) {
    echo json_encode(['error' => 'Paramètres manquants.']);
    exit;
}

// Récupérer les noms de l'école et de la classe
$school_nom = $pdo->query("SELECT nom FROM ecoles WHERE id = $school_id")->fetchColumn();
$class_nom = $pdo->query("SELECT nom FROM classes WHERE id = $class_id")->fetchColumn();

// Vérification si l'école ou la classe n'a pas été trouvée
if (!$school_nom || !$class_nom) {
    echo json_encode(['error' => 'École ou classe introuvable.']);
    exit;
}

// Vérification du type de fichier (image)
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($imported_photo['type'], $allowedTypes)) {
    echo json_encode(['error' => 'Type de fichier non autorisé.']);
    exit;
}

// Création du dossier avec les noms de l'école et de la classe
$targetDir = "uploads/$school_nom/$class_nom/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true); // Crée le dossier avec les bonnes permissions
}

// Renommage du fichier avec le prénom et nom de l'élève
$fileExtension = pathinfo($imported_photo['name'], PATHINFO_EXTENSION); // Récupère l'extension du fichier
$targetFile = $targetDir . $student_prenom . '_' . $student_nom . '.' . $fileExtension;


// Déplacement de l'image vers le dossier cible
if (move_uploaded_file($imported_photo['tmp_name'], $targetFile)) {
    echo json_encode(['success' => 'Image importée avec succès.']);
} else {
    echo json_encode(['error' => 'Échec de l\'importation de l\'image.']);
}

// Chemin du fichier JSON
$jsonFile = "uploads/$school_nom/$class_nom/data.json";

// Charger les données existantes (s'il y en a)
$data = [];
if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true) ?? [];
}

// Ajouter les nouvelles informations
$newEntry = [
    'firstname' => $student_prenom,
    'lastname' => $student_nom,
    'photo' => basename($targetFile)
];
$data[] = $newEntry;

// Sauvegarder les données dans le fichier JSON
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

?>
