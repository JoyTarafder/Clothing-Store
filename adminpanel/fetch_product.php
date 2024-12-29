<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$subcategory_id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM products WHERE subcategory_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subcategory_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo '<div class="bg-white rounded-lg shadow-sm overflow-hidden">';
    echo '<img src="' . htmlspecialchars($row['image_primary']) . '" alt="' . htmlspecialchars($row['name']) . '" 
          class="w-full h-48 object-cover">';
    echo '<div class="p-4">';
    echo '<h3 class="text-lg font-semibold mb-2">' . htmlspecialchars($row['name']) . '</h3>';
    echo '<p class="text-gray-600 mb-2">Stock: <span class="text-green-600">' . $row['quantity'] . '</span></p>';
    echo '<div class="flex justify-end">';
    echo '<button class="text-red-500 hover:text-red-700" onclick="deleteProduct(' . $row['id'] . ')">';
    echo '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">';
    echo '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>';
    echo '</svg>';
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}


$conn->close();
?>
