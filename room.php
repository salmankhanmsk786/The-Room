<?php
    include 'get_group_info.php';


    // Redirect to the login page if the user is not logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit;
    }

    $groupData = getGroupInfo();

    if (!$groupData['success']) {
    // Handle error, e.g., show an error message or redirect
    die("Error: " . $groupData['message']);
    }

    $groupNumber = $groupData['groupInfo']['group_number'];
    $groupMessage = $groupData['groupInfo']['message'];
    $groupmember = $groupData['groupInfo']['members'];
    $facultyComment = $groupData['groupInfo']['faculty_comment'] ?? 'No comment';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room</title>
    <link rel="stylesheet" href=".css" type="text/css">
    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            z-index: 1;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: center;
            height: 100vh;
            width: 100vw;
            color : white;
            background-color: #321545; /* Replace #ff0000 with your desired color */            

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

        .container {
                  
            display : flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1;
            background-color: #210633;
            position: relative;
            border : 5px solid #a773c9;
            border-radius: 10px;
                   
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


        /* The clock layout */
        #clock {
            z-index: 1;

        }

        /* The clock table */
        .clock-table {
            
            z-index: 1;
            position: relative;
            border-collapse: collapse;

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
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            position: relative;
            width: 100%;
            display : flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: center;
            margin-top: 40px;
            margin-bottom: 50px;

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

        .faculty-comment {
            z-index: 2;
            background-color: #210633;
            color : white;
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 10px;
            text-decoration: none;
            padding : 10px;
            width: 70vw;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

        }

</style>

</head>
<body>
    
<h1>Student Dashboard</h1>


<div class="container">

    <div class="message">
        <h1> <?php echo $groupMessage; ?> </h1>
    </div>
            
    <!-- The ID "clock" is for the clock layout -->
        <div id="clock" >
   
        <!-- The clock layout will be generated here by room.js -->
        <table class="clock-table">

        <!-- Generate the clock layout here -->
        <?php
        // Define the positions of each member on the "clock"
        $positions = [

            [2, 0], [3, 1], [3, 3], [4, 2], [2, 4], [1, 3], [0, 2], [1, 1],
        ];

        // Get the members from the group data
        $members = $groupData['groupInfo']['members'];
        for ($row = 0; $row < 5; $row++) {
            echo '<tr>';        
            for ($col = 0; $col < 5; $col++) {
                if ($row == 2 && $col == 1) {
                    echo "<td colspan='3'  >Table: {$groupNumber}</td>";
                    $col += 2; // Skip the next 2 columns because they are now merged into one
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
        foreach ($groupmember as $member) {
            if ($member['role'] == 'student') { 
                echo '<ui> ' . $member['first_name'] . ' ' . $member['last_name'] .'<br>'.  '' . '</ui>';
            }
        }
    ?>
    </div>

</div>

<!-- Display faculty comment -->
    <div class="faculty-comment">
        <h3>Message from Faculty: </h3>
        <p><?php echo htmlspecialchars($facultyComment); ?></p>
    </div>


<!-- Logout Button -->
<a href="logout.php" class="logout-button"> Logout </a>

</body>
</html>
