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
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", ""); // Mettez ici vos identifiants
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données envoyées en JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['schoolId']) && isset($data['name'])) {
        $schoolId = $data['schoolId'];
        $name = $data['name'];

        // Préparation et exécution de la requête SQL
        $sql = "INSERT INTO classes (ecole_id, nom) VALUES (?, ?)"; // Adaptez "ecole_id" au nom exact de votre colonne
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$schoolId, $name]);

        // Réponse en cas de succès
        echo json_encode(['success' => true, 'message' => 'Classe ajoutée avec succès']);
    } else {
        // Si les paramètres sont manquants
        echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo json_encode(['success' => false, 'message' => 'Erreur interne du serveur : ' . $e->getMessage()]);
}
?>
