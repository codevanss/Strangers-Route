<?php
session_start();
if(!isset($_SESSION['userLoggedIn'])){ // Check if the user is logged in
    header("Location: LOGIN (1).php"); // Redirect to the login page
    exit(); // Stop further execution of the script
}
$insert = false;
if(isset($_POST['name'])){
    // Set connection variables
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "strangers_route";

    // Create a database connection
    $con = mysqli_connect($server, $username, $password , $database);
    // Check for connection success
    if(!$con){
        echo "Connection not established";
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success connecting to the db";

    // Collect post variables
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $passanger_type = $_POST['passanger_type'];
    $passanger_count = $_POST['passanger_count'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $tripdate = date('Y-m-d', strtotime($_POST['tripdate']));
    $email = $_POST['email'];
    $sql = "INSERT INTO `strangers_route`.`creator` (`name`, `gender`, `passanger_type`, `passanger_count`, `departure`, `destination`, `tripdate` ,`email`) VALUES ('$name', '$gender', '$passanger_type', '$passanger_count', '$departure', '$destination', '$tripdate' , '$email');";
    // echo $sql;

    // checking date format
    // echo "Formatted Date: " . $tripdate;

    // Execute the query
    if($con->query($sql) == true){
        // echo "Successfully inserted";

        // Flag for successful insertion
        $insert = true;
    }
    else{
        echo "ERROR: $sql <br> $con->error";
    }

    // Close the database connection
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="icon" href="images/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="find.css">
    <title>Strangers Route</title>

    <style>
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            position: relative;
            width: 70%;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }
    </style>

<script>
    $(document).ready(function() {
        $("#tripDate").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showAnim: "slideDown"
        });
    });
    
            
</script>


</head>
<body>
    <header style="padding: 15px; margin:10px;">
        <div class="logo">
            <a href="#"><img src="images/tes.png" alt="logo"  ></a>
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="find.html">Find</a></li>
            </ul>
        </nav>
    </header>

    <main>
        
        <div class="background">
            
        <form action="" method="post">
            <div class="box1" style="height: 525px; margin: 10px; ">
                <h2 style="margin-top: 5px;">Create Trip</h2>

                <input type="text" name="name" placeholder="Enter Your Name">

                <div class="gender-container">
                    <p>Gender:</p>
                    <label for="male">
                        <input type="radio" name="gender" id="male" value="Male"> Male
                    </label>
                    <label for="female">
                        <input type="radio" name="gender" id="female" value="Female"> Female
                    </label>
                </div>

                <select name="passanger_type">
                    <option value="" disabled selected>Select Passenger Type</option>
                    <option value="Adult">Adult</option>
                    <option value="Child">Child</option>
                    <option value="Senior">Senior Citizen</option>
                </select>

                <input type="number" name="passanger_count" min="1" placeholder="Enter Passenger Count">
                <input type="text" name="departure" placeholder="Enter your Departure (Country,Region, or City)">
                <input type="text" name="destination" placeholder="Enter your Destination (Country,Region, or City)">
                <input type="date" id="tripdate" name="tripdate" class="form-control" placeholder="Select a date" required>
                <input type="email" name="email" placeholder="Enter Your Email" required>
                
                <button style="margin-bottom: 5px;">Submit</button>
            </div>
        </form>
  
            <div class="text">
                <h3>Try our new trip Customizer</h3>
                <p>Create a day-by-day itinerary<br/>customized to you</p>
                <button class="customize-btn"><a href="find.html">Find Trip</a></button>
            </div>
        </div>
    </main>

</body>
</html>
