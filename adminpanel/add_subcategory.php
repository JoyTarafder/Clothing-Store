<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $subcategory_name = $_POST['subcategory_name'];
    
    $sql = "INSERT INTO sub_categories (category_id, name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $category_id, $subcategory_name);
    
    $response = ['success' => false];
    
    if ($stmt->execute()) {
        $response['success'] = true;
    }
    
    echo json_encode($response);
}

$conn->close();
?>
