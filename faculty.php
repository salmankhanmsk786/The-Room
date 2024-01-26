<?php
session_start();

// Redirect to the login page if the user is not a faculty member or not logged in
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

// Fetch all groups
$sql = "SELECT * FROM groups";
$groups = [];

if ($result = $conn->query($sql)) {
    while ($group = $result->fetch_assoc()) {
        // Fetch members for this group

        $membersSql = "SELECT user_id, first_name, last_name, photo, role FROM members WHERE FIND_IN_SET(user_id, ?) AND is_logged_in = TRUE;
        ";
        if ($memberStmt = $conn->prepare($membersSql)) {
            $memberStmt->bind_param("s", $group['student_ids']);
            $memberStmt->execute();
            $membersResult = $memberStmt->get_result();
            $members = [];
            while ($member = $membersResult->fetch_assoc()) {
                // Only add students to the array, skip faculty members
                if ($member['role'] == 'student') {
                    $members[] = $member;
                }
            }
            $group['members'] = $members;
            $groups[] = $group;
        }
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="styles.css">  
    <style>

    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        z-index: 1;
        background-color: #210633;
        color : white;
        display: flex;
        justify-content: center;
        align-items: center;

        }

        h1 {
            font-size: 50px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            color : white;
            margin-top: 50px;
            margin-bottom: 50px;
            position: absolute;
            z-index: 2;
            top: 0;

        }

        .group-container {

            display : flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1;
            position: absolute;
            border-radius: 10px;
            width: 400px; 
            height: 800px;
            margin: 20px auto; /* Centers the container and adds space around it */
            position: relative;
            justify-content: space-between; /* This will distribute space evenly */
            margin-top: 150px;
            margin-bottom: 150px;
        }


        .container {
                  
            display : flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 1;
            background-color: #210633;
            position: relative;
            border : 5px solid #a773c9;
            border-radius: 10px;
            width: 400px; 
            height: 800px; 
            position: relative;
               
        }


        .message {
           
           background-color: #210633;
           position: relative;
           z-index: 1;
           text-align: center;
           color: white;
           font-size: 22px;
           font-weight: bold;
           font-family: Arial, Helvetica, sans-serif;
           position: relative;
           width: 100%;
           height: 100px;
           border-radius: 10px;
           display: flex ;
        justify-content: center;
            align-items: center;
            

       }

       .message, .Groupname-container, .clock-table {
        width: calc(100% - 40px); /* Adjust width to account for padding */
        height: calc(100% - 40px); /* Adjust height to account for padding */
         max-width: 100%; /* Ensure it doesn't grow larger than the container */
        max-height: 100%; /* Ensure it doesn't grow larger than the container */
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
   
        }



        /* The clock layout */
        #clock {
            z-index: 1;
            position: relative;
            justify-content: center;
            display: flex;
            align-items: center;
            flex-direction: column;

        }

        /* The clock table */
        .clock-table {
            
            z-index: 1;
            position: relative;
            border-collapse: collapse;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

        }

        /* The clock table cells */
        .clock-table td {
           
            padding: 10px;
            margin: 0;
            z-index: 1;
            overflow: hidden;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            color : black;
            position: relative;
            width: 50px;
            height: 50px;
            background-color: #210633;
            color : white;  

        }

        /* The clock table cell content */
        .clock-table td img {
            width: 100%;   
            height: 100%;
            z-index: 1;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            overflow: hidden;
            display: block;
            position: relative;
                

        }

        .Groupname-container {

            background-color: #210633;
            color : white;
            z-index: 1;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            position: relative;
            width: 100%;
            border-radius: 10px;
            text-align: center;
            padding: 10px;
            margin: 0;
            
        }

        .logout-button {
            position: absolute;
            z-index: 2;
            background-color: #210633;
            color : white;
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 10px;
            text-decoration: none;
            padding : 10px;
            bottom : 50px;
        }

        .logout-button:hover {
            background-color: #a773c9;
            color : white;           
            transition : 0.5s;
        }

        .group-messages {
           
            color : white;
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 10px;
            text-decoration: none;
            padding : 10px;
            margin: 0;
            height: 100px;
            width: 100px;
            position: relative;
            z-index: 1;
            overflow: hidden;
            text-align: center;
            
        }

        .group-messages p {
            margin: 0;
            padding: 0;
            margin-bottom: 10px;
        }

        .group-messages p small {
            font-size: 12px;
            font-weight: normal;
        }

        button {
            background-color: #210633;
            color : white;
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 10px;
            text-decoration: none;
            padding : 10px;
            margin: 0;
            position: relative;
            z-index: 1;
            overflow: hidden;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #a773c9;
            color : white;           
            transition : 0.5s;
        }

        textarea {
            background-color: white;
            color : black;
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 10px;
            text-decoration: none;
            margin: 0;
            position: relative;
            z-index: 1;
            overflow: hidden;
            text-align: center;
            height: 100px;
        }

    </style>

</head>
<body>


<h1>Faculty Dashboard</h1>

<?php foreach ($groups as $group): ?>
    <div class="group-container">

        <div class="container">

            <!-- The ID "clock" is for the clock layout -->
            <div class="message">
                <?php echo $group['message']; ?>
            </div>

                <div id="clock" >
   
                <table class="clock-table">

                    <!-- Generate the clock layout here -->
                 <?php
                    // Define the positions of each member on the "clock"
                $positions = [

                    [2, 0], [3, 1], [3, 3], [4, 2], [2, 4], [1, 3], [0, 2], [1, 1],
                ];

        // Get the members from the group data
        $members = $group['members'];
        for ($row = 0; $row < 5; $row++) {
            echo '<tr>';        
            for ($col = 0; $col < 5; $col++) {
                if ($row == 2 && $col == 1) {
                    echo "<td colspan='3'  >Table: {$group['group_number']}</td>";
                    $col += 2; 
                }
                
                else if ($row != 2 || ($col != 1 && $col != 2 && $col != 3)) {
                    // Check if this position should have a member photo
                    $positionIndex = array_search([$col, $row], $positions);
                    
                    if ($positionIndex !== false && isset($members[$positionIndex])) {
                        // Output the member photo
                        $member = $members[$positionIndex];
                        $imagePath = $member['photo'] ? $member['photo'] : 'default-placeholder.png'; // Specify the path to your default image
                        if ($member['role'] == 'student') { 
                            
                            echo "<td><img src='{$imagePath}' alt='Profile photo'></td>";
                        }
                       
                    } else {
                        echo '<td></td>';
                    }

                }
            }
            echo '</tr>';
        }
        ?>       
        </table>
            
        </div>
        
            <div class="Groupname-container">
             <?php
             // Check if each member is a student and display their name if they are
             foreach ($members as $member) {
                if ($member['role'] == 'student') {
                    echo "<h5>{$member['first_name']} {$member['last_name']}</h5>";
                }
             }
             ?>
            </div>
        </div>

       <!-- Form for submitting faculty comment -->
    <form method="post" action="submitComment.php">
        <input type="hidden" name="group_number" value="<?php echo $group['group_number']; ?>">
        <textarea name="comment" placeholder="Write a comment..."></textarea>
        <button type="submit">Submit Comment</button>
    </form>


</div>


<?php endforeach; ?>    

<!-- Logout Button -->
<a href="logout.php" class="logout-button"> Logout </a>
</body>
</html>
