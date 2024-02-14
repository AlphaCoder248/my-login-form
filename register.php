<?php
$servername = "localhost";
$username = "newuser";
$dbpassword = "admin123";
$dbname = "login-form";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password != $confirmPassword) {
    echo "Passwords do not match";
    exit;
}

$sql_check_email = "SELECT * FROM users WHERE email='$email'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email->num_rows > 0) {
    echo "Email already exists";
    exit;
}


$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
