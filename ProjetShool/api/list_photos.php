<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

$school = $_POST['school'] ?? null;
$class = $_POST['class'] ?? null;

if (!$school || !$class) {
    echo json_encode(['error' => 'École ou classe non spécifiée']);
    exit;
}

// Construire le chemin du répertoire
$directory = "uploads/" . rawurlencode($school) . "/" . rawurlencode($class);

if (!is_dir($directory)) {
    echo json_encode(['error' => 'Répertoire introuvable']);
    exit;
}

// Lister les fichiers dans le répertoire
$photos = [];
foreach (scandir($directory) as $file) {
    if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|png|jpeg|gif)$/i', $file)) {
        $photos[] = [
            'url' => "http://localhost/ProjetShool/api/" . $directory . "/" . $file,
            'filename' => $file
        ];
    }
}

echo json_encode(['photos' => $photos]);


