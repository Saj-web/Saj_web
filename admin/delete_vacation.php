<?php
include '../db.php';

// Delete vacation
$id = $_GET['id'];
$sql = "DELETE FROM vacation WHERE vacation_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

// Redirect to vacation page
header("Location: vacation.php");
exit;
?>