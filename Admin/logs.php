<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

$result = mysqli_query($conn, "SELECT * FROM change_logs ORDER BY created_at DESC LIMIT 100");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Logs - Berde Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-success">System Activity & Change Logs</h3>
        <a href="index.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
    </div>

    <table class="table table-hover border">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Admin / User</th>
                <th>Action</th>
                <th>Table</th>
                <th>Record ID</th>
                <th>Details</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($row['username']); ?></span></td>
                        <td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($row['action']); ?></span></td>
                        <td><code><?php echo htmlspecialchars($row['table_name']); ?></code></td>
                        <td><?php echo $row['record_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><small class="text-muted"><?php echo $row['created_at']; ?></small></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">Aan wali wax log ah lagu kaydin.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>