<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "ProjectDB");

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit;
}

$query = "SELECT o.oid, o.odate, o.ototalamount, o.odeliverydate, o.odeliveraddress, o.ostatus, 
                 c.cname, c.ctel, 
                 f.fid, f.fname, of.oqty 
          FROM Orders o
          JOIN Customers c ON o.cid = c.cid
          JOIN OrderFurnitures of ON o.oid = of.oid
          JOIN Furnitures f ON of.fid = f.fid";

$result = $conn->query($query);
$orders = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $fid = intval($row['fid']);
       
        $matRes = $conn->query("SELECT m.mname, fm.pmqty as usedQty, m.mqty, m.munit 
                                FROM FurnitureMaterials fm 
                                JOIN Materials m ON fm.mid = m.mid 
                                WHERE fm.fid = $fid");
        
        $row['materials'] = $matRes ? $matRes->fetch_all(MYSQLI_ASSOC) : [];
        $orders[] = $row;
    }
}
echo json_encode($orders);
?>