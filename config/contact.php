<?php 
// 1. Isku xirka Database-ka (Hubi in magaca database-kaagu yahay berde_db)
$conn = mysqli_connect("localhost", "root", "", "berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$msg = "";

// Marka form la diro
if(isset($_POST['send_message'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert = mysqli_query($conn, "INSERT INTO contact_messages (name, email, subject, message) 
                                   VALUES ('$name', '$email', '$subject', '$message')");
    
    if($insert){
        $msg = "Fariintaada waa la diray, waad ku mahadsantahay!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | Berde Construction</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    background: #f4f7f6;
}

/* HEADER */
header {
    background: rgb(28, 63, 29); /* Header cad si logogu u muuqdo */
    padding: 10px 0;
    display: flex;
    justify-content: space-around;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

header a {
    color: #0a5c36;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
}

/* HERO */
.hero {
    background: linear-gradient(rgba(10,92,54,0.8), rgba(10,92,54,0.8)),
                url('../sawir/contact.jpg');
    background-size: cover;
    background-position: center;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

/* CONTACT BOX */
.contact-box {
    max-width: 1000px;
    margin: -60px auto 50px;
    background: white;
    padding: 40px;
    border-radius: 15px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

input, textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box; /* Si uusan baaxada u dhaafo */
}

button {
    background: #0a5c36;
    color: white;
    border: none;
    padding: 15px;
    width: 100%;
    cursor: pointer;
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
}

button:hover {
    background: #4da975;
}

/* FOOTER */
footer {
    background: #0a5c36;
    color: white;
    text-align: center;
    padding: 25px;
}
</style>
</head>

<body>

<header>
    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="../sawir/logo.jpeg" alt="Logo" style="height: 50px; border-radius: 5px;">
        <h2 style="color:#0a5c36; margin:0; font-weight: 900;">BERDE</h2>
    </div>
    
    <nav>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="projects.php">Projects</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<section class="hero">
    <div style="text-align: center;">
        <h1 style="font-size: 45px; margin: 0;">CONTACT US</h1>
        <p>Ma haysaa su'aal ama mashruuc? Nala soo xiriir!</p>
    </div>
</section>

<div class="contact-box">

    <div style="border-right: 1px solid #eee; padding-right: 20px;">
        <h3 style="color:#0a5c36; font-size: 24px;">Get In Touch</h3>
        <p style="color: #666; line-height: 1.6;">Nala soo xiriir si aad u hesho adeegyo dhismo oo tayo leh. Kooxdayada ayaa diyaar kuu ah.</p>

        <div style="margin-top: 30px;">
            <p><i class="fa fa-phone" style="color:#0a5c36; width: 25px;"></i> +252 61XXXXXXX</p>
            <p><i class="fa fa-envelope" style="color:#0a5c36; width: 25px;"></i> info@berde.com</p>
            <p><i class="fa fa-map-marker" style="color:#0a5c36; width: 25px;"></i> Bosaso, Somalia</p>
        </div>
    </div>

    <form method="POST">
        <?php if($msg != ""): ?>
            <div style="background: #e8f5e9; color: green; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid green;">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="subject" placeholder="Subject">
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

        <button type="submit" name="send_message">Send Message <i class="fa fa-paper-plane"></i></button>
    </form>

</div>

<footer>
    <p>© <?php echo date("Y"); ?> Berde Construction | All Rights Reserved</p>
</footer>

</body>
</html>