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
$addresses_sql = "SELECT id, address, city, state, zip, country FROM addresses WHERE username = ?";
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
            display: none;
        }
        .notification.delete {
            background-color: #ffe6e6;
            border-color: #f5b2b2;
            color: #7a2c2c;
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
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 250px; /* Adjusted height */
            border: 1px solid #e5e7eb;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .address-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
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
        .address-card .address-body p {
            margin: 0.5rem 0;
            word-wrap: break-word; /* Ensure long words break */
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
        <div class="notification delete" id="notification">
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
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Country</label>
                                <select name="country" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
                                    <option value="">Select a country</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cabo Verde">Cabo Verde</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                                    <option value="Congo, Republic of the">Congo, Republic of the</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Eswatini">Eswatini</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, North">Korea, North</option>
                                    <option value="Korea, South">Korea, South</option>
                                    <option value="Kosovo">Kosovo</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="North Macedonia">North Macedonia</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City">Vatican City</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
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
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($address['address']); ?></p>
                            <p><strong>City:</strong> <?php echo htmlspecialchars($address['city']); ?></p>
                            <p><strong>State:</strong> <?php echo htmlspecialchars($address['state']); ?></p>
                            <p><strong>ZIP Code:</strong> <?php echo htmlspecialchars($address['zip']); ?></p>
                            <p><strong>Country:</strong> <?php echo htmlspecialchars($address['country']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this address?</p>
            <div class="modal-buttons">
                <button class="modal-button yes" onclick="deleteAddress()">Yes</button>
                <button class="modal-button no" onclick="closeModal()">No</button>
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
                const notification = document.getElementById('notification');
                notification.style.display = 'block';
                setTimeout(hideNotification, 3000); // Hide after 3 seconds
                const url = new URL(window.location.href);
                url.searchParams.delete('added');
                url.searchParams.delete('deleted');
                window.history.replaceState({}, document.title, url.toString());
            }
        };
    </script>
</body>
</html>

