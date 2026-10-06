<?php
// 1. Isku xirka Database-ka
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Hubi in Admin-ku Login yahay
if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}

// ==================== UNIVERSAL PROCESS (Add / Insert) ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_universal'])) {
    
    // Hubi in table_name la soo diray
    // CORRECT (Koodhka saxda ah):
if (!isset($_POST['table_name']) || empty($_POST['table_name'])) {
        die("Invalid table selection: Table name is missing.");
    }

    $table = strtolower(trim(mysqli_real_escape_string($conn,$_POST['table_name'])));
    $title = mysqli_real_escape_string($conn, $_POST['title']);$description = mysqli_real_escape_string($conn,$_POST['description']);

    // Qaybaha Careers
    $job_location = isset($_POST['job_location']) ? mysqli_real_escape_string($conn,$_POST['job_location']) : 'Somalia';
    $job_type = isset($_POST['job_type']) ? mysqli_real_escape_string($conn,$_POST['job_type']) : 'Full-time';

    // Whitelist-ka Table-laha loo oggol yahay
    $allowed_tables = ['services', 'sectors', 'projects', 'about', 'careers'];
    if (!in_array($table,$allowed_tables)) {
        die("Invalid table selection.");
    }

    // Handle Image Upload
    $target_dir = "img/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
        $file_extension = strtolower(pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION));
        $new_image_name = time() . "_" . uniqid() . "." . $file_extension;
        $target_file = $target_dir .$new_image_name;

        $check = getimagesize($_FILES["image_file"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                
                // Query Selection
                if ($table == 'careers') {$query = "INSERT INTO careers (job_title, image, description, job_location, job_type, status) VALUES ('$title', '$new_image_name', '$description', '$job_location', '$job_type', 1)";
                } 
                elseif ($table == 'sectors') {$query = "INSERT INTO sectors (title, image, description, status) VALUES ('$title', '$new_image_name', '$description', 1)";
                } 
                elseif ($table == 'projects') {$query = "INSERT INTO projects (title, image, description, status) VALUES ('$title', '$new_image_name', '$description', 1)";
                } 
                elseif ($table == 'about') {$query = "INSERT INTO about (title, image, description, status) VALUES ('$title', '$new_image_name', '$description', 1)";
                } 
                else {
                    $query = "INSERT INTO $table (title, image, description, status) VALUES ('$title', '$new_image_name', '$description', 1)";
                }

                if (mysqli_query($conn,$query)) {
                    $inserted_id = mysqli_insert_id($conn);
                    
                    if (function_exists('log_change')) {
                        log_change($conn, 'INSERT', $table,$inserted_id, "Wuxuu soo kordhiyay xog cusub: '$title'");
                    }

                    header("Location: index.php?msg=Success");
                    exit();
                } else {
                    echo "Database Error: " . mysqli_error($conn);
                }

            } else {
                echo "Error: Failed to move uploaded file to destination folder.";
            }
        } else {
            echo "Error: The file you uploaded is not a valid image.";
        }
    } else {
        echo "Error: Please upload an image file.";
    }
}

// ==================== DELETE PROCESS ====================
if (isset($_GET['delete']) && isset($_GET['tbl'])) {
    $id = intval($_GET['delete']);
    $tbl = strtolower(trim(mysqli_real_escape_string($conn, $_GET['tbl'])));$allowed_tables = ['services', 'sectors', 'projects', 'about', 'careers', 'contact_messages'];

    if (in_array($tbl, $allowed_tables)) {$query = "DELETE FROM `$tbl` WHERE id = $id";
        if (mysqli_query($conn,$query)) {
            
            if (function_exists('log_change')) {
                log_change($conn, 'DELETE', $tbl,$id, "Wuxuu tirtiray xogta ID: $id ee table-ka$tbl");
            }

            header("Location: index.php?msg=Deleted");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        die("Invalid table operation.");
    }
}
?>