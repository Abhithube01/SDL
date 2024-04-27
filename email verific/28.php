<?php
// Step 1: Database Connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Registration Form (index.php)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
// Step 3: Register User (register.php)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Generate Verification Code
    $verificationCode = md5(uniqid(rand()));

    // Insert user data into database
    $sql = "INSERT INTO users (email, password, verification_code, is_verified) VALUES ('$email', '$password', '$verificationCode', 0)";
    if ($conn->query($sql) === TRUE) {
        // Send Verification Email
        $to = $email;
        $subject = "Email Verification";
        $message = "Click the link to verify your email: http://yourdomain.com/verify.php?code=$verificationCode";
        $headers = "From: your@example.com";
        mail($to, $subject, $message, $headers);
        echo "Registration successful. Please verify your email.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Step 4: Verify Email (verify.php)
if(isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
    $sql = "SELECT * FROM users WHERE verification_code='$verificationCode' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $email = $user['email'];
        // Update user's status to verified
        $update_sql = "UPDATE users SET is_verified=1 WHERE email='$email'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Email verification successful. You can now <a href='login.php'>login</a>.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid verification code.";
    }
}

// Step 5: Login Page (login.php)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
