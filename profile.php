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
$sql = "SELECT name, username, email FROM customers WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_username);
$stmt->execute();
$stmt->bind_result($name, $username, $email);
$stmt->fetch();
$stmt->close();

// Get order count
$count_sql = "SELECT COUNT(*) as count FROM orders WHERE username = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("s", $current_username);
$count_stmt->execute();
$result = $count_stmt->get_result();
$order_count = $result->fetch_assoc()['count'];
$count_stmt->close();

// Update profile information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    // Update customers table
    $update_sql = "UPDATE customers SET name = ?, username = ?, email = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssss", $new_name, $new_username, $new_email, $current_username);
    $update_stmt->execute();
    $update_stmt->close();

    // Update payment_cards table if username is changed
    if ($new_username !== $current_username) {
        $update_cards_sql = "UPDATE payment_cards SET username = ? WHERE username = ?";
        $update_cards_stmt = $conn->prepare($update_cards_sql);
        $update_cards_stmt->bind_param("ss", $new_username, $current_username);
        $update_cards_stmt->execute();
        $update_cards_stmt->close();
    }

    // Update session username
    $_SESSION['username'] = $new_username;

    // Update session storage in the browser
    echo "<script>
        sessionStorage.setItem('username', '$new_username');
        window.location.href = 'profile.php?updated=true';
    </script>";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | GadgetsPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9ff;
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #4f46e5;
            background-color: #eef2ff;
        }
        .nav-link.active {
            color: #4f46e5;
            background-color: #eef2ff;
            border-right: 3px solid #4f46e5;
        }
        .form-input {
            transition: all 0.2s ease;
        }
        .form-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        .save-btn {
            transition: all 0.3s ease;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
        .notification {
            background-color: #e6fffa;
            border-color: #b2f5ea;
            color: #2c7a7b;
            position: relative;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .notification .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                     <!-- Logo -->
                        <a href="./index.php">
                        <img src="./images/logo.png" class="w-20 h-10" alt="logo" />
                        </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Welcome back,</span>
                    <span class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($name); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Notification -->
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
        <span class="block sm:inline" id="notification-message"></span>
        <svg class="fill-current h-6 w-6 text-green-500 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.5-5.5 1.5-1.5L10 12l7-7 1.5 1.5L10 15z"/></svg>
        <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="hideNotification();">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
        </button>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <?php if (isset($_GET['updated']) && $_GET['updated'] == 'true'): ?>
        <div class="notification">
            <span class="block sm:inline">Profile updated successfully.</span>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
        <?php endif; ?>
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Sidebar -->
            <div class="hidden lg:block lg:col-span-3">
                <nav class="space-y-1">
                    <a href="#" class="nav-link active flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My Profile
                    </a>
                    <a href="address_book.php" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
                        <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Address Book
                    </a>
                    <a href="my_orders.php" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
                        <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        My Orders
                        <span class="ml-auto bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">
                            <?php echo $order_count; ?>
                        </span>
                    </a>
                    <a href="my_payments.php" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
                        <img src="./images/credit-card.png" class="w-5 h-5 mr-3" alt="Credit Card" />
                        My Payments
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-2xl shadow">
                    <div class="px-8 py-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-900">Profile Information</h2>
                        <p class="mt-1 text-sm text-gray-500">Update your account's profile information and email address.</p>
                    </div>
                    
                    <form action="profile.php" method="POST" class="px-8 py-6 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" placeholder="Change Your Password" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="save-btn px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            notificationMessage.textContent = message;
            notification.classList.remove('hidden');
            setTimeout(hideNotification, 2000);
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('hidden');
        }

        // Automatically hide notification after 2 seconds
        setTimeout(function() {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.style.display = 'none';
            }
        }, 2000);
    </script>
</body>
</html>