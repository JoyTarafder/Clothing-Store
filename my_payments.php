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
$cards_sql = "SELECT id, card_number, expiry_date, cvv, cardholder_name, card_type FROM payment_cards WHERE username = ?";
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
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 220px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-logo {
            width: 60px;
        }
        .card-number {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.125rem;
            margin-top: 1rem;
        }
        .card-details {
            font-size: 1rem;
            color: #e0e7ff;
        }
        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #e53e3e;
            cursor: pointer;
        }
        .icon {
            display: inline-block;
            vertical-align: middle;
            margin-right: 0.5rem;
        }
        .card-chip {
            background: linear-gradient(135deg, #FFD700 0%, #fff 50%, #FFD700 100%);
            width: 40px;
            height: 30px;
            border-radius: 4px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .modal-button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-button.yes {
            background-color: #4f46e5;
            color: white;
        }
        .modal-button.no {
            background-color: #e53e3e;
            color: white;
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

    <!-- Notification -->
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
        <span class="block sm:inline" id="notification-message"></span>
        <svg class="fill-current h-6 w-6 text-green-500 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.5-5.5 1.5-1.5L10 12l7-7 1.5 1.5L10 15z"/></svg>
        <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="hideNotification();">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
        </button>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <?php if (isset($_GET['added']) && $_GET['added'] == 'true'): ?>
        <div class="notification" id="notification">
            <span class="block sm:inline">Card added successfully.</span>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        <div class="notification" id="notification">
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
                    </a>
                    <a href="my_payments.php" class="nav-link active flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <img src="./images/credit-card.png" class="w-5 h-5 mr-3" alt="Credit Card" />
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
                                <label class="block text-sm font-medium text-gray-700">Card Type</label>
                                <select name="card_type" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Visa Card">Visa Card</option>
                                    <option value="MasterCard">MasterCard</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Card Number</label>
                                <input type="text" name="card_number" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiry Date (MM/YYYY)</label>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                    <?php 
                    $backgrounds = [
                        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%)',
                        'linear-gradient(135deg, #43cea2 0%, #185a9d 100%)'
                    ];
                    $i = 0;
                    foreach ($cards as $card): 
                    ?>
                    <div class="relative w-full h-56 rounded-xl p-6 text-white shadow-lg" style="background: <?php echo $backgrounds[$i % count($backgrounds)]; ?>;">
                        <!-- Card Issuer Logo -->
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium"><?php echo htmlspecialchars($card['card_type']); ?></div>
                        </div>
                        
                        <!-- Chip -->
                        <div class="mt-4 flex items-center gap-2">
                            <!-- <div class="card-chip"></div> -->
                            <!-- Wireless Symbol -->
                            <img src="./images/image 3.png" alt="Wireless" class="h-10">
                            <img src="./images/Vector.png" alt="Wireless" class="h-8">
                        </div>

                        <!-- Card Number -->
                        <div class="mt-6">
                            <div class="text-2xl font-medium tracking-widest">
                                <?php 
                                    $masked_number = str_pad(substr($card['card_number'], -4), 16, '*', STR_PAD_LEFT);
                                    echo chunk_split($masked_number, 4, ' ');
                                ?>
                            </div>
                        </div>

                        <!-- Cardholder Details -->
                        <div class="mt-3 flex justify-between items-end">
                            <div>
                                <div class="text-xs text-white/80">Cardholder Name</div>
                                <div class="text-sm font-medium">
                                    <?php echo htmlspecialchars($card['cardholder_name']); ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-white/80">Expired Date</div>
                                <div class="text-sm font-medium">
                                    <?php 
                                        $expiry_date = DateTime::createFromFormat('Y-m-d', $card['expiry_date']);
                                        echo $expiry_date->format('m/Y');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <button type="button" class="delete-btn" onclick="confirmDelete(<?php echo $card['id']; ?>)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <?php 
                    $i++;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2 class="text-lg font-semibold">Confirm Deletion</h2>
            <p>Are you sure you want to delete this card?</p>
            <div class="modal-buttons">
                <button class="modal-button yes" onclick="deleteCard()">Yes</button>
                <button class="modal-button no" onclick="closeModal()">No</button>
            </div>
        </div>
    </div>

    <script>
        let cardIdToDelete = null;

        function confirmDelete(cardId) {
            cardIdToDelete = cardId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            cardIdToDelete = null;
        }

        function deleteCard() {
            if (cardIdToDelete !== null) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete_payment.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'card_id';
                input.value = cardIdToDelete;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

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
