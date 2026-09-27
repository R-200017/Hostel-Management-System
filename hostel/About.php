<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | My Home Girl's Hostel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .logo span {
            color: #ffdd40;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #ffdd40;
        }
        
        .hero {
            text-align: center;
            padding: 80px 0;
            background: linear-gradient(rgba(26, 95, 122, 0.8), rgba(21, 152, 149, 0.8)), url('https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1800&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            margin-bottom: 40px;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .about-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .about-text {
            flex: 1;
            min-width: 300px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .about-text h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #1a5f7a;
            position: relative;
            padding-bottom: 10px;
        }
        
        .about-text h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
            border-radius: 2px;
        }
        
        .about-text p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #555;
        }
        
        .about-image {
            flex: 1;
            min-width: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .about-image:hover img {
            transform: scale(1.03);
        }
        
        .services-section {
            margin-bottom: 60px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-title h2 {
            font-size: 36px;
            color: #1a5f7a;
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
        
        .service-img {
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f8ff;
        }
        
        .service-img i {
            font-size: 70px;
            color: #1a5f7a;
        }
        
        .service-info {
            padding: 25px;
            text-align: center;
        }
        
        .service-info h3 {
            margin-bottom: 15px;
            color: #1a5f7a;
            font-size: 24px;
        }
        
        .service-info p {
            color: #555;
            margin-bottom: 20px;
        }
        
        .divider {
            height: 1px;
            background: #eee;
            margin: 20px 0;
        }
        
        .read-more {
            display: inline-block;
            padding: 10px 20px;
            background: #1a5f7a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .read-more:hover {
            background: #159895;
            transform: translateY(-3px);
        }
        
        .values-section {
            margin-bottom: 60px;
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .value-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .value-card:hover {
            transform: translateY(-5px);
        }
        
        .value-icon {
            font-size: 40px;
            margin-bottom: 20px;
            color: #1a5f7a;
        }
        
        .value-card h3 {
            margin-bottom: 15px;
            color: #1a5f7a;
        }
        
        .value-card p {
            color: #555;
        }
        
        .testimonials-section {
            background: white;
            padding: 60px 0;
            margin-bottom: 60px;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial p {
            font-style: italic;
            margin-bottom: 20px;
            color: #555;
        }
        
        .testimonial .student {
            display: flex;
            align-items: center;
        }
        
        .testimonial .student img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .testimonial .student-info h4 {
            color: #1a5f7a;
            margin-bottom: 5px;
        }
        
        .testimonial .student-info p {
            color: #7f8c8d;
            margin: 0;
            font-style: normal;
            font-size: 14px;
        }
        
        footer {
            background: #1a5f7a;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-column h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: #57c5b6;
        }
        
        .footer-column p {
            margin-bottom: 20px;
            color: #ecf0f1;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #57c5b6;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #ecf0f1;
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .about-text, .about-image {
                flex: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">MyHomeGirl's<span>Hostel</span></div>
                <ul class="nav-links">
                    <li><a href="landing.php">Home</a></li>
                    <li><a href="About.php">About</a></li>
                    <li><a href="Contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>About My Home Girl's Hostel</h1>
            <p>providing comfortable and secure student accommodation since 2021</p>
        </div>
    </section>

    <section class="about-content">
        <div class="container">
            <div class="about-text">
                <h2>Our Story</h2>
                <p>Founded in 2021,My Home Girl's Hostel  was created with a simple mission: to provide safe, affordable, and comfortable accommodation for students pursuing their education away from home. What started as a single building with 20 rooms has now grown to a network of hostels accommodating over 35 students.</p>
                <p>Our journey began when our founder, a former student himself, experienced the challenges of finding quality accommodation. He envisioned a place that would not just provide a room, but a community where students could thrive academically and socially.</p>
                <p>Today, we continue to uphold our founding principles while constantly improving our facilities and services to meet the evolving needs of modern students.</p>
            </div>
            <div class="about-image">
                 <img src="img/hostel-5.jpg" alt="Our Hostel">
            </div>
        </div>
    </section>

    <section class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Services</h2>
                <p>We provide everything you need for a comfortable and productive stay</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <div class="service-info">
                        <h3>High-Speed WiFi</h3>
                        <p>Stay connected with our high-speed internet access available throughout the hostel. Perfect for studying, research, and staying in touch with family.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="service-info">
                        <h3>CCTV Security</h3>
                        <p>Your safety is our priority. Our premises are monitored 24/7 with state-of-the-art CCTV systems and security personnel.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="service-info">
                        <h3>IPS Power Backup</h3>
                        <p>Never worry about power outages. Our uninterrupted power supply ensures you can study comfortably at any time.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-broom"></i>
                    </div>
                    <div class="service-info">
                        <h3>Daily Housekeeping</h3>
                        <p>Enjoy a clean and hygienic environment with our daily cleaning services. We maintain high standards of cleanliness throughout.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="service-info">
                        <h3>Meal System</h3>
                        <p>Nutritious and delicious meals prepared daily by our experienced chefs. We accommodate special dietary requirements too.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="service-info">
                        <h3>Secure Access</h3>
                        <p>Rest easy with our biometric access systems and 24/7 security personnel ensuring only authorized entry to the premises.</p>
                        <div class="divider"></div>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Values</h2>
                <p>The principles that guide everything we do</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Safety First</h3>
                    <p>We prioritize the safety and security of our students above all else, with comprehensive measures to ensure a protected environment.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Home Environment</h3>
                    <p>We strive to create a warm, welcoming atmosphere that feels like a home away from home for all our residents.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>Student Support</h3>
                    <p>We're committed to supporting our students not just with accommodation, but with their overall well-being and academic success.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>What Our Students Say</h2>
                <p>Hear from students who have experienced our hostel services</p>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial">
                    <p>"The WiFi here is fantastic! I can stream lectures and study without any interruptions. The housekeeping staff keeps everything spotless too!"</p>
                    <div class="student">
                        <img src="" alt="Student">
                        <div class="student-info">
                            <h4>Purna  Paul</h4>
                            <p>Engineering Student</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"I feel completely safe here with 24/7 CCTV monitoring and security personnel. The meal system provides nutritious food that reminds me of home."</p>
                    <div class="student">
                        <img src="" alt="Student">
                        <div class="student-info">
                            <h4>Aspriya Akter Mukti</h4>
                            <p>Medical Student</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"The IPS power backup is a lifesaver during exam season. Even during power outages, I can continue studying without any disruption."</p>
                    <div class="student">
                        <img src="" alt="Student">
                        <div class="student-info">
                            <h4>Mohini</h4>
                            <p>Business Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About My Home Girl's Hostel</h3>
                    <p>Providing safe, comfortable and affordable accommodation for students since 2010. Our mission is to create a home away from home.</p>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="landing.php">Home</a></li>
                        <li><a href="About.php">About Us</a></li>
                         <li><a href="Contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Garjantali,Rangamati,Bangladesh</li>
                        <li><i class="fas fa-phone"></i> +8801750-165199</li>
                        <li><i class="fas fa-envelope"></i> myhomegirlshostelrangamati@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy;  My Home Girl's Hostel. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>