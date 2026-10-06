<?php 
session_start();

// 1. Hubi in Admin-ku Login yahay
if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}

// 2. Path-ka db.php oo sax ah (Maadaama uu faylkan ku jiro admin/)

$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");
// 3. Definition-ka log_change (Si aanu Fatal Error uga dhicin haddii uusan db.php ku jirin)
if (!function_exists('log_change')) {
    function log_change($conn, $action, $table_name, $record_id, $details = '') {
        $user_id = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['admin'] ?? 'System/Guest';

        $sql = "INSERT INTO change_logs (user_id, username, action, table_name, record_id, details) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "isssis", $user_id, $username, $action, $table_name, $record_id, $details);
            mysqli_stmt_execute($stmt);
        }
    }
}

// 4. Soo aqri xogta hadda jirta (Safe Prepared Query)
function getSetting($key, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT setting_value FROM site_settings WHERE setting_key = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['setting_value'] ?? '';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Home Page & About - Berde Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; padding-top: 40px; }
        .main-card { max-width: 800px; margin: auto; border-radius: 15px; border: none; }
        .main-green { background: #0a5c36; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card main-card shadow-sm">
        <div class="card-header main-green py-3">
            <h4 class="mb-0 fw-bold">Manage Home Page & About</h4>
        </div>
        <div class="card-body p-4">

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                <div class="alert alert-success py-2">Xogta waa la cusboaysiiyay!</div>
            <?php endif; ?>

            <form action="process_home.php" method="POST">
                <div class="mb-3">
                    <label class="fw-bold form-label">Hero Title:</label>
                    <input type="text" name="hero_title" value="<?php echo htmlspecialchars(getSetting('hero_title', $conn)); ?>" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold form-label">Hero Subtitle:</label>
                    <textarea name="hero_subtitle" class="form-control" rows="3" required><?php echo htmlspecialchars(getSetting('hero_subtitle', $conn)); ?></textarea>
                </div>
                
                <hr class="my-4">
                
                <div class="mb-3">
                    <label class="fw-bold form-label">About Us Text:</label>
                    <textarea name="about_text" rows="5" class="form-control" required><?php echo htmlspecialchars(getSetting('about_text', $conn)); ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="index.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                    <button type="submit" name="update_home" class="btn btn-success fw-bold px-4" style="background: #0a5c36;">Update Website Content</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>