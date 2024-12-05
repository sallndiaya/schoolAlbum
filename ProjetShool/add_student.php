<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


ob_start(); // Commence un tampon de sortie

try {
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['firstName'], $data['lastName'], $data['schoolId'], $data['classId'])) {
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $schoolId = $data['schoolId'];
        $classId = $data['classId'];

        $stmt = $pdo->prepare("INSERT INTO students (prenom, nom, ecole_id, classe_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $schoolId, $classId]);

        ob_clean(); // Nettoie le tampon de sortie
        echo json_encode(['success' => true, 'message' => 'Élève ajouté avec succès']);
    } else {
        ob_clean(); // Nettoie le tampon de sortie
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
    }
} catch (Exception $e) {
    ob_clean(); // Nettoie le tampon de sortie
    echo json_encode(['success' => false, 'message' => 'Erreur interne : ' . $e->getMessage()]);
}

ob_end_flush(); // Ferme le tampon de sortie
?>
