<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Asia/Kolkata');
include('includes/checklogin.php');
check_login();
$ai=$_SESSION['id'];
// code for change password
if(isset($_POST['changepwd']))
{
  $op=$_POST['oldpassword'];
  $np=$_POST['newpassword'];
$udate=date('d-m-Y h:i:s', time());;
    $sql="SELECT password FROM userregistration where password=?";
    $chngpwd = $mysqli->prepare($sql);
    $chngpwd->bind_param('s',$op);
    $chngpwd->execute();
    $chngpwd->store_result(); 
    $row_cnt=$chngpwd->num_rows;;
    if($row_cnt>0)
    {
        $con="update userregistration set password=?,passUdateDate=?  where id=?";
$chngpwd1 = $mysqli->prepare($con);
$chngpwd1->bind_param('ssi',$np,$udate,$ai);
  $chngpwd1->execute();
        $_SESSION['msg']="Password Changed Successfully !!";
    }
    else
    {
        $_SESSION['msg']="Old Password not match !!";
    }   
    

}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Change Password</title>
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            background: #024542c6;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info span {
            margin-right: 15px;
        }
        
        .logout-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        .main-container {
            display: flex;
            min-height: calc(100vh - 70px);
        }
        
        .sidebar {
            width: 250px;
            background: #008080;
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            padding: 12px 20px;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar-menu li:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #4CAF50;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
        }
        
        .content {
            flex: 1;
            padding: 20px;
        }
        
        .page-title {
            color: #2a9880ff;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .panel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .panel-heading {
            background: #02625eff;
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
        }
        
        .panel-body {
            padding: 20px;
        }
        
        .form-horizontal .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .control-label {
            font-weight: 600;
            color: #444444ff;
            width: 30%;
            text-align: right;
            padding-right: 15px;
        }
        
        .form-control {
            width: 70%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #2a5298;
            outline: none;
            box-shadow: 0 0 0 2px rgba(42, 82, 152, 0.2);
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            margin-right: 10px;
        }
        
        .btn-default {
            background-color: #e0e0e0;
            color: #333;
        }
        
        .btn-default:hover {
            background-color: #d0d0d0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #09bd9fff 0%, #079f79ff 100%);
            color: white;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .text-center {
            text-align: center;
        }
        
        .help-block {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .alert {
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .col-sm-offset-4 {
            margin-left: 30%;
        }
    </style>
<script type="text/javascript">
function valid()
{
if(document.changepwd.newpassword.value!= document.changepwd.cpassword.value)
{
alert("Password and Re-Type Password Field do not match  !!");
document.changepwd.cpassword.focus();
return false;
}
return true;
}
</script>

</head>
<body>
    <div class="header">
        <h1>Hostel Management System</h1>
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['login']; ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="main-container">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="User-dashboard.php">Dashboard</a></li>
                
                <li><a href="room-details.php">Room Details</a></li>
              
                <li><a href="change-password.php" style="background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #4CAF50;">Change Password</a></li>
            </ul>
        </div>

        <div class="content">
            <h2 class="page-title">Change Password</h2>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php 
                    $result ="SELECT passUdateDate FROM userregistration WHERE id=?";
                    $stmt = $mysqli->prepare($result);
                    $stmt->bind_param('i',$ai);
                    $stmt->execute();
                    $stmt -> bind_result($result);
                    $stmt -> fetch(); 
                    ?>
                    Update Your Password &nbsp;<?php echo $result; ?> 
                </div>
                <div class="panel-body">
                    <form method="post" class="form-horizontal" name="changepwd" id="change-pwd" onSubmit="return valid();">
                        <?php if(isset($_POST['changepwd'])) { ?>
                            <div class="alert <?php echo (strpos($_SESSION['msg'], 'Successfully') !== false) ? 'alert-success' : 'alert-danger'; ?>">
                                <?php echo htmlentities($_SESSION['msg']); ?>
                                <?php $_SESSION['msg'] = ""; ?>
                            </div>
                        <?php } ?>
                        
                        <div class="form-group">
                            <label class="control-label">Old Password</label>
                            <div>
                                <input type="password" value="" name="oldpassword" id="oldpassword" class="form-control" onBlur="checkpass()" required="required">
                                <span id="password-availability-status" class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <div>
                                <input type="password" class="form-control" name="newpassword" id="newpassword" value="" required="required">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <div>
                                <input type="password" class="form-control" value="" required="required" id="cpassword" name="cpassword">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4">
                                <button class="btn btn-default" type="submit">Cancel</button>
                                <input type="submit" name="changepwd" Value="Change Password" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
function checkpass() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'oldpassword='+$("#oldpassword").val(),
type: "POST",
success:function(data){
$("#password-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
</body>
</html>

