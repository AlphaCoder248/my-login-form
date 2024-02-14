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

$sql_check = "SELECT COUNT(*) AS count FROM userprofile WHERE email='$email'";
$result_check = $conn->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    $sql_profile = "SELECT * FROM userprofile WHERE email='$email'";
    $result_profile = $conn->query($sql_profile);
    $row_profile = $result_profile->fetch_assoc();

    $firstName = $row_profile['firstName'];
    $lastName = $row_profile['lastName'];
    $age = $row_profile['age'];
    $gender = $row_profile['gender'];
    $phone = $row_profile['phone'];
} else {
    $sql_insert = "INSERT INTO userprofile (email) VALUES ('$email')";
    if ($conn->query($sql_insert) === TRUE) {
        $firstName = '';
        $lastName = '';
        $age = '';
        $gender = 'select';
        $phone = '';
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: steelblue;
        }
        .container {
            background-color: #a6e6f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
        h2 {
            color: #333333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: bold;
            color: #555555;
        }
        .btn {
            margin-top: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            width: 100%;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profile</h2>
        <form id="profileForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
                </div>
                <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="select" <?php if($gender == "select") echo "selected"; ?>>Select</option>
                        <option value="male" <?php if($gender == "male") echo "selected"; ?>>Male</option>
                        <option value="female" <?php if($gender == "female") echo "selected"; ?>>Female</option>
                        <option value="other" <?php if($gender == "other") echo "selected"; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Save Details</button>
                </div>
                <div class="col-md-6">
                    <button id="logoutButton" class="btn btn-danger">Logout</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#profileForm').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'update_profile.php',
                    data: $(this).serialize(),
                    success: function(response){
                        alert(response);
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                    }
                });
            });
            $('#logoutButton').click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'logout.php',
                    success: function(response){
                        window.location.href = "login.html";
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>

