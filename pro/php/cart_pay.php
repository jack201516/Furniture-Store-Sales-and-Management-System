<?php
header('Content-Type: application/json; charset=utf-8');
session_start();


$hostname = "127.0.0.1";
$database = "projectdb";
$username = "root"; 
$password = "";    

$conn = mysqli_connect($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

if (!isset($_SESSION['cid'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$cid = intval($_SESSION['cid']);


$input = file_get_contents('php://input');
$data = json_decode($input, true);

$totalAmount = floatval($data['totalAmount']);
$address = trim($data['address']);
$deliveryDate = trim($data['deliveryDate']);
$cartItems = $data['items']; 

if (empty($cartItems) || empty($address) || empty($deliveryDate)) {
    echo json_encode(["status" => "error", "message" => "Missing required order information"]);
    exit();
}


mysqli_begin_transaction($conn);

try {

    $stmtOrder = $conn->prepare("INSERT INTO Orders (ototalamount, cid, odeliverydate, odeliveraddress, ostatus) VALUES (?, ?, ?, ?, 1)");
    $stmtOrder->bind_param("diss", $totalAmount, $cid, $deliveryDate, $address);
    $stmtOrder->execute();
    
 
    $oid = $conn->insert_id;
    $stmtOrder->close();

  
    $stmtItems = $conn->prepare("INSERT INTO OrderFurnitures (oid, fid, oqty) VALUES (?, ?, ?)");
    
    foreach ($cartItems as $item) {
        $fid = intval($item['fid']);
        $oqty = intval($item['oqty']);
        
        $stmtItems->bind_param("iii", $oid, $fid, $oqty);
        $stmtItems->execute();
    }
    $stmtItems->close();


    mysqli_commit($conn);
    echo json_encode(["status" => "success", "message" => "Order placed successfully", "oid" => $oid]);
$oid = $conn->insert_id;


foreach ($cartItems as $item) {
    $fid = intval($item['fid']);
    $oqty = intval($item['oqty']);
    

    $res = $conn->query("SELECT mid, pmqty FROM FurnitureMaterials WHERE fid = $fid");
    while ($row = $res->fetch_assoc()) {
        $mid = $row['mid'];
        $deduct = $row['pmqty'] * $oqty;
        
 
        $conn->query("UPDATE Materials SET mqty = mqty - $deduct WHERE mid = $mid");
    }
}
} catch (Exception $e) {

    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => "Failed to process order: " . $e->getMessage()]);
}

mysqli_close($conn);
?>