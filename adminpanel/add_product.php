<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $materials = $_POST['materials'];
    // Get other form fields...
    $subcategory_id = $_POST['subcategory_id'];
    $subcategory_name = $_POST['subcategory_name'];
    // Get other form fields...

    $sql = "INSERT INTO products (name, materials, brand, color, size, buying_price, vendor_id, 
            retail_price, discount_price, bulk_price, bulk_quantity, delivery_fee, delivery_time, 
            quantity, image_url, image_url2, image_url3, image_url4, image_url5, description, subcategory_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    // Bind parameters and execute...
    $stmt->bind_param("ssssssssssssssssssss", $name, $materials, $brand, $color, $size, $buying_price,      $vendor_id,$retail_price, $discount_price, $bulk_price, $bulk_quantity, $delivery_fee, $delivery_time, 
            $quantity, $image_url, $image_url2, $image_url3, $image_url4, $image_url5, $description, $subcategory_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect to products page with the subcategory ID as a query parameter

    header("Location: products.php?subcategory_id=" . $_POST['subcategory_id']);
    exit();
}
?>