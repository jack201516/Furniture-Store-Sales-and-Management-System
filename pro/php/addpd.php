<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect("127.0.0.1", "root", "", "projectdb");
$data = json_decode(file_get_contents('php://input'), true);

mysqli_begin_transaction($conn);
try {
   
    $stmt1 = $conn->prepare("INSERT INTO Furnitures (fname, fdesc, fprice) VALUES (?, ?, ?)");
    $stmt1->bind_param("ssd", $data['fname'], $data['fdesc'], $data['fprice']);
    $stmt1->execute();
    $fid = $stmt1->insert_id;


    $stmt2 = $conn->prepare("INSERT INTO FurnitureMaterials (fid, mid, pmqty) VALUES (?, ?, ?)");
    foreach ($data['materials'] as $mat) {
        $mid = intval($mat['mid']);
        $qty = intval($mat['qty']);
        if ($mid > 0 && $qty > 0) {
            $stmt2->bind_param("iii", $fid, $mid, $qty);
            $stmt2->execute();
        }
    }

    mysqli_commit($conn);
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>