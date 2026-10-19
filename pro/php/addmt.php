<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "ProjectDB");

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['mname'];
$qty = intval($data['mqty']);
$unit = $data['munit'];


$stmt = $conn->prepare("INSERT INTO Materials (mname, mqty, munit) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $qty, $unit);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>