<!-- login.php -->
<?php
session_start();

$servername = "localhost";
$username = "newuser";
$dbpassword = "admin123";
$dbname = "login-form";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password == $row['password']) {
        $_SESSION['email'] = $email;
        echo "Login successful";
    } else {
        echo "Incorrect password";
    }
} else {
    echo "User not found";
}

$conn->close();
?>
