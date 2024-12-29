<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete products associated with the subcategory
        $sql = "DELETE FROM products WHERE subcategory_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Delete the subcategory
        $sql = "DELETE FROM sub_categories WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $response['success'] = true;
    } catch (Exception $e) {
        // Rollback transaction if any query fails
        $conn->rollback();
    }
}

echo json_encode($response);

$conn->close();
?>
