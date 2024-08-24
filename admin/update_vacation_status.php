<?php
include '../db.php';

$vacation_id = $_POST['vacation_id'];
$status = $_POST['status'];

$sql = "UPDATE vacation SET status = ? WHERE vacation_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $status, $vacation_id);
mysqli_stmt_execute($stmt);

header("Location: emp_vacation.php");
exit;
?>