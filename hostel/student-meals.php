<?php
session_start();
include('includes/config.php');

// Check if user is logged in (student)
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Code for meal ordering
if(isset($_POST['order_meal']))
{
    $meal_id = $_POST['meal_id'];
    $quantity = $_POST['quantity'];
    $payment_method = $_POST['payment_method'];
    $user_id = $_SESSION['id'];
    
    // Get meal price
    $price_query = "SELECT price FROM meals WHERE id = ?";
    $stmt = $mysqli->prepare($price_query);
    $stmt->bind_param('i', $meal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $meal = $result->fetch_assoc();
    
    $total_price = $meal['price'] * $quantity;
    
    // Insert order into database
    $order_query = "INSERT INTO orders (user_id, meal_id, quantity, total_price, payment_method, order_date) VALUES (?,?,?,?,?,NOW())";
    $stmt = $mysqli->prepare($order_query);
    $stmt->bind_param('iiids', $user_id, $meal_id, $quantity, $total_price, $payment_method);
    $stmt->execute();
    
    echo"<script>alert('Meal ordered successfully! Total amount: ".number_format($total_price, 2).". Payment method: ".$payment_method."');</script>";
    echo"<script>window.location.href = 'student-meals.php'</script>";
}

// Fetch meals from database
$breakfast_meals = array();
$lunch_meals = array();
$dinner_meals = array();
$special_meals = array();

$query = "SELECT * FROM meals ORDER BY created_at DESC";
$result = $mysqli->query($query);

if($result) {
    while($row = $result->fetch_assoc()) {
        if($row['is_special'] == 1) {
            $special_meals[] = $row;
        } else {
            if($row['meal_type'] == 'breakfast') {
                $breakfast_meals[] = $row;
            } elseif($row['meal_type'] == 'lunch') {
                $lunch_meals[] = $row;
            } elseif($row['meal_type'] == 'dinner') {
                $dinner_meals[] = $row;
            }
        }
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
	<title>Student Meal View</title>
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
			--accent-color: #e74c3c;
			--light-color: #ecf0f1;
			--success-color: #2ecc71;
			--breakfast-color: #ff9a3c;
			--lunch-color: #6a11cb;
			--dinner-color: #2e86de;
			--special-color: #d63384;
		}
		
		body {
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			min-height: 100vh;
			padding: 20px;
		}
		
		.ts-main-content {
			width: 100%;
			max-width: 1400px;
			margin: 0 auto;
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
			margin-bottom: 30px;
		}
		
		.panel-heading {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: white;
			padding: 20px;
			font-weight: 600;
			font-size: 30px;
			text-align: center;
		}
		
		.meal-panel .panel-heading {
			text-align: left;
			font-size: 24px;
			padding: 15px 20px;
		}
		
		.breakfast-panel .panel-heading {
			background: linear-gradient(135deg, var(--breakfast-color), #ff6b6b);
		}
		
		.lunch-panel .panel-heading {
			background: linear-gradient(135deg, var(--lunch-color), #8A2BE2);
		}
		
		.dinner-panel .panel-heading {
			background: linear-gradient(135deg, var(--dinner-color), #1E90FF);
		}
		
		.special-panel .panel-heading {
			background: linear-gradient(135deg, var(--special-color), #fd7e14);
		}
		
		.panel-body {
			padding: 30px;
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
		
		.meal-list {
			list-style: none;
			padding: 0;
		}
		
		.meal-item {
			background: #f8f9fa;
			border-radius: 8px;
			padding: 15px;
			margin-bottom: 15px;
			transition: all 0.3s;
			border-left: 4px solid #ddd;
			position: relative;
			cursor: pointer;
		}
		
		.meal-item.special {
			background: #fff5f5;
			border-left: 4px solid var(--special-color);
			box-shadow: 0 4px 12px rgba(214, 51, 132, 0.15);
		}
		
		.meal-item:hover {
			background: #e9ecef;
			transform: translateY(-2px);
			box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		}
		
		.meal-item.special:hover {
			background: #ffeef4;
		}
		
		.meal-item.active {
			background: #e3f2fd;
			border-left: 4px solid var(--primary-color);
		}
		
		.meal-info {
			flex: 1;
		}
		
		.meal-name {
			font-weight: 600;
			font-size: 18px;
			margin-bottom: 5px;
			color: #333;
		}
		
		.meal-description {
			color: #6c757d;
			margin-bottom: 5px;
		}
		
		.meal-price {
			font-weight: 700;
			color: var(--success-color);
			font-size: 18px;
			margin: 5px 0;
		}
		
		.meal-occasion {
			color: var(--special-color);
			font-weight: 600;
			font-size: 14px;
			margin-top: 5px;
		}
		
		.meal-calories {
			color: #e74c3c;
			font-weight: 500;
		}
		
		.empty-meal-message {
			text-align: center;
			color: #6c757d;
			font-style: italic;
			padding: 20px;
		}
		
		.navbar {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			border-radius: 8px;
			margin-bottom: 30px;
		}
		
		.navbar-brand {
			color: white !important;
			font-weight: 600;
		}
		
		.special-badge {
			background: linear-gradient(135deg, var(--special-color), #fd7e14);
			color: white;
			padding: 3px 10px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			margin-left: 10px;
		}
		
		.special-section {
			margin-top: 40px;
			margin-bottom: 20px;
		}
		
		.section-title {
			text-align: center;
			color: var(--special-color);
			font-weight: 700;
			margin-bottom: 20px;
			font-size: 24px;
			position: relative;
			padding-bottom: 10px;
		}
		
		.section-title:after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 50%;
			transform: translateX(-50%);
			width: 100px;
			height: 3px;
			background: linear-gradient(to right, var(--special-color), #fd7e14);
			border-radius: 3px;
		}
		
		/* Meal Details Styles */
		.meal-details {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;
			margin-top: 10px;
			display: none;
			border: 1px solid #ddd;
			width: 100%;
		}
		
		.meal-details.active {
			display: block;
			animation: fadeIn 0.3s ease-in;
		}
		
		.meal-details-content {
			display: flex;
			flex-direction: column;
			gap: 10px;
		}
		
		.detail-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 5px 0;
			border-bottom: 1px solid #eee;
		}
		
		.detail-label {
			font-weight: 600;
			color: #555;
		}
		
		.detail-value {
			color: #333;
		}
		
		/* Order Form Styles */
		.order-form {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;
			margin-top: 10px;
			display: none;
			border: 1px solid #ddd;
			width: 100%;
		}
		
		.order-form.active {
			display: block;
			animation: fadeIn 0.3s ease-in;
		}
		
		.quantity-selector {
			margin-bottom: 15px;
		}
		
		.quantity-selector label {
			display: block;
			margin-bottom: 5px;
			font-weight: 600;
		}
		
		.quantity-selector input {
			width: 80px;
			padding: 5px 10px;
			border: 1px solid #ddd;
			border-radius: 4px;
		}
		
		.payment-options label {
			display: block;
			margin-bottom: 10px;
			font-weight: 600;
		}
		
		.payment-option {
			display: flex;
			align-items: center;
			margin: 10px 0;
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 6px;
			cursor: pointer;
			transition: all 0.3s;
		}
		
		.payment-option:hover {
			background: #e9ecef;
		}
		
		.payment-option.selected {
			background: #d4edda;
			border-color: var(--success-color);
		}
		
		.payment-option input[type="radio"] {
			margin-right: 10px;
		}
		
		.meal-actions {
			display: flex;
			gap: 10px;
			margin-top: 10px;
		}
		
		.btn-meal {
			padding: 8px 15px;
			border-radius: 5px;
			font-weight: 600;
			transition: all 0.3s;
			border: none;
			cursor: pointer;
		}
		
		.btn-success {
			background: linear-gradient(135deg, var(--success-color), #27ae60);
			color: white;
		}
		
		.btn-success:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
		}
		
		.btn-primary {
			background: linear-gradient(135deg, var(--primary-color), #2980b9);
			color: white;
		}
		
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(10px); }
			to { opacity: 1; transform: translateY(0); }
		}
		
		.meal-type-badge {
			display: inline-block;
			padding: 3px 8px;
			border-radius: 4px;
			font-size: 12px;
			font-weight: 600;
			margin-left: 10px;
			color: white;
		}
		
		.breakfast-badge {
			background-color: var(--breakfast-color);
		}
		
		.lunch-badge {
			background-color: var(--lunch-color);
		}
		
		.dinner-badge {
			background-color: var(--dinner-color);
		}
		
		.special-badge-modal {
			background-color: var(--special-color);
		}
		
		/* Dashboard Button Styles */
		.dashboard-button-container {
			text-align: center;
			margin: 30px 0;
		}
		
		.btn-dashboard {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: white;
			padding: 12px 24px;
			border-radius: 50px;
			font-weight: 600;
			font-size: 16px;
			text-decoration: none;
			transition: all 0.3s ease;
			box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
			border: none;
			cursor: pointer;
			position: relative;
			overflow: hidden;
		}
		
		.btn-dashboard:hover {
			transform: translateY(-3px);
			box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
			color: white;
			text-decoration: none;
		}
		
		.btn-dashboard:active {
			transform: translateY(-1px);
			box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
		}
		
		.btn-dashboard i {
			margin-right: 8px;
			font-size: 18px;
		}
		
		.btn-dashboard::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
			transition: left 0.5s;
		}
		
		.btn-dashboard:hover::before {
			left: 100%;
		}
		
		@media (max-width: 768px) {
			body {
				padding: 15px;
			}
			
			.panel-body {
				padding: 20px;
			}
			
			.meal-actions {
				flex-direction: column;
			}
			
			.btn-dashboard {
				padding: 10px 20px;
				font-size: 14px;
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
						<h2 class="page-title"> Today's Meal Options </h2>
						
						<!-- Dashboard Button -->
						<div class="dashboard-button-container">
							<a href="User-dashboard.php" class="btn-dashboard">
								<i class="fa fa-tachometer"></i> Go to Dashboard
							</a>
						</div>
						
						<div class="row">
							<!-- Breakfast Panel -->
							<div class="col-md-4">
								<div class="panel panel-default meal-panel breakfast-panel">
									<div class="panel-heading">Breakfast Options</div>
									<div class="panel-body">
										<ul class="meal-list">
											<?php if(count($breakfast_meals) > 0): ?>
												<?php foreach($breakfast_meals as $meal): ?>
													<li class="meal-item" onclick="toggleMealDetails(<?php echo $meal['id']; ?>)">
														<div class="meal-info">
															<div class="meal-name">
																<?php 
																	// Extract meal name from description (first few words)
																	$description = $meal['description'];
																	$words = explode(' ', $description);
																	$name = implode(' ', array_slice($words, 0, 5));
																	echo htmlspecialchars($name . (count($words) > 5 ? '...' : ''));
																?>
																<span class="meal-type-badge breakfast-badge">Breakfast</span>
															</div>
															<div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
															<div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
														</div>
														
														<!-- Meal Details Section -->
														<div id="meal-details-<?php echo $meal['id']; ?>" class="meal-details">
															<div class="meal-details-content">
																<div class="detail-row">
																	<span class="detail-label">Meal Name:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['description']); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Price:</span>
																	<span class="detail-value"><?php echo number_format($meal['price'], 2); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Type:</span>
																	<span class="detail-value"><?php echo ucfirst($meal['meal_type']); ?></span>
																</div>
																<?php if(!empty($meal['occasion'])): ?>
																<div class="detail-row">
																	<span class="detail-label">Occasion:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['occasion']); ?></span>
																</div>
																<?php endif; ?>
															</div>
															<div class="meal-actions">
																<button class="btn btn-success btn-meal" onclick="event.stopPropagation(); toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
															</div>
														</div>
														
														<!-- Order Form Section -->
														<div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
															<form method="post" onclick="event.stopPropagation();">
																<input type="hidden" name="meal_id" value="<?php echo $meal['id']; ?>">
																<div class="quantity-selector">
																	<label>Quantity:</label>
																	<input type="number" name="quantity" value="1" min="1" max="10" required>
																</div>
																<div class="payment-options">
																	<label>Payment Method:</label>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="cash" required> Cash on Delivery
																	</div>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="bkash"> bKash
																	</div>
																</div>
																<button type="submit" name="order_meal" class="btn btn-primary btn-meal">Confirm Order</button>
															</form>
														</div>
													</li>
												<?php endforeach; ?>
											<?php else: ?>
												<div class="empty-meal-message">No breakfast meals available today.</div>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Lunch Panel -->
							<div class="col-md-4">
								<div class="panel panel-default meal-panel lunch-panel">
									<div class="panel-heading">Lunch Options</div>
									<div class="panel-body">
										<ul class="meal-list">
											<?php if(count($lunch_meals) > 0): ?>
												<?php foreach($lunch_meals as $meal): ?>
													<li class="meal-item" onclick="toggleMealDetails(<?php echo $meal['id']; ?>)">
														<div class="meal-info">
															<div class="meal-name">
																<?php 
																	// Extract meal name from description (first few words)
																	$description = $meal['description'];
																	$words = explode(' ', $description);
																	$name = implode(' ', array_slice($words, 0, 5));
																	echo htmlspecialchars($name . (count($words) > 5 ? '...' : ''));
																?>
																<span class="meal-type-badge lunch-badge">Lunch</span>
															</div>
															<div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
															<div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
														</div>
														
														<!-- Meal Details Section -->
														<div id="meal-details-<?php echo $meal['id']; ?>" class="meal-details">
															<div class="meal-details-content">
																<div class="detail-row">
																	<span class="detail-label">Meal Name:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['description']); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Price:</span>
																	<span class="detail-value"><?php echo number_format($meal['price'], 2); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Type:</span>
																	<span class="detail-value"><?php echo ucfirst($meal['meal_type']); ?></span>
																</div>
																<?php if(!empty($meal['occasion'])): ?>
																<div class="detail-row">
																	<span class="detail-label">Occasion:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['occasion']); ?></span>
																</div>
																<?php endif; ?>
															</div>
															<div class="meal-actions">
																<button class="btn btn-success btn-meal" onclick="event.stopPropagation(); toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
															</div>
														</div>
														
														<!-- Order Form Section -->
														<div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
															<form method="post" onclick="event.stopPropagation();">
																<input type="hidden" name="meal_id" value="<?php echo $meal['id']; ?>">
																<div class="quantity-selector">
																	<label>Quantity:</label>
																	<input type="number" name="quantity" value="1" min="1" max="10" required>
																</div>
																<div class="payment-options">
																	<label>Payment Method:</label>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="cash" required> Cash on Delivery
																	</div>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="bkash"> bKash
																	</div>
																</div>
																<button type="submit" name="order_meal" class="btn btn-primary btn-meal">Confirm Order</button>
															</form>
														</div>
													</li>
												<?php endforeach; ?>
											<?php else: ?>
												<div class="empty-meal-message">No lunch meals available today.</div>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Dinner Panel -->
							<div class="col-md-4">
								<div class="panel panel-default meal-panel dinner-panel">
									<div class="panel-heading">Dinner Options</div>
									<div class="panel-body">
										<ul class="meal-list">
											<?php if(count($dinner_meals) > 0): ?>
												<?php foreach($dinner_meals as $meal): ?>
													<li class="meal-item" onclick="toggleMealDetails(<?php echo $meal['id']; ?>)">
														<div class="meal-info">
															<div class="meal-name">
																<?php 
																	// Extract meal name from description (first few words)
																	$description = $meal['description'];
																	$words = explode(' ', $description);
																	$name = implode(' ', array_slice($words, 0, 5));
																	echo htmlspecialchars($name . (count($words) > 5 ? '...' : ''));
																?>
																<span class="meal-type-badge dinner-badge">Dinner</span>
															</div>
															<div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
															<div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
														</div>
														
														<!-- Meal Details Section -->
														<div id="meal-details-<?php echo $meal['id']; ?>" class="meal-details">
															<div class="meal-details-content">
																<div class="detail-row">
																	<span class="detail-label">Meal Name:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['description']); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Price:</span>
																	<span class="detail-value"><?php echo number_format($meal['price'], 2); ?></span>
																</div>
																<div class="detail-row">
																	<span class="detail-label">Type:</span>
																	<span class="detail-value"><?php echo ucfirst($meal['meal_type']); ?></span>
																</div>
																<?php if(!empty($meal['occasion'])): ?>
																<div class="detail-row">
																	<span class="detail-label">Occasion:</span>
																	<span class="detail-value"><?php echo htmlspecialchars($meal['occasion']); ?></span>
																</div>
																<?php endif; ?>
															</div>
															<div class="meal-actions">
																<button class="btn btn-success btn-meal" onclick="event.stopPropagation(); toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
															</div>
														</div>
														
														<!-- Order Form Section -->
														<div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
															<form method="post" onclick="event.stopPropagation();">
																<input type="hidden" name="meal_id" value="<?php echo $meal['id']; ?>">
																<div class="quantity-selector">
																	<label>Quantity:</label>
																	<input type="number" name="quantity" value="1" min="1" max="10" required>
																</div>
																<div class="payment-options">
																	<label>Payment Method:</label>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="cash" required> Cash on Delivery
																	</div>
																	<div class="payment-option" onclick="selectPayment(this)">
																		<input type="radio" name="payment_method" value="bkash"> bKash
																	</div>
																</div>
																<button type="submit" name="order_meal" class="btn btn-primary btn-meal">Confirm Order</button>
															</form>
														</div>
													</li>
												<?php endforeach; ?>
											<?php else: ?>
												<div class="empty-meal-message">No dinner meals available today.</div>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Special Occasion Meals Section -->
						<div class="special-section">
							<h3 class="section-title">Special Occasion Meals</h3>
							
							<div class="panel panel-default special-panel">
								<div class="panel-heading">Celebration Specials</div>
								<div class="panel-body">
									<?php if(count($special_meals) > 0): ?>
										<ul class="meal-list">
											<?php foreach($special_meals as $meal): ?>
												<li class="meal-item special" onclick="toggleMealDetails(<?php echo $meal['id']; ?>)">
													<div class="meal-info">
														<div class="meal-name">
															<?php 
																// Extract meal name from description (first few words)
																$description = $meal['description'];
																$words = explode(' ', $description);
																$name = implode(' ', array_slice($words, 0, 5));
																echo htmlspecialchars($name . (count($words) > 5 ? '...' : ''));
															?>
															<span class="special-badge">Special</span>
														</div>
														<div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
														<div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
														<?php if(!empty($meal['occasion'])): ?>
															<div class="meal-occasion">Occasion: <?php echo htmlspecialchars($meal['occasion']); ?></div>
														<?php endif; ?>
													</div>
													
													<!-- Meal Details Section -->
													<div id="meal-details-<?php echo $meal['id']; ?>" class="meal-details">
														<div class="meal-details-content">
															<div class="detail-row">
																<span class="detail-label">Meal Name:</span>
																<span class="detail-value"><?php echo htmlspecialchars($meal['description']); ?></span>
															</div>
															<div class="detail-row">
																<span class="detail-label">Price:</span>
																<span class="detail-value"><?php echo number_format($meal['price'], 2); ?></span>
															</div>
															<div class="detail-row">
																<span class="detail-label">Type:</span>
																<span class="detail-value">Special Occasion</span>
															</div>
															<?php if(!empty($meal['occasion'])): ?>
															<div class="detail-row">
																<span class="detail-label">Occasion:</span>
																<span class="detail-value"><?php echo htmlspecialchars($meal['occasion']); ?></span>
															</div>
															<?php endif; ?>
														</div>
														<div class="meal-actions">
															<button class="btn btn-success btn-meal" onclick="event.stopPropagation(); toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
														</div>
													</div>
													
													<!-- Order Form Section -->
													<div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
														<form method="post" onclick="event.stopPropagation();">
															<input type="hidden" name="meal_id" value="<?php echo $meal['id']; ?>">
															<div class="quantity-selector">
																<label>Quantity:</label>
																<input type="number" name="quantity" value="1" min="1" max="10" required>
															</div>
															<div class="payment-options">
																<label>Payment Method:</label>
																<div class="payment-option" onclick="selectPayment(this)">
																	<input type="radio" name="payment_method" value="cash" required> Cash on Delivery
																</div>
																<div class="payment-option" onclick="selectPayment(this)">
																	<input type="radio" name="payment_method" value="bkash"> bKash
																</div>
															</div>
															<button type="submit" name="order_meal" class="btn btn-primary btn-meal">Confirm Order</button>
														</form>
													</div>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php else: ?>
										<div class="empty-meal-message">No special occasion meals available today.</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<script>
		// Function to toggle the meal details visibility
		function toggleMealDetails(mealId) {
			var mealDetails = document.getElementById('meal-details-' + mealId);
			var mealItem = document.querySelector('[onclick="toggleMealDetails(' + mealId + ')"]');
			var orderForm = document.getElementById('order-form-' + mealId);
			
			// Close any open order forms first
			if (orderForm && orderForm.classList.contains('active')) {
				orderForm.classList.remove('active');
			}
			
			if (mealDetails) {
				if (mealDetails.classList.contains('active')) {
					mealDetails.classList.remove('active');
					if (mealItem) mealItem.classList.remove('active');
				} else {
					// Close all other open meal details
					var allMealDetails = document.querySelectorAll('.meal-details');
					allMealDetails.forEach(function(details) {
						details.classList.remove('active');
					});
					
					// Remove active class from all meal items
					var allMealItems = document.querySelectorAll('.meal-item');
					allMealItems.forEach(function(item) {
						item.classList.remove('active');
					});
					
					// Open the selected meal details
					mealDetails.classList.add('active');
					
					// Add active class to the clicked meal item
					if (mealItem) mealItem.classList.add('active');
					
					// Scroll to the meal details for better UX
					mealDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}
			}
		}
		
		// Function to toggle the order form visibility
		function toggleOrderForm(mealId) {
			var orderForm = document.getElementById('order-form-' + mealId);
			var mealDetails = document.getElementById('meal-details-' + mealId);
			
			if (orderForm) {
				if (orderForm.classList.contains('active')) {
					orderForm.classList.remove('active');
				} else {
					// Close all other open order forms
					var allOrderForms = document.querySelectorAll('.order-form');
					allOrderForms.forEach(function(form) {
						form.classList.remove('active');
					});
					
					// Open the selected order form
					orderForm.classList.add('active');
					
					// Scroll to the order form for better UX
					orderForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}
			}
		}
		
		// Function to select payment option
		function selectPayment(element) {
			// Remove selected class from all payment options
			var paymentOptions = document.querySelectorAll('.payment-option');
			paymentOptions.forEach(function(option) {
				option.classList.remove('selected');
			});
			
			// Add selected class to clicked option
			element.classList.add('selected');
			
			// Check the radio button
			var radio = element.querySelector('input[type="radio"]');
			if (radio) {
				radio.checked = true;
			}
		}
		
		// Initialize the page
		document.addEventListener('DOMContentLoaded', function() {
			// Add click event listeners to payment options
			document.addEventListener('click', function(e) {
				if (e.target.classList.contains('payment-option')) {
					selectPayment(e.target);
				}
			});
		});
	</script>
</body>
</html>