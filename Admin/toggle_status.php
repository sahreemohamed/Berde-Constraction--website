<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}

$conn = mysqli_connect("sql303.infinityfree.com", "if0_42952198", "sP6kxRQFENz", "if0_42952198_berde_db");

if (isset($_GET['id']) && isset($_GET['tbl']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $tbl = $_GET['tbl'];
    $status = intval($_GET['status']);

    $allowed_tables = array('services', 'sectors', 'projects', 'careers', 'about');

    if (in_array($tbl, $allowed_tables)) {
        $stmt = mysqli_prepare($conn, "UPDATE `$tbl` SET `status` = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $status, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $action_text = ($status == 1) ? 'Muujiyay (Show)' : 'Qariyay (Hide)';
            //log_change($conn, 'TOGGLE_STATUS', $tbl, $id, "Wuxuu $action_text xogta ID: $id ee table-ka $tbl");//
        }
    }
}

header("Location: index.php");
exit();
?>