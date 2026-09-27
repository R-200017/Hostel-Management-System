<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Get the logged-in user's registration number
// First, get the user's email or ID from session
$uid = $_SESSION['login'];

// Query to get the user's registration number from registration table
$regno = '';
$user_query = "SELECT regno FROM registration WHERE emailid = ? OR regno = ? LIMIT 1";
$user_stmt = $mysqli->prepare($user_query);
$user_stmt->bind_param('ss', $uid, $uid);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $regno = $user_data['regno'];
} else {
    // If not found in registration table, try userregistration table
    $user_query2 = "SELECT regNo FROM userregistration WHERE email = ? OR regNo = ? LIMIT 1";
    $user_stmt2 = $mysqli->prepare($user_query2);
    $user_stmt2->bind_param('ss', $uid, $uid);
    $user_stmt2->execute();
    $user_result2 = $user_stmt2->get_result();
    
    if ($user_result2->num_rows > 0) {
        $user_data2 = $user_result2->fetch_assoc();
        $regno = $user_data2['regNo'];
    }
}

// Fetch user-specific fees from database using registration number
$hostel_fees = array();
$service_fees = array();
$meal_fees = array();

if (!empty($regno)) {
    // Query to get fees for this specific user using regno
    $query = "SELECT * FROM fees WHERE regno = ? ORDER BY created_at DESC";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $regno);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result) {
        while($row = $result->fetch_assoc()) {
            if($row['fee_type'] == 'hostel') {
                $hostel_fees[] = $row;
            } elseif($row['fee_type'] == 'service') {
                $service_fees[] = $row;
            } elseif($row['fee_type'] == 'meal') {
                $meal_fees[] = $row;
            }
        }
    }
}

// Calculate total fees for this user
$total_hostel_fee = 0;
$total_service_fee = 0;
$total_meal_fee = 0;

foreach($hostel_fees as $fee) {
    $total_hostel_fee += $fee['amount'];
}

foreach($service_fees as $fee) {
    $total_service_fee += $fee['amount'];
}

foreach($meal_fees as $fee) {
    $total_meal_fee += $fee['amount'];
}

$total_fee = $total_hostel_fee + $total_service_fee + $total_meal_fee;

