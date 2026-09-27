<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses

if(isset($_POST['add_room']))
{
$seater=$_POST['seater'];
$roomno=$_POST['rmno'];
$fees=$_POST['fee'];
$sql="SELECT room_no FROM rooms where room_no=?";
$stmt1 = $mysqli->prepare($sql);
$stmt1->bind_param('i',$roomno);
$stmt1->execute();
$stmt1->store_result(); 
$row_cnt=$stmt1->num_rows;;
if($row_cnt>0)
{
echo"<script>alert('Room already exist');</script>";
echo"<script>window.location.href = 'admin-dashboard.php';</script>";
exit();

}
else
{
$query="insert into  rooms (seater,room_no,fees) values(?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('iii',$seater,$roomno,$fees);
$stmt->execute();
echo"<script>alert('Room has been added successfully');</script>";
// Redirect to admin-dashboard.php after successful creation
echo"<script>window.location.href = 'admin-dashboard.php';</script>";
exit();
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
	<title>Create Room</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>
	<style>
		:root {
			--primary-color: #3498db;
			--secondary-color: #6a11cb;
			--accent-color: #e74c3c;
			--light-color: #ecf0f1;
			--success-color: #2ecc71;
		}
		
		body {
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}
		
		.ts-main-content {
			width: 100%;
			max-width: 1400px;
		}
		
		.content-wrapper {
			padding: 0;
		}
		
		.panel-default {
			border: none;
			border-radius: 12px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
			background: #fff;
			overflow: hidden;
		}
		
		.panel-heading {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: white;
			padding: 20px;
			font-weight: 600;
			font-size: 30px;
			text-align: center;
		}
		
		.panel-body {
			padding: 30px;
		}
		
		.form-control {
			border-radius: 6px;
			border: 1px solid #ddd;
			padding: 12px 15px;
			transition: all 0.3s;
			font-size: 15px;
		}
		
		.form-control:focus {
			border-color: var(--primary-color);
			box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
		}
		
		.btn-primary {
			background: linear-gradient(to right, var(--primary-color), #2980b9);
			border: none;
			border-radius: 6px;
			padding: 12px 25px;
			font-weight: 600;
			transition: all 0.3s;
			width: 100%;
			font-size: 16px;
			margin-top: 10px;
		}
		
		.btn-primary:hover {
			background: linear-gradient(to right, #2980b9, var(--primary-color));
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
		}
		
		.hr-dashed {
			border-top: 1px dashed #ddd;
			margin: 25px 0;
		}
		
		.page-title {
			color: var(--secondary-color);
			margin-bottom: 25px;
			font-weight: 700;
			text-align: center;
			display: block;
			font-size: 28px;
			text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
		}
		
		.control-label {
			font-weight: 600;
			color: #555;
			padding-top: 10px;
		}
		
		.form-horizontal .form-group {
			margin-left: 0;
			margin-right: 0;
			margin-bottom: 20px;
		}
		
		.alert-message {
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 20px;
			text-align: center;
			font-weight: 500;
		}
		
		@media (max-width: 768px) {
			body {
				padding: 15px;
			}
			
			.panel-body {
				padding: 20px;
			}
			
			.col-sm-8 {
				width: 100%;
			}
			
			.col-sm-2 {
				width: 100%;
				margin-bottom: 8px;
			}
		}
	</style>
</head>
<body>
	
	<div class="ts-main-content">
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Add a Room</h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Room Details</div>
									<div class="panel-body">
									<?php if(isset($_POST['add_room']))
{ ?>
<div class="alert-message" style="color: red; background: #ffe6e6;"><?php echo htmlentities($_SESSION['id']); ?><?php echo htmlentities($_SESSION['id']=""); ?>
</div>
<?php } ?>
										<form method="post" class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-2 control-label">Select Seater</label>
												<div class="col-sm-8">
													<Select name="seater" class="form-control" required>
														<option value="">Select Seater</option>
														<option value="1">Single Seater</option>
														<option value="2">Two Seater</option>
														<option value="3">Three Seater</option>
														<option value="4">Four Seater</option>
													</Select>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-2 control-label">Room No.</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="rmno" id="rmno" value="" required="required">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-2 control-label">Fee(Per Student)</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="fee" id="fee" value="" required="required">
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<input class="btn btn-primary" type="submit" name="add_room" value="Create Room">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>