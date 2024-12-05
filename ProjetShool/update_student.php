<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'], $data['prenom'], $data['nom'], $data['ecole_id'], $data['classe_id'])) {
        $stmt = $pdo->prepare("UPDATE students SET prenom = ?, nom = ?, ecole_id = ?, classe_id = ? WHERE id = ?");
        $stmt->execute([$data['prenom'], $data['nom'], $data['ecole_id'], $data['classe_id'], $data['id']]);

        echo json_encode(['success' => true, 'message' => 'Élève mis à jour avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur interne : ' . $e->getMessage()]);
}
?>