// Code for processing payment
if(isset($_POST['process_payment'])) {
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $amount = $_POST['amount'];
    
    // Verify the amount matches the user's total fee
    if($amount != $total_fee) {
        echo"<script>alert('Payment amount does not match your total fee. Please pay exactly ৳".number_format($total_fee, 2)."');</script>";
    } else {
        // Get user_id from userlog table
        $user_id_query = "SELECT id FROM userlog WHERE userEmail = ? OR userEmail = ? LIMIT 1";
        $user_id_stmt = $mysqli->prepare($user_id_query);
        $user_id_stmt->bind_param('ss', $uid, $uid);
        $user_id_stmt->execute();
        $user_id_result = $user_id_stmt->get_result();
        
        if($user_id_result->num_rows > 0) {
            $user_data = $user_id_result->fetch_assoc();
            $user_id = $user_data['id'];
            
            // Insert payment record with user_id
            $query = "INSERT INTO payments (user_id, regno, payment_method, transaction_id, amount, status) VALUES (?,?,?,?,?,'pending')";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('isssd', $user_id, $regno, $payment_method, $transaction_id, $amount);
            
            if($stmt->execute()) {
                echo"<script>alert('Payment has been processed and is awaiting verification');</script>";
                echo"<script>window.location.href = 'user-dashboard.php'</script>";
            } else {
                echo"<script>alert('Error processing payment. Please try again.');</script>";
            }
        } else {
            echo"<script>alert('Error: User not found in system. Please contact administration.');</script>";
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
    <title>Hostel Fee Payment System - User</title>
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
            --hostel-color: #ff9a3c;
            --service-color: #6a11cb;
            --meal-color: #2e86de;
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
        
        .fee-panel .panel-heading {
            text-align: left;
            font-size: 24px;
            padding: 15px 20px;
        }
        
        .hostel-panel .panel-heading {
            background: linear-gradient(135deg, var(--hostel-color), #ff6b6b);
        }
        
        .service-panel .panel-heading {
            background: linear-gradient(135deg, var(--service-color), #8A2BE2);
        }
        
        .meal-panel .panel-heading {
            background: linear-gradient(135deg, var(--meal-color), #1E90FF);
        }
        
        .payment-panel .panel-heading {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
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
        
        .btn-fee {
            width: auto;
            padding: 8px 20px;
            margin: 5px;
        }
        
        .btn-hostel {
            background: linear-gradient(to right, var(--hostel-color), #ff6b6b);
        }
        
        .btn-service {
            background: linear-gradient(to right, var(--service-color), #8A2BE2);
        }
        
        .btn-meal {
            background: linear-gradient(to right, var(--meal-color), #1E90FF);
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
        
        .fee-list {
            list-style: none;
            padding: 0;
        }
        
        .fee-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }
        
        .fee-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .fee-info {
            flex: 1;
        }
        
        .fee-name {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .fee-description {
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .fee-amount {
            color: #e74c3c;
            font-weight: 500;
            font-size: 20px;
        }
        
        .fee-user {
            color: #6c757d;
            font-style: italic;
            margin-top: 5px;
        }
        
        .fee-actions {
            display: flex;
            gap: 10px;
        }
        
        .tab-container {
            margin-bottom: 20px;
        }
        
        .tab-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .tab-button {
            padding: 12px 30px;
            border: none;
            background: #ddd;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 6px 6px 0 0;
            margin: 0 5px;
        }
        
        .tab-button.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .empty-fee-message {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
        
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .summary-amount {
            font-size: 24px;
            font-weight: 700;
            color: #e74c3c;
        }
        
        .total-summary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .total-summary .summary-title {
            color: white;
        }
        
        .total-summary .summary-amount {
            color: white;
        }
        
        .payment-method {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .payment-option {
            flex: 1;
            text-align: center;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .payment-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(52, 152, 219, 0.1);
        }
        
        .payment-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .bkash-icon {
            color: #e2136e;
        }
        
        .nagad-icon {
            color: #f60;
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
            
            .fee-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .fee-actions {
                margin-top: 15px;
                width: 100%;
                justify-content: flex-end;
            }
            
            .tab-button {
                padding: 10px 15px;
                font-size: 14px;
            }
            
            .payment-method {
                flex-direction: column;
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
    </style>
</head>
<body>
    
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title"> Hostel Fee Details - Student View</h2>
                        
                        <div class="dashboard-button-container" style="text-align: center; margin: 30px 0;">
                              <a href="User-dashboard.php" class="btn-dashboard" style="display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #3498db, #6a11cb); color: white; padding: 12px 24px; border-radius: 50px; font-weight: 600; font-size: 16px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);">
                                 <i class="fa fa-tachometer" style="margin-center: 8px;"></i> Go to Dashboard
                               </a>
                        </div>
                        
                        <?php if(empty($regno)): ?>
                            <div class="alert alert-danger">
                                <strong>Error:</strong> Could not find your registration information. Please contact administration.
                            </div>
                        <?php else: ?>

                            
                        
                        <!-- Fee Summary Section -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-title">Hostel Fee</div>
                                    <div class="summary-amount">৳<?php echo number_format($total_hostel_fee, 2); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-title">Service Fee</div>
                                    <div class="summary-amount">৳<?php echo number_format($total_service_fee, 2); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-title">Meal Fee</div>
                                    <div class="summary-amount">৳<?php echo number_format($total_meal_fee, 2); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card total-summary">
                                    <div class="summary-title">Total Fee</div>
                                    <div class="summary-amount">৳<?php echo number_format($total_fee, 2); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-container">
                            <div class="tab-buttons">
                                <button class="tab-button active" onclick="openTab('viewFees')">View Fees</button>
                                <button class="tab-button" onclick="openTab('makePayment')">Make Payment</button>
                                <button class="tab-button" onclick="openTab('paymentHistory')">Payment History</button>
                            </div>
                            
                            <!-- View Fees Tab -->
                            <div id="viewFees" class="tab-content active">
                                <div class="row">
                                    <!-- Hostel Fee Panel -->
                                    <div class="col-md-4">
                                        <div class="panel panel-default fee-panel hostel-panel">
                                            <div class="panel-heading">Hostel Fees</div>
                                            <div class="panel-body">
                                                <ul class="fee-list">
                                                    <?php if(count($hostel_fees) > 0): ?>
                                                        <?php foreach($hostel_fees as $fee): ?>
                                                            <li class="fee-item">
                                                                <div class="fee-info">
                                                                    <div class="fee-amount">৳<?php echo number_format($fee['amount'], 2); ?></div>
                                                                    <div class="fee-date"><?php echo date('M d, Y', strtotime($fee['created_at'])); ?></div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="empty-fee-message">No hostel fees assigned to you.</div>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Service Fee Panel -->
                                    <div class="col-md-4">
                                        <div class="panel panel-default fee-panel service-panel">
                                            <div class="panel-heading">Service Fees</div>
                                            <div class="panel-body">
                                                <ul class="fee-list">
                                                    <?php if(count($service_fees) > 0): ?>
                                                        <?php foreach($service_fees as $fee): ?>
                                                            <li class="fee-item">
                                                                <div class="fee-info">
                                                                    <div class="fee-amount">৳<?php echo number_format($fee['amount'], 2); ?></div>
                                                                    <div class="fee-date"><?php echo date('M d, Y', strtotime($fee['created_at'])); ?></div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="empty-fee-message">No service fees assigned to you.</div>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Meal Fee Panel -->
                                    <div class="col-md-4">
                                        <div class="panel panel-default fee-panel meal-panel">
                                            <div class="panel-heading">Meal Fees</div>
                                            <div class="panel-body">
                                                <ul class="fee-list">
                                                    <?php if(count($meal_fees) > 0): ?>
                                                        <?php foreach($meal_fees as $fee): ?>
                                                            <li class="fee-item">
                                                                <div class="fee-info">
                                                                    <div class="fee-amount">৳<?php echo number_format($fee['amount'], 2); ?></div>
                                                                    <div class="fee-date"><?php echo date('M d, Y', strtotime($fee['created_at'])); ?></div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="empty-fee-message">No meal fees assigned to you.</div>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Make Payment Tab -->
                            <div id="makePayment" class="tab-content">
                                <div class="panel panel-default payment-panel">
                                    <div class="panel-heading">Make Payment</div>
                                    <div class="panel-body">
                                        <?php if($total_fee > 0): ?>
                                            <div class="alert alert-info">
                                                <strong>Total Amount Due:</strong> ৳<?php echo number_format($total_fee, 2); ?>
                                            </div>
                                            
                                            <form method="post" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Payment Method</label>
                                                    <div class="col-sm-8">
                                                        <div class="payment-method">
                                                            <div class="payment-option" onclick="selectPayment('bkash')">
                                                                <div class="payment-icon bkash-icon">
                                                                    <i class="fa fa-mobile"></i>
                                                                </div>
                                                                <div>bKash</div>
                                                                <input type="radio" name="payment_method" value="bkash" style="display: none;" required>
                                                            </div>
                                                            <div class="payment-option" onclick="selectPayment('nagad')">
                                                                <div class="payment-icon nagad-icon">
                                                                    <i class="fa fa-mobile"></i>
                                                                </div>
                                                                <div>Nagad</div>
                                                                <input type="radio" name="payment_method" value="nagad" style="display: none;" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Transaction ID</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="transaction_id" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Amount</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" name="amount" value="<?php echo $total_fee; ?>" step="0.01" min="0" readonly>
                                                        <small class="text-muted">This amount is fixed based on your fees</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <input class="btn btn-primary" type="submit" name="process_payment" value="Process Payment">
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="hr-dashed"></div>
                                            
                                            <h4>Payment Instructions:</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background: #e2136e; color: white;">bKash Payment</div>
                                                        <div class="panel-body">
                                                            <ol>
                                                                <li>Go to your bKash app or dial *247#</li>
                                                                <li>Select "Send Money"</li>
                                                                <li>Enter our bKash number: 01XXXXXXXXX</li>
                                                                <li>Enter amount: ৳<?php echo number_format($total_fee, 2); ?></li>
                                                                <li>Enter reference: <?php echo $regno; ?> (Your Registration Number)</li>
                                                                <li>Complete the transaction</li>
                                                                <li>Enter the transaction ID in the form above</li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background: #f60; color: white;">Nagad Payment</div>
                                                        <div class="panel-body">
                                                            <ol>
                                                                <li>Go to your Nagad app or dial *167#</li>
                                                                <li>Select "Send Money"</li>
                                                                <li>Enter our Nagad number: 01XXXXXXXXX</li>
                                                                <li>Enter amount: ৳<?php echo number_format($total_fee, 2); ?></li>
                                                                <li>Enter reference: <?php echo $regno; ?> (Your Registration Number)</li>
                                                                <li>Complete the transaction</li>
                                                                <li>Enter the transaction ID in the form above</li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-success">
                                                <strong>No fees due!</strong> You don't have any outstanding fees at this time.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment History Tab -->
                            <div id="paymentHistory" class="tab-content">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Payment History</div>
                                    <div class="panel-body">
                                        <?php
                                        // Fetch payment history for the current user using regno
                                        $payment_query = "SELECT * FROM payments WHERE regno = ? ORDER BY created_at DESC";
                                        $payment_stmt = $mysqli->prepare($payment_query);
                                        $payment_stmt->bind_param('s', $regno);
                                        $payment_stmt->execute();
                                        $payment_result = $payment_stmt->get_result();
                                        
                                        if($payment_result->num_rows > 0): ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Transaction ID</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while($payment = $payment_result->fetch_assoc()): ?>
                                                            <tr>
                                                                <td><?php echo $payment['transaction_id']; ?></td>
                                                                <td><?php echo ucfirst($payment['payment_method']); ?></td>
                                                                <td>৳<?php echo number_format($payment['amount'], 2); ?></td>
                                                                <td>
                                                                    <span class="label label-<?php 
                                                                        if($payment['status'] == 'completed') echo 'success';
                                                                        elseif($payment['status'] == 'pending') echo 'warning';
                                                                        else echo 'danger';
                                                                    ?>">
                                                                        <?php echo ucfirst($payment['status']); ?>
                                                                    </span>
                                                                </td>
                                                                <td><?php echo date('M d, Y h:i A', strtotime($payment['created_at'])); ?></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="empty-fee-message">No payment history found.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php endif; // End of if(empty($regno)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openTab(tabName) {
            var i, tabContent, tabButtons;
            
            // Hide all tab content
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active");
            }
            
            // Remove active class from all buttons
            tabButtons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }
            
            // Show the specific tab content and add active class to the button
            document.getElementById(tabName).classList.add("active");
            event.currentTarget.classList.add("active");
        }
        
        function selectPayment(method) {
            // Remove selected class from all options
            var options = document.getElementsByClassName('payment-option');
            for (var i = 0; i < options.length; i++) {
                options[i].classList.remove('selected');
            }
            
            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');
            
            // Set the radio button value
            document.querySelector('input[name="payment_method"][value="' + method + '"]').checked = true;
        }
    </script>
    
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