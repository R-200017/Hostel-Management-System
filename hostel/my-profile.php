<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$aid=$_SESSION['id'];
if(isset($_POST['update']))
{
    $fname=$_POST['fname'];
    $mname=$_POST['mname'];
    $lname=$_POST['lname'];
    $contactno=$_POST['contact'];
    $udate = date('d-m-Y h:i:s', time());
    $query="update userRegistration set firstName=?,middleName=?,lastName=?,contactNo=?,updationDate=? where id=?";
    $stmt = $mysqli->prepare($query);
    $rc=$stmt->bind_param('sssisi',$fname,$mname,$lname,$contactno,$udate,$aid);
    $stmt->execute();
    echo"<script>alert('Profile updated Successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Profile Update</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6f42c1;
            --accent-color: #36b9cc;
            --light-bg: #f8f9fc;
            --dark-text: #5a5c69;
        }
        
        body {
            background: linear-gradient(to right, #f8f9fc, #e9ecef);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            min-height: 100vh;
        }
        
        .profile-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .profile-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 28px;
        }
        
        .profile-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: var(--primary-color);
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        
        .profile-body {
            padding: 30px;
        }
        
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .section-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            font-size: 18px;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            transition: all 0.3s;
            font-size: 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.15);
        }
        
        .form-control:read-only {
            background-color: #f8f9fc;
            opacity: 0.8;
        }
        
        .btn-update {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            color: white;
        }
        
        .last-update {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-top: 10px;
        }
        
        .info-card {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .info-card h5 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                margin: 20px;
            }
            
            .profile-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <?php	
            $aid=$_SESSION['id'];
            $udate = date('d-m-Y h:i:s', time());
            $ret="select * from userregistration where id=?";
            $stmt= $mysqli->prepare($ret);
            $stmt->bind_param('i',$aid);
            $stmt->execute();
            $res=$stmt->get_result();
            while($row=$res->fetch_object()) {
            ?>
            <h2><?php echo $row->firstName; ?>'s Profile</h2>
            <p>Manage and update your personal information</p>
            <div class="last-update">
                <i class="fas fa-clock me-2"></i>Last updated: <?php echo $row->updationDate; ?>
            </div>
        </div>
        
        <div class="profile-body">
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i>Profile Information</h5>
                <p class="mb-0">Keep your personal details up to date to ensure proper account management.</p>
            </div>
            
            <form method="post" action="" name="registration" class="form-horizontal">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required-field">Registration No</label>
                            <input type="text" name="regno" class="form-control" value="<?php echo $row->regNo; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required-field">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row->email; ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="section-title"><i class="fas fa-user-circle"></i> Personal Details</div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label required-field">First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $row->firstName; ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="mname" class="form-control" value="<?php echo $row->middleName; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label required-field">Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $row->lastName; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="section-title"><i class="fas fa-phone"></i> Contact Information</div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label class="form-label required-field">Contact Number</label>
                            <input type="text" name="contact" class="form-control" maxlength="10" value="<?php echo $row->contactNo; ?>" required>
                            <div class="form-text">Enter your 11-digit phone number</div>
                        </div>
                    </div>
                </div>
                
                <?php } ?>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" name="update" class="btn btn-update">
                            <i class="fas fa-sync-alt me-2"></i>Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                // Contact number validation
                const contactField = form.querySelector('[name="contact"]');
                if (contactField.value && !/^\d{10}$/.test(contactField.value)) {
                    contactField.classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill all required fields correctly.');
                }
            });
        });
    </script>
</body>
</html>