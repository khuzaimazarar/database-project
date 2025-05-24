<?php
// admin_manage_menu.php

require_once 'db_config.php';

$success_message = '';
$error_message = '';

// --- Handle Add/Edit Menu Item ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
        $item_name = trim($_POST['item_name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        $is_available = isset($_POST['is_available']) ? 1 : 0; // Checkbox value

        if (empty($item_name) || empty($description) || empty($category) || $price <= 0) {
            $error_message = "All fields (and valid Price) are required.";
        } else {
            if ($action == 'add') {
                $sql = "INSERT INTO menu_items (item_name, description, price, category, is_available) VALUES (?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssdsi", $item_name, $description, $price, $category, $is_available);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Menu item added successfully.";
                    } else {
                        $error_message = "Error adding menu item: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            } elseif ($action == 'edit') {
                $sql = "UPDATE menu_items SET item_name = ?, description = ?, price = ?, category = ?, is_available = ? WHERE item_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssdsii", $item_name, $description, $price, $category, $is_available, $item_id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Menu item updated successfully.";
                    } else {
                        $error_message = "Error updating menu item: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            }
        }
    }
}

// --- Handle Delete Menu Item ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $sql = "DELETE FROM menu_items WHERE item_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Menu item deleted successfully.";
            } else {
                $error_message = "Error deleting menu item: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

// --- Fetch all menu items for display ---
$menu_items = [];
$sql = "SELECT item_id, item_name, description, price, category, is_available FROM menu_items ORDER BY category, item_name ASC";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $menu_items[] = $row;
    }
    mysqli_free_result($result);
} else {
    $error_message = "Error fetching menu items: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Changed margin to 0 to ensure cover works across full page */
            color: #333;
            background-image: url(main.png); /* MATCHES admin.html */
            background-size: cover;          /* MATCHES admin.html */
            background-repeat: no-repeat;    /* Ensures image doesn't tile */
            background-attachment: fixed;    /* Keeps image fixed on scroll */
        }
        .container {
            max-width: 90%;
            margin: 20px auto; /* Added margin-top to separate from top edge */
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white for readability */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: white; /* Changed heading color to be visible against potential dark background image */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5); /* Adds a subtle shadow for better readability */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .action-links a.delete {
            color: #dc3545;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container textarea,
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="checkbox"] {
            margin-right: 5px;
        }
        .form-container button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button.cancel {
            background-color: #6c757d;
        }
        .message.success {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .message.error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        /* Style for the "Back to Dashboard" link to make it more visible */
        .container p a {
            color: aqua; /* Matches the welcome text in admin.html */
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Menu</h1>
        <p><a href="admin.php">Back to Dashboard</a></p> <?php if (!empty($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container" id="menuItemForm">
            <h2>Add New Menu Item</h2>
            <form action="admin_manage_menu.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="item_id" id="formItemId" value="0">

                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>

                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>

                <label>
                    <input type="checkbox" id="is_available" name="is_available" value="1" checked>
                    Available
                </label><br><br>

                <button type="submit">Submit Item</button>
                <button type="button" class="cancel" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <h2>Current Menu Items</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($menu_items) > 0): ?>
                    <?php foreach ($menu_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td><?php echo ($item['is_available'] == 1 ? 'Yes' : 'No'); ?></td>
                            <td class="action-links">
                                <a href="#" onclick="editMenuItem(<?php echo htmlspecialchars(json_encode($item)); ?>)">Edit</a>
                                <a href="admin_manage_menu.php?delete_id=<?php echo htmlspecialchars($item['item_id']); ?>" onclick="return confirm('Are you sure you want to delete this menu item?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No menu items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editMenuItem(item) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formItemId').value = item.item_id;
            document.getElementById('item_name').value = item.item_name;
            document.getElementById('description').value = item.description;
            document.getElementById('price').value = item.price;
            document.getElementById('category').value = item.category;
            document.getElementById('is_available').checked = (item.is_available == 1);

            document.querySelector('#menuItemForm h2').innerText = 'Edit Menu Item';
            document.querySelector('#menuItemForm button[type="submit"]').innerText = 'Update Item';
        }

        function resetForm() {
            document.getElementById('menuItemForm').reset();
            document.getElementById('formAction').value = 'add';
            document.getElementById('formItemId').value = '0';
            document.getElementById('is_available').checked = true; // Default to available
            document.querySelector('#menuItemForm h2').innerText = 'Add New Menu Item';
            document.querySelector('#menuItemForm button[type="submit"]').innerText = 'Submit Item';
        }
    </script>
</body>
</html>