<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
include 'db.php';
$school_id = $_GET['school_id'];

$sql = "SELECT id, name FROM classes WHERE ecole_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $school_id);
$stmt->execute();
$result = $stmt->get_result();

$classes = [];
while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}

echo json_encode($classes);
?>
