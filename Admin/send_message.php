<?php
// Isku xirka database-ka
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hadii la rixo batanka Tirtirka (Delete)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $delete_id");
    header("Location: messages.php");
    exit();
}

// Kasoo saarida fariimaha database-ka (kuwa ugu cusub sare)
$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
        }
        .header-box {
            background-color: #06402B;
            color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .table-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .table thead {
            background-color: #06402B;
            color: #ffffff;
        }
        .btn-delete {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }
        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <!-- HEADER -->
    <div class="header-box d-flex justify-content-between align-items-center">
        <div>
            <h3 class="m-0 font-weight-bold"><i class="fa fa-envelope me-2"></i> Customer Messages</h3>
            <small class="text-light">Fariimaha ay macaamiishu ka soo direen bogga Contact Us</small>
        </div>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back to Dashboard</a>
    </div>

    <!-- MESSAGES TABLE -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { 
                    ?>
                        <tr>
                            <td><strong>#<?php echo $row['id']; ?></strong></td>
                            <td><i class="fa fa-user text-success me-2"></i><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none"><?php echo htmlspecialchars($row['email']); ?></a></td>
                            <td style="max-width: 350px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                            <td>
                                <a href="messages.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('Ma meelaysaa in aad tirtirto fariintan?');">
                                   <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center text-muted py-4">Wali wax fariin ah laguuma soo meelayn.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>