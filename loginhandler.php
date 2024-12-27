<?php
session_start();

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

// Capture form data
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user data
$sql = "SELECT password FROM customers WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
    $_SESSION['username'] = $username;
    echo "<script>
            sessionStorage.setItem('username', '$username');
            window.location.href = 'index.php';
          </script>";
    exit();
} else {
    header("Location: login.html?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>
