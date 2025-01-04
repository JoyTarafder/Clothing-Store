<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="./index.php" class="text-2xl font-bold text-gray-800">Clothing App</a>
            <div class="space-x-4">
                <a href="./index.php" class="text-gray-600 hover:text-gray-800">Home</a>
                <a href="./aboutus.php" class="text-gray-600 hover:text-gray-800">About Us</a>
                <a href="./career.php" class="text-gray-600 hover:text-gray-800">Career</a>
                <a href="./contact.php" class="text-gray-600 hover:text-gray-800">Contact</a>
                <a href="./faqs.php" class="text-gray-600 hover:text-gray-800">FAQs</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Frequently Asked Questions</h1>
            <p class="text-lg text-gray-600 mt-4">Find answers to the most commonly asked questions.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">What is your return policy?</h2>
                    <p class="text-gray-600">
                        You can return any item purchased from our store within 30 days of the delivery date. The item must be in its original condition, unused, and with all tags attached. Please refer to our <a href="./returnpolicy.php" class="text-blue-600 hover:underline">Return Policy</a> for more details.
                    </p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">How can I track my order?</h2>
                    <p class="text-gray-600">
                        Once your order is shipped, you will receive a tracking number via email. You can use this tracking number to monitor the status of your delivery on our website or the courier's website.
                    </p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Do you offer international shipping?</h2>
                    <p class="text-gray-600">
                        Yes, we offer international shipping to many countries. Delivery times and shipping charges may vary based on the destination. Please refer to our <a href="./deliverypolicy.php" class="text-blue-600 hover:underline">Delivery Policy</a> for more information.
                    </p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">How can I contact customer service?</h2>
                    <p class="text-gray-600">
                        You can contact our customer service team by emailing us at support@clothstore.com or by filling out the contact form on our <a href="./contact.php" class="text-blue-600 hover:underline">Contact Us</a> page.
                    </p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">What payment methods do you accept?</h2>
                    <p class="text-gray-600">
                        We accept various payment methods including credit/debit cards, PayPal, and other local payment options. You can view the available payment methods at checkout.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-indigo-950 border-t border-gray-200 py-8">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Logo and Social Links -->
                <div>
                    <h2 class="text-2xl font-semibold text-white">
                        <img src="./images/Logo/logo.png" class="w-40 h-40" alt="" />
                    </h2>
                    <h3 class="text-sm font-medium text-white mt-4">FOLLOW US</h3>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" aria-label="Facebook" class="text-gray-600 hover:text-black">
                            <i class="fab fa-facebook-f">
                                <img src="./images/facebook.png" class="w-6 h-6" alt="" />
                            </i>
                        </a>
                        <a href="#" aria-label="Instagram" class="text-gray-600 hover:text-black">
                            <i class="fab fa-instagram">
                                <img src="./images/instagram.png" class="w-6 h-6" alt="" />
                            </i>
                        </a>
                        <a href="#" aria-label="LinkedIn" class="text-gray-600 hover:text-black">
                            <i class="fab fa-linkedin-in">
                                <img src="./images/linkedin.png" class="w-6 h-6" alt="" />
                            </i>
                        </a>
                        <a href="#" aria-label="YouTube" class="text-gray-600 hover:text-black">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Help Section -->
                <div>
                    <h3 class="text-lg font-medium text-white">HELP</h3>
                    <ul class="mt-4 space-y-2 text-sm text-white">
                        <li><a href="./faqs.php" class="hover:text-zinc-300">FAQs</a></li>
                        <li><a href="./returnpolicy.php" class="hover:text-zinc-300">Return Policy</a></li>
                        <li><a href="./privacypolicy.php" class="hover:text-zinc-300">Privacy Policy</a></li>
                        <li><a href="./deliverypolicy.php" class="hover:text-zinc-300">Delivery Policy</a></li>
                        <li><a href="./storelocations.php" class="hover:text-zinc-300">Store Locations</a></li>
                        <li><a href="./terms.php" class="hover:text-zinc-300">Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-medium text-white">ABOUT</h3>
                    <ul class="mt-4 space-y-2 text-sm text-white">
                        <li><a href="./aboutus.php" class="hover:text-zinc-300">About Us</a></li>
                        <li><a href="./career.php" class="hover:text-zinc-300">Career</a></li>
                    </ul>
                    <h3 class="text-lg font-medium text-white mt-6">Donate Now</h3>
                    <ul class="mt-4 space-y-2 text-sm text-white">
                        <li><a href="#" class="hover:text-zinc-300">Login</a></li>
                        <li><a href="./adminpanel/adminPanelLogInPage.html" class="hover:text-zinc-300">Admin Panel</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div>
                    <h3 class="text-lg font-medium text-white">CONTACT</h3>
                    <div class="text-sm text-white mt-4">
                        <ul class="mt-4 space-y-2 text-sm text-white mb-5">
                            <li><a href="./contact.php" class="hover:text-zinc-300">Contact Us</a></li>
                        </ul>
                        <p>
                            <strong>Corporate Office</strong><br />
                            Saimon Centre, Level-3<br />
                            House No-4A, Road No-22,<br />
                            Gulshan-01, Dhaka-1212<br />
                            Phone: +8801904000258<br />
                            (10 AM - 8 PM)<br />
                            <em>Except Weekend/Govt. Holidays</em><br />
                            Email: support@clothstore.com
                        </p>
                    </div>
                </div>
            </div>

            <!-- Subscription Form -->
            <div class="mt-8 text-center">
                <p class="text-sm text-white">Be the first to know about special offers and new products</p>
                <div class="mt-4 flex justify-center">
                    <input type="email" placeholder="Enter your email..." class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none" />
                    <button class="px-4 py-2 bg-black text-white rounded-r-md">SUBSCRIBE</button>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mt-8 flex justify-center space-x-4">
                <img src="./images/SSLCommerz-Pay.png" alt="Visa" class="h-28" />
            </div>

            <!-- Copyright -->
            <div class="mt-4 text-center text-white text-base">
                © 2024 - All Rights Reserved by Joy Tarafder
            </div>
        </div>
    </footer>
</body>
</html>
