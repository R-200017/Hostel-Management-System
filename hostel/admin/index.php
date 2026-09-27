<?php
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT username,email,password,id FROM admin WHERE (userName=? || email=?) AND password=? ");
    $stmt->bind_param('sss', $username, $username, $password);
    $stmt->execute();
    $stmt->bind_result($username, $username, $password, $id);
    $rs = $stmt->fetch();
    $_SESSION['id'] = $id;

    if ($rs) {
        header("location:admin-dashboard.php");
        exit;
    } else {
        echo "<script>alert('Invalid Username/Email or Password');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/font-awesome.min.css"> <!-- For icons -->
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #0072ff, #00c6ff); /* blue gradient like screenshot */
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }
    .login-container {
      text-align: center;
      width: 300px;
    }
    .login-container img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 20px;
    }
    .input-group {
      position: relative;
      margin-bottom: 20px;
    }
    .input-group i {
      position: absolute;
      left: 10px;
      top: 12px;
      color: #aaa;
    }
    .input-group input {
      width: 100%;
      padding: 10px 10px 10px 35px;
      border: none;
      border-bottom: 2px solid #fff;
      background: transparent;
      color: #fff;
      outline: none;
      font-size: 14px;
    }
    .input-group input::placeholder {
      color: #eee;
    }
    .login-btn {
      width: 100%;
      padding: 10px;
      border: 2px solid #fff;
      background: transparent;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }
    .login-btn:hover {
      background: #fff;
      color: #0072ff;
    }
    .options {
      margin-top: 10px;
      font-size: 13px;
      display: flex;
      justify-content: space-between;
    }
    .options a {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- User avatar -->
    <img src="img/user.png" alt="Admin">

    <form method="post">
      <div class="input-group">
        <i class="fa fa-user"></i>
        <input type="text" name="username" placeholder="Username or Email" required>
      </div>
      <div class="input-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <input type="submit" name="login" value="LOGIN" class="login-btn">
    </form>

    <div class="options">
      <label><input type="checkbox"> Remember me</label>
      <a href="#">Forgot Password?</a>
    </div>
  </div>
</body>
</html>
