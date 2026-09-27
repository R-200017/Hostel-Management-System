<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Code for meal management
if(isset($_POST['add_meal']))
{
    $meal_type = $_POST['meal_type'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_special = isset($_POST['is_special']) ? 1 : 0;
    $occasion = $_POST['occasion'];
    
    $query = "INSERT INTO meals (meal_type, description, price, is_special, occasion) VALUES (?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssdis', $meal_type, $description, $price, $is_special, $occasion);
    $stmt->execute();
    
    echo"<script>alert('Meal has been added successfully');</script>";
    echo"<script>window.location.href = 'admin-dashboard.php'</script>";
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
    
    echo"<script>alert('Meal ordered successfully! Total amount: ".$total_price.". Payment method: ".$payment_method."');</script>";
    echo"<script>window.location.href = 'admin-dashboard.php'</script>";
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

// Code for deleting a meal
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM meals WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    
    echo"<script>alert('Meal has been deleted successfully');</script>";
    echo"<script>window.location.href = 'admin-dashboard.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Daily Meal Planning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        
        .page-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }
        
        .tab-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .tab-buttons {
            display: flex;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .tab-button {
            flex: 1;
            padding: 15px;
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .tab-button:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .tab-button.active {
            background: rgba(255,255,255,0.2);
            box-shadow: inset 0 -3px 0 white;
        }
        
        .tab-content {
            display: none;
            padding: 30px;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .panel {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .panel-heading {
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            font-size: 18px;
        }
        
        .panel-body {
            padding: 20px;
        }
        
        .meal-panel .panel-heading {
            color: white;
        }
        
        .breakfast-panel .panel-heading {
            background: linear-gradient(135deg, var(--breakfast-color), #ff6b6b);
        }
        
        .lunch-panel .panel-heading {
            background: linear-gradient(135deg, var(--lunch-color), #2575fc);
        }
        
        .dinner-panel .panel-heading {
            background: linear-gradient(135deg, var(--dinner-color), #4facfe);
        }
        
        .special-panel .panel-heading {
            background: linear-gradient(135deg, var(--special-color), #e91e63);
            color: white;
        }
        
        .meal-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .meal-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
        }
        
        .meal-item:hover {
            background: #f9f9f9;
        }
        
        .meal-item.special {
            border-left: 4px solid var(--special-color);
            background: #fff9fc;
        }
        
        .meal-info {
            flex: 1;
        }
        
        .meal-name {
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }
        
        .meal-description {
            color: #7f8c8d;
            margin: 5px 0;
        }
        
        .meal-price {
            font-weight: 700;
            color: var(--success-color);
            font-size: 18px;
        }
        
        .meal-occasion {
            font-style: italic;
            color: #666;
            margin-top: 5px;
            font-size: 0.9em;
        }
        
        .meal-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-meal {
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .empty-meal-message {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }
        
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
        
        .special-badge {
            background: var(--special-color);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 10px;
        }
        
        .conditional-field {
            display: none;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
        }
        
        .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
        }
        
        .form-horizontal .form-group {
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            border: none;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
            border: none;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Daily Meal Planning</h2>
                
                <div class="tab-container">
                    <div class="tab-buttons">
                        <button class="tab-button active" onclick="openTab('addMeal', event)">Add Meal</button>
                        <button class="tab-button" onclick="openTab('viewMeals', event)">View & Order Meals</button>
                        <button class="tab-button" onclick="openTab('specialMeals', event)">Special Occasions</button>
                    </div>
                    
                    <!-- Add Meal Tab -->
                    <div id="addMeal" class="tab-content active">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New Meal</div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Meal Type</label>
                                        <div class="col-sm-8">
                                            <select name="meal_type" class="form-control" required>
                                                <option value="">Select Meal Type</option>
                                                <option value="breakfast">Breakfast</option>
                                                <option value="lunch">Lunch</option>
                                                <option value="dinner">Dinner</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="description" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Price</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" name="price" step="0.01" min="0" required placeholder="Enter meal price">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Special Meal</label>
                                        <div class="col-sm-8 checkbox-container">
                                            <input type="checkbox" id="is_special" name="is_special" value="1" onchange="toggleOccasionField()">
                                            <label for="is_special">Mark as special occasion meal</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group conditional-field" id="occasionField">
                                        <label class="col-sm-2 control-label">Occasion</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="occasion" placeholder="E.g., Christmas, Birthday, Anniversary">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <input class="btn btn-primary" type="submit" name="add_meal" value="Add Meal">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View Meals Tab -->
                    <div id="viewMeals" class="tab-content">
                        <div class="row">
                            <!-- Breakfast Panel -->
                            <div class="col-md-4">
                                <div class="panel panel-default meal-panel breakfast-panel">
                                    <div class="panel-heading">Breakfast</div>
                                    <div class="panel-body">
                                        <ul class="meal-list">
                                            <?php if(count($breakfast_meals) > 0): ?>
                                                <?php foreach($breakfast_meals as $meal): ?>
                                                    <li class="meal-item">
                                                        <div class="meal-info">
                                                            <div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
                                                            <div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
                                                        </div>
                                                        <div class="meal-actions">
                                                            <button class="btn btn-success btn-meal" onclick="toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
                                                            <a href="?delete_id=<?php echo $meal['id']; ?>" class="btn btn-primary btn-meal" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                                                        </div>
                                                        <div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
                                                            <form method="post">
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
                                                <div class="empty-meal-message">No breakfast meals added yet.</div>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Lunch Panel -->
                            <div class="col-md-4">
                                <div class="panel panel-default meal-panel lunch-panel">
                                    <div class="panel-heading">Lunch</div>
                                    <div class="panel-body">
                                        <ul class="meal-list">
                                            <?php if(count($lunch_meals) > 0): ?>
                                                <?php foreach($lunch_meals as $meal): ?>
                                                    <li class="meal-item">
                                                        <div class="meal-info">
                                                            <div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
                                                            <div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
                                                        </div>
                                                        <div class="meal-actions">
                                                            <button class="btn btn-success btn-meal" onclick="toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
                                                            <a href="?delete_id=<?php echo $meal['id']; ?>" class="btn btn-primary btn-meal" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                                                        </div>
                                                        <div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
                                                            <form method="post">
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
                                                <div class="empty-meal-message">No lunch meals added yet.</div>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dinner Panel -->
                            <div class="col-md-4">
                                <div class="panel panel-default meal-panel dinner-panel">
                                    <div class="panel-heading">Dinner</div>
                                    <div class="panel-body">
                                        <ul class="meal-list">
                                            <?php if(count($dinner_meals) > 0): ?>
                                                <?php foreach($dinner_meals as $meal): ?>
                                                    <li class="meal-item">
                                                        <div class="meal-info">
                                                            <div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
                                                            <div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
                                                        </div>
                                                        <div class="meal-actions">
                                                            <button class="btn btn-success btn-meal" onclick="toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
                                                            <a href="?delete_id=<?php echo $meal['id']; ?>" class="btn btn-primary btn-meal" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                                                        </div>
                                                        <div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
                                                            <form method="post">
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
                                                <div class="empty-meal-message">No dinner meals added yet.</div>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Meals Tab -->
                    <div id="specialMeals" class="tab-content">
                        <div class="panel panel-default special-panel">
                            <div class="panel-heading">Special Occasion Meals</div>
                            <div class="panel-body">
                                <?php if(count($special_meals) > 0): ?>
                                    <ul class="meal-list">
                                        <?php foreach($special_meals as $meal): ?>
                                            <li class="meal-item special">
                                                <div class="meal-info">
                                                    <div class="meal-name">
                                                        <?php echo ucfirst($meal['meal_type']); ?> 
                                                        <span class="special-badge">Special</span>
                                                    </div>
                                                    <div class="meal-description"><?php echo htmlspecialchars($meal['description']); ?></div>
                                                    <div class="meal-price"><?php echo number_format($meal['price'], 2); ?></div>
                                                    <?php if(!empty($meal['occasion'])): ?>
                                                        <div class="meal-occasion">Occasion: <?php echo htmlspecialchars($meal['occasion']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="meal-actions">
                                                    <button class="btn btn-success btn-meal" onclick="toggleOrderForm(<?php echo $meal['id']; ?>)">Order Now</button>
                                                    <a href="?delete_id=<?php echo $meal['id']; ?>" class="btn btn-primary btn-meal" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                                                </div>
                                                <div id="order-form-<?php echo $meal['id']; ?>" class="order-form">
                                                    <form method="post">
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
                                    <div class="empty-meal-message">No special occasion meals added yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Function to switch between tabs
        function openTab(tabName, event) {
            // Hide all tab content
            var tabContent = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active");
            }
            
            // Remove active class from all buttons
            var tabButtons = document.getElementsByClassName("tab-button");
            for (var i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }
            
            // Show the specific tab content
            document.getElementById(tabName).classList.add("active");
            
            // Add active class to the clicked button
            if (event) {
                event.currentTarget.classList.add("active");
            }
        }
        
        // Function to toggle the occasion field based on checkbox
        function toggleOccasionField() {
            var checkbox = document.getElementById('is_special');
            var occasionField = document.getElementById('occasionField');
            
            if (checkbox && occasionField) {
                if (checkbox.checked) {
                    occasionField.style.display = 'block';
                } else {
                    occasionField.style.display = 'none';
                }
            }
        }
        
        // Function to toggle the order form visibility
        function toggleOrderForm(mealId) {
            var orderForm = document.getElementById('order-form-' + mealId);
            
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
            // Initialize the occasion field visibility
            toggleOccasionField();
            
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