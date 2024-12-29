<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Category Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-8">
            <a href="category.php" class="mr-4">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div class="text-2xl font-semibold text-gray-800">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "admin_panel";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $category_id = $_GET['id'];
                $sql = "SELECT name FROM categories WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $category = $result->fetch_assoc();
                echo htmlspecialchars($category['name']);
                ?>
            </div>
        </div>

        <!-- Add Sub-Category Button -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8 flex items-center cursor-pointer hover:bg-gray-100" 
             onclick="openModal()">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-gray-700">Add New Sub-Category</span>
            </div>
        </div>

        <!-- Sub-Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php include 'fetch_subcategories.php'; ?>
            <div class="subcategory-card cursor-pointer" data-subcategory-id="<?php echo $row['id']; ?>">
                <!-- Sub-category content -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="subcategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Add New Sub-Category</h3>
            <form id="subcategoryForm">
                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                <input type="text" name="subcategory_name" class="w-full border rounded-lg p-2 mb-4" 
                       placeholder="Sub-Category Name" required>
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
            document.getElementById('subcategoryModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('subcategoryModal').classList.add('hidden');
        }

        document.getElementById('subcategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('add_subcategory.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });

        function deleteSubCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the sub-category and all associated products.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('delete_subcategory.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'The sub-category has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        document.querySelectorAll('.subcategory-card').forEach(card => {
            card.addEventListener('click', function() {
                const subcategoryId = this.dataset.subcategoryId;
                window.location.href = `products.php?id=${subcategoryId}`;
            });
        });
    </script>
</body>
</html>