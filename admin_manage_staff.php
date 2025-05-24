<?php
// admin_manage_staff.php

require_once 'db_config.php'; // Include your database configuration

$success_message = '';
$error_message = '';

// --- Handle Add/Edit Staff ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $staff_id = isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $role = trim($_POST['role']); // e.g., 'Chef', 'Waiter', 'Manager'
        $password = $_POST['password']; // Only for add, or if changed during edit
        $hire_date = trim($_POST['hire_date']);
        $salary = floatval($_POST['salary']);

        // Basic validation
        if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($phone_number) || empty($role) || empty($hire_date) || $salary <= 0) {
            $error_message = "All fields are required and salary must be positive.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format.";
        } else {
            if ($action == 'add') {
                if (empty($password)) {
                    $error_message = "Password is required for new staff members.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Check if username or email already exists in staff table
                    $stmt_check = mysqli_prepare($conn, "SELECT staff_id FROM staff WHERE username = ? OR email = ?");
                    mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
                    mysqli_stmt_execute($stmt_check);
                    mysqli_stmt_store_result($stmt_check);

                    if (mysqli_stmt_num_rows($stmt_check) > 0) {
                        $error_message = "Username or Email already exists for another staff member.";
                    } else {
                        $sql = "INSERT INTO staff (first_name, last_name, username, email, phone_number, role, password, hire_date, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, "ssssssssd", $first_name, $last_name, $username, $email, $phone_number, $role, $hashed_password, $hire_date, $salary);
                            if (mysqli_stmt_execute($stmt)) {
                                $success_message = "Staff member added successfully.";
                            } else {
                                $error_message = "Error adding staff member: " . mysqli_error($conn);
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
                    $sql = "UPDATE staff SET first_name = ?, last_name = ?, username = ?, email = ?, phone_number = ?, role = ?, password = ?, hire_date = ?, salary = ? WHERE staff_id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssssssdi", $first_name, $last_name, $username, $email, $phone_number, $role, $hashed_password, $hire_date, $salary, $staff_id);
                    }
                } else {
                    // This is the corrected section
                    $sql = "UPDATE staff SET first_name = ?, last_name = ?, username = ?, email = ?, phone_number = ?, role = ?, hire_date = ?, salary = ? WHERE staff_id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Changed "sssssssi" to "sssssssdi" to match 9 placeholders (7 strings, 1 decimal, 1 integer)
                        mysqli_stmt_bind_param($stmt, "sssssssdi", $first_name, $last_name, $username, $email, $phone_number, $role, $hire_date, $salary, $staff_id);
                    }
                }

                if ($stmt) {
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Staff member updated successfully.";
                    } else {
                        $error_message = "Error updating staff member: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error preparing statement: " . mysqli_error($conn);
                }
            }
        }
    }
}

// --- Handle Delete Staff ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $sql = "DELETE FROM staff WHERE staff_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Staff member deleted successfully.";
            } else {
                $error_message = "Error deleting staff member: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

// --- Fetch all staff members for display ---
$staff_members = [];
$sql = "SELECT staff_id, first_name, last_name, username, email, phone_number, role, hire_date, salary FROM staff ORDER BY staff_id DESC";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $staff_members[] = $row;
    }
    mysqli_free_result($result);
} else {
    $error_message = "Error fetching staff members: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - Admin Dashboard</title>
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
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
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
        <h1>Manage Staff</h1>
        <p><a href="admin.php">Back to Dashboard</a></p>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container" id="staffForm">
            <h2>Add New Staff Member</h2>
            <form action="admin_manage_staff.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="staff_id" id="formStaffId" value="0">

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

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Chef">Chef</option>
                    <option value="Waiter">Waiter</option>
                    <option value="Manager">Manager</option>
                    <option value="Cashier">Cashier</option>
                    <option value="Cleaner">Cleaner</option>
                </select>

                <label for="hire_date">Hire Date:</label>
                <input type="date" id="hire_date" name="hire_date" required>

                <label for="salary">Salary:</label>
                <input type="number" step="0.01" id="salary" name="salary" required>

                <label for="password">Password (Leave blank if not changing for edit):</label>
                <input type="password" id="password" name="password">

                <button type="submit">Submit Staff</button>
                <button type="button" class="cancel" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <h2>Current Staff Members</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($staff_members) > 0): ?>
                    <?php foreach ($staff_members as $staff): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($staff['staff_id']); ?></td>
                            <td><?php echo htmlspecialchars($staff['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($staff['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($staff['username']); ?></td>
                            <td><?php echo htmlspecialchars($staff['email']); ?></td>
                            <td><?php echo htmlspecialchars($staff['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($staff['role']); ?></td>
                            <td><?php echo htmlspecialchars($staff['hire_date']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($staff['salary'], 2)); ?></td>
                            <td class="action-links">
                                <a href="#" onclick="editStaff(<?php echo htmlspecialchars(json_encode($staff)); ?>)">Edit</a>
                                <a href="admin_manage_staff.php?delete_id=<?php echo htmlspecialchars($staff['staff_id']); ?>" onclick="return confirm('Are you sure you want to delete this staff member?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No staff members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editStaff(staff) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formStaffId').value = staff.staff_id;
            document.getElementById('first_name').value = staff.first_name;
            document.getElementById('last_name').value = staff.last_name;
            document.getElementById('username').value = staff.username;
            document.getElementById('email').value = staff.email;
            document.getElementById('phone_number').value = staff.phone_number;
            document.getElementById('role').value = staff.role;
            document.getElementById('hire_date').value = staff.hire_date;
            document.getElementById('salary').value = staff.salary;
            document.getElementById('password').value = ''; // Leave blank for security
            document.querySelector('#staffForm h2').innerText = 'Edit Staff Member';
            document.querySelector('#staffForm button[type="submit"]').innerText = 'Update Staff';
        }

        function resetForm() {
            document.getElementById('staffForm').reset();
            document.getElementById('formAction').value = 'add';
            document.getElementById('formStaffId').value = '0';
            document.querySelector('#staffForm h2').innerText = 'Add New Staff Member';
            document.querySelector('#staffForm button[type="submit"]').innerText = 'Submit Staff';
        }
    </script>
</body>
</html>