<?php
// admin_manage_orders.php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_config.php';

$success_message = '';
$error_message = '';

// --- Handle Add/Edit Order ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $customer_id = intval($_POST['customer_id']); // Assuming you'll select from existing customers
        $order_date = trim($_POST['order_date']);
        $total_amount = floatval($_POST['total_amount']);
        $status = trim($_POST['status']);

        if (empty($order_date) || empty($status) || $customer_id <= 0 || $total_amount <= 0) {
            $error_message = "All fields (and valid Customer ID/Total Amount) are required.";
        } else {
            if ($action == 'add') {
                $sql = "INSERT INTO orders (customer_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "isds", $customer_id, $order_date, $total_amount, $status);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Order added successfully.";
                    } else {
                        $error_message = "Error adding order: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            } elseif ($action == 'edit') {
                $sql = "UPDATE orders SET customer_id = ?, order_date = ?, total_amount = ?, status = ? WHERE order_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "isdsi", $customer_id, $order_date, $total_amount, $status, $order_id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Order updated successfully.";
                    } else {
                        $error_message = "Error updating order: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            }
        }
    }
}

// --- Handle Delete Order ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Order deleted successfully.";
            } else {
                $error_message = "Error deleting order: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

// --- Fetch all orders for display ---
$orders = [];
// Corrected: Join with 'user' table and use 'id' and 'username'
$sql = "SELECT o.order_id, o.order_date, o.total_amount, o.status, u.username AS customer_username, u.id AS customer_id
        FROM orders o
        JOIN user u ON o.customer_id = u.id
        ORDER BY o.order_date DESC";

if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    mysqli_free_result($result);
} else {
    $error_message = "Error fetching orders: " . mysqli_error($conn);
}

// Fetch customers for the dropdown in the 'Add Order' form
$customers = [];
// CORRECTED: Changed table name from 'users' to 'user' and column from 'user_id' to 'id'
$sql_customers = "SELECT id, username FROM user WHERE role = 'Customer' ORDER BY username ASC";
if ($result_customers = mysqli_query($conn, $sql_customers)) {
    while ($row_customer = mysqli_fetch_assoc($result_customers)) {
        $customers[] = $row_customer;
    }
    mysqli_free_result($result_customers);
} else {
    $error_message .= " Error fetching customers: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styles similar to manage-customers.php and admin.html */
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
        .form-container input[type="date"],
        .form-container input[type="number"],
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        <h1>Manage Orders</h1>
        <p><a href="admin.php">Back to Dashboard</a></p>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container" id="orderForm">
            <h2>Add New Order</h2>
            <form action="admin_manage_orders.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="order_id" id="formOrderId" value="0">

                <label for="customer_id">Customer:</label>
                <select id="customer_id" name="customer_id" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                            <?php echo htmlspecialchars($customer['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="order_date">Order Date:</label>
                <input type="date" id="order_date" name="order_date" required>

                <label for="total_amount">Total Amount:</label>
                <input type="number" step="0.01" id="total_amount" name="total_amount" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>

                <button type="submit">Submit Order</button>
                <button type="button" class="cancel" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <h2>Current Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_username']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td class="action-links">
                                <a href="#" onclick="editOrder(<?php echo htmlspecialchars(json_encode($order)); ?>)">Edit</a>
                                <a href="admin_manage_orders.php?delete_id=<?php echo htmlspecialchars($order['order_id']); ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editOrder(order) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formOrderId').value = order.order_id;
            // Set customer dropdown using the customer_id from the fetched order
            document.getElementById('customer_id').value = order.customer_id;
            document.getElementById('order_date').value = order.order_date;
            document.getElementById('total_amount').value = order.total_amount;
            document.getElementById('status').value = order.status;

            document.querySelector('#orderForm h2').innerText = 'Edit Order';
            document.querySelector('#orderForm button[type="submit"]').innerText = 'Update Order';
        }

        function resetForm() {
            document.getElementById('orderForm').reset();
            document.getElementById('formAction').value = 'add';
            document.getElementById('formOrderId').value = '0';
            document.querySelector('#orderForm h2').innerText = 'Add New Order';
            document.querySelector('#orderForm button[type="submit"]').innerText = 'Submit Order';
        }
    </script>
</body>
</html>