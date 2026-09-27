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
        header("location:admin/admin-dashboard.php");
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
      background: url('img/admin-log.jpg') no-repeat center center/cover; /* Background image */
      display: flex;
      justify-content: center;
      align-items: center;
      color:black;
    }
    form {
      text-align: center;
      width: 300px;
    }
    h2 {
      margin-bottom: 30px;
      font-size: 26px;
      letter-spacing: 1px;
      text-transform: uppercase;
      
    }
    .input-group {
      position: relative;
      margin-bottom: 20px;
    }
    .input-group i {
      position: absolute;
      left: 10px;
      top: 12px;
      color: #fff;
    }
    .input-group input {
      width: 100%;
      padding: 10px 10px 10px 35px;
      border: 2px solid #fff;
      background: transparent;  /* fully transparent */
      color: #fff;
      outline: none;
      font-size: 14px;
      border-radius: 5px;
    }
    .input-group input::placeholder {
      color: #eee;
    }
    .login-btn {
      width: 115%;
      padding: 10px;
      border: 2px solid black;
      background: transparent;  /* fully transparent */
      color:black;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
      border-radius: 5px;
    }
    .login-btn:hover {
      background: rgba(255, 255, 255, 0.2); /* slight white overlay */
      color: #fff;
    }
  </style>
</head>
<body>

  <form method="post">
    <h2>Admin Login</h2>
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

</body>
</html>
