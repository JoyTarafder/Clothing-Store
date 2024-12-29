<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.*, 
        COUNT(DISTINCT sc.id) as subcategories,
        COUNT(DISTINCT p.id) as products
        FROM categories c
        LEFT JOIN sub_categories sc ON c.id = sc.category_id
        LEFT JOIN products p ON sc.id = p.subcategory_id
        GROUP BY c.id";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo '<a href="subcategory.php?id=' . $row['id'] . '" class="block bg-white rounded-lg shadow-md p-6 hover:bg-gray-100">';
    echo '<div class="flex justify-between items-center mb-4">';
    echo '<h3 class="text-xl font-semibold text-gray-800">' . htmlspecialchars($row['name']) . '</h3>';
    echo '<button class="delete-button text-red-500 hover:text-red-700" onclick="event.stopPropagation(); deleteCategory(' . $row['id'] . ')">';
    echo '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">';
    echo '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>';
    echo '</svg>';
    echo '</button>';
    echo '</div>';
    echo '<div class="space-y-1 text-gray-600">';
    echo '<p>Subcategories: ' . $row['subcategories'] . '</p>';
    echo '<p>Products: ' . $row['products'] . '</p>';
    echo '</div>';
    echo '</a>';
}

$conn->close();
?>
