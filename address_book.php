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

// Fetch user's addresses
$addresses_sql = "SELECT id, address, city, state, zip FROM addresses WHERE username = ?";
$addresses_stmt = $conn->prepare($addresses_sql);
$addresses_stmt->bind_param("s", $current_username);
$addresses_stmt->execute();
$addresses_result = $addresses_stmt->get_result();
$addresses = $addresses_result->fetch_all(MYSQLI_ASSOC);
$addresses_stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Book | GadgetsPlus</title>
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
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
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
            display: none;
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
        .address-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 180px;
            border: 1px solid #e5e7eb;
        }
        .address-card .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #e53e3e;
            cursor: pointer;
        }
        .address-card .address-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .address-card .address-header .address-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }
        .address-card .address-body {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
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
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #3730a3;
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
        <div class="notification" id="notification">
            <span class="block sm:inline">Address added successfully.</span>
            <button class="close-btn" onclick="hideNotification();">&times;</button>
        </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        <div class="notification" id="notification">
            <span class="block sm:inline">Address deleted successfully.</span>
            <button class="close-btn" onclick="hideNotification();">&times;</button>
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
                    <a href="address_book.php" class="nav-link active flex items-center px-4 py-3 text-sm font-medium rounded-lg">
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
                    <a href="my_payments.php" class="nav-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg">
                        <img src="./images/credit-card.png" class="w-5 h-5 mr-3" alt="Credit Card" />
                        My Payments
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h1 class="text-xl font-semibold text-gray-900">Address Book</h1>
                    </div>
                    
                    <form action="add_address.php" method="POST" class="px-6 py-4 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">State</label>
                                <input type="text" name="state" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                <input type="text" name="zip" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="save-btn px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                                Add Address
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Display added addresses -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                    <?php foreach ($addresses as $address): ?>
                    <div class="address-card">
                        <div class="address-header">
                            <div class="address-title"><?php echo htmlspecialchars($address['address']); ?></div>
                            <button type="button" class="delete-btn" onclick="confirmDelete(<?php echo $address['id']; ?>)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="address-body">
                            <p><?php echo htmlspecialchars($address['city']); ?>, <?php echo htmlspecialchars($address['state']); ?> <?php echo htmlspecialchars($address['zip']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <script>
        let addressIdToDelete = null;

        function confirmDelete(addressId) {
            addressIdToDelete = addressId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            addressIdToDelete = null;
        }

        function deleteAddress() {
            if (addressIdToDelete !== null) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete_address.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'address_id';
                input.value = addressIdToDelete;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.style.display = 'none';
            }
        }

        // Show notification if added or deleted parameter is present
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('added') || urlParams.has('deleted')) {
                document.getElementById('notification').style.display = 'block';
                const url = new URL(window.location.href);
                url.searchParams.delete('added');
                url.searchParams.delete('deleted');
                window.history.replaceState({}, document.title, url.toString());
            }
        };
    </script>
</body>
</html>

