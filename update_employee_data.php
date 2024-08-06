<?php
include 'db.php';

$employeeId = $_POST['employee_id'];
$employeeName = $_POST['employee_name'];
$employeeMobile = $_POST['employee_mobile'];
$employeeAddress = $_POST['employee_address'];
$employeeEmail = $_POST['employee_email'];
$role = $_POST['role'];

$sql = "UPDATE employee SET employee_name = ?, employee_mobile = ?, employee_address = ?, employee_email = ? WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ssssi', $employeeName, $employeeMobile, $employeeAddress, $employeeEmail, $employeeId);
mysqli_stmt_execute($stmt);

$sql = "UPDATE userroles SET role = ? WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'si', $role, $employeeId);
mysqli_stmt_execute($stmt);

mysqli_close($conn);
?>


