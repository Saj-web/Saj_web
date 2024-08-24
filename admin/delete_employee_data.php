<?php
include '../db.php';

$employeeId = $_GET['employee_id'];

// Delete from userroles 
$sql = "DELETE FROM userroles WHERE user_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from attendance
$sql = "DELETE FROM attendance WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from department
$sql = "DELETE FROM employee_department WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from evaluation
$sql = "DELETE FROM evaluation WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from salary
$sql = "DELETE FROM salary WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from training
$sql = "DELETE FROM trainings WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then delete from vacation
$sql = "DELETE FROM vacation WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

// Then finally delete from employee
$sql = "DELETE FROM employee WHERE employee_id =?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);

mysqli_close($conn);

// Redirect back to employee list
header('Location: get_employee_data.php');
exit;
?>