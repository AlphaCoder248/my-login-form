<?php
session_start();

$servername = "localhost";
$username = "newuser";
$dbpassword = "admin123";
$dbname = "login-form";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];

$sql = "INSERT INTO userprofile (email, firstName, lastName, age, gender, address) 
        VALUES ('$email', '$firstName', '$lastName', '$age', '$gender', '$address')
        ON DUPLICATE KEY UPDATE firstName='$firstName', lastName='$lastName', age='$age', gender='$gender', address='$address'";

if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
