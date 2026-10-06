<?php 
// 1. Isku xirka Database-ka
$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db"); 

session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}
?>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>From</th>
                <th>Email</th>
                <th>Message Body</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 2. Soo aqri fariimaha
            $msg_query = mysqli_query($conn, "SELECT * FROM messages ORDER BY id DESC");
            
            // 3. Hubi haddii ay fariimo jiraan
            if($msg_query && mysqli_num_rows($msg_query) > 0) {
                while($msg = mysqli_fetch_assoc($msg_query)) {
            ?>
            <tr>
                <td class="fw-bold"><?php echo htmlspecialchars($msg['sender_name']); ?></td>
                <td><a href="mailto:<?php echo htmlspecialchars($msg['sender_email']); ?>"><?php echo htmlspecialchars($msg['sender_email']); ?></a></td>
                <td><?php echo htmlspecialchars(substr($msg['message_body'], 0, 50)); ?>...</td>
                <td class="text-end">
                    <a href="view_message.php?id=<?php echo $msg['id']; ?>" class="btn btn-info btn-sm text-white">Read</a>
                    <a href="process.php?del_msg=<?php echo $msg['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Ma hubtaa inaad tirtirto fariintan?')">
                       Delete
                    </a>
                </td>
            </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='4' class='text-center text-muted py-3'>Wax fariin ah wali lama helin.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>