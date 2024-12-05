
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'], $data['nom'])) {
    $stmt = $pdo->prepare("UPDATE ecoles SET nom = ? WHERE id = ?");
    $stmt->execute([$data['nom'], $data['id']]);
    echo json_encode(["success" => "École mise à jour avec succès"]);
} else {
    echo json_encode(["error" => "Données manquantes"]);
}
?>

