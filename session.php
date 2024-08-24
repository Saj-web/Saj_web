<?php
session_start();
include 'db.php';

function checkEmailExists($email) {
    global $conn;
    $sql = "SELECT employee_email FROM employee WHERE employee_email='$email'";
    $result = $conn->query($sql);
    return ($result->num_rows > 0);
}

function checkPasswordChanged($user_id) {
    global $conn;
    $sql = "SELECT password_changed FROM employee WHERE employee_id='$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['password_changed'];
}
?>
