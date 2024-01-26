<?php
session_start();

// Only allow faculty to submit comments
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'faculty') {
    header('Location: login.html');
    exit;
}


// Database connection details
$dbHost = 'localhost';
$dbUsername = 'salman';
$dbPassword = 'salman';
$dbName = 'school_system';

// Create a new database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['group_number']) && isset($_POST['comment'])) {
    // Database connection details
    // ... (same as before)

    $groupNumber = $_POST['group_number'];
    $comment = $_POST['comment'];

    // Update the faculty_comment in the database
    $sql = "UPDATE groups SET faculty_comment = ? WHERE group_number = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $comment, $groupNumber);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    // Redirect back to faculty.php
    header('Location: faculty.php');
    exit;
}
?>
