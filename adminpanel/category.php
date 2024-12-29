<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-slate-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Admin Panel</h2>
            <button class="bg-blue-700 text-white py-2 px-4 rounded-md hover:bg-blue-600">Log Out</button>
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

    <div class="container mx-auto flex mt-8">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 text-white flex flex-col">
            <!-- Scrollable Navigation -->
            <nav class="flex-1 overflow-y-auto mt-4" style="scrollbar-width: thin; scrollbar-color: #1f2937 #2d3748">
                <ul class="space-y-2">
                    <li>
                        <a href="adminPanel.html" id="dashboard-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">Dashboard</a>
                    </li>
                    <li>
                        <a href="orderManagement.html" id="order-management-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">Order Management</a>
                    </li>
                    <li>
                        <a href="inventory.html" id="inventory-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">Inventory</a>
                    </li>
                    <li>
                        <a href="category.php" id="category-management-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">Category Management</a>
                    </li>
                    <li>
                        <a href="userManagement.html" id="user-management-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">User Management</a>
                    </li>
                    <li>
                        <a href="vendorManagement.html" id="vendor-management-link" class="sidebar-link block py-2.5 px-4 hover:bg-slate-700 rounded transition duration-200">Vendor Management</a>
                    </li>
                    <li>
                        <a href="siteManagement.html" id="site-management-link" class="sidebar-link block py-2.5 px-4 rounded transition duration-200">Site Management</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-8">
            <div class="flex items-center mb-8">
                <div class="text-2xl font-semibold text-gray-800">Category Management</div>
            </div>

            <!-- Add Category Button -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-8 flex items-center cursor-pointer hover:bg-gray-100" 
                 onclick="openModal()">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="text-gray-700">Add New Category</span>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="categoriesGrid">
                <?php include 'fetch_categories.php'; ?>
                <button class="delete-button" onclick="deleteCategory(<?php echo $category['id']; ?>)">Delete</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Add New Category</h3>
            <form id="categoryForm">
                <input type="text" name="category_name" class="w-full border rounded-lg p-2 mb-4" 
                       placeholder="Category Name" required>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-100">Cancel</button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
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

        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('add_category.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Category added successfully.');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to add category.');
                }
            });
        });

        function deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will also delete all associated subcategories and products.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('delete_category.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Category deleted successfully.');
                            closeModal();
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showNotification('Failed to delete category.');
                        }
                    });
                }
            });
        }

        // Ensure the delete button click does not propagate to the anchor tag
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });

        // Ensure clicking on the category card navigates to the subcategory page
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const categoryId = this.dataset.categoryId;
                window.location.href = `subcategory.php?category_id=${categoryId}`;
            });
        });

        // JavaScript for mobile sidebar toggle
        const menuToggle = document.getElementById("menu-toggle");
        const sidebar = document.querySelector("aside");

        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("hidden");
        });

        // JavaScript to set active state on menu click
        function setActive(element) {
            const sidebarLinks = document.querySelectorAll(".sidebar-link");
            sidebarLinks.forEach((link) =>
                link.classList.remove("bg-blue-800", "active")
            );
            element.classList.add("bg-blue-800", "active");
        }

        // Set the active link based on the current page
        document.addEventListener("DOMContentLoaded", function () {
            const currentPage = window.location.pathname.split("/").pop();
            const linkMap = {
                "dashboard.html": "dashboard-link",
                "orderManagement.html": "order-management-link",
                "inventory.html": "inventory-link",
                "category.php": "category-management-link",
                "userManagement.html": "user-management-link",
                "vendorManagement.html": "vendor-management-link",
                "siteManagement.html": "site-management-link",
            };
            const activeLinkId = linkMap[currentPage];
            if (activeLinkId) {
                const activeLink = document.getElementById(activeLinkId);
                if (activeLink) {
                    setActive(activeLink);
                }
            }
        });

        // Ensure the delete button click does not propagate to the anchor tag
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    </script>
</body>
</html>