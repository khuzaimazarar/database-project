<?php
// admin_manage_payments.php

require_once 'db_config.php'; // Include your database configuration

$success_message = '';
$error_message = '';

// --- Handle Add/Edit Payment ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
        $order_id = intval($_POST['order_id']); // Assuming you'll select from existing orders
        $customer_id = intval($_POST['customer_id']); // Assuming you'll select from existing customers
        $payment_date = trim($_POST['payment_date']);
        $amount = floatval($_POST['amount']);
        $payment_method = trim($_POST['payment_method']);
        $status = trim($_POST['status']); // e.g., 'Completed', 'Refunded', 'Pending'

        // Basic validation
        if ($order_id <= 0 || $customer_id <= 0 || empty($payment_date) || $amount <= 0 || empty($payment_method) || empty($status)) {
            $error_message = "All fields are required and amounts must be positive.";
        } else {
            if ($action == 'add') {
                $sql = "INSERT INTO payments (order_id, customer_id, payment_date, amount, payment_method, status) VALUES (?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisdss", $order_id, $customer_id, $payment_date, $amount, $payment_method, $status);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Payment record added successfully.";
                    } else {
                        $error_message = "Error adding payment record: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            } elseif ($action == 'edit') {
                $sql = "UPDATE payments SET order_id = ?, customer_id = ?, payment_date = ?, amount = ?, payment_method = ?, status = ? WHERE payment_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisdssi", $order_id, $customer_id, $payment_date, $amount, $payment_method, $status, $payment_id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Payment record updated successfully.";
                    } else {
                        $error_message = "Error updating payment record: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            }
        }
    }
}

// --- Handle Delete Payment ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $sql = "DELETE FROM payments WHERE payment_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Payment record deleted successfully.";
            } else {
                $error_message = "Error deleting payment record: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

// --- Fetch all payments for display ---
$payments = [];
// Joining with orders and users tables to get meaningful display data
$sql = "SELECT p.payment_id, p.payment_date, p.amount, p.payment_method, p.status,
                o.order_id, u.username AS customer_username, u.id AS customer_id
        FROM payments p
        LEFT JOIN orders o ON p.order_id = o.order_id
        LEFT JOIN user u ON p.customer_id = u.id
        ORDER BY p.payment_date DESC";

if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }
    mysqli_free_result($result);
} else {
    $error_message = "Error fetching payments: " . mysqli_error($conn);
}

// Fetch orders for the dropdown in the 'Add Payment' form
$orders_dropdown = [];
$sql_orders = "SELECT order_id, total_amount FROM orders ORDER BY order_id DESC"; // You might want to add customer name or order details
if ($result_orders = mysqli_query($conn, $sql_orders)) {
    while ($row_order = mysqli_fetch_assoc($result_orders)) {
        $orders_dropdown[] = $row_order;
    }
    mysqli_free_result($result_orders);
} else {
    $error_message .= " Error fetching orders for dropdown: " . mysqli_error($conn);
}

// Fetch customers for the dropdown in the 'Add Payment' form
$customers_dropdown = [];
$sql_customers = "SELECT id, username FROM user WHERE role = 'Customer' ORDER BY username ASC"; // Corrected table and column names
if ($result_customers = mysqli_query($conn, $sql_customers)) {
    while ($row_customer = mysqli_fetch_assoc($result_customers)) {
        $customers_dropdown[] = $row_customer;
    }
    mysqli_free_result($result_customers);
} else {
    $error_message .= " Error fetching customers for dropdown: " . mysqli_error($conn);
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add some basic styles here or in your styles.css */
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
            width: calc(100% - 22px); /* Adjust for padding and border */
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
        <h1>Manage Payments</h1>
        <p><a href="admin.php">Back to Dashboard</a></p>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container" id="paymentForm">
            <h2>Add New Payment Record</h2>
            <form action="admin_manage_payments.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="payment_id" id="formPaymentId" value="0">

                <label for="order_id">Order ID:</label>
                <select id="order_id" name="order_id" required>
                    <option value="">Select Order</option>
                    <?php foreach ($orders_dropdown as $order_dr): ?>
                        <option value="<?php echo htmlspecialchars($order_dr['order_id']); ?>">
                            Order #<?php echo htmlspecialchars($order_dr['order_id']); ?> (Total: <?php echo htmlspecialchars(number_format($order_dr['total_amount'], 2)); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="customer_id">Customer:</label>
                <select id="customer_id" name="customer_id" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers_dropdown as $customer_dr): ?>
                        <option value="<?php echo htmlspecialchars($customer_dr['id']); ?>">
                            <?php echo htmlspecialchars($customer_dr['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="payment_date">Payment Date:</label>
                <input type="date" id="payment_date" name="payment_date" required>

                <label for="amount">Amount:</label>
                <input type="number" step="0.01" id="amount" name="amount" required>

                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="Online">Online</option>
                </select>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                    <option value="Refunded">Refunded</option>
                </select>

                <button type="submit">Submit Payment</button>
                <button type="button" class="cancel" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <h2>Current Payment Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($payments) > 0): ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['customer_username']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($payment['amount'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($payment['status']); ?></td>
                            <td class="action-links">
                                <a href="#" onclick="editPayment(<?php echo htmlspecialchars(json_encode($payment)); ?>)">Edit</a>
                                <a href="admin_manage_payments.php?delete_id=<?php echo htmlspecialchars($payment['payment_id']); ?>" onclick="return confirm('Are you sure you want to delete this payment record?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No payment records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editPayment(payment) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formPaymentId').value = payment.payment_id;
            document.getElementById('order_id').value = payment.order_id;
            document.getElementById('customer_id').value = payment.customer_id;
            document.getElementById('payment_date').value = payment.payment_date;
            document.getElementById('amount').value = payment.amount;
            document.getElementById('payment_method').value = payment.payment_method;
            document.getElementById('status').value = payment.status;

            document.querySelector('#paymentForm h2').innerText = 'Edit Payment Record';
            document.querySelector('#paymentForm button[type="submit"]').innerText = 'Update Payment';
        }

        function resetForm() {
            document.getElementById('paymentForm').reset();
            document.getElementById('formAction').value = 'add';
            document.getElementById('formPaymentId').value = '0';
            document.querySelector('#paymentForm h2').innerText = 'Add New Payment Record';
            document.querySelector('#paymentForm button[type="submit"]').innerText = 'Submit Payment';
        }
    </script>
</body>
</html>