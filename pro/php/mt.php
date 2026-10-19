<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "ProjectDB");

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit;
}

$result = $conn->query("SELECT mid, mname, mqty, munit FROM Materials");
$materials = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($materials);
?>