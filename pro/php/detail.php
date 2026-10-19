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


$fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;


$stmt = $conn->prepare("SELECT fid, fname, fdesc, fprice FROM Furnitures WHERE fid = ?");
$stmt->bind_param("i", $fid);
$stmt->execute();
$result = $stmt->get_result();

if ($furniture = $result->fetch_assoc()) {
    $stmt->close();

    $stock_stmt = $conn->prepare("
        SELECT fm.mid, fm.pmqty, m.mqty 
        FROM FurnitureMaterials fm
        JOIN Materials m ON fm.mid = m.mid
        WHERE fm.fid = ?
    ");
    $stock_stmt->bind_param("i", $fid);
$stock_stmt->execute();
    $stock_stmt->execute();
    $stock_result = $stock_stmt->get_result();

    $max_stock = null;

    while ($row = $stock_result->fetch_assoc()) {
        $pmqty = $row['pmqty'];
        $mqty = $row['mqty'];

      
        if ($pmqty > 0) {
            $possible_stock = floor($mqty / $pmqty);
            
          
            if ($max_stock === null || $possible_stock < $max_stock) {
                $max_stock = $possible_stock;
            }
        } else {
            $max_stock = 0;
        }
    }
    $stock_stmt->close();

    
    if ($max_stock === null) {
        $max_stock = 0;
    }

 
    $furniture['stock'] = (int)$max_stock;

    echo json_encode($furniture);
} else {
    echo json_encode(["error" => "Furniture not found"]);
}

mysqli_close($conn);
?>