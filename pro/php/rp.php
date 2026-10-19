<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

$hostname = "127.0.0.1";
$database = "projectdb";
$username = "root";
$password = "";

$conn = mysqli_connect($hostname, $username, $password, $database);


$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'oid';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';


$allowedSort = ['oid', 'odate', 'fid', 'oqty', 'ototalamount', 'cid', 'odeliverydate', 'ostatus'];
if (!in_array($sortColumn, $allowedSort)) $sortColumn = 'oid';
$order = (strtoupper($order) === 'ASC') ? 'ASC' : 'DESC';


$sql = "SELECT o.oid, o.odate, of.fid, of.oqty, o.ototalamount, o.cid, o.odeliverydate, o.ostatus 
        FROM Orders o
        JOIN OrderFurnitures of ON o.oid = of.oid
        ORDER BY $sortColumn $order";

$result = mysqli_query($conn, $sql);
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

echo json_encode($orders);
mysqli_close($conn);
?>