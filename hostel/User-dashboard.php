
<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');

// Check if user is logged in
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if user has booked a room
$booking_check = $mysqli->prepare("SELECT * FROM hostelbookings WHERE userId = ?");
$booking_check->bind_param('i', $_SESSION['id']);
$booking_check->execute();
$booking_result = $booking_check->get_result();
$has_booking = $booking_result->num_rows > 0;
$booking_data = $has_booking ? $booking_result->fetch_assoc() : null;
$booking_check->close();
?>

<!-- In your dashboard HTML, add something like this: -->
<?php if(!$has_booking): ?>
<div class="alert alert-info">
    <p>You haven't booked a hostel room yet. <a href="book-hostel.php">Click here to book one</a>.</p>
</div>
<?php else: ?>
<div class="alert alert-success">
    <p>You have already booked a hostel room. Room details: <?php echo $booking_data['hostelType']; ?></p>
</div>
<?php endif; ?>

<!doctype html>

<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="theme-color" content="#80b9f1ff">
  
  <title>Student Dashboard | Hostel Management System</title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --gray-color: #6c757d;
      --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }
    
    body {
      background-color: #f5f7fb;
      color: #495057;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    /* Header Styles */
    .user-header {
      background: linear-gradient(120deg, #4361ee, #7209b7);
      color: white;
      padding: 15px 20px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .user-header .brand {
      font-size: 22px;
      font-weight: 600;
      display: flex;
      align-items: center;
    }
    
    .user-header .brand i {
      margin-right: 10px;
    }
    
    .user-nav {
      display: flex;
      align-items: center;
    }
    
    .user-nav .nav-item {
      margin-left: 20px;
      position: relative;
    }
    
    .user-nav .nav-link {
      color: white;
      font-weight: 500;
      display: flex;
      align-items: center;
    }
    
    .user-nav .nav-link i {
      margin-right: 5px;
    }
    
    .user-nav .nav-link:hover {
      color: rgba(255, 255, 255, 0.8);
    }
    
    .user-profile {
      display: flex;
      align-items: center;
      cursor: pointer;
    }
    
    .user-profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    /* Sidebar Styles */
    .user-sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      bottom: 0;
      width: 250px;
      background: white;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
      z-index: 900;
      overflow-y: auto;
      transition: all 0.3s ease;
    }
    
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 20px 0;
    }
    
    .sidebar-menu li {
      margin-bottom: 5px;
    }
    
    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: #495057;
      text-decoration: none;
      transition: all 0.3s;
      border-left: 4px solid transparent;
    }
    
    .sidebar-menu a:hover, .sidebar-menu a.active {
      background: #f8f9fa;
      color: var(--primary-color);
      border-left-color: var(--primary-color);
    }
    
    .sidebar-menu a i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
    
    /* Main Content */
    .ts-main-content {
      margin-left: 250px;
      padding-top: 70px;
      background: #f5f7fb;
      min-height: 100vh;
    }
    
    .content-wrapper {
      padding: 20px;
    }
    
    .dashboard-header {
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .dashboard-header h2 {
      font-weight: 600;
      color: var(--dark-color);
      margin-bottom: 5px;
    }
    
    .dashboard-header p {
      color: var(--gray-color);
      font-size: 16px;
    }
    
    .dashboard-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      margin-bottom: 25px;
      border: none;
      overflow: hidden;
    }
    
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .card-icon {
      font-size: 28px;
      margin-bottom: 15px;
      color: #fff;
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
    }
    
    .card-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 10px;
      color: var(--dark-color);
    }
    
    .card-text {
      color: var(--gray-color);
      font-size: 14px;
      margin-bottom: 15px;
    }
    
    .card-link {
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      transition: var(--transition);
    }
    
    .card-link:hover {
      color: var(--secondary-color);
    }
    
    .card-link i {
      margin-left: 5px;
      transition: var(--transition);
    }
    
    .card-link:hover i {
      transform: translateX(3px);
    }
    
    .bg-primary { background: linear-gradient(45deg, #4361ee, #3a56d4); }
    .bg-success { background: linear-gradient(45deg, #4cc9f0, #3ab5d4); }
    .bg-warning { background: linear-gradient(45deg, #f72585, #d41a6e); }
    .bg-info { background: linear-gradient(45deg, #7209b7, #5d0896); }
    .bg-secondary { background: linear-gradient(45deg, #4895ef, #3a80d4); }
    .bg-dark { background: linear-gradient(45deg, #560bad, #450888); }
    
    .user-welcome {
      background: linear-gradient(120deg, #6a11cb, #2575fc);
      color: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
    }
    
    .welcome-text {
      font-size: 24px;
      font-weight: 500;
    }
    
    .welcome-subtext {
      font-size: 16px;
      opacity: 0.9;
    }
    
    .profile-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      width: 200px;
      z-index: 1000;
      display: none;
    }
    
    .profile-dropdown.show {
      display: block;
    }
    
    .profile-dropdown a {
      display: block;
      padding: 12px 15px;
      color: #495057;
      text-decoration: none;
      transition: all 0.3s;
    }
    
    .profile-dropdown a:hover {
      background: #f8f9fa;
      color: var(--primary-color);
    }
    
    .profile-dropdown a i {
      margin-right: 8px;
      width: 18px;
    }
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
      .user-sidebar {
        transform: translateX(-100%);
        width: 220px;
      }
      
      .user-sidebar.active {
        transform: translateX(0);
      }
      
      .ts-main-content {
        margin-left: 0;
      }
      
      .menu-toggle {
        display: block !important;
      }
    }
    
    .menu-toggle {
      display: none;
      background: none;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="user-header">
    <div class="brand">
      <i class="fas fa-home"></i>
      <span>Hostel Management System</span>
    </div>
    
    <button class="menu-toggle">
      <i class="fas fa-bars"></i>
    </button>
    
    <nav class="user-nav">
      <div class="nav-item">
        <div class="user-profile" id="profileDropdownTrigger">
          <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['id']); ?>&background=4361ee&color=fff" alt="User">
          
          <i class="fas fa-chevron-down ml-1" style="font-size: 12px;"></i>
        </div>
        <div class="profile-dropdown" id="profileDropdown">
          <a href="my-profile.php"><i class="fas fa-user"></i> My Profile</a>
          <a href="change-password.php"><i class="fas fa-lock"></i> Change Password</a>
          <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
          <div style="border-top: 1px solid #eee; margin: 5px 0;"></div>
          <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </div>
    </nav>
  </header>

  <!-- Sidebar -->
  <aside class="user-sidebar">
    <ul class="sidebar-menu">
      <li><a href= "User-dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="book-hostel.php"><i class="fas fa-bed"></i> Book Room</a></li>
      <li><a href="room-details.php"><i class="fas fa-door-open"></i> Room Details</a></li>
      <li><a href="student-meals.php"><i class="fas fa-utensils"></i> Meal System</a></li>
      <li><a href="user-payment.php"><i class="fas fa-credit-card"></i> Payments</a></li>
      <li><a href="my-profile.php"><i class="fas fa-user"></i> My Profile</a></li>
      <li><a href="change-password.php"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <div class="ts-main-content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="dashboard-header">
          <h2>Student Dashboard</h2>
          <p>Welcome back! Manage your hostel activities from one place.</p>
        </div>
        
        <!-- Welcome Banner -->
        <div class="user-welcome">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h3 class="welcome-text">Hello</h3>
              <p class="welcome-subtext">Here's everything you need to manage your hostel stay.</p>
            </div>
            
          </div>
        </div>
        
        <div class="row">
          <!-- Book Hostel Room Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-primary">
                <i class="fas fa-bed"></i>
              </div>
              <h4 class="card-title">Book Hostel Room</h4>
              <p class="card-text">Reserve your preferred hostel room for the semester</p>
              <a href="book-hostel.php" class="card-link">Book Now <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          
          <!-- Room Details Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-success">
                <i class="fas fa-door-open"></i>
              </div>
              <h4 class="card-title">Room Details</h4>
              <p class="card-text">View information about your current room allocation</p>
              <a href="room-details.php" class="card-link">View Details <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          
          <!-- Meal System Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-warning">
                <i class="fas fa-utensils"></i>
              </div>
              <h4 class="card-title"> Meal Details </h4>
              <p class="card-text">View your meal plans and dining preferences</p>
              <a href="student-meals.php" class="card-link">View Meals <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        
        <div class="row">
          <!-- Payment Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-info">
                <i class="fas fa-credit-card"></i>
              </div>
              <h4 class="card-title">Payment</h4>
              <p class="card-text">View and pay your hostel fees and other charges</p>
              <a href="user-payment.php" class="card-link">Make Payment <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          
          <!-- My Profile Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-secondary">
                <i class="fas fa-user"></i>
              </div>
              <h4 class="card-title">My Profile</h4>
              <p class="card-text">Update your personal information and preferences</p>
              <a href="my-profile.php" class="card-link">View Profile <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          
          <!-- Change Password Card -->
          <div class="col-md-4">
            <div class="dashboard-card text-center p-4">
              <div class="card-icon bg-dark">
                <i class="fas fa-lock"></i>
              </div>
              <h4 class="card-title">Change Password</h4>
              <p class="card-text">Update your login password for security purposes</p>
              <a href="change-password.php" class="card-link">Change Password <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Toggle sidebar on mobile
    document.querySelector('.menu-toggle').addEventListener('click', function() {
      document.querySelector('.user-sidebar').classList.toggle('active');
    });

    // Simple animation for card hover effects
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.dashboard-card');
      
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-5px)';
          this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.12)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = '';
          this.style.boxShadow = '';
        });
      });
      
      // Profile dropdown functionality
      const profileTrigger = document.getElementById('profileDropdownTrigger');
      const profileDropdown = document.getElementById('profileDropdown');
      
      if (profileTrigger && profileDropdown) {
        profileTrigger.addEventListener('click', function(e) {
          e.stopPropagation();
          profileDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function() {
          profileDropdown.classList.remove('show');
        });
        
        // Prevent dropdown from closing when clicking inside it
        profileDropdown.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });
  </script>

</body>

</html>