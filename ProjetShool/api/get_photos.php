<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type");



require 'db.php';

$schoolId = $_GET['school_id'] ?? null;
$classId = $_GET['class_id'] ?? null;

if (!$schoolId || !$classId) {
    echo json_encode(['error' => 'Paramètres manquants.']);
    exit;
}

// Récupérer les noms de l'école et de la classe
$schoolName = $pdo->query("SELECT nom FROM ecoles WHERE id = $schoolId")->fetchColumn();
$className = $pdo->query("SELECT nom FROM classes WHERE id = $classId")->fetchColumn();

$directory = "uploads/" . rawurlencode($schoolName) . "/" . rawurlencode($className) . "/data.json";

if (file_exists($directory)) {
    $students = json_decode(file_get_contents($directory), true);
    foreach ($students as &$student) {
        $student['url'] = "http://localhost/ProjetShool/api/uploads/" . rawurlencode($schoolName) . "/" . rawurlencode($className) . "/" . $student['photo'];
    }
    echo json_encode($students);
} else {
    echo json_encode([]);
}





?>
