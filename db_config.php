<?php
// db_config.php

define('DB_SERVER', 'localhost'); // Your database server
define('DB_USERNAME', 'root');   // Your database username
define('DB_PASSWORD', '');       // Your database password (default for XAMPP is empty)
define('DB_NAME', 'project');    // Your database name
define('DB_PORT', 3307);         // <--- NEW LINE: Define the custom MySQL port

// Attempt to connect to MySQL database
// The port is now passed as the 5th argument to mysqli_connect
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>