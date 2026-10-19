<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "projectdb");

$data = json_decode(file_get_contents('php://input'), true);
$fid = intval($data['fid']);


$checkOrder = $conn->query("SELECT COUNT(*) as count FROM OrderFurnitures WHERE fid = $fid");
$rowOrder = $checkOrder->fetch_assoc();

if ($rowOrder['count'] > 0) {
    echo json_encode(["status" => "error", "message" => "Cannot delete: This item has existing related orders."]);
    exit();
}


mysqli_begin_transaction($conn);
try {
    
    $conn->query("DELETE FROM FurnitureMaterials WHERE fid = $fid");
    
 
    $conn->query("DELETE FROM Furnitures WHERE fid = $fid");
    
    mysqli_commit($conn);
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}

mysqli_close($conn);
?>