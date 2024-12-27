<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "clothingshopdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_username = $_SESSION['username'];
$new_name = $_POST['name'];
$new_username = $_POST['username'];
$new_email = $_POST['email'];
$new_password = $_POST['password'];

// Update user data
if (!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE customers SET name = ?, username = ?, email = ?, password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $new_name, $new_username, $new_email, $hashed_password, $current_username);
} else {
    $sql = "UPDATE customers SET name = ?, username = ?, email = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $new_name, $new_username, $new_email, $current_username);
}

if ($stmt->execute()) {
    $_SESSION['username'] = $new_username;
    echo "<script>
            sessionStorage.setItem('username', '$new_username');
            window.location.href = 'profile.php?status=success';
          </script>";
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
