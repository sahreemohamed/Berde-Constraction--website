<?php 
// 1. Session-ka waa inuu ugu horreeyaa mar walba
session_start();

// 2. Isku xirka Database-ka (Gudaha ama 'include db.php')
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hubi in Admin-ku Login yahay
if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in']) && !isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Qaybta garashada Admin-ka hadda galay
$current_admin = $_SESSION['admin'] ?? $_SESSION['admin_username'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'Admin 2';

// HUBIN: Haddii nidaamku locked yahay
if (isset($_SESSION['locked']) && $_SESSION['locked'] === true) {
    header("Location: lockscreen.php");
    exit();
}

// Haddii la tirtirayo fariin (Contact Us) - Safely with Prepared Statement
if (isset($_GET['delete_msg'])) {
    $msg_id = intval($_GET['delete_msg']);
    $stmt = mysqli_prepare($conn, "DELETE FROM contact_messages WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $msg_id);
    mysqli_stmt_execute($stmt);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Content</title>
    <link rel="icon" type="image/x-icon" href="../sawir/logo.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .main-green { background: #0a5c36; color: white; }
        .card { border-radius: 15px; border: none; }
        .table-img { width: 70px; height: 45px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0a5c36;">BERDE Content Manager</h2>
            <small class="text-muted">
                <i class="fas fa-user-shield me-1 text-success"></i> 
                WELCOME: <strong><?php echo htmlspecialchars($current_admin); ?></strong> 
                <span class="badge bg-info text-dark ms-1"><?php echo htmlspecialchars($admin_role); ?></span>
            </small>
        </div>
        
        <div class="d-flex gap-2">
            <?php if ($admin_role === 'Super Admin' || $current_admin === 'admin'): ?>
                <a href="manage_admins.php" class="btn btn-primary fw-bold"><i class="fas fa-users-cog me-1"></i> Manage Admins</a>
            <?php endif; ?>

            <a href="lockscreen.php" class="btn btn-secondary fw-bold"><i class="fas fa-lock me-1"></i> Lock Screen</a>
            <a href="change-password.php" class="btn btn-warning fw-bold text-dark"><i class="fas fa-key me-1"></i> Change Password</a>
            <a href="logs.php" class="btn btn-outline-success fw-bold"><i class="fas fa-history me-1"></i> View Logs</a>
            <a href="logout.php" class="btn btn-danger fw-bold"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
        </div>
    </div>

    <!-- ADD CONTENT FORM -->
    <div class="card shadow-sm mb-5">
        <div class="card-header main-green py-3">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Add New Content</h5>
        </div>
        <div class="card-body p-4">
            <form action="process.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="fw-bold small">Target Section</label>
                        <select name="table_name" class="form-select" required>
                            <option value="services">Services</option>
                            <option value="sectors">Sectors</option>
                            <option value="projects">Projects</option>
                            <option value="about">About </option>
                            <!-- Halkan waxaa la saxay 'career' oo loo beddelay 'careers' -->
                            <option value="careers">Careers </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold small">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-bold small">Upload Image</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*" required>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold small">Detailed Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Write description here..." required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold small">Job Location (Optional for Careers)</label>
                        <input type="text" name="job_location" class="form-control" placeholder="Tusaale: Mogadishu">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold small">Job Type (Optional for Careers)</label>
                        <select name="job_type" class="form-select">
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="add_universal" class="btn main-green px-5 shadow-sm">Save to Website</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 1. QAYBTA FARIIMAHA MACMIILKA -->
    <?php 
    $msg_query = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");
    if($msg_query):
    ?>
    <div class="card shadow-sm mb-5 border-start border-4 border-success">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h6 class="mb-0 fw-bold text-uppercase text-success"><i class="fas fa-envelope me-2"></i> Messages From Contact Us</h6>
            <span class="badge bg-success"><?php echo mysqli_num_rows($msg_query); ?> Messages</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small">
                    <tr>
                        <th width="10%">#ID</th>
                        <th width="20%">Name</th>
                        <th width="20%">Email</th>
                        <th width="40%">Message</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($msg_query) > 0) {
                        while($msg_row = mysqli_fetch_assoc($msg_query)) { 
                    ?>
                    <tr>
                        <td><strong>#<?php echo $msg_row['id']; ?></strong></td>
                        <td class="fw-bold text-start ps-3"><?php echo htmlspecialchars($msg_row['name']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($msg_row['email']); ?>"><?php echo htmlspecialchars($msg_row['email']); ?></a></td>
                        <td class="text-start"><?php echo nl2br(htmlspecialchars($msg_row['message'])); ?></td>
                        <td>
                            <a href="?delete_msg=<?php echo $msg_row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ma hubtaa inaad tirtirto fariintan?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo '<tr><td colspan="5" class="text-muted py-3">Wax fariin ah wali ma soo dhacin.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- 2. QAYBAHA KALE EE WEBSITE-KA (SERVICES, SECTORS, CAREERS, ETC.) -->
    <?php 
    $sections = ['services', 'sectors', 'projects', 'careers', 'about']; 
    foreach($sections as $tbl): 
        $query = mysqli_query($conn, "SELECT * FROM $tbl ORDER BY id DESC");
        if($query):
    ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h6 class="mb-0 fw-bold text-uppercase" style="color: #0a5c36;"><?php echo $tbl; ?> List</h6>
            <span class="badge main-green"><?php echo mysqli_num_rows($query); ?> Items</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small">
                    <tr>
                        <th width="10%">Image</th>
                        <th width="25%">Title</th>
                        <th width="15%">Status</th>
                        <th width="50%" class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)) { 
                        $page_link = "../config/" . $tbl . ".php";
                        $status = isset($row['status']) ? intval($row['status']) : 1;
                    ?>
                    <tr>
                        <td>
                            <img src="img/<?php echo htmlspecialchars($row['image']); ?>" class="table-img shadow-sm" onerror="this.src='https://via.placeholder.com/100x60?text=No+Img'">
                        </td>
                        <td class="fw-bold text-start ps-4">
                            <?php 
                                if(!empty($row['title'])) {
                                    echo htmlspecialchars($row['title']); 
                                } elseif(!empty($row['job_title'])) {
                                    echo htmlspecialchars($row['job_title']);
                                } elseif(!empty($row['sector_name'])) {
                                    echo htmlspecialchars($row['sector_name']);
                                } elseif(!empty($row['name'])) {
                                    echo htmlspecialchars($row['name']);
                                } else {
                                    echo '<span class="text-muted small">No Title Found</span>';
                                }
                            ?>
                        </td>
                        <td>
                            <span class="badge <?php echo ($status == 1) ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo ($status == 1) ? 'Shown' : 'Hidden'; ?>
                            </span>
                        </td>
                        <td class="text-end px-4">
                            <?php if ($status == 1): ?>
                                <a href="toggle_status.php?id=<?php echo $row['id']; ?>&tbl=<?php echo $tbl; ?>&status=0" class="btn btn-sm btn-warning text-dark fw-bold">
                                    <i class="fas fa-eye-slash me-1"></i> Hide
                                </a>
                            <?php else: ?>
                                <a href="toggle_status.php?id=<?php echo $row['id']; ?>&tbl=<?php echo $tbl; ?>&status=1" class="btn btn-sm btn-success fw-bold">
                                    <i class="fas fa-eye me-1"></i> Show
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo $page_link; ?>" target="_blank" class="btn btn-sm btn-dark fw-bold"><i class="fas fa-external-link-alt"></i> View</a>
                            <a href="edit.php?id=<?php echo $row['id']; ?>&tbl=<?php echo $tbl; ?>" class="btn btn-sm btn-info text-white mx-1"><i class="fas fa-edit"></i> Edit</a>
                            <a href="process.php?delete=<?php echo $row['id']; ?>&tbl=<?php echo $tbl; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ma hubtaa inaad tirtirto?')"><i class="fas fa-trash"></i> Del</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; endforeach; ?>
</div>

</body>
</html>