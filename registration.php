<?php
    session_start();
    include('config.php');
    $msg = "";
    if(isset($_POST['register'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

        if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
            $msg = "Username should only contain alphanumeric characters!";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid Email!";
        }
        elseif(strlen($password) < 6) {
            $msg = "Password must be atleast 6 characters!";
        }
        elseif($password != $cpassword) {
            $msg = "Passwords do not match!";
        }
        else {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                $msg = "Email already exists!";
            }
            else {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hash_password')";
                mysqli_query($conn, $query);
                $_SESSION['username'] = $username;
                header('location: index.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <form method="post" action="">
                <h2>Registration</h2>
                <?php if($msg != "") echo "<div class='error'>".$msg."</div>"; ?>
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" required>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn" name="register">Register</button>
                </div>
                <p>Already a member? <a href="login.php">Sign in</a></p>
            </form>
        </div>
    </body>
</html>
