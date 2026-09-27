<?php
session_start();
include('includes/config.php');

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prepared statement to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT email, password, id FROM userregistration WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_email, $db_password, $id);
    $rs = $stmt->fetch();
    
    if($stmt->num_rows > 0 && password_verify($password, $db_password))
    {
        $_SESSION['id'] = $id;
        $_SESSION['login'] = $db_email;

        $ip = $_SERVER['REMOTE_ADDR'];
        $geopluginURL = 'http://www.geoplugin.net/php.gp?ip='.$ip;
        $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
        $city = $addrDetailsArr['geoplugin_city'] ?? 'Unknown';
        $country = $addrDetailsArr['geoplugin_countryName'] ?? 'Unknown';

        $log = "INSERT INTO userLog(userId,userEmail,userIp,city,country) VALUES(?,?,?,?,?)";
        $log_stmt = $mysqli->prepare($log);
        $log_stmt->bind_param('issss', $id, $db_email, $ip, $city, $country);
        $log_stmt->execute();
        $log_stmt->close();

        header("Location: User-dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username/Email or password";
    }
    $stmt->close();
}
?>
   

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: #B589D6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
    margin: 0;
}

.login-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 350px;
}

h2 {
    margin-bottom: 30px;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 1.8em;
}

/* Error message */
.error-message {
    color: #e74c3c;
    background: #fadbd8;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    display: <?php echo isset($error) ? 'block' : 'none'; ?>;
}

/* Input with icon */
.input-group {
    position: relative;
    margin-bottom: 20px;
}

.input-group i {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #999;
    font-size: 1.2em;
}

.input-group input {
    width: 100%;
    box-sizing: border-box;
    padding: 12px 12px 12px 40px;
    font-size: 1em;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.input-group input:focus {
    border-color: #f39c12;
    outline: none;
}

/* Login button */
button {
    width: 100%;
    padding: 12px;
    font-size: 1.1em;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: linear-gradient(45deg, #8e44ad, #9b59b6);
    color: white;
    transition: all 0.3s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

/* Registration link */
.registration-link {
    margin-top: 15px;
    text-align: center;
}

.registration-link a {
    color: #8e44ad;
    text-decoration: none;
}

.registration-link a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="login-container">
    <h2><i class="fas fa-user"></i>User Login</h2>
    
    <?php if(isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login">Login</button>
    </form>
    
    <div class="registration-link">
        <a href="registration.php">Don't have an account? Register</a>
    </div>
</div>

</body>
</html>