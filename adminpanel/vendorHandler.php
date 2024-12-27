<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Vendor Request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $address = $_POST['address'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if (empty($name) || empty($type) || empty($email) || empty($contact_no) || empty($address)) {
        echo json_encode([
            "success" => false, 
            "message" => "All fields except comment are required", 
            "missing_fields" => [
                "name" => empty($name),
                "type" => empty($type),
                "email" => empty($email),
                "contact_no" => empty($contact_no),
                "address" => empty($address)
            ]
        ]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO vendors (name, type, email, contact_no, address, comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $type, $email, $contact_no, $address, $comment);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Vendor added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add vendor: " . $stmt->error]);
    }
    $stmt->close();
    exit;
}

// Handle Fetch Vendors Request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $conn->query("SELECT * FROM vendors");
    if ($result) {
        $vendors = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($vendors);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to fetch vendors: " . $conn->error]);
    }
    exit;
}

$conn->close();
?>
