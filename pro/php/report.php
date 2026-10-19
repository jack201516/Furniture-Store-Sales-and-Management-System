<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "ProjectDB");

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit;
}


$query = "SELECT o.oid, f.fid, f.fname, f.fprice, of.oqty, 
                 (of.oqty * f.fprice) as totalSales 
          FROM Orders o
          JOIN OrderFurnitures of ON o.oid = of.oid
          JOIN Furnitures f ON of.fid = f.fid
          ORDER BY o.oid ASC"; 

$result = $conn->query($query);
$reportData = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

echo json_encode($reportData);
?>