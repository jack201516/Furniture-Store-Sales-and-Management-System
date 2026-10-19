<?php
header('Content-Type: application/json; charset=utf-8');
session_start();


$hostname = "127.0.0.1";
$database = "projectdb";
$username = "root"; 
$password = "";    

$conn = mysqli_connect($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}


$sql = "SELECT fid, fname, fprice FROM Furnitures";
$result = mysqli_query($conn, $sql);

$furnitures = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $furnitures[] = $row;
    }
}

echo json_encode($furnitures);

mysqli_close($conn);
?>