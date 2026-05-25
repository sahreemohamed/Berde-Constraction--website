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
    <title>Projects - Berde Construction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link rel="stylesheet" href="style.css">
    <style>
        body { 
            
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../sawir/project.jpg'); 
            background: #f4f7f6; 
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
         .hero-projects {
    background: linear-gradient(rgba(10, 92, 54, 0.8), rgba(10, 92, 54, 0.8)), 
                url('../sawir/project.jpg'); /* Halkan ayaan kuugu hagaajiyay */
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 0;
    text-align: center;
}
        .project-card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }
        .project-card:hover { transform: translateY(-10px); }
        .main-green { color: #0a5c36; }
        footer {
            background-color: #0a5c36;
            color: white;
            padding: 40px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>

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
            <li><a href="sectors.php">Sectors</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="careers.php">Careers</a></li>
            <li><a href="contact.php" class="btn-contact">Contact</a></li>
        </ul>
    </div>
</nav>
    <header class="hero-projects">
        <div>
            <h1>OUR <span>PROJECTS</span></h1>
            <p>Innovative Engineering & Reliable Construction Solutions</p>
        </div>
    </header>

<div class="section-title">
    <h2>Our Projects</h2>
    <div class="line"></div>
    <p class="section-subtitle">A showcase of our commitment to quality, innovation, and structural integrity in every project we complete.</p>
</div>
<div class="universal-grid">
    <?php
    $get_projects = mysqli_query($conn, "SELECT * FROM projects WHERE status = 1");
    while($row = mysqli_fetch_assoc($get_projects)) { ?>
        <div class="content-card">
            <img src="../admin/img/<?php echo $row['image']; ?>" alt="Projects Image">
            <div class="content-body">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>


<footer style="background-color: #0a5c36; color: white; padding: 60px 0 20px 0; margin-top: auto;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h4 class="fw-bold mb-4">BERDE <span class="text-warning">CONSTRUCTION</span></h4>
                <p class="text-light opacity-75" style="line-height: 1.8;">
                    Leading the way in modern infrastructure and sustainable building solutions. We turn your vision into reality with precision and quality.
                </p>
                <div class="mt-4">
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 ms-lg-auto">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php" class="text-white text-decoration-none opacity-75">Home</a></li>
                    <li class="mb-2"><a href="about.php" class="text-white text-decoration-none opacity-75">About Us</a></li>
                    <li class="mb-2"><a href="projects.php" class="text-white text-decoration-none opacity-75">Our Projects</a></li>
                    <li class="mb-2"><a href="careers.php" class="text-white text-decoration-none opacity-75">Careers</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-4">Contact Info</h5>
                <ul class="list-unstyled text-light opacity-75">
                    <li class="mb-3"><i class="fas fa-map-marker-alt me-3 text-warning"></i> Bosaso,Somalia</li>
                    <li class="mb-3"><i class="fas fa-phone-alt me-3 text-warning"></i> +252 -097430106</li>
                    <li class="mb-3">
            <a href="https://www.facebook.com/BERDE" target="_blank" class="text-white text-decoration-none">
                <i class="fab fa-facebook me-3 text-warning"></i> Facebook 
            </a>
                    <li class="mb-3"><i class="fas fa-envelope me-3 text-warning"></i> berdeconstruction12@gmail.com</li>
                </ul>
            </div>
        </div>
     
        <hr class="mt-5 mb-4 border-secondary opacity-25">

        <div class="row">
            <div class="col-md-12 text-center">
                <p class="small mb-0 text-light opacity-50">
                    &copy; <?php echo date('Y'); ?> Berde Construction Company. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


</body>
</html>