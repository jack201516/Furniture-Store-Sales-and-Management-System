<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "projectdb");
$result = $conn->query("SELECT * FROM Furnitures");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
mysqli_close($conn);
?>