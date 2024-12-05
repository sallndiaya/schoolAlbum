<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['ecole_id'])) {
        $ecole_id = intval($_GET['ecole_id']);
        $stmt = $pdo->prepare("SELECT * FROM personnels WHERE ecole_id = ?");
        $stmt->execute([$ecole_id]);
        $personnels = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'personnels' => $personnels]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètre ecole_id manquant']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur interne : ' . $e->getMessage()]);
}
