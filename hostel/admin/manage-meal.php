<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_GET['del']))
{
	$id=intval($_GET['del']);
	$adn="delete from meals where id=?";
		$stmt= $mysqli->prepare($adn);
		$stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	   
        echo "<script>alert('Meal Deleted Successfully');</script>" ;
		 echo"<script>window.location.href = 'admin-dashboard.php'</script>";
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
	<title>Manage Meals</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		:root {
			--primary-color: #3498db;
			--secondary-color: #6a11cb;
			--breakfast-color: #ff9a3c;
			--lunch-color: #6a11cb;
			--dinner-color: #2e86de;
		}
		
		body {
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}
		
		.ts-main-content {
			padding: 20px;
		}
		
		.page-title {
			color: var(--secondary-color);
			margin-bottom: 25px;
			font-weight: 700;
			text-align: center;
			display: block;
			font-size: 28px;
			text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
			margin-top: 20px;
		}
		
		.panel-default {
			border: none;
			border-radius: 12px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
			background: #fff;
			overflow: hidden;
			margin-bottom: 30px;
		}
		
		.panel-heading {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: white;
			padding: 20px;
			font-weight: 600;
			font-size: 24px;
			text-align: center;
		}
		
		.table th {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: white;
		}
		
		.meal-type-badge {
			padding: 5px 10px;
			border-radius: 15px;
			color: white;
			font-weight: 600;
		}
		
		.breakfast-badge {
			background: linear-gradient(135deg, var(--breakfast-color), #ff6b6b);
		}
		
		.lunch-badge {
			background: linear-gradient(135deg, var(--lunch-color), #8A2BE2);
		}
		
		.dinner-badge {
			background: linear-gradient(135deg, var(--dinner-color), #1E90FF);
		}
		
		
		.action-buttons a {
			margin: 0 5px;
			padding: 5px 10px;
			border-radius: 4px;
		}
		
		.btn-edit {
			background: #3498db;
			color: white;
		}
		
		.btn-delete {
			background: #e74c3c;
			color: white;
		}
		
		@media (max-width: 768px) {
			.btn-add-meal {
				float: none;
				width: 100%;
				margin-bottom: 15px;
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
						<h2 class="page-title">Manage Meals</h2>
						
						
						
						<div class="clearfix"></div>
						
						<div class="panel panel-default">
							<div class="panel-heading">All Meal Details</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Sno.</th>
											<th>Meal Type</th>
											<th>Description</th>
											<th>Posting Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sno.</th>
											<th>Meal Type</th>
											<th>Description</th>
											<th>Posting Date</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
<?php	
$aid=$_SESSION['id'];
$ret="select * from meals";
$stmt= $mysqli->prepare($ret);
$stmt->execute();
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
{
	// Determine badge class based on meal type
	$badge_class = '';
	switch($row->meal_type) {
		case 'breakfast':
			$badge_class = 'breakfast-badge';
			$meal_type_display = 'Breakfast';
			break;
		case 'lunch':
			$badge_class = 'lunch-badge';
			$meal_type_display = 'Lunch';
			break;
		case 'dinner':
			$badge_class = 'dinner-badge';
			$meal_type_display = 'Dinner';
			break;
		default:
			$badge_class = '';
			$meal_type_display = ucfirst($row->meal_type);
	}
?>
<tr>
	<td><?php echo $cnt;?></td>
	<td>
		<span class="meal-type-badge <?php echo $badge_class;?>">
			<?php echo $meal_type_display;?>
		</span>
	</td>
	<td><?php echo htmlspecialchars($row->description);?></td>
	<td><?php echo $row->created_at;?></td>
	<td class="action-buttons">
		<a href="edit-meal.php?id=<?php echo $row->id;?>" class="btn-edit">
			<i class="fa fa-edit"></i> Edit
		</a>
		<a href="manage-meal.php?del=<?php echo $row->id;?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this meal?');">
			<i class="fa fa-close"></i> Delete
		</a>
	</td>
</tr>
<?php
$cnt=$cnt+1;
} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
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