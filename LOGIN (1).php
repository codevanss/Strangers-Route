<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_POST['login'])) {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "strangers_route";

    $con = new mysqli($server, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $email = trim($_POST['email']);
    $passwordInput = trim($_POST['password']);

    $stmt = $con->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $registration = $result->fetch_assoc();

        // Uncomment for debugging password mismatch
        echo "Input: " . $passwordInput . "<br>";
        echo "Stored: " . $registration['password'] . "<br>";

        if (password_verify($passwordInput, $registration['password'])) {
            $_SESSION['userLoggedIn'] = $email;
            $_SESSION['username'] = $registration['username'];
            header("Location: create.php");
            exit();
            echo "done";

        } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh; background: url('./images/login_image.jpg') no-repeat center center fixed; background-size: cover; opacity: 0.7; " >
    <form method="post" class="bg-white p-5 rounded shadow" style="width: 900px;">
        <h2 class="text-center mb-4" >Login</h2>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        <div class="text-center mt-3">
            <p>Not registered? <a href="registration.php" class="text-primary">Register</a></p>
        </div>
    </form>
</body>
</html>
