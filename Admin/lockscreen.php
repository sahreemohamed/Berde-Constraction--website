<?php
session_start();
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['admin'] ?? $_SESSION['admin_logged_in'] ?? 'Ani';
$_SESSION['locked'] = true;
$error = "";

if (isset($_POST['unlock'])) {
    $password = trim($_POST['password']);

    // Raadi qofka xilligaas Lock-ka ku jira oo keliya
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $db_password = $user['password'];

        if ($password === $db_password || password_verify($password, $db_password)) {
            unset($_SESSION['locked']);
            header("Location: index.php");
            exit();
        } else {
            $error = "Password-ka aad gelisay waa makhashi!";
        }
    } else {
        $error = "User lagama helin database-ka!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Locked - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #0a5c36; color: white; font-family: 'Segoe UI', sans-serif; }
        .lock-card { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 15px; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card lock-card p-4 text-center shadow-lg border-0" style="max-width: 380px; width: 100%;">
    <div class="mb-3">
        <i class="fas fa-user-lock fa-4x text-warning"></i>
    </div>
    <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($username); ?></h4>
    <p class="small text-light mb-4">Nidaamku waa xiran yahay (Locked)</p>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <input type="password" name="password" class="form-control text-center" placeholder="Geli Password-ka" required autofocus>
        </div>
        <button type="submit" name="unlock" class="btn btn-warning w-100 fw-bold">Ka Saar Lock-ka</button>
    </form>
</div>

</body>
</html>