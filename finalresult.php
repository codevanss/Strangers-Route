<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "strangers_route";

// Create a database connection
$con = new mysqli($server, $username, $password, $database);

// Check for connection errors
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$data = []; // Store results in an array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $tripdate = $_POST['tripdate']; // Ensure this matches the form input name


    // Prepare SQL statement (corrected column name)
    $stmt = $con->prepare("SELECT * FROM creator WHERE departure = ? AND destination = ? AND tripdate = ?");
    $stmt->bind_param("sss", $departure, $destination, $tripdate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store results in an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strangers Route</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body style="background-image: url('./images/images/dubai-4044183_1280.jpg') ">
    <div class="container" style="opacity:0.8">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6 text-center">Results According to Your Search</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class="bg-dark text-white">
                                <td>ID</td>
                                <td>Name</td>
                                <td>Gender</td>
                                <td>Passenger Type</td>
                                <td>Departure</td>
                                <td>Destination</td>
                                <td>Trip Date</td>
                                <td>Email</td>
                            </tr>
                            <?php if (!empty($data)) { ?>
                                <?php foreach ($data as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['creator_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($row['passanger_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['departure']); ?></td>
                                        <td><?php echo htmlspecialchars($row['destination']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tripdate']); ?></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                                                <?php echo htmlspecialchars($row['email']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan='7'>No trips found for this destination.</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>