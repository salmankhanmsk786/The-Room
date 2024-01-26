<?php
session_start();

function getGroupInfo() {
    // Database connection details
    $dbHost = 'localhost';
    $dbUsername = 'salman';
    $dbPassword = 'salman';
    $dbName = 'school_system';

    // Create a new database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }

    $userId = $_SESSION['user_id'] ?? 0;

    $sql = "SELECT g.group_number, g.message, m.user_id, m.first_name, m.last_name, m.photo, m.role, g.faculty_comment
            FROM groups g
            JOIN members m ON FIND_IN_SET(m.user_id, g.student_ids)
            WHERE FIND_IN_SET(?, g.student_ids) AND m.is_logged_in = TRUE";


    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $groupInfo = [];
        while ($row = $result->fetch_assoc()) {
            $groupInfo['group_number'] = $row['group_number'];
            $groupInfo['message'] = $row['message'];
            $groupInfo['faculty_comment'] = $row['faculty_comment'];
            $groupInfo['members'][] = [
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'photo' => $row['photo'],
                'role' => $row["role"]

            ];
        }

        $stmt->close();
        $conn->close();
        return ['success' => true, 'groupInfo' => $groupInfo];
    } else {
        return ['success' => false, 'message' => 'Failed to prepare the SQL statement'];
    }
}

// Check how the script is being accessed
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header('Content-Type: application/json');
    echo json_encode(getGroupInfo());
}
?>
