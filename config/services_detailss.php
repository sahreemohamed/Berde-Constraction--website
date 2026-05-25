<?php 
$conn = mysqli_connect("localhost", "root", "", "berde_db");

// 1. Soo qabo ID-ga adeegga
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM services WHERE id = $id");
    $service = mysqli_fetch_assoc($query);

    if(!$service) {
        die("Adeegan lama helin!");
    }
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $service['title']; ?> | Berde Construction</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .details-hero {
            background: linear-gradient(rgba(6, 64, 43, 0.8), rgba(0, 0, 0, 0.8)), url('assets/img/<?php echo $service['image']; ?>');
            background-size: cover; background-position: center;
            height: 300px; display: flex; align-items: center; justify-content: center; color: #fff;
        }
        .gallery-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-top: 40px; }
        .gallery-item img { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; border: 3px solid #eee; }
        .service-info { padding: 80px 10%; background: #fff; }
        .sidebar-card { background: #f4f4f4; padding: 25px; border-radius: 8px; border-top: 5px solid #06402B; }
    </style>
</head>
<body>

<header class="main-header" style="background:#06402B !important; position:relative;">
    </header>

<div class="details-hero">
    <h1><?php echo $service['title']; ?></h1>
</div>

<section class="service-info">
    <div style="max-width: 1200px; margin: auto; display: flex; gap: 50px;">
        
        <div style="flex: 2;">
            <h2 style="color:#06402B; font-size: 35px; margin-bottom: 20px;">Detailed Overview</h2>
            <p style="font-size: 18px; line-height: 1.8; color: #555;">
                <?php echo $service['description']; ?>
            </p>

            <h3 style="margin-top: 50px; color:#06402B;">Project Gallery</h3>
            <div class="gallery-container">
                <?php 
                // Soo saar sawirada gallery-ga hadii ay ku jiraan database-ka
                $gallery_q = mysqli_query($conn, "SELECT * FROM service_gallery WHERE service_id = $id");
                if(mysqli_num_rows($gallery_q) > 0) {
                    while($img = mysqli_fetch_assoc($gallery_q)) { ?>
                        <div class="gallery-item">
                            <img src="assets/img/<?php echo $img['gallery_image']; ?>">
                        </div>
                    <?php } 
                } else {
                    echo "<p>No gallery images uploaded yet.</p>";
                } ?>
            </div>
        </div>

        <div style="flex: 1;">
            <div class="sidebar-card">
                <h3>Contact for Quote</h3>
                <p>Ma rabtaa adeegan? Nala soo xiriir hadda.</p>
                <a href="contact.php" class="btn-main" style="display:block; text-align:center; margin-top:15px;">Get a Quote</a>
            </div>
            <br>
            <div class="sidebar-card" style="border-top-color: #a0d8a0;">
                <h3>Other Services</h3>
                <ul style="list-style:none; padding:0;">
                    <?php 
                    $others = mysqli_query($conn, "SELECT * FROM services WHERE id != $id LIMIT 5");
                    while($row = mysqli_fetch_assoc($others)) { ?>
                        <li style="margin-bottom:10px;">
                            <a href="service-details.php?id=<?php echo $row['id']; ?>" style="text-decoration:none; color:#333;">
                                <i class="fa fa-arrow-right" style="color:#06402B;"></i> <?php echo $row['title']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</section>

</body>
</html>