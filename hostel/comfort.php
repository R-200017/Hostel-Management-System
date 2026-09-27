<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comfort Zone - Hostel Facilities</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6;
            background-color: #f5f5f5;
        }
        
        /* Header */
        header {
            background: linear-gradient(135deg, #1a5f7a 0%, #159895 100%);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: relative;
        }
        
        .back-btn {
            position: absolute;
            left: 20px;
            top: 20px;
            color: transparent; /* Made text transparent */
            text-decoration: none;
            font-weight: bold;
            background: transparent; /* Changed to transparent */
            padding: 8px 15px;
            border-radius: 5px;
            transition: none; /* Remove transition */
            width: 120px; /* Fixed width for consistent invisible button area */
            height: 40px; /* Fixed height */
            border: none; /* Remove any border */
            cursor: pointer; /* Keep cursor as pointer to indicate it's clickable */
        }
        
        .back-btn:hover {
            background: transparent; /* Keep transparent on hover */
        }
        
        /* Gallery Section */
        .gallery-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .gallery-title {
            text-align: center;
            margin-bottom: 30px;
            color: #1a5f7a;
            font-size: 2.2em;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .image-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            animation: zoom 0.6s;
        }
        
        @keyframes zoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
        }
        
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .close:hover {
            color: #f39c12;
        }
        
        .caption-text {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 50px;
        }
    </style>
</head>
<body>
    <header>
        <a href="landing.php" class="back-btn" title="Back to Home">← Back to Home</a>
        <h1>Comfort Zone Facilities</h1>
        <p>Explore our relaxing spaces designed for your comfort</p>
    </header>
    
    <div class="gallery-container">
        <h2 class="gallery-title">Our Comfort Areas</h2>
        
        <div class="gallery-grid">

         <div class="gallery-item" onclick="openModal('img/reading.jpg', 'Reading Corner')">
                <img src="img/reading.jpg" alt="Reading Area">
                <div class="image-caption">Reading Corner</div>
            </div>

             <div class="gallery-item" onclick="openModal('img/rooftop.jpg', 'Scenic Rooftop')">
                <img src="img/rooftop.jpg" alt="Hostel Rooftop">
                <div class="image-caption">Scenic Rooftop</div>
            </div>

            <div class="gallery-item" onclick="openModal('img/balcony.jpg', 'Spacious Balcony')">
                <img src="img/balcony.jpg" alt="Hostel Balcony">
                <div class="image-caption">Spacious Balcony</div>
            </div>
            
            <!-- New Windows View Item (replaced exterior) -->
            <div class="gallery-item" onclick="openModal('img/outside.jpg', 'Beautiful Window Views')">
                <img src="img/outside.jpg" alt="Window Views">
                <div class="image-caption">Beautiful Window Views</div>
            </div>
            
            <div class="gallery-item" onclick="openModal('img/garden.jpg', 'Relaxation Garden')">
                <img src="img/garden.jpg" alt="Garden Area">
                <div class="image-caption">Relaxation Garden</div>
            </div>
            
            <div class="gallery-item" onclick="openModal('img/common.jpg', 'Common Lounge')">
                <img src="img/common.jpg" alt="Common Lounge">
                <div class="image-caption">Common Lounge</div>
            </div>
            
        </div>
    </div>
    
    <!-- Modal for image preview -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption" class="caption-text"></div>
    </div>
    
    <script>
        function openModal(src, caption) {
            document.getElementById("imageModal").style.display = "block";
            document.getElementById("modalImage").src = src;
            document.getElementById("caption").innerHTML = caption;
        }
        
        function closeModal() {
            document.getElementById("imageModal").style.display = "none";
        }
        
        // Close modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });
    </script>
</body>
</html>