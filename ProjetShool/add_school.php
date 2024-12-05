
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Inclure la connexion à la base de données
require 'db.php';

// Vérifier si la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées depuis le frontend
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data['nom'])) {
        $schoolName = $data['nom'];

        // Préparer et exécuter la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO ecoles (nom) VALUES (:nom)");
        $stmt->bindParam(':nom', $schoolName, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Réponse en cas de succès
            echo json_encode(['success' => true, 'message' => 'École ajoutée avec succès.']);
        } else {
            // Réponse en cas d'échec
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'école.']);
        }
    } else {
        // Réponse en cas de données invalides
        echo json_encode(['success' => false, 'message' => 'Nom de l\'école requis.']);
    }
} else {
    // Réponse si la méthode n'est pas POST
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
?>



