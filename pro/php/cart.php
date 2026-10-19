<?php
header('Content-Type: application/json; charset=utf-8');
session_start();


$hostname = "127.0.0.1";
$database = "projectdb"; 
$username = "root"; 
$password = "";    

$conn = mysqli_connect($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}


if (!isset($_SESSION['cid'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$cid = intval($_SESSION['cid']);


$stmt = $conn->prepare("SELECT cid, cname, ctel, caddr FROM Customers WHERE cid = ?");
$stmt->bind_param("i", $cid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Customer not found"]);
}

$stmt->close();
mysqli_close($conn);
?>