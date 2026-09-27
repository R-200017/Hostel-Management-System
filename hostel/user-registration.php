<?php
session_start();
include('includes/config.php');

// Database connection check
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Get and sanitize form data
    $regno = trim($_POST['regno']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $department = trim($_POST['department']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    // Validate required fields
    if (empty($regno) || empty($fname) || empty($lname) || empty($department) || 
        empty($contact) || empty($email) || empty($password)) {
        $error = "All required fields must be filled!";
    }
    // Validate passwords match
    elseif ($password !== $cpassword) {
        $error = "Passwords do not match!";
    }
    // Validate password strength
    elseif (strlen($password) < 4) {
        $error = "Password must be at least 4 characters long!";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    }
    else {
        // Check if email already exists
        $check_email = $mysqli->prepare("SELECT id FROM userregistration WHERE email = ?");
        $check_email->bind_param('s', $email);
        $check_email->execute();
        $check_email->store_result();
        
        if ($check_email->num_rows > 0) {
            $error = "Email already exists!";
            $check_email->close();
        } else {
            $check_email->close();
            
            // Check if registration number already exists
            $check_regno = $mysqli->prepare("SELECT id FROM userregistration WHERE regno = ?");
            $check_regno->bind_param('s', $regno);
            $check_regno->execute();
            $check_regno->store_result();
            
            if ($check_regno->num_rows > 0) {
                $error = "Registration number already exists!";
                $check_regno->close();
            } else {
                $check_regno->close();
                
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $mysqli->prepare("INSERT INTO userregistration (regno, firstname, middlename, lastname, department,contactNo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssssss', $regno, $fname, $mname, $lname,$department, $contact, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    $success = "Registration successful! You can now login.";
                    // Clear form fields
                    $_POST = array();
                     header("refresh:3;url=landing.php");
                     exit();

                } else {
                    $error = "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}
?>
       
  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #CBC3E3;;
            --accent-color: #2575fc;
        }
        
        body {
            background:white;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .registration-container {
            background: #fffef1;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }
        
        .registration-header {
            background: #6a11cb;
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .registration-header h2 {
            margin: 0;
            font-weight: 600;
        }
        
        .registration-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .registration-body {
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
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.15);
        }
        
        .btn-register {
            background: #6a11cb;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
            color: white;
        }
        
        .btn-register:hover {
            background:white;
            color: #6a11cb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        
        .btn-reset {
            background:  #6a11cb;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
            color: white;
        }
        
        .btn-reset:hover {
            background: white;
            color: #6a11cb;
            transform: translateY(-2px);
        }
        
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .status-message {
            font-size: 0.85rem;
            padding: 5px;
            border-radius: 4px;
            margin-top: 5px;
        }
        
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 5px;
            background: #eee;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .registration-container {
                margin: 20px;
            }
            
            .registration-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-header">
            <h2><i class="fas fa-user-graduate"></i> Student Registration</h2>
            <p>Complete the form below to register as a student</p>
        </div>
        
        <div class="registration-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-box" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-box" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form id="registrationForm" method="POST" action="">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h4 class="section-title"><i class="fas fa-user"></i> Personal Information</h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="regno" class="form-label required-field">Registration Number</label>
                            <input type="text" class="form-control" id="regno" name="regno" value="<?php echo isset($_POST['regno']) ? htmlspecialchars($_POST['regno']) : ''; ?>" required>
                            <div class="status-message" id="regno-status"></div>
                        </div>
                        
                       
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fname" class="form-label required-field">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname" value="<?php echo isset($_POST['mname']) ? htmlspecialchars($_POST['mname']) : ''; ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="lname" class="form-label required-field">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>" required>
                        </div>
                    </div>
                </div>

                 <div class="col-md-6 mb-3">
                            <label for="department" class="form-label required-field">Department</label>
                            <select class="form-select" id="department" name="department" required>
                                <option value="">Select Department</option>
                                <option value="Computer Science" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                                <option value="Electrical Engineering" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Electrical Engineering') ? 'selected' : ''; ?>>Electrical Engineering</option>
                                <option value="Mechanical Engineering" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Mechanical Engineering') ? 'selected' : ''; ?>>Mechanical Engineering</option>
                                <option value="Civil Engineering" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Civil Engineering') ? 'selected' : ''; ?>>Civil Engineering</option>
                                <option value="Business Administration" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Business Administration') ? 'selected' : ''; ?>>Business Administration</option>
                                <option value="Mathematics" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                                <option value="Physics" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Physics') ? 'selected' : ''; ?>>Physics</option>
                                <option value="Chemistry" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Chemistry') ? 'selected' : ''; ?>>Chemistry</option>
                            </select>
                        </div>
                
                <!-- Contact Information Section -->
                <div class="form-section">
                    <h4 class="section-title"><i class="fas fa-address-book"></i> Contact Information</h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label required-field">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-field">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            <div class="status-message" id="email-status"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Security Section -->
                <div class="form-section">
                    <h4 class="section-title"><i class="fas fa-lock"></i> Security</h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required-field">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="passwordStrengthBar"></div>
                            </div>
                            <div class="form-text">Use at least 4 characters with a mix of letters, numbers & symbols</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="cpassword" class="form-label required-field">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                            <div class="status-message" id="password-match-status"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <button type="reset" class="btn btn-reset"><i class="fas fa-redo-alt"></i> Reset Form</button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button type="submit" name="register" class="btn btn-register"><i class="fas fa-user-plus"></i> Register Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('cpassword');
            const passwordMatchStatus = document.getElementById('password-match-status');
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            
            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;
                
                passwordStrengthBar.style.width = strength + '%';
                
                if (strength < 50) {
                    passwordStrengthBar.style.backgroundColor = '#dc3545';
                } else if (strength < 75) {
                    passwordStrengthBar.style.backgroundColor = '#fd7e14';
                } else {
                    passwordStrengthBar.style.backgroundColor = '#198754';
                }
            });
            
            // Confirm password validation
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    passwordMatchStatus.textContent = 'Passwords do not match!';
                    passwordMatchStatus.style.color = '#dc3545';
                } else {
                    passwordMatchStatus.textContent = 'Passwords match!';
                    passwordMatchStatus.style.color = '#198754';
                }
            });
            
            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Check if all required fields are filled
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                // Check password match
                if (passwordInput.value !== confirmPasswordInput.value) {
                    isValid = false;
                    passwordMatchStatus.textContent = 'Passwords do not match!';
                    passwordMatchStatus.style.color = '#dc3545';
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