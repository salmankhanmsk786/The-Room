<?php
session_start(); // Start a new session or resume the existing one

header('Content-Type: application/json'); // Specify the return content type as JSON

// These variables should be retrieved from a config file or environment variables
$dbHost = 'localhost';
$dbUsername = 'salman'; // Use the appropriate username for your database
$dbPassword = 'salman'; // Use the appropriate password for your database
$dbName = 'school_system';

// Create a connection to the database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post variables
    $userId = $_POST['userid'];
    $password = $_POST['password'];
    
    // Prepare a select statement
    $sql = "SELECT user_id, first_name, last_name, password, role FROM members WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $userId);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();
            
            // Check if user exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($user_id, $first_name, $last_name, $hashed_password, $role);
                if ($stmt->fetch()) {
                    // Verify the password
                    if ($password === $hashed_password) {
                        // Password is correct, so start a new session
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["role"] = $role;
                        
                        // Send JSON response
                        if ($password === $hashed_password) {
                            // Password is correct, so start a new session
                            // Password is correct, so update login status
                            $updateLoginStatusSql = "UPDATE members SET is_logged_in = TRUE WHERE user_id = ?";
                                if ($updateStmt = $conn->prepare($updateLoginStatusSql)) {
                                     $updateStmt->bind_param("i", $user_id);
                                     $updateStmt->execute();
                                     $updateStmt->close();
                                     }

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["role"] = $role;


                            // Redirect to the appropriate page based on the user's role
                            if ($role === 'faculty') {
                                header('Location: faculty.php');
                            } else {
                                header('Location: room.php');
                            }
                            exit;
                        }
                    } else {
                        // Password is not valid, send JSON response
                        echo json_encode(['success' => false, 'message' => 'The password you entered was not valid.']);
                    }
                }
            } else {
                // User ID does not exist, send JSON response
                echo json_encode(['success' => false, 'message' => 'No account found with that user ID.']);
            }
        } else {
            // Execution failed, send JSON response
            echo json_encode(['success' => false, 'message' => 'Oops! Something went wrong. Please try again later.']);
        }

        // Close statement
        $stmt->close();
    }
} else {
    // Not a POST request, send JSON response
    echo json_encode(['success' => false, 'message' => 'Error: Request must be POST.']);
}

// Close connection
$conn->close();
?>
