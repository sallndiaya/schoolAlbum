<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $stmt = $pdo->prepare("DELETE FROM personnels WHERE id = ?");
        $stmt->execute([$data['id']]);

        echo json_encode(['success' => true, 'message' => 'Élève supprimé avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID manquant']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur interne : ' . $e->getMessage()]);
}
?>
