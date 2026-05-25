<?php
// 1. Macluumaadka Database-ka
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "berde_db";

// 2. Samaynta Xiriirka (Connection)
$conn = mysqli_connect($host, $user, $pass, $dbname);

// 3. Hubi haddii xiriirku guulaystay
if (!$conn) {
    die("Xiriirka database-ka waa uu fashilmay: " . mysqli_connect_error());
}

// 4. Taageerada farta Soomaaliga/Carabiga
mysqli_set_charset($conn, "utf8mb4");

// Haddii aad rabto inaad hubiso xiriirka intaad dhisayso, ka saar labada dhibcood ee hoose:
// echo "Database Connected Successfully!";
?>