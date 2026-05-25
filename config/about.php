
<?php 
 $conn = mysqli_connect("localhost", "root", "", "berde_db");

// 2. Soo aqri xogta ku jirta miiska 'about'
$query = mysqli_query($conn, "SELECT * FROM about LIMIT 1");
$data = mysqli_fetch_assoc($query);

// Prevent error: If the database is empty, use this default data
if(!$data) {
    $data = [
        'title' => 'About Berde Construction',
        'sub_title' => 'Building Your Future',
        'description' => 'We are a leading construction company dedicated to high-quality infrastructure and development.',
        'mission' => 'To provide superior construction services with integrity and excellence.',
        'vision' => 'To be the most trusted and innovative construction partner in the region.',
        'image' => 'https://images.unsplash.com/photo-1503387762-592dea58ef21?q=80&w=1350&auto=format&fit=crop'
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Berde Construction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../sawir/logo.jpeg" alt="Berde Logo" class="logo-img-nav me-2">
            <div class="d-flex flex-column">
                <span class="logo-text-main">BERDE</span>
                <small class="logo-text-sub">Construction & Engineering</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="careers.php">Careers</a></li>
                <li class="nav-item">
                    <a class="nav-link btn-contact-nav" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section class="about-page-header py-5" style="background: linear-gradient(rgba(10, 92, 54, 0.8), rgba(10, 92, 54, 0.8)), url('../sawir/about.jpg'); background-size: cover; background-position: center; color: white;">
    <div class="container text-center py-4">
        <h1 class="display-4 fw-bold text-uppercase">About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">About</li>
            </ol>
        </nav>
    </div>
</section>



<?php
// Waxaan soo kaxaynaynaa xogta ugu dambaysa ee About-ka
$about_query = mysqli_query($conn, "SELECT * FROM about ORDER BY id DESC LIMIT 1");
$about_data = mysqli_fetch_assoc($about_query);

if($about_data) {
?>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            
            <div class="col-lg-5">
                <div class="about-img-wrapper">
                    <img src="../admin/img/<?php echo $about_data['image']; ?>" 
                         alt="About Berde" 
                         class="img-fluid rounded-4 shadow-lg"
                         style="border-radius: 20px !important;">
                </div>
            </div>

            <div class="col-lg-7">
                <div class="about-content">
                    <h2 class="fw-bold mb-3" style="color: #0a5c36; font-size: 2.5rem;">
                        <?php echo $about_data['title']; ?>
                    </h2>
                    <div class="line mb-4" style="width: 60px; height: 5px; background: #16301c; border-radius: 5px;"></div>
                    
                    <div class="about-text" style="line-height: 1.8; color: #333; font-size: 1.1rem;">
                        <?php echo nl2br($about_data['description']); ?>
                    </div>

                   
                </div>
            </div>

        </div>
    </div>
</section>
<?php } ?>

    </div>
</section>

<footer class="footer-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Berde Construction</h5>
                <p class="footer-desc">
                    We are a leading construction and engineering firm, dedicated to delivering high-quality services built on integrity and innovation.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/2527430106" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="sectors.php">Sectors</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="careers.php">Careers</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>

          

            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Get In Touch</h5>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> Bosaso, Bari, Somalia</li>
                    <li><i class="fas fa-phone"></i> +252 -907430106</li>
                    <li><i class="fas fa-envelope"></i> berdeconstruction12@gmail.com</li>
                    <li><i class="fas fa-clock"></i> Sat - Thu: 8:00 AM - 5:00 PM</li>
                </ul>
            </div>
        </div>

        <hr class="footer-hr">
        
        <div class="footer-bottom text-center">
            <p>&copy; 2026 <span>Berde Construction and Engineering</span>. All Rights Reserved.</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>