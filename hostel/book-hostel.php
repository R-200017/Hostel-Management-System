<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Check if user already booked a room FIRST
$uid = $_SESSION['login'];
$stmt = $mysqli->prepare("SELECT roomno FROM registration WHERE emailid=? OR regno=?");
$stmt->bind_param('ss', $uid, $uid);
$stmt->execute();
$stmt->store_result();
$hasBooking = ($stmt->num_rows > 0);
$stmt->close();

// Only process the form if user doesn't have a booking
if (!$hasBooking && isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $seater = $_POST['seater'];
    $feespm = $_POST['fpm'];
   $stayfrom = $_POST['stayf'];
    $duration = $_POST['duration'];
   
    $regno = $_POST['regno'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $department = $_POST['department'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];
    $gname = $_POST['gname'];
    $grelation = $_POST['grelation'];
    $gcontac = $_POST['gcontact'];
    $address = $_POST['address'];
    
    $query = "insert into registration(roomno,seater,feespm,stayfrom,duration,regno,firstName,middleName,lastName,department,contactno,emailid,guardianName,guardianRelation,guardianContactno,Address) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('isisissssisissis', $roomno, $seater, $feespm,$stayfrom, $duration,$regno, $fname, $mname, $lname,$department , $contactno, $emailid,  $gname,$grelation, $gcontac,$address);
    
    if ($stmt->execute()) {
        // Set session variable to show success message
        $_SESSION['booking_success'] = true;
        // Redirect to same page to show "already booked" message
        header("Location: book-hostel.php");
        exit();
    } else {
        echo "<script>alert('Error booking room. Please try again.');</script>";
    }
    $stmt->close();
}

// Check again if booking was just completed
if (isset($_SESSION['booking_success'])) {
    $hasBooking = true;
    unset($_SESSION['booking_success']); // Clear the session variable
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
    <title>Student Hostel Registration</title>
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        .booking-container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px auto;
        }
        
        .booking-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .booking-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .booking-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .booking-body {
            padding: 30px;
        }
        
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .section-title {
            color: #6a11cb;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            font-size: 20px;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }
        
        .form-control[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-col {
            flex: 1;
            padding: 0 10px;
            min-width: 250px;
            margin-bottom: 15px;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        
        .btn-default {
            background: #f8f9fa;
            color: #333;
        }
        
        .btn-default:hover {
            background: #e9ecef;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
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
        
        .room-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .room-info p {
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .room-info span {
            font-weight: 600;
            color: #6a11cb;
        }
        
        .status-message {
            font-size: 14px;
            margin-top: 5px;
            padding: 5px;
            border-radius: 4px;
        }
        
        .already-booked {
            text-align: center;
            padding: 40px 20px;
        }
        
        .already-booked i {
            font-size: 64px;
            color: #6a11cb;
            margin-bottom: 20px;
        }
        
        .already-booked h3 {
            color: #6a11cb;
            margin-bottom: 15px;
        }
        
        .room-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin: 15px 0;
            transition: all 0.3s;
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .booking-body {
                padding: 20px;
            }
            
            .form-col {
                flex: 100%;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
    <script>
        function getSeater(val) {
            $.ajax({
                type: "POST",
                url: "get_seater.php",
                data: 'roomid=' + val,
                success: function(data) {
                    $('#seater').val(data);
                    updateRoomInfo();
                }
            });
            $.ajax({
                type: "POST",
                url: "get_seater.php",
                data: 'rid=' + val,
                success: function(data) {
                    $('#fpm').val(data);
                    updateRoomInfo();
                }
            });
        }
        
        function updateRoomInfo() {
            const roomNo = $('#room').val();
            const seater = $('#seater').val();
            const fees = $('#fpm').val();
            
            if (roomNo && seater && fees) {
                $('.room-info').html(`
                    <p>Room Number: <span>${roomNo}</span></p>
                    <p>Capacity: <span>${seater} Person</span></p>
                    <p>Monthly Fee: <span>${fees}</span></p>
                `);
            }
        }
        
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'roomno=' + $("#room").val(),
                type: "POST",
                success: function(data) {
                    $("#room-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
</head>

<body>
    <div class="booking-container">
        <div class="booking-header">
            <h1><i class="fas fa-bed"></i> Hostel Room Booking</h1>
            <p>Complete the form below to book your hostel room</p>
        </div>
        
        <div class="booking-body">
            <?php if ($hasBooking) { ?>
                <div class="already-booked">
                    <i class="fas fa-check-circle"></i>
                    <h3>Room Already Booked</h3>
                    <p>You have already booked a hostel room. You can view your room details below.</p>
                    <a href="room-details.php" class="btn btn-primary">
                        <i class="fas fa-door-open"></i> View Room Details
                    </a>
                </div>
            <?php } else { ?>
                <form method="post" action="">
                    <!-- Room Information Section -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-bed"></i> Room Information</h3>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Room Number</label>
                                <select name="room" id="room" class="form-control" onChange="getSeater(this.value);" onBlur="checkAvailability()" required>
                                    <option value="">Select Room</option>
                                    <?php 
                                    $query = "SELECT * FROM rooms";
                                    $stmt2 = $mysqli->prepare($query);
                                    $stmt2->execute();
                                    $res = $stmt2->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="status-message" id="room-availability-status"></div>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">Seater Capacity</label>
                                <input type="text" name="seater" id="seater" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Fees Per Month </label>
                                <input type="text" name="fpm" id="fpm" class="form-control" readonly>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">Stay From</label>
                                <input type="date" name="stayf" id="stayf" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Duration (Months)</label>
                                <select name="duration" id="duration" class="form-control" required>
                                    <option value="">Select Duration</option>
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="4">4 Months</option>
                                    <option value="5">5 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="7">7 Months</option>
                                    <option value="8">8 Months</option>
                                    <option value="9">9 Months</option>
                                    <option value="10">10 Months</option>
                                    <option value="11">11 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="room-info">
                            <p>Please select a room to see details</p>
                        </div>
                    </div>
                    
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-user"></i> Personal Information</h3>
                        
                        <?php
                        $aid = $_SESSION['id'];
                        $ret = "select * from userregistration where id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="regno" id="regno" class="form-control" value="<?php echo $row->regNo; ?>" readonly>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $row->firstName; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="mname" id="mname" class="form-control" value="<?php echo $row->middleName; ?>" readonly>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $row->lastName; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" value="<?php echo $row->department; ?>" class="form-control" readonly>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact" id="contact" value="<?php echo $row->contactNo; ?>" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $row->email; ?>" readonly>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>
                    
                    <!-- Guardian Information Section -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-users"></i> Guardian Information</h3>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Guardian Name</label>
                                <input type="text" name="gname" id="gname" class="form-control" required>
                            </div>
                            
                            <div class="form-col">
                                <label class="form-label">Relationship</label>
                                <input type="text" name="grelation" id="grelation" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label">Guardian Contact Number</label>
                                <input type="text" name="gcontact" id="gcontact" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Section -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-home"></i> Address Information</h3>
                        
                        <div class="form-group">
                            <label class="form-label">Permanent Address</label>
                            <textarea rows="5" name="address" id="address" class="form-control" required></textarea>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="reset" class="btn btn-default">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> Book Room Now
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Update room info when page loads if values are already selected
            updateRoomInfo();
            
            // Add animation to form elements
            $('.form-control').focus(function() {
                $(this).parent().css('transform', 'translateY(-2px)');
            }).blur(function() {
                $(this).parent().css('transform', 'translateY(0)');
            });
        });
    </script>
</body>
</html>