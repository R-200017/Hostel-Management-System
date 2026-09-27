<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxHostel - Premium Student Accommodation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(120deg, #1a5f7a 0%, #2c3e50 100%);
            color: white;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative; /* For positioning the invisible button */
        }
        
        h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .room-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }
        
        .room-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .room-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .room-card:hover .room-image {
            transform: scale(1.05);
        }
        
        .room-content {
            padding: 20px;
        }
        
        .room-title {
            font-size: 1.4rem;
            color: #1a5f7a;
            margin-bottom: 12px;
            font-weight: 600;
        }
        
        .room-desc {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .room-features {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .feature {
            display: flex;
            align-items: center;
            color: #1a5f7a;
            font-size: 0.9rem;
        }
        
        .feature i {
            margin-right: 5px;
        }
        
        .price-tag {
            background: linear-gradient(120deg, #1a5f7a 0%, #2c3e50 100%);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .view-btn {
            display: block;
            text-align: center;
            background: #1a5f7a;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: background 0.3s;
        }
        
        .view-btn:hover {
            background: #144a5e;
        }
        
        .image-container {
            position: relative;
            overflow: hidden;
        }
        
        .room-type {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #1a5f7a;
        }
        
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            color: #777;
            font-size: 0.9rem;
        }
        
        /* Invisible home button */
        .invisible-home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            opacity: 0;
            pointer-events: all;
            z-index: 100;
        }
        
        .invisible-home-btn a {
            text-decoration: none;
            color: transparent;
            background: transparent;
            padding: 12px 22px;
            border-radius: 6px;
            display: inline-block;
        }
        
        @media (max-width: 768px) {
            .room-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }
            
            h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <!-- Invisible Home Button -->
            <div class="invisible-home-btn">
                <a href="landing.php">🏠 Home</a>
            </div>
            
            <h1>Premium Student Accommodation</h1>
            <p class="subtitle">Experience comfort, community, and convenience in our modern hostel rooms designed for student life.</p>
        </header>
        
        <div class="room-container">
            <a href="show-room.php?room=single" class="room-card-link">
                <div class="room-card">
                    <div class="image-container">
                        <img src="img/1.jpg" alt="Single Room" class="room-image">
                    </div>
                    <div class="room-content">
                        <h3 class="room-title">Single Seater Room</h3>
                        <p class="room-desc">Enjoy complete privacy with a comfortable single bed, personal study desk, wardrobe, and attached bathroom.</p>
                        <div class="room-features">
                            <div class="feature">
                                <i class="fas fa-user"></i> 1 Person
                            </div>
                            <div class="feature">
                                <i class="fas fa-bath"></i> Attached
                            </div>
                            
                        </div>
                        <div class="view-btn">View Details</div>
                    </div>
                </div>
            </a>
            
            <a href="show-room.php?room=double" class="room-card-link">
                <div class="room-card">
                    <div class="image-container">
                        <img src="img/double-1.jpg" alt="Double Room" class="room-image">
                    </div>
                    <div class="room-content">
                        <h3 class="room-title">Double Seater Room</h3>
                        <p class="room-desc">Spacious room for two students with twin beds, shared study desk, large wardrobe, and attached washroom.</p>
                        <div class="room-features">
                            <div class="feature">
                                <i class="fas fa-users"></i> 2 People
                            </div>
                            <div class="feature">
                                <i class="fas fa-bath"></i> Attached
                            </div>
                        
                        </div>
                        <div class="view-btn">View Details</div>
                    </div>
                </div>
            </a>
            
            <a href="show-room.php?room=three" class="room-card-link">
                <div class="room-card">
                    <div class="image-container">
                        <img src="img/3.jpg" alt="Triple Room" class="room-image">
                    </div>
                    <div class="room-content">
                        <h3 class="room-title">Three Seater Room</h3>
                        <p class="room-desc">Affordable option for three students. Cozy beds, shared furniture, and well-ventilated windows for comfort.</p>
                        <div class="room-features">
                            <div class="feature">
                                <i class="fas fa-users"></i> 3 People
                            </div>
                            <div class="feature">
                                <i class="fas fa-bath"></i> Attached
                            </div>
                        
                        </div>
                        <div class="view-btn">View Details</div>
                    </div>
                </div>
            </a>
            
            <a href="show-room.php?room=four" class="room-card-link">
                <div class="room-card">
                    <div class="image-container">
                        <img src="img/4.jpg" alt="Quad Room" class="room-image">
                    </div>
                    <div class="room-content">
                        <h3 class="room-title">Four Seater Room</h3>
                        <p class="room-desc">Perfect for group living. Shared space with four beds, wardrobes, and good lighting for an affordable stay.</p>
                        <div class="room-features">
                            <div class="feature">
                                <i class="fas fa-users"></i> 4 People
                            </div>
                            <div class="feature">
                                <i class="fas fa-bath"></i> Attached
                            </div>
                            
                        </div>
                        <div class="view-btn">View Details</div>
                    </div>
                </div>
            </a>
            
            <a href="show-room.php?room=dining" class="room-card-link">
                <div class="room-card">
                    <div class="image-container">
                        <img src="img/dining.jpg" alt="Dining Hall" class="room-image">
                    </div>
                    <div class="room-content">
                        <h3 class="room-title">Dining Hall</h3>
                        <p class="room-desc">Spacious dining hall offering healthy and hygienic meals three times a day. A perfect place for social interaction.</p>
                        <div class="room-features">
                            <div class="feature">
                                <i class="fas fa-utensils"></i> Buffet Style
                            </div>
                            <div class="feature">
                                <i class="fas fa-clock"></i> 7am-9pm
                            </div>
                            <div class="price-tag">Included</div>
                        </div>
                        <div class="view-btn">View Details</div>
                    </div>
                </div>
            </a>
        </div>
        
        <footer>
            <p>© MY Home Girl's Hostel | Premium Student Accommodation</p>
            <p>Contact: myhomegirlsgmail.com | Phone: +8801750-16519</p>
        </footer>
    </div>
</body>
</html>