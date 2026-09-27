<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hostel Management System</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; line-height: 1.6; }

    /* Navbar */
    nav {
        background:linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
        color: white;
        display: flex;
        justify-content: flex-end;
        padding: 15px;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    nav a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
        font-weight: bold;
        cursor:pointer;
    }
    nav a:hover { color: #f39c12; }

    /* Hero */
    .hero {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }
    .slides {
        display: flex;
        width: 200%;
        height: 100%;
        animation: slide 10s infinite;
    }
    .slides img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    @keyframes slide {
        0%,45%  { transform: translateX(0%); }
        50%,95% { transform: translateX(-50%); }
        100% { transform: translateX(0%); }
    }
    .hero-text {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        background: rgba(13, 2, 27, 0.25);
        padding: 20px 40px;
        border-radius: 10px;
        font-style:italic;
        font-size: 2.5em;
        text-align: center;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        font-weight: 800;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    }

    /* Features */
    .features {
        display: flex;
        justify-content: space-around;
        padding: 40px 20px;
        background: #f9f9f9;
    }
    .feature {
        flex: 1;
        margin: 0 15px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .feature:hover {
        transform: translateY(-5px);
    }
    .feature img { 
        width: 100%; 
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .feature:hover img {
        transform: scale(1.03);
    }

    /* Testimonial */
    .testimonial {
        background:linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
        color: white;
        padding: 50px 20px;
        text-align: center;
        font-style: italic;
    }

    /* Gallery - UPDATED FOR HORIZONTAL SCROLL */
    .gallery {
        padding: 40px 20px;
        text-align: center;
        background: #f9f9f9;
    }
    .gallery h2 { 
        margin-bottom: 30px; 
        font-size: 2rem;
        color: #1a5f7a;
    }
    .gallery-container {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding: 15px 10px;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
    .gallery-container::-webkit-scrollbar {
        height: 8px;
    }
    .gallery-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .gallery-container::-webkit-scrollbar-thumb {
        background: #1a5f7a;
        border-radius: 10px;
    }
    .gallery-container::-webkit-scrollbar-thumb:hover {
        background: #159895;
    }
    .gallery-item {
        flex: 0 0 auto;
        width: 300px;
        height: 250px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover {
        transform: scale(1.03);
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }

    /* Dropdown styling */
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #444;
        min-width: 160px;
        border-radius: 5px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        z-index: 200;
    }
    .dropdown-content a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: #f39c12;
        color: white;
    }
    .show { display: block; }

    /* Footer */
    footer {
        background: linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
        color: white;
        text-align: center;
        padding: 20px;
    }
    footer a { color: #f39c12; text-decoration: none; }

    /* Responsive */
    @media (max-width: 768px) {
        .features {
            flex-direction: column;
        }
        .feature {
            margin: 15px 0;
        }
        .gallery-item {
            width: 250px;
            height: 200px;
        }
    }
</style>
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="landing.php">Home</a>
    <a href="About.php">About Us</a>
    <a href="Contact.php">Contact Us</a>
    <div class="dropdown">
        <a href="#" class="dropbtn">Login</a>
        <div class="dropdown-content">
            <a href="login.php">User Login</a>
            <a href="adminlogin.php">Admin Login</a>
            <a href="user-registration.php">Registration</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<div class="hero">
    <div class="slides">
        <img src="img/home.jpg" alt="Slide 1">
        <img src="img/hostel-6.jpg" alt="Slide 2">
    </div>
    <div class="hero-text">
        Comfortable, Clean & Affordable Rooms for Students
    </div>
</div>

<!-- Features -->
<section class="features">
    <div class="feature" onclick="window.location.href='comfort.php'">
        <img src="img/com.jpg" alt="Comfort">
        <h3>Comfort Zone</h3>
        <p>A place where you found peace and comfort.</p>
    </div>

    <!-- Link to rooms.html -->
    <div class="feature" onclick="window.location.href='rooms.php'">
        <img src="img/best-room.jpg" alt="Rooms">
        <h3>Room Features</h3>
        <p>Modern,organized,spacious,and affordable rooms.</p>
    </div>

    <div class="feature" onclick="openMap()">
        <img src="img/loc1.png" alt="Location">
        <h3>Location</h3>
        <p>Located close to universities and transport links.<br>Garjantali, Rangamati, Bangladesh</p>
    </div>
</section>

<!-- Testimonial -->
<section class="testimonial">
    "Staying here was the best decision! Clean rooms, friendly staff, and great location."
    <br>– A Happy Guest
</section>

<!-- Gallery - UPDATED -->
<section class="gallery">
    <h2>Gallery</h2>
    <div class="gallery-container">
        <div class="gallery-item">
            <img src="img/hostel-5.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/hos1.jpg" alt="Hostel Common Area">
        </div>
        <div class="gallery-item">
            <img src="img/room1.jpg" alt="Hostel Room">
        </div>

        <div class="gallery-item">
            <img src="img/room2.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/best-room.jpg" alt="Hostel Building">
        </div>

        <div class="gallery-item">
            <img src="img/1.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/2set.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/room3.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/dining.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/com.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/rooftop.jpg" alt="Hostel Room">
        </div>
        <div class="gallery-item">
            <img src="img/hos3.jpg" alt="Hostel Exterior">
        </div>
        <div class="gallery-item">
            <img src="img/hos4.jpg" alt="Hostel Facilities">
        </div>
        <div class="gallery-item">
            <img src="img/hos5.jpg" alt="Hostel Interior">
        </div>
        
    </div>
</section>

<!-- Footer -->
<footer>
    <p>&copy; My Home Girl's Hostel. All Rights Reserved.</p>
    <p><a href="#">Privacy Policy</a> | <a href="#">Terms</a></p>
</footer>

<script>
function openMap() {
    window.open('https://maps.app.goo.gl/aTuN8fygo4A2PwGN8', '_blank');
}

// Dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropbtn = document.querySelector('.dropbtn');
    const dropdownContent = dropbtn.nextElementSibling;

    dropbtn.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', function(event) {
        if (!event.target.matches('.dropbtn')) {
            if (dropdownContent.classList.contains('show')) dropdownContent.classList.remove('show');
        }
    });
});
</script>
</body>
</html>