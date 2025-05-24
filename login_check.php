<?php
// Start session to manage user login state
session_start();

// !!! IMPORTANT SECURITY WARNING !!!
// Directly comparing passwords like this is INSECURE.
// This is used here to match your database structure shown previously.
// For any production system, use password_hash() and password_verify().

// Database credentials - Replace with your actual details if they change
$servername = "localhost"; // Or your database server name
$username = "root";      // Your database username
$password = "";          // Your database password (empty string)
$dbname = "project";     // Your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    // In a real application, you might log this error and show a generic message
    die("Connection failed: " . $conn->connect_error);
}

// Get username and password from the form
// Using htmlspecialchars to prevent XSS in case input is echoed (though not directly here)
$input_username = htmlspecialchars($_POST['username']);
$input_password = $_POST['password']; // Password is not escaped with htmlspecialchars before verification

// Prepare and execute a SQL query to find the user
// Using prepared statements is crucial for preventing SQL injection
$sql = "SELECT username, password, role FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Handle prepare error - log this in production
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, fetch data and verify the password
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];
    $user_role = $row['role'];

    // --- INSECURE DIRECT PASSWORD COMPARISON ---
    if ($input_password === $stored_password) {
        // Password is correct, set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $user_role; // Store the user's role in the session

        // Redirect based on role
        if ($user_role === 'Admin') {
            header("Location: admin.php"); // Redirect to admin.html
        } else {
            header("Location: customer.php"); // Redirect to customer.html
        }
        exit(); // Stop script execution after redirection

    } else {
        // Invalid password
        // Redirect back to login.html with an error message
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    // No user found with that username
    // Redirect back to login.html with an error message
    header("Location: login.php?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>