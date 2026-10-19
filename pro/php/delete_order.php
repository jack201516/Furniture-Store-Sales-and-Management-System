<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
$conn = mysqli_connect("127.0.0.1", "root", "", "projectdb");

$data = json_decode(file_get_contents('php://input'), true);
$oid = intval($data['oid']);

mysqli_begin_transaction($conn);
try {

    $items = $conn->query("SELECT fid, oqty FROM OrderFurnitures WHERE oid = $oid");
    while ($item = $items->fetch_assoc()) {
        $fid = $item['fid'];
        $oqty = $item['oqty'];
        
   
        $mats = $conn->query("SELECT mid, pmqty FROM FurnitureMaterials WHERE fid = $fid");
        while ($mat = $mats->fetch_assoc()) {
            $add = $mat['pmqty'] * $oqty;
            $conn->query("UPDATE Materials SET mqty = mqty + $add WHERE mid = {$mat['mid']}");
        }
    }
    

    $conn->query("DELETE FROM OrderFurnitures WHERE oid = $oid");
    $conn->query("DELETE FROM Orders WHERE oid = $oid");
    
    mysqli_commit($conn);
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>