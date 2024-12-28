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
$card_id = $_POST['card_id'];

$sql = "DELETE FROM payment_cards WHERE id = ? AND username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $card_id, $current_username);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: my_payments.php?deleted=true");
exit();
?>
