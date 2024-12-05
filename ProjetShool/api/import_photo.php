<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Connexion à la base de données
include 'db.php';

// Vérification des paramètres nécessaires
if (isset($_FILES['image']) && isset($_POST['school_id']) && isset($_POST['class_id'])) {
    $school_id = $_POST['school_id'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    // Vérifier que le fichier est bien une image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        echo json_encode(['error' => 'Type de fichier non autorisé.']);
        exit;
    }

    // Créer le dossier de destination si nécessaire
    $targetDir = "uploads/ecole/$school_id/$class_id/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Déplacer l'image vers le dossier cible
    $targetFile = $targetDir . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        echo json_encode(['success' => 'Image importée avec succès.']);
    } else {
        echo json_encode(['error' => 'Échec de l\'importation de l\'image.']);
    }
} else {
    echo json_encode(['error' => 'Paramètres manquants.']);
}
?>
