<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
            
    $query = "SELECT * FROM users WHERE username= '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['jabatan'] = $user['jabatan'];
        header('Location: dashboard.php');
    } else{
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In Cafekita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <span class="borderLine"></span>
        <form action="" method="POST">
            <h2>Sign In</h2>
            <div class="inputBox">
                <input type="text"  name="username" id="username" required>
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password"  name="password" id="password" required>
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="">Forgot Password</a>
                <a href="">Signup</a>
            </div>
            <input type="submit">
        </form>
    </div>
</body>
</html>