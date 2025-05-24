<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// admin_manage_customers.php

// Include database configuration
require_once 'db_config.php';

// Initialize variables for messages
$success_message = '';
$error_message = '';

// --- Handle Add/Edit User ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $role = trim($_POST['role']);
        $age = intval($_POST['age']);
        $password = $_POST['password'];

        // Basic validation
        if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($phone_number) || empty($role) || $age <= 0) {
            $error_message = "All fields are required and Age must be positive.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format.";
        } else {
            if ($action == 'add') {
                if (empty($password)) {
                    $error_message = "Password is required for new users.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt_check = mysqli_prepare($conn, "SELECT id FROM user WHERE username = ? OR email = ?");
                    mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
                    mysqli_stmt_execute($stmt_check);
                    mysqli_stmt_store_result($stmt_check);

                    if (mysqli_stmt_num_rows($stmt_check) > 0) {
                        $error_message = "Username or Email already exists.";
                    } else {
                        $sql = "INSERT INTO user (FName, LName, username, email, phone, role, password, age) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $last_name, $username, $email, $phone_number, $role, $hashed_password, $age);
                            if (mysqli_stmt_execute($stmt)) {
                                $success_message = "User added successfully.";
                            } else {
                                $error_message = "Error adding user: " . mysqli_error($conn);
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            $error_message = "Error preparing statement: " . mysqli_error($conn);
                        }
                    }
                    mysqli_stmt_close($stmt_check);
                }
            } elseif ($action == 'edit') {
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE user SET FName = ?, LName = ?, username = ?, email = ?, phone = ?, role = ?, password = ?, age = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssssisi", $first_name, $last_name, $username, $email, $phone_number, $role, $hashed_password, $age, $id);
                    }
                } else {
                    $sql = "UPDATE user SET FName = ?, LName = ?, username = ?, email = ?, phone = ?, role = ?, age = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssssii", $first_name, $last_name, $username, $email, $phone_number, $role, $age, $id);
                    }
                }

                if ($stmt) {
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "User updated successfully.";
                    } else {
                        $error_message = "Error updating user: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            }
        }
    }
}

// --- Handle Delete User ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $sql = "DELETE FROM user WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "User deleted successfully.";
            } else {
                $error_message = "Error deleting user: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

// --- Fetch all users for display from the 'user' table ---
$users = [];
$sql = "SELECT id, FName AS first_name, LName AS last_name, username, age, email, phone AS phone_number, role FROM user ORDER BY id DESC";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_free_result($result);
} else {
    $error_message = "Error fetching users: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - Admin Dashboard</title>
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
        .form-container input[type="email"],
        .form-container input[type="password"],
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
        <h1>Manage Customers</h1>
        <p><a href="admin.php">Back to Dashboard</a></p>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container" id="userForm">
            <h2>Add New User</h2>
            <form action="admin_manage_customers.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="user_id" id="formUserId" value="0">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required min="1">

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                    <option value="Manager">Manager</option>
                    <option value="Chef">Chef</option>
                    <option value="Staff">Staff</option>
                </select>

                <label for="password">Password (Leave blank if not changing for edit):</label>
                <input type="password" id="password" name="password">

                <button type="submit">Submit User</button>
                <button type="button" class="cancel" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <h2>Current Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['age']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($user['role'] ?? ''); ?></td>
                            <td class="action-links">
                                <a href="#" onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</a>
                                <a href="admin_manage_customers.php?delete_id=<?php echo htmlspecialchars($user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editUser(user) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formUserId').value = user.id;
            document.getElementById('first_name').value = user.first_name;
            document.getElementById('last_name').value = user.last_name;
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('phone_number').value = user.phone_number;
            document.getElementById('age').value = user.age;
            document.getElementById('role').value = user.role;
            document.getElementById('password').value = '';
            document.querySelector('#userForm h2').innerText = 'Edit User';
            document.querySelector('#userForm button[type="submit"]').innerText = 'Update User';
        }

        function resetForm() {
            document.getElementById('userForm').reset();
            document.getElementById('formAction').value = 'add';
            document.getElementById('formUserId').value = '0';
            document.querySelector('#userForm h2').innerText = 'Add New User';
            document.querySelector('#userForm button[type="submit"]').innerText = 'Submit User';
        }
    </script>
</body>
</html>