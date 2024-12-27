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
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];
$cardholder_name = $_POST['cardholder_name'];

$sql = "INSERT INTO payment_cards (username, card_number, expiry_date, cvv, cardholder_name) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $current_username, $card_number, $expiry_date, $cvv, $cardholder_name);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: my_payments.php?added=true");
exit();
?>
