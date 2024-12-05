<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'db.php';
$school_id = $_GET['school_id'];
$class_id = $_GET['class_id'];

$sql = "SELECT filename, CONCAT('uploads/', school_id, '/', class_id, '/', filename) AS url 
        FROM photos 
        WHERE school_id = ? AND class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $school_id, $class_id);
$stmt->execute();
$result = $stmt->get_result();

$photos = [];
while ($row = $result->fetch_assoc()) {
    $photos[] = $row;
}

echo json_encode($photos);
?>
