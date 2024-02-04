<!-- profile.php -->
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

$email = $_SESSION['email'];

// Check if the email exists in the userprofile table
$sql_check = "SELECT COUNT(*) AS count FROM userprofile WHERE email='$email'";
$result_check = $conn->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    // Fetch user profile data
    $sql_profile = "SELECT * FROM userprofile WHERE email='$email'";
    $result_profile = $conn->query($sql_profile);
    $row_profile = $result_profile->fetch_assoc();

    $firstName = $row_profile['firstName'];
    $lastName = $row_profile['lastName'];
    $age = $row_profile['age'];
    $gender = $row_profile['gender'];
    $address = $row_profile['address'];
} else {
    // Insert new row into userprofile table
    $sql_insert = "INSERT INTO userprofile (email) VALUES ('$email')";
    if ($conn->query($sql_insert) === TRUE) {
        // Set default values for profile fields
        $firstName = '';
        $lastName = '';
        $age = '';
        $gender = 'select';
        $address = '';
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
</head>
<body>
    <div class="container">
        <h2>Profile</h2>
        <form id="profileForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="select" <?php if($gender == "select") echo "selected"; ?>>Select</option>
                    <option value="male" <?php if($gender == "male") echo "selected"; ?>>Male</option>
                    <option value="female" <?php if($gender == "female") echo "selected"; ?>>Female</option>
                    <option value="other" <?php if($gender == "other") echo "selected"; ?>>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address"><?php echo $address; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save details</button>
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
        });
    </script>
</body>
</html>
