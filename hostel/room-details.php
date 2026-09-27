<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
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
    <title>Room Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 510 + ',height=' + 430 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
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
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
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
            background: linear-gradient(180deg, #2a5298 0%, #1e3c72 100%);
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
            color: #2a5298;
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
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
        }
        
        .panel-body {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f1f1f1;
        }
        
        h3, h4 {
            margin: 15px 0;
            color: #2a5298;
        }
        
        .print-icon {
            cursor: pointer;
            font-size: 24px;
            color: #2a5298;
            margin-bottom: 15px;
            display: inline-block;
        }
        
        .print-icon:hover {
            color: #1e3c72;
        }
        
        @media print {
            .header, .sidebar, .print-icon {
                display: none;
            }
            
            .main-container {
                display: block;
            }
            
            .content {
                padding: 0;
                margin: 0;
            }
        }
        
        .no-booking {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 18px;
        }
        
        .no-booking i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ccc;
        }
        
        .book-now-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .book-now-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .already-booked {
            text-align: center;
            padding: 30px;
            background-color: #f0f8ff;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #4CAF50;
        }
        
        .already-booked i {
            font-size: 48px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        
        .already-booked h3 {
            color: red;
            margin-bottom: 10px;
        }
        
        .already-booked p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        
       
        
        .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
    </style>
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
                <li><a href="room-details.php" style="background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #4CAF50;">Room Details</a></li>
                <li><a href="change-password.php">Change Password</a></li>
            </ul>
        </div>

        <div class="content">
            <h2 class="page-title">Room Details</h2>
            
            <div class="panel panel-default">
                <div class="panel-heading">All Room Details</div>
                <div class="panel-body">
                    <?php
                    // Get user details from userregistration table first
                    $uid = $_SESSION['id'];
                    $user_query = "SELECT regno, email FROM userregistration WHERE id = ?";
                    $user_stmt = $mysqli->prepare($user_query);
                    $user_stmt->bind_param('i', $uid);
                    $user_stmt->execute();
                    $user_result = $user_stmt->get_result();

                    if ($user_row = $user_result->fetch_object()) {
                        $user_regno = $user_row->regno;
                        $user_email = $user_row->email;
                        
                        // Now query the registration table using both regno and email
                        $ret = "SELECT * FROM registration WHERE (emailid=? || regno=?) ORDER BY postingDate DESC LIMIT 1";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('ss', $user_email, $user_regno);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        $cnt = 1;
                        
                        if ($row = $res->fetch_object()) {
                            // Student has already booked a room
                            $roomno = $row->roomno;
                    ?>
                            <div class="already-booked">
                                
                                <h3>You Have Already Booked a Room</h3>
                                <p>Your room booking details are shown below. You can print this information for your records.</p>
                                <div class="action-buttons">
                                    
                                        
                                    </a>
                                    <span class="print-icon" OnClick="CallPrint(this.value)" title="Print the Report">
                                        <i class="fas fa-print"></i> Print Report
                                    </span>
                                </div>
                            </div>
                            
                            <table id="zctb" cellspacing="0" width="100%" border="1">
                                <tbody>
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:blue">
                                            <h3>Room Related Info</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Registration Number :</th>
                                        <td><?php echo $row->regno; ?></td>
                                        <th>Apply Date :</th>
                                        <td colspan="3"><?php echo $row->postingDate; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Room no :</b></td>
                                        <td><?php echo $row->roomno; ?></td>
                                        <td><b>Seater :</b></td>
                                        <td><?php echo $row->seater; ?></td>
                                        <td><b>Fees PM :</b></td>
                                        <td><?php echo $fpm = $row->feespm; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Hostel Fee:</th>
                                        <td><?php echo $hf = 1 * $fpm ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" style="color:red">
                                            <h4>Personal Info</h4>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Reg No. :</b></td>
                                        <td><?php echo $row->regno; ?></td>
                                        <td><b>Full Name :</b></td>
                                        <td><?php echo $row->firstName; ?> <?php echo $row->middleName; ?> <?php echo $row->lastName; ?></td>
                                        <td><b>Email :</b></td>
                                        <td><?php echo $row->emailid; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b>Contact No. :</b></td>
                                        <td><?php echo $row->contactno; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><b>Guardian Contact No. :</b></td>
                                        <td colspan="6"><?php echo $row->guardianContactno; ?></td>
                                    </tr>

                                    <tr>
                                        <td><b> Address: </b></td>
                                        <td colspan="7"><?php echo $row->Address; ?></td>
                                    </tr>

                                    <!-- Roommates Section -->
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:green">
                                            <h3>Roommates Details</h3>
                                        </td>
                                    </tr>
                                    <?php
                                    // Query to get roommates (excluding current user)
                                    $roommates_query = "SELECT * FROM registration WHERE roomno = ? AND (emailid != ? AND regno != ?) ORDER BY firstName";
                                    $stmt_roommates = $mysqli->prepare($roommates_query);
                                    $stmt_roommates->bind_param('sss', $roomno, $user_email, $user_regno);
                                    $stmt_roommates->execute();
                                    $roommates_result = $stmt_roommates->get_result();

                                    if ($roommates_result->num_rows > 0) {
                                        $roommate_count = 1;
                                        while ($roommate = $roommates_result->fetch_object()) {
                                    ?>
                                            <tr>
                                                <td colspan="6" style="background-color:#f5f5f5;">
                                                    <h4>Roommate <?php echo $roommate_count; ?></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Reg No. :</b></td>
                                                <td><?php echo $roommate->regno; ?></td>
                                                <td><b>Full Name :</b></td>
                                                <td><?php echo $roommate->firstName . ' ' . $roommate->middleName . ' ' . $roommate->lastName; ?></td>
                                                <td><b>Email :</b></td>
                                                <td><?php echo $roommate->emailid; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Contact No. :</b></td>
                                                <td><?php echo $roommate->contactno; ?></td>
                                                <td><b>Department :</b></td>
                                                <td><?php echo $roommate->department; ?></td>
                                            </tr>
                                    <?php
                                            $roommate_count++;
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" style="text-align:center;">No roommates assigned yet</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                    <?php
                        } else {
                            // No booking found
                            echo '<div class="no-booking">';
                            echo '<i class="fas fa-bed"></i>';
                            echo '<h3>No Room Booking Found</h3>';
                            echo '<p>You haven\'t booked a hostel room yet.</p>';
                            echo '<a href="book-hostel.php" class="book-now-btn">Book Now</a>';
                            echo '</div>';
                        }
                    } else {
                        // User details not found
                        echo '<div class="no-booking">';
                        echo '<i class="fas fa-exclamation-triangle"></i>';
                        echo '<h3>User Details Not Found</h3>';
                        echo '<p>Please contact administrator.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function CallPrint(strid) {
            var prtContent = document.getElementById("zctb");
            if (!prtContent) {
                alert("Nothing to print. Please book a room first.");
                return;
            }
            
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write('<html><head><title>Room Details Report</title>');
            WinPrint.document.write('<style>');
            WinPrint.document.write('body { font-family: Arial, sans-serif; }');
            WinPrint.document.write('table { width: 100%; border-collapse: collapse; }');
            WinPrint.document.write('table, th, td { border: 1px solid #000; }');
            WinPrint.document.write('th, td { padding: 8px; text-align: left; }');
            WinPrint.document.write('th { background-color: #f2f2f2; }');
            WinPrint.document.write('h3, h4 { color: #000; }');
            WinPrint.document.write('</style>');
            WinPrint.document.write('</head><body>');
            WinPrint.document.write('<h2 style="text-align:center;">Room Details Report</h2>');
            WinPrint.document.write(prtContent.outerHTML);
            WinPrint.document.write('</body></html>');
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }
    </script>
</body>

</html>