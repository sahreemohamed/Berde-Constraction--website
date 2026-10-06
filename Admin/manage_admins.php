<?php
session_start();
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$msg = '';
$error = '';

// 1. KU DAR ADMIN CUSUB (Add Admin 2)
if (isset($_POST['add_admin'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hubi in Username-ka ama Email-ku uusan horey u jirin
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? OR email = ?");
        mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $error = "Magacan ama Email-kan horey ayaa loo isticmaalay!";
        } else {
            // Ku dar user-ka cusub database-ka
            $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $password);

            if (mysqli_stmt_execute($insert_stmt)) {
                $msg = "Admin cusub si guul leh ayaa loo dhalay!";
            } else {
                $error = "Khalad ayaa dhacay marka lagu dharayay user-ka!";
            }
        }
    } else {
        $error = "Fadlan soo buuxi dhammaan reeraha!";
    }
}

// 2. TIRTIR ADMIN (Delete Admin 2)
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    
    // U diad in Super Admin-ka (ID = 1) la tirtiro
    if ($del_id != 1) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $del_id");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Marnaba ma tirtiri kartid Super Admin-ka nidaamka!";
    }
}

// Raadi dhammaan Admin-yada
$result = mysqli_query($conn, "SELECT id, username, email, created_at FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maamulka Admin-yada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">Maamulka Admin-yada System-ka</h3>
        <a href="index.php" class="btn btn-secondary fw-bold"><i class="fas fa-arrow-left me-1"></i> Ku laabaw Dashboard-ka</a>
    </div>

    <!-- Farriimaha Guusha ama Error-ka -->
    <?php if(!empty($msg)): ?>
        <div class="alert alert-success py-2"><?php echo $msg; ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="alert alert-danger py-2"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- FOOMKA KU DARIDA ADMIN CUSUB -->
        <div class="col-md-4">
            <div class="card border-0 bg-light p-3 rounded">
                <h5 class="fw-bold text-success mb-3"><i class="fas fa-user-plus me-2"></i>Ku dar Admin Cusub</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Geli Username" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Geli Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Geli Password" required>
                    </div>
                    <button type="submit" name="add_admin" class="btn btn-success w-100 fw-bold">Abuur Admin</button>
                </form>
            </div>
        </div>

        <!-- LIISKA ADMIN-YADA JIRA -->
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Xilliga la abuuray</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong>#<?php echo $row['id']; ?></strong></td>
                            <td><span class="badge bg-primary fs-6"><?php echo htmlspecialchars($row['username']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                            <td>
                                <?php if($row['id'] == 1): ?>
                                    <span class="badge bg-danger">Super Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark">Admin 2</span>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-muted"><?php echo $row['created_at'] ?? 'N/A'; ?></small></td>
                            <td>
                                <?php if($row['id'] != 1): ?>
                                    <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ma hubtaa inaad tirtirto admin-kan?')"><i class="fas fa-trash"></i></a>
                                <?php else: ?>
                                    <span class="text-muted small">Protected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>