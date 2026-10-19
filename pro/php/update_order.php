<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "ProjectDB");

$data = json_decode(file_get_contents('php://input'), true);
$oid = intval($data['oid']);
$qty = intval($data['oqty']);
$status = intval($data['ostatus']);


$stmt1 = $conn->prepare("UPDATE Orders SET ostatus = ? WHERE oid = ?");
$stmt1->bind_param("ii", $status, $oid);
$stmt1->execute();


$stmt2 = $conn->prepare("UPDATE OrderFurnitures SET oqty = ? WHERE oid = ?");
$stmt2->bind_param("ii", $qty, $oid);
$stmt2->execute();

echo json_encode(["status" => "success"]);
?>