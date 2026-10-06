<?php
include 'config/db.php';

$error = '';

if (isset($_POST['save'])) {

    // 1. Amni-dhowrka Xogta (Sanitization)
    $title = trim($_POST['title']);
    $desc  = trim($_POST['description']);

    // 2. Kontroolka Sawirka (Image Security)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        
        $image     = $_FILES['image']['name'];
        $tmp       = $_FILES['image']['tmp_name'];
        $ext       = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        
        // Formats-ka la ogol yahay oo kaliya
        $allowed_ext = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($ext, $allowed_ext)) {
            
            // Magac unug ah oo cusub si looga hortago in faylalku is dhuftaan
            $new_image_name = time() . '_' . uniqid() . '.' . $ext;
            
            // Kaydinta sawirka (Hubi in folder-ka 'uploads' ama 'img' uu joogo)
            $upload_dir = "../img/"; 
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($tmp, $upload_dir . $new_image_name)) {
                
                // 3. SQL Query oo ammaan ah (Prepared Statement)
                $stmt = mysqli_prepare($conn, "INSERT INTO about (title, description, image, status) VALUES (?, ?, ?, 1)");
                mysqli_stmt_bind_param($stmt, "sss", $title, $desc, $new_image_name);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Cillad ayaa ka dhacday database-ka!";
                }
                
            } else {
                $error = "Sawirka lama muujin karin ama lama upload-gareyn karin!";
            }

        } else {
            $error = "Fadlan soo upload-garee sawir sax ah (JPG, JPEG, PNG, WEBP)!";
        }

    } else {
        $error = "Fadlan soo dooro sawir!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add About</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f4f6f9; }
        .form-container { background: white; padding: 25px; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        input[type="text"], textarea, input[type="file"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #06402B; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        button:hover { background: #52c480; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add About</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description" rows="5" required></textarea><br>
        <input type="file" name="image" accept="image/*" required><br>
        <button name="save">Save</button>
    </form>
</div>

</body>
</html>