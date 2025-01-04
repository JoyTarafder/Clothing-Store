<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Product Management</h1>
            <button onclick="openAddProductModal()" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "admin_panel";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $subcategory_id = $_GET['subcategory_id'] ?? 0;
            $sql = "SELECT * FROM products WHERE subcategory_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $subcategory_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                echo '<div class="bg-white rounded-lg shadow-sm border p-4 hover:shadow-md transition-shadow">';
                echo '<img src="'.htmlspecialchars($row['image_url']).'" alt="'.htmlspecialchars($row['name']).'" class="w-full h-48 object-cover rounded-lg mb-4">';
                echo '<h3 class="text-lg font-semibold mb-2">'.htmlspecialchars($row['name']).'</h3>';
                echo '<p class="text-green-600 font-medium">Stock: '.htmlspecialchars($row['quantity']).'</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center overflow-y-auto">
        <div class="bg-white rounded-lg p-6 w-[800px] max-h-[90vh] overflow-y-auto my-8">
            <h3 class="text-lg font-semibold mb-4">Add New Product</h3>
            <form id="productForm" class="space-y-4">
                <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                
                <!-- Basic Information -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Product Name</label>
                        <input type="text" name="name" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Materials</label>
                        <input type="text" name="materials" class="w-full border rounded-lg p-2" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Brand</label>
                        <input type="text" name="brand" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Color</label>
                        <input type="text" name="color" class="w-full border rounded-lg p-2" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Size</label>
                    <select name="size" class="w-full border rounded-lg p-2" required>
                        <option value="">Select Size</option>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Buying Price</label>
                        <input type="number" name="buying_price" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Vendor</label>
                        <select name="vendor" class="w-full border rounded-lg p-2" required>
                            <?php include 'fetch_vendors.php'; ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Retail Price</label>
                        <input type="number" name="retail_price" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Discount Price</label>
                        <input type="number" name="discount_price" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Bulk Price</label>
                        <input type="number" name="bulk_price" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Bulk Quantity (pcs)</label>
                        <input type="number" name="bulk_quantity" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Delivery Fee</label>
                        <input type="number" name="delivery_fee" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Delivery Time (days)</label>
                        <input type="number" name="delivery_time" class="w-full border rounded-lg p-2" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" class="w-full border rounded-lg p-2" required>
                </div>

                <!-- Images -->
                <div class="space-y-2">
                    <div>
                        <label class="block text-sm font-medium mb-1">Primary Image URL</label>
                        <input type="url" name="image_primary" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Image URL 2 (Optional)</label>
                        <input type="url" name="image_2" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Image URL 3 (Optional)</label>
                        <input type="url" name="image_3" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Image URL 4 (Optional)</label>
                        <input type="url" name="image_4" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Image URL 5 (Optional)</label>
                        <input type="url" name="image_5" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Product Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg p-2" required></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
        }
    </script>
</body>
</html>