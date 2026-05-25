<?php
 $conn = mysqli_connect("localhost", "root", "", "berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Careers | Berde Construction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="header.css">

</head>
<body>
  
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php" class="logo">
            <img src="../sawir/logo.jpeg" alt="Logo" onerror="this.style.display='none'"> 
            <span>BERDE</span>
        <small class="logo-text-sub">Construction & Engineering</small>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="sectors.php">Sectors</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="careers.php" style="color: var(--accent-yellow);">Careers</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

<header class="hero-careers">
    <div>
        <h1>Join Our <span>Team</span></h1>
        <p>Build your future with Berde Construction</p>
    </div>
</header>

<div class="container py-5">
    <div class="row g-4">
        <?php 
        $get_jobs = mysqli_query($conn, "SELECT * FROM careers WHERE status = 1 ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($get_jobs)) { ?>
        <div class="col-lg-4 col-md-6">
            <div class="job-card">
                <img src="../admin/img/<?php echo $row['image']; ?>" class="job-img">
                <div class="p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-light text-dark border"><?php echo $row['job_type']; ?></span>
                        <small><i class="fas fa-map-marker-alt text-danger"></i> <?php echo $row['job_location']; ?></small>
                    </div>
                    <h4 style="color: #0a5c36;"><?php echo $row['title']; ?></h4>
                    <p class="text-muted small"><?php echo substr($row['description'], 0, 100); ?>...</p>
                    <a href="contact.php?job=<?php echo urlencode($row['title']); ?>" class="btn-apply">Apply Now</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer class="main-footer">
    <div class="container">
        <div class="row g-4">
            
            <div class="col-lg-4 col-md-12">
                <div class="footer-logo">
                    <h5>BERDE <span>CONSTRUCTION</span></h5>
                </div>
              <p class="footer-desc">
    We provide high-quality construction services, utilizing modern engineering techniques and premium materials to deliver excellence.
</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/BERDE" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/252097430106" target="_blank"><i class="fab fa-whatsapp"></i></a>
                   
                </div>
            </div>

            <div class="col-lg-2 col-md-6 px-lg-4">
                <h6 class="footer-title">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="careers.php">Careers</a></li>
                </ul>
            </div>

            <div class="col-lg-6 col-md-6">
                <h6 class="footer-title">Contact Information</h6>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Main Office: Bosaso, Puntland, Somalia</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+252 097430106 / +252 90XXXXXXX</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>berdeconstruction12@gmail.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Sabti - Khamiis: 8:00 AM - 5:00 PM</span>
                </div>
            </div>

        </div>

        <hr class="footer-hr">

        <div class="footer-bottom">
            <p>&copy; 2026 <strong>Berde Construction & Engineering</strong>. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>