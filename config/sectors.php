<?php 
// 1. Connection-ka Database-ka
('config/db.php');
 
$conn = mysqli_connect("localhost", "root", "", "berde_db");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sectors | Berde Construction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        
      

        .container { max-width: 1200px; margin: 50px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; }
        
        .card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 30px; text-align: center; }
        .card img { width: 80px; margin-bottom: 20px; }
        
        footer { background: #06402B; color: white; padding: 50px 0; text-align: center; margin-top: 100px; }
    </style>
</head>
<body>
    <nav class="navbar">
    <div class="nav-container">
        <a href="index.php" class="logo">
    <img src="../sawir/logo.jpeg" alt="Berde Logo" style="height: 40px; margin-right: 10px;">
<span>BERDE</span>
     <small class="logo-text-sub">Construction & Engineering</small>
</a>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="sectors.php" class="active">Sectors</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="careers.php">Careers</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

    <header class="hero-sectors">
        <div>
            <h1>MAIN <span>SECTORS</span></h1>
            <p style="font-size: 18px; letter-spacing: 1px;">Expertise Across Diverse Engineering Disciplines</p>
        </div>
    </header>

    

 <div class="section-title">
    <h2>Main Sectors</h2>
    <div class="line"></div>
    <p class="section-subtitle">Providing specialized expertise across diverse sectors to build a more sustainable and modern future.</p>
</div>
 
<div class="universal-grid">
    <?php
    $get_sectors = mysqli_query($conn, "SELECT * FROM sectors WHERE status = 1");
    while($row = mysqli_fetch_assoc($get_sectors)) { ?>
        <div class="content-card">
            <img src="../admin/img/<?php echo $row['image']; ?>" alt="sectors Image">
            <div class="content-body">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>


<footer class="main-footer">
    <div class="footer-container">

        <!-- Company Info -->
        <div class="footer-col">
            <h3>Berde Construction</h3>
            <p>We deliver modern engineering and construction solutions across Somalia with quality and innovation.</p>
        </div>

        <!-- Contact Info -->
        <div class="footer-col">
            <h4>Contact Us</h4>
            <p><i class="fa fa-phone"></i> +252 097430106</p>
            <p><i class="fa fa-envelope"></i> berdeconstruction12@gmail.com</p>
            <p><i class="fa fa-map-marker-alt"></i>Main Office, Bosaso, Somalia</p>
        </div>

        <!-- Social Links -->
        <div class="footer-col">
            <h4>Follow Us</h4>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i> </a><br>
                <a href="https://wa.me/252097430106"><i class="fab fa-whatsapp"></i> </a><br>
                <a href="mailto:berdeconstruction12@gmail.com"><i class="fa fa-envelope"></i> </a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 Berde Construction & Engineering. All Rights Reserved.</p>
    </div>
 
</footer>

</body>
</html>