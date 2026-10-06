<?php
session_start();

// Haddii admin-ku horey u logged in ahaa, toos ugu dir index.php
if (isset($_SESSION['admin']) || isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

$error = '';

if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Safe Prepared Statement
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Hubi Password-ka (Plain-text ama Hashed)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                
                // Kaydi Session-ka Isticmaalaha
                $_SESSION['admin'] = $user['username'];
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];

                // Qaybta Dynamic Role-ka (Ani = Super Admin, Mahad/Admin2 = Admin 2)
                if (isset($user['role']) && !empty($user['role'])) {
                    $_SESSION['admin_role'] = $user['role'];
                } else {
                    $_SESSION['admin_role'] = ($user['id'] == 1) ? 'Super Admin' : 'Admin 2';
                }

                header("Location: index.php");
                exit();
            } else {
                $error = "Password-ka aad gelisay waa khaldan yahay!";
            }
        } else {
            $error = "Magaca ama Email-ka lama helin!";
        }
    } else {
        $error = "Fadlan soo buuxi dhammaan reeraha foomka!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Berde Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            background: #06402B;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        .btn-custom {
            background: #06402B;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background: #52c480;
            color: #06402B;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="login-header">
        <h4 class="mb-0 fw-bold">Admin Login</h4>
        <small>Berde Management System</small>
    </div>
    <div class="card-body p-4">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Username / Email</label>
                <input type="text" name="username" class="form-control" placeholder="Geli username ama email" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Geli password-ka" required>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" name="login_btn" class="btn btn-custom fw-bold py-2">Sign In</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>