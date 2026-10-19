<?php
session_start();

$hostname = "127.0.0.1";
$database = "projectdb"; 
$username = "root";
$password = "";

$conn = mysqli_connect($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $input_id = $_POST['login_id']; 
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT sid FROM Staffs WHERE sid = ? AND spassword = ?");
    $stmt->bind_param("is", $input_id, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['sid'] = $row['sid']; 
        header("Location: ../frontpage/stpd.html");
        exit();
    }

   
    $stmt = $conn->prepare("SELECT cid FROM Customers WHERE cid = ? AND cpassword = ?");
    $stmt->bind_param("is", $input_id, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cid'] = $row['cid']; 
        header("Location: ../frontpage/fp.html");
        exit();
    }

//if error
    echo "<script>alert('Invalid ID or password.'); window.location.href='index.html';</script>";
}

$conn->close();
?>