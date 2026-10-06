<?php
session_start();

$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['admin'] ?? $_SESSION['admin_logged_in'] ?? 'Ani';
$message = "";
$error = "";

if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Kasoo raadi user-ka shaqaynaya oo keliya (Laga saaray 'OR id = 1')
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && ($current_password === $user['password'] || password_verify($current_password, $user['password']))) {
        
        if ($new_password === $confirm_password) {
            $user_id = $user['id'];
            
            // Password-ka cusub ee qofkaas uun cusboonaysii
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_password, $user_id);
            
            if ($update_stmt->execute()) {
                $message = "Password-ka waa la badalay si guul leh!";

                // --- LOG-KA KU KAYDI TABLE-KA 'change_logs' ---
                $action     = "CHANGE PASSWORD";
                $table_name = "users";
                $details    = "User-ka $username wuxuu badalay password-kiisa";

                $log_stmt = $conn->prepare("INSERT INTO change_logs (user_id, username, action, table_name, record_id, details) VALUES (?, ?, ?, ?, ?, ?)");
                
                if ($log_stmt) {
                    $log_stmt->bind_param("isssis", $user_id, $username, $action, $table_name, $user_id, $details);
                    $log_stmt->execute();
                }

            } else {
                $error = "Cilad ayaa dhacday marka la badalayay.";
            }
        } else {
            $error = "Password-ka cusub iyo ku celiintiisa isma leeyihiin!";
        }
    } else {
        $error = "Password-kaaga hore (Current Password) waa makhashi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Badal Password-ka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .toggle-btn { cursor: pointer; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title fw-bold mb-0" style="color: #0a5c36;">Badal Password-ka</h4>
                        <a href="index.php" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i> Tilmaam</a>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Password-ka Hadda (Current)</label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                <span class="input-group-text toggle-btn" onclick="togglePassword('current_password', 'icon1')">
                                    <i class="fas fa-eye" id="icon1"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Password-ka Cusub</label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                                <span class="input-group-text toggle-btn" onclick="togglePassword('new_password', 'icon2')">
                                    <i class="fas fa-eye" id="icon2"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Ku Celi Password-ka Cusub</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                <span class="input-group-text toggle-btn" onclick="togglePassword('confirm_password', 'icon3')">
                                    <i class="fas fa-eye" id="icon3"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" name="update_password" class="btn w-100 text-white fw-bold py-2" style="background: #0a5c36;">Badal Password-ka</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>