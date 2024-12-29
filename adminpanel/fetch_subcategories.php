<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_id = $_GET['id'] ?? 0;

$sql = "SELECT sc.*, 
        COUNT(DISTINCT p.id) as products,
        COUNT(DISTINCT v.id) as variants
        FROM sub_categories sc
        LEFT JOIN products p ON sc.id = p.subcategory_id
        LEFT JOIN variants v ON p.id = v.product_id
        WHERE sc.category_id = ?
        GROUP BY sc.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo '<div class="subcategory-card bg-white rounded-lg shadow-md p-6 cursor-pointer" data-subcategory-id="' . $row['id'] . '">';
    echo '<div class="flex justify-between items-center mb-4">';
    echo '<h3 class="text-xl font-semibold text-gray-800">' . htmlspecialchars($row['name']) . '</h3>';
    echo '<button class="text-red-500 hover:text-red-700" onclick="deleteSubCategory(' . $row['id'] . ')">';
    echo '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">';
    echo '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>';
    echo '</svg>';
    echo '</button>';
    echo '</div>';
    echo '<div class="space-y-1 text-gray-600">';
    echo '<p>Products: ' . $row['products'] . '</p>';
    echo '<p>Variant: ' . $row['variants'] . '</p>';
    echo '</div>';
    echo '</div>';
}

$conn->close();
?>