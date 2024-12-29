<?php
session_start();

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

// Handle Login Request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM adminuser WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['password'] === $inputPassword) { // Use password_verify() if hashed
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $user['username'];
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password"]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
