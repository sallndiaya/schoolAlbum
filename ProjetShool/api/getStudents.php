<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


try {
    $pdo = new PDO("mysql:host=localhost;dbname=photo_ecole", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("
        SELECT s.id, s.prenom, s.nom, e.nom AS ecole_nom, c.nom AS classe_nom
        FROM students s
        JOIN ecoles e ON s.ecole_id = e.id
        JOIN classes c ON s.classe_id = c.id
    ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["students" => $students]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur : " . $e->getMessage()]);
}
?>