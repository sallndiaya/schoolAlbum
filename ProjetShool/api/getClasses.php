<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");



include 'db.php';

if (isset($_GET['ecole_id'])) {
    $ecole_id = $_GET['ecole_id'];
    
    // Définir la requête SQL
    $query = "SELECT * FROM classes WHERE ecole_id = :ecole_id";
    
    // Préparer et exécuter la requête
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ecole_id', $ecole_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Récupérer les résultats
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($classes);
} else {
    echo json_encode(["error" => "L'ID de l'école est requis."]);
    exit;
}

?>

