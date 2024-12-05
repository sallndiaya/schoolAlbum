<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Récupération des écoles
    $stmt = $pdo->query("SELECT * FROM ecoles");
    $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($schools);

} elseif ($method === 'POST') {
    // Ajout ou modification d'une école
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        // Modification
        $stmt = $pdo->prepare("UPDATE ecoles SET nom = ? WHERE id = ?");
        $stmt->execute([$data['nom'], $data['id']]);
    } else {
        // Ajout
        $stmt = $pdo->prepare("INSERT INTO ecoles (nom) VALUES (?)");
        $stmt->execute([$data['nom']]);
    }
    echo json_encode(["success" => true]);

} elseif ($method === 'DELETE') {
    // Suppression d'une école
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $pdo->prepare("DELETE FROM ecoles WHERE id = ?");
    $stmt->execute([$data['id']]);
    echo json_encode(["success" => true]);
}
?>
