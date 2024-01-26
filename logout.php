<?php
session_start();

// Database credentials
$dbHost = 'localhost';
$dbUsername = 'salman';
$dbPassword = 'salman';
$dbName = 'school_system';

// Create a connection to the database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // Prepare an update statement
    $sql = "UPDATE members SET is_logged_in = FALSE WHERE user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind user_id to the statement
        $stmt->bind_param("i", $_SESSION["user_id"]);
        // Execute the statement
        $stmt->execute();
        // Close the statement
        $stmt->close();
    }

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: index.html");
    exit;
}

// Close connection
$conn->close();
?>
