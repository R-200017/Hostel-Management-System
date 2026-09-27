<?php
$rooms = [
    "single" => [
        "title" => "Single Seater Room",
        "image" => "img/1.jpg",
        "details" => "Enjoy complete privacy with a comfortable single bed, personal study desk, wardrobe, and attached bathroom. Perfect for focused study."
    ],
    "double" => [
        "title" => "Double Seater Room",
        "image" => "img/double-1.jpg",
        "details" => "Spacious room for two students with twin beds, shared study desk, large wardrobe, and attached washroom."
    ],
    "three" => [
        "title" => "Three Seater Room",
        "image" => "img/3.jpg",
        "details" => "Affordable option for three students. Cozy beds, shared furniture, and well-ventilated windows for comfort."
    ],
    "four" => [
        "title" => "Four Seater Room",
        "image" => "img/4.jpg",
        "details" => "Perfect for group living. Shared space with four beds, wardrobes, and good lighting for an affordable stay."
    ],
    "dining" => [
        "title" => "Dining Hall",
        "image" => "img/dining.jpg",
        "details" => "Spacious dining hall offering healthy and hygienic meals three times a day. A perfect place for social interaction."
    ]
];

$roomKey = $_GET['room'] ?? 'single';
$room = $rooms[$roomKey] ?? $rooms['single'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $room['title']; ?> - LuxHostel</title>
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
        min-height: 100vh;
        padding: 0;
    }
    
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    
    .room-header {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }
    
    .room-title {
        color: #1a5f7a;
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 700;
        position: relative;
        display: inline-block;
    }
    
    .room-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #1a5f7a, #2c3e50);
        border-radius: 2px;
    }
    
    .room-content {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .image-container {
        flex: 1;
        min-width: 300px;
        position: relative;
    }
    
    .room-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    
    .image-container:hover .room-image {
        transform: scale(1.03);
    }
    
    .details-container {
        flex: 1;
        padding: 40px;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .room-description {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 30px;
    }
    
    .features-list {
        list-style: none;
        margin-bottom: 30px;
    }
    
    .features-list li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }
    
    .features-list li:last-child {
        border-bottom: none;
    }
    
    .features-list i {
        color: #1a5f7a;
        margin-right: 15px;
        font-size: 1.2rem;
        width: 24px;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(120deg, #1a5f7a 0%, #2c3e50 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 15px rgba(26, 95, 122, 0.3);
    }
    
    .btn-outline {
        background: transparent;
        color: #1a5f7a;
        border: 2px solid #1a5f7a;
    }
    
    .btn-outline:hover {
        background: #1a5f7a;
        color: white;
    }
    
    .btn i {
        margin-right: 8px;
    }
    
    .back-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        opacity: 0;
        pointer-events: all;
        z-index: 100;
    }
    
    .back-btn a {
        text-decoration: none;
        color: transparent;
        background: transparent;
        padding: 12px 22px;
        border-radius: 6px;
        display: inline-block;
    }
    
    .invisible-btn {
        opacity: 0;
        pointer-events: all;
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
    
    .invisible-btn a {
        text-decoration: none;
        color: transparent;
        background: transparent;
        padding: 12px 22px;
        border-radius: 6px;
        display: inline-block;
    }
    
    @media (max-width: 768px) {
        .room-content {
            flex-direction: column;
        }
        
        .image-container {
            min-height: 300px;
        }
        
        .room-title {
            font-size: 2rem;
        }
        
        .details-container {
            padding: 25px;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="room-header">
            <h1 class="room-title"><?php echo $room['title']; ?></h1>
        </div>
        
        <div class="room-content">
            <div class="image-container">
                <img src="<?php echo $room['image']; ?>" alt="<?php echo $room['title']; ?>" class="room-image">
            </div>
            
            <div class="details-container">
                <p class="room-description"><?php echo $room['details']; ?></p>
                
                <ul class="features-list">
                    <?php if ($roomKey != 'dining'): ?>
                    <li><i class="fas fa-bed"></i> Comfortable <?php echo $roomKey == 'single' ? 'single' : ($roomKey == 'double' ? 'twin' : ($roomKey == 'three' ? 'three' : 'four')); ?> bed(s)</li>
                    <li><i class="fas fa-door-open"></i> <?php echo $roomKey == 'single' ? 'Private' : 'Shared'; ?> entrance</li>
                    <li><i class="fas fa-bath"></i> Attached bathroom</li>
                    <li><i class="fas fa-desktop"></i> Study desk<?php echo $roomKey != 'single' ? 's' : ''; ?></li>
                    <li><i class="fas fa-tshirt"></i> Wardrobe<?php echo $roomKey != 'single' ? 's' : ''; ?> space</li>
                    <?php else: ?>
                    <li><i class="fas fa-utensils"></i> Healthy meals</li>
                    <li><i class="fas fa-clock"></i> Open from 7am to 9pm</li>
                    <li><i class="fas fa-users"></i> Social space</li>
                    <li><i class="fas fa-wifi"></i> Free WiFi access</li>
                    
                    <?php endif; ?>
                </ul>
                
                <!-- Invisible Back to Rooms Button -->
                <div class="invisible-btn">
                    <a href="rooms.php"><i class="fas fa-arrow-left"></i> Back to Rooms</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="back-btn">
        <a href="rooms.php">⬅ Back to Rooms</a>
    </div>
</body>
</html>