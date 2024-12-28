<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothingshopdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_username = $_SESSION['username'];

if (isset($_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'])) {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    $sql = "INSERT INTO addresses (username, address, city, state, zip) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $current_username, $address, $city, $state, $zip);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: address_book.php?added=true");
    exit();
} else {
    echo "All fields are required.";
}
?>
