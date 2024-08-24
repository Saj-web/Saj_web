<?php
include '../db.php';

$employeeId = $_POST['employee_id'];
$employeeName = $_POST['employee_name'];
$employeeMobile = $_POST['employee_mobile'];
$employeeAddress = $_POST['employee_address'];
$employeeEmail = $_POST['employee_email'];
$role = $_POST['role'];
$departmentName = $_POST['department_name'];

// Get department ID
$sql = "SELECT department_id FROM department WHERE department_name = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $departmentName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$departmentId = $row['department_id'];

// Update employee details
$sql = "UPDATE employee SET employee_name = ?, employee_mobile = ?, employee_address = ?, employee_email = ? WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ssssi', $employeeName, $employeeMobile, $employeeAddress, $employeeEmail, $employeeId);
mysqli_stmt_execute($stmt);

// Update user role
$sql = "UPDATE userroles SET role = ? WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'si', $role, $employeeId);
mysqli_stmt_execute($stmt);

// Update employee department
$sql = "UPDATE employee_department SET department_id = ? WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $departmentId, $employeeId);
mysqli_stmt_execute($stmt);

// Redirect back to employee list
header('Location: get_employee_data.php');
exit;