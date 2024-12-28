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

// Fetch user's name
$name_sql = "SELECT name FROM customers WHERE username = ?";
$name_stmt = $conn->prepare($name_sql);
$name_stmt->bind_param("s", $current_username);
$name_stmt->execute();
$name_stmt->bind_result($name);
$name_stmt->fetch();
$name_stmt->close();

// Fetch user's payment cards
$cards_sql = "SELECT id, card_number, expiry_date, cvv, cardholder_name FROM payment_cards WHERE username = ?";
$cards_stmt = $conn->prepare($cards_sql);
$cards_stmt->bind_param("s", $current_username);
$cards_stmt->execute();
$cards_result = $cards_stmt->get_result();
$cards = $cards_result->fetch_all(MYSQLI_ASSOC);
$cards_stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payments | GadgetsPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
        .card {
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-logo {
            width: 50px;
        }
        .card-number {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.1rem;
            margin-top: 1rem;
        }
        .card-details {
            font-size: 0.875rem;
            color: #e0e7ff;
        }
        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #e53e3e;
            cursor: pointer;
        }
        .icon {
            display: inline-block;
            vertical-align: middle;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <?php if (isset($_GET['added']) && $_GET['added'] == 'true'): ?>
        <div class="notification">
            <span class="block sm:inline">Card added successfully.</span>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        <div class="notification">
            <span class="block sm:inline">Card deleted successfully.</span>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
        <?php endif; ?>
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Sidebar -->
            <div class="hidden lg:block lg:col-span-3">
                <nav class="space-y-1">
                    <a href="profile.php" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
                        <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My Profile
                    </a>
                    <a href="#" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
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
                    </a>
                    <a href="my_payments.php" class="nav-link active flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-4.4 0-8-1.8-8-4V8c0-2.2 3.6-4 8-4s8 1.8 8 4v6c0 2.2-3.6 4-8 4z"/>
                        </svg>
                        My Payments
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h1 class="text-xl font-semibold text-gray-900">Add Payment Card</h1>
                    </div>
                    
                    <form action="add_payment.php" method="POST" class="px-6 py-4 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Card Number</label>
                                <input type="text" name="card_number" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <input type="text" name="expiry_date" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" name="cvv" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cardholder Name</label>
                                <input type="text" name="cardholder_name" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="save-btn px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                                Add Card
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Display added cards -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Payment Cards</h2>
                    <?php foreach ($cards as $card): ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-details"><span class="icon">👤</span><?php echo htmlspecialchars($card['cardholder_name']); ?></div>
                            <img src="./images/visa.png" class="card-logo" alt="Card Logo" />
                        </div>
                        <div class="card-number">**** **** **** <?php echo substr($card['card_number'], -4); ?></div>
                        <div class="card-details"><span class="icon">📅</span>Expiry: <?php echo htmlspecialchars($card['expiry_date']); ?> | <span class="icon">🔒</span>CVV: <?php echo htmlspecialchars($card['cvv']); ?></div>
                        <form action="delete_payment.php" method="POST" class="inline">
                            <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                            <button type="submit" class="delete-btn">&times;</button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
