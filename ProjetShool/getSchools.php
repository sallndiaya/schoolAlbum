<?php
/*header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header('Content-Type: application/json');*/

//echo json_encode($schools);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include 'db.php'; // Connexion à la base de données via PDO

$stmt = $pdo->query("SELECT * FROM ecoles");
$schools = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($schools);


?>


