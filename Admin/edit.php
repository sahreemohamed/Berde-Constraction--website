<?php
session_start();

// 1. Hubi in Admin-ku Login yahay
if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Path-ka saxda ah ee database config
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

// 2. Hubi in xogta ID iyo Table la soo gudbiyay
if (!isset($_GET['id']) || !isset($_GET['tbl'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$tbl = $_GET['tbl'];

// 3. Security Whitelist: Kahor tag in Table aan la ogolayn la pasiyo
$allowed_tables = array('services', 'sectors', 'projects', 'careers','about');
if (!in_array($tbl, $allowed_tables)) {
    die("<h3 style='text-align:center; margin-top:50px; color:red;'>Table-kan lama ogola!</h3>");
}

// 4. Aqoonsiga magaca Column-ka ee Table kasta
if ($tbl == 'sectors') {
    $col = 'sector_name';
} elseif ($tbl == 'projects') {
    $col = 'name';
} elseif ($tbl == 'careers') {
    $col = 'job_title';
} else {
    $col = 'title'; // Services & Default
}

// 5. Soo saar xogta dhabta ah ee hadda jirta
$stmt = mysqli_prepare($conn, "SELECT * FROM `$tbl` WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("<h3 style='text-align:center; margin-top:50px; color:red;'>Xogtan lama helin!</h3>");
}

$error = '';

// 6. Markii badhanka Update la riixo
if (isset($_POST['update_data'])) {
    $t = trim($_POST['title']);
    $d = trim($_POST['description']);
    $image_name = $row['image']; // Sawirkii hore

    // Haddii sawir cusub la soo upload-gareeyay
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($ext, $allowed_ext)) {
            $new_img_name = time() . '_' . uniqid() . '.' . $ext;
            $upload_dir = "img/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Tirtir sawirkii hore haddii uu jiro
            if (!empty($row['image']) && file_exists($upload_dir . $row['image'])) {
                unlink($upload_dir . $row['image']);
            }

            if (move_uploaded_file($tmp, $upload_dir . $new_img_name)) {
                $image_name = $new_img_name;
            } else {
                $error = "Sawirka lama upload-gareyn karin!";
            }
        } else {
            $error = "Fadlan soo dooro sawir noociisu yahay (JPG, PNG, WEBP)!";
        }
    }

    if (empty($error)) {
        // Safe Dynamic Query execution
        $update_sql = "UPDATE `$tbl` SET `$col` = ?, `image` = ?, `description` = ? WHERE id = ?";
        $up_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($up_stmt, "sssi", $t, $image_name, $d, $id);

        if (mysqli_stmt_execute($up_stmt)) {
            header("Location: index.php?msg=success");
            exit();
        } else {
            $error = "Cillad ayaa dhacday intii lagu jiray kaydinta database-ka.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content - Berde Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; padding-top: 50px; padding-bottom: 50px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .edit-card { max-width: 600px; margin: auto; border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .main-green { 
            background: #06402B; 
            color: white; 
            border-top-left-radius: 15px; 
            border-top-right-radius: 15px; 
        }
        .btn-success-custom { background: #06402B; color: white; border: none; }
        .btn-success-custom:hover { background: #52c480; color: #06402B; }
    </style>
</head>
<body>

<div class="container">
    <div class="card edit-card">
        <div class="card-header main-green py-3 text-center">
            <h4 class="mb-0 fw-bold">Edit <?php echo ucfirst(htmlspecialchars($tbl)); ?></h4>
        </div>
        <div class="card-body p-4">

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="fw-bold form-label">Title / Name</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($row[$col]); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold form-label">Current Image</label><br>
                    <?php if (!empty($row['image']) && file_exists("img/" . $row['image'])): ?>
                        <img src="img/<?php echo htmlspecialchars($row['image']); ?>" width="120" height="80" style="object-fit:cover;" class="mb-2 rounded border">
                    <?php else: ?>
                        <span class="text-muted d-block mb-2">Sawir ma jiro</span>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Kaliya dooro sawir cusub haddii aad rabtid inaad beddesho.</small>
                </div>

                <div class="mb-3">
                    <label class="fw-bold form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" name="update_data" class="btn btn-success-custom fw-bold py-2">Update Changes</button>
                    <a href="index.php" class="btn btn-light border py-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>