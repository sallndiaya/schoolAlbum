

<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header('Content-Type: application/json');
echo json_encode($schools);

include 'db.php';
$sql = "SELECT id, name FROM schools";
$result = $conn->query($sql);

$schools = [];
while ($row = $result->fetch_assoc()) {
    $schools[] = $row;
}

echo json_encode($schools);
?>
