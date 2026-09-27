<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - My Home Girls Hostel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4eaf1 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        /* Header Styles */
        .header {
            max-width: 1070px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #2D8493;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 28px;
        }
        
        .back-to-home {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: #2D8493;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .back-to-home:hover {
            background: #006a9c;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        
        .back-to-home i {
            margin-right: 8px;
        }
        
        .container {
            max-width: 1070px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .content {
            display: flex;
            flex-wrap: wrap;
        }
        
        .contact-info {
            flex: 1;
            min-width: 300px;
            background: linear-gradient(135deg, #006a9c 0%, #2D8493 100%);
            color: white;
            padding: 40px 30px;
            position: relative;
        }
        
        .contact-info h2 {
            font-size: 26px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 12px;
        }
        
        .contact-info h2:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: white;
        }
        
        .contact-form {
            flex: 2;
            min-width: 400px;
            padding: 40px 30px;
            background: white;
        }
        
        .info-item {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-item h3 {
            font-size: 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .info-item h3 i {
            margin-right: 12px;
            font-size: 22px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .info-item p {
            font-size: 16px;
            opacity: 0.9;
            padding-left: 52px;
        }
        
        .info-item a {
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            position: relative;
        }
        
        .info-item a:hover {
            color: #a6e4ff;
            transform: translateY(-2px);
        }
        
        .info-item a.email-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #a6e4ff;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s;
        }
        
        .info-item a.email-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        
        .form-title {
            font-size: 26px;
            margin-bottom: 30px;
            color: #2c3e50;
            position: relative;
            padding-bottom: 12px;
        }
        
        .form-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: #2D8493;
        }
        
        .form-group {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .form-group:last-child {
            border-bottom: none;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 18px;
        }
        
        input, textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #2D8493;
            box-shadow: 0 0 0 3px rgba(45, 132, 147, 0.1);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        button {
            background: #2D8493;
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }
        
        button:hover {
            background: #006a9c;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
        }
        
        .notification.show {
            opacity: 1;
        }
        
        .email-instruction {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
        
        .copy-notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background: #333;
            color: white;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
        }
        
        .copy-notification.show {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            
            .contact-info, .contact-form {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header with navigation -->
    <div class="header">
        <div class="logo">
            <i class="fas fa-home"></i>
            <span>My Home Girls Hostel</span>
        </div>
        <a href="landing.php" class="back-to-home">
            <i class="fas fa-arrow-left"></i>
            Back to Home
        </a>
    </div>

    <!-- Contact content -->
    <div class="container">
        <div class="content">
            <div class="contact-info">
                <h2>Contact Info</h2>
                
                <div class="info-item">
                    <h3><i class="fas fa-map-marker-alt"></i> Address</h3>
                    <p>Garjantali, Rangamati<br>Bangladesh</p>
                </div>
                
                <div class="info-item">
                    <h3><i class="fas fa-envelope"></i> Email</h3>
                    <p>
                        <a href="mailto:myhomegirlshostelrangamati@gmail.com" class="email-link" id="email-link">
                            myhomegirlshostelrangamati@gmail.com
                        </a>
                        <br>
                        <small style="padding-left: 52px; opacity: 0.8; display: block; margin-top: 5px;">
                            
                        </small>
                    </p>
                </div>
                
                <div class="info-item">
                    <h3><i class="fas fa-phone"></i> Phone</h3>
                    <p>
                        <a href="tel:+8801778643448" id="phone-link">
                            +8801778643448
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="contact-form">
                
                
                
                    
                    
                    <div class="form-group">
                        <label for="message">Write your message here...</label>
                        <textarea id="message" placeholder="Type your message here" required></textarea>
                    </div>
                    
                    <button type="submit">Send Message</button>
                </form>
                
                <p class="email-instruction"></p>
            </div>
        </div>
    </div>

    <div class="notification" id="notification">Message sent successfully!</div>
    <div class="copy-notification" id="copy-notification">Email address copied to clipboard!</div>

    <script>
        // Form submission handling
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            // In a real application, you would send this data to a server
            // For demonstration, we'll just show a success message
            
            // Show notification
            const notification = document.getElementById('notification');
            notification.textContent = 'Thank you for your message, ' + name + '! We will get back to you soon.';
            notification.classList.add('show');
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
            
            // Reset form
            this.reset();
        });
        
        // Enhanced email link functionality
        const emailLink = document.getElementById('email-link');
        
        emailLink.addEventListener('click', function(e) {
            // The mailto: link will naturally open the email client
            // We'll add a small visual feedback
            this.style.transform = 'scale(1.05)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
        
        // Optional: Add right-click to copy email functionality
        emailLink.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            const email = this.textContent;
            
            // Copy to clipboard
            navigator.clipboard.writeText(email).then(() => {
                const copyNotification = document.getElementById('copy-notification');
                copyNotification.textContent = 'Email address copied to clipboard!';
                copyNotification.classList.add('show');
                
                setTimeout(() => {
                    copyNotification.classList.remove('show');
                }, 2000);
            });
        });
    </script>
</body>
</html>