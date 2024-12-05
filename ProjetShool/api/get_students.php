<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'db.php'; // Connexion à la base de données

if (isset($_GET['classe_id'])) {
    $classe_id = intval($_GET['classe_id']);

    // Préparer et exécuter la requête
    $stmt = $pdo->prepare('SELECT id, prenom, nom FROM students WHERE classe_id = ?');
    $stmt->execute([$classe_id]);

    // Récupérer les résultats
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données en format JSON
    echo json_encode($students);
} else {
    // Erreur si classe_id n'est pas fourni
    echo json_encode(['error' => 'L\'ID de la classe est requis.']);
}



?>


