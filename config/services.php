<?php 
// 1. Isku xirka Database-ka (Hubi in magaca database-kaagu yahay berde_db)
$conn = mysqli_connect("localhost", "root", "", "berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Berde Construction & Engineering</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="style.css">
    <style>
        :root { --primary-green: #f1f9f6; --accent-green: #28a745; --light-bg: #f9f9f9; }
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: var(--light-bg); color: #333; }
        
        .hero-services { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../sawir/services.jpg'); 
            background-size: cover; background-position: center;
            height: 350px; display: flex; align-items: center; justify-content: center; 
            text-align: center; color: white;
        }   
        .hero-services h1 { font-size: 55px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 3px; }
        .hero-services h1 span { color: var(--accent-green); }

        .services-container { max-width: 1250px; margin: -60px auto 80px; padding: 0 20px; position: relative; z-index: 10; }
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 30px; }
        
        .service-card {
            background: #fff; border-radius: 15px; overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); transition: 0.4s ease;
            display: flex; flex-direction: column; height: 100%;
        }
        .service-card:hover { transform: translateY(-10px); }
        .card-img { height: 250px; width: 100%; object-fit: cover; border-bottom: 5px solid var(--accent-green); }
        .card-body { padding: 30px; text-align: left; flex-grow: 1; }
        .card-body i { font-size: 35px; color: var(--accent-green); margin-bottom: 15px; display: block; }
        .card-body h3 { font-size: 22px; color: var(--primary-green); margin-bottom: 15px; font-weight: 800; text-transform: uppercase; }
        .card-body p { font-size: 14.5px; line-height: 1.8; color: #555; margin-bottom: 20px; text-align: justify; }
        
        footer { background: #02230c; color: #ccc; padding: 80px 0 30px; margin-top: 50px; }
        .footer-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; padding: 0 20px; }
        .footer-col h4 { color: #fff; font-size: 20px; margin-bottom: 25px; border-left: 4px solid var(--accent-green); padding-left: 15px; text-transform: uppercase; }
        .footer-col ul { list-style: none; padding: 0; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul li a { color: #ccc; text-decoration: none; transition: 0.3s; }
        .footer-col ul li a:hover { color: var(--accent-green); padding-left: 5px; }
        .footer-bottom { text-align: center; padding-top: 50px; border-top: 1px solid #222; margin-top: 50px; font-size: 14px; }
    </style>
</head>
<body>


<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <a href="index.php">
                <img src="../sawir/logo.jpeg" alt="Berde Logo" class="logo-img">
                <span class="logo-text">BERDE</span>
                <small class="logo-text-sub">Construction & Engineering</small>
            </a>
        </div>

        <nav class="navbar">
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="services.php" class="nav-link active">Services</a></li>
                <li><a href="projects.php" class="nav-link">Projects</a></li>
                <li><a href="sectors.php" class="nav-link">Sectors</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li><a href="careers.php" class="nav-link">Careers</a></li>
                <li><a href="contact.php" class="nav-contact-btn">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="hero-services">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>OUR <span>SERVICES</span></h1>
            <div class="hero-line"></div>
            <p>Engineering Excellence & Strategic Construction</p>
        </div>
    </div>
</section>
<div class="section-title">
    <h2>Our Services</h2>
    <div class="line"></div>
    <p class="section-subtitle">Delivering excellence in every build through comprehensive construction solutions tailored to your needs.</p>
</div>
    <div class="universal-grid">
    <?php
    $get_services = mysqli_query($conn, "SELECT * FROM services WHERE status = 1");
    while($row = mysqli_fetch_assoc($get_services)) { ?>
        <div class="content-card">
            <img src="../admin/img/<?php echo $row['image']; ?>" alt="Services Image">
            <div class="content-body">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h4>BERDE</h4>
                <p>A premier engineering firm specializing in modern infrastructure, luxury residential, and industrial masterpieces.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Navigation</h4>
                <ul>
                    <li><a href="index.php">Home </a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Details</h4>
                <p><i class="fa fa-map-marker-alt" style="color: var(--accent-green); margin-right: 10px;"></i> bosaso, Somalia</p>
                <p><i class="fa fa-phone" style="color: var(--accent-green); margin-right: 10px;"></i>+252 097430106 </p>
                <a href="#"><i class="BERDE"></i> </a><br>
                <a href="https://wa.me/252097430106"><i class="fab fa-whatsapp"></i> </a><br>
                <a href="mailto:berdeconstruction12@gmail.com"><i class="fa fa-envelope"></i> </a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 Berde Construction & Engineering. Built with Precision.
        </div>
    </footer>

</body>
</html>