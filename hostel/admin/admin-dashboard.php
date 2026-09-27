<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Get statistics for the dashboard
$result = "SELECT count(*) FROM registration";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($student_count);
$stmt->fetch();
$stmt->close();

$result1 = "SELECT count(*) FROM rooms";
$stmt1 = $mysqli->prepare($result1);
$stmt1->execute();
$stmt1->bind_result($room_count);
$stmt1->fetch();
$stmt1->close();

// Get additional stats
$result2 = "SELECT count(*) FROM payments WHERE status = 'pending'";
$stmt2 = $mysqli->prepare($result1);
$stmt2->execute();
$stmt2->bind_result($pending_payments);
$stmt2->fetch();
$stmt2->close();

$result3 = "SELECT count(*) FROM meal_plans";
$stmt3 = $mysqli->prepare($result1);
$stmt3->execute();
$stmt3->bind_result($meal_plans);
$stmt3->fetch();
$stmt3->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #00d2ff;
            --success: #00b09b;
            --info: #2193b0;
            --warning: #f46b45;
            --danger: #ee0979;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --sidebar-width: 250px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background:  linear-gradient(to right, var(--primary), var(--secondary));
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            z-index: 1000;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left h1 {
            font-size: 1.5rem;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: #6a11cb;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            padding: 25px 0;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
        }

        .menu-title {
            padding: 15px 25px 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .menu-link:hover, .menu-link.active {
            background: linear-gradient(to right, rgba(255, 255, 255, 0.1), transparent);
            color: white;
            border-left-color: var(--primary);
        }

        .menu-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 30px;
            transition: var(--transition);
        }

        .page-title {
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            padding-bottom: 10px;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        /* Dashboard Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .stat-card:nth-child(2)::before {
            background: linear-gradient(to right, var(--success), #00d2ff);
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(to right, var(--warning), #ffa751);
        }

        .stat-card:nth-child(4)::before {
            background: linear-gradient(to right, var(--danger), #ff5858);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon.student {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .stat-icon.room {
            background: linear-gradient(135deg, var(--success), #00d2ff);
        }

        .stat-icon.payment {
            background: linear-gradient(135deg, var(--warning), #ffa751);
        }

        .stat-icon.meal {
            background: linear-gradient(135deg, var(--danger), #ff5858);
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 5px;
            background: linear-gradient(to right, var(--dark), #495057);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .stat-card-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--light-gray);
        }

        .view-details {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: var(--transition);
        }

        .view-details:hover {
            color: var(--secondary);
            gap: 12px;
        }

        /* Welcome Panel */
        .welcome-panel {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(106, 17, 203, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-content h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .welcome-content p {
            opacity: 0.9;
            max-width: 600px;
        }

        .welcome-icon {
            font-size: 4rem;
            opacity: 0.2;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
            }

            .welcome-panel {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .welcome-icon {
                order: -1;
            }
        }

        /* Toggle button for mobile */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .menu-toggle {
                display: block;
            }

            .header {
                padding: 0 15px;
            }

            .main-content {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            
            <h1>Admin Dashboard</h1>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <div class="avatar">A</div>
                <span>Administrator</span>
            </div>
            
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            
            
            <li class="menu-title">Room Management</li>
            <li class="menu-item">
                <a href="create-room.php" class="menu-link"> 
                    <i>➕</i> Create Room
                </a>
            </li>
            <li class="menu-item">
                <a href="manage-rooms.php" class="menu-link">
                    <i>🛏️</i> Manage Rooms
                </a>
            </li>
            
            <li class="menu-title">Meal Management</li>
            <li class="menu-item">
                <a href="add-meal.php" class="menu-link">
                    <i>🍽️</i> Add Meal 
                </a>
            </li>
            <li class="menu-item">
                <a href="manage-meal.php" class="menu-link">
                    <i>📋</i> Manage Meal System
                </a>
            </li>
            
            <li class="menu-title">Financial</li>
            <li class="menu-item">
                <a href="manage-payment.php" class="menu-link">
                    <i>💳</i> Manage Payments
                </a>
            </li>
            
            <li class="menu-title">User Management</li>
            <li class="menu-item">
                <a href="manage-students.php" class="menu-link">
                    <i>👥</i> User Details
                </a>
            </li>
            
            <li class="menu-title">System</li>
            <li class="menu-item">
                <a href="access-log.php" class="menu-link">
                    <i>📝</i> Access Logs
                </a>
            </li>
            <li class="menu-item">
                <a href="logout.php" class="menu-link">
                    <i>🚪</i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <h2 class="page-title">Dashboard Overview</h2>
        
        <!-- Welcome Panel -->
        <div class="welcome-panel">
            <div class="welcome-content">
                <h2>Welcome, Administrator!</h2>
                <p>Here's an overview of your hostel management system. You can manage rooms, meals, payments, and user details from this dashboard.</p>
            </div>
            
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon student">👥</div>
                </div>
                <div class="stat-value"><?php echo $student_count; ?></div>
                <div class="stat-label">Total Students</div>
                <div class="stat-card-footer">
                    <a href="manage-students.php" class="view-details">
                        View Details <span>→</span>
                    </a>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon room">🛏️</div>
                </div>
                <div class="stat-value"><?php echo $room_count; ?></div>
                <div class="stat-label">Total Rooms</div>
                <div class="stat-card-footer">
                    <a href="manage-rooms.php" class="view-details">
                        View Details <span>→</span>
                    </a>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon payment">💳</div>
                </div>
                <div class="stat-value"><?php echo $pending_payments; ?></div>
                <div class="stat-label">Pending Payments</div>
                <div class="stat-card-footer">
                    <a href="manage-payments.php" class="view-details">
                        View Details <span>→</span>
                    </a>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon meal">🍽️</div>
                </div>
                <div class="stat-value"><?php echo $meal_plans; ?></div>
                <div class="stat-label">Meal Plans</div>
                <div class="stat-card-footer">
                    <a href="manage-meal.php" class="view-details">
                        View Details <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Toggle sidebar on mobile
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        
        // Add active class to clicked menu items
        const menuItems = document.querySelectorAll('.menu-link');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.getAttribute('href') !== '#') {
                    e.preventDefault();
                }
                
                menuItems.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>