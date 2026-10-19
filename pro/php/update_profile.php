<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['cid'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$conn = mysqli_connect("127.0.0.1", "root", "", "projectdb");
$data = json_decode(file_get_contents('php://input'), true);

$cid = $_SESSION['cid'];
$newPassword = $data['password'];
$newTel = $data['contact'];
$newAddr = $data['address'];

$stmt = $conn->prepare("UPDATE Customers SET cpassword = ?, ctel = ?, caddr = ? WHERE cid = ?");
$stmt->bind_param("sssi", $newPassword, $newTel, $newAddr, $cid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
}

$stmt->close();
mysqli_close($conn);
?>