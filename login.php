<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    
    // Check user in the database
    $sql = "SELECT * FROM employee WHERE employee_name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['employee_password']) {
            // Fetch user role
            $user_id = $row['employee_id'];
            $sql_role = "SELECT role FROM userroles WHERE user_id='$user_id'";
            $role_result = $conn->query($sql_role);
            $role_row = $role_result->fetch_assoc();

            // Store session data
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $row['employee_name'];
            $_SESSION['user_role'] = $role_row['role'];
            $_SESSION['password_changed'] = $row['password_changed'];

            // Insert attendance data into another table
            $attendance_data = array(
                'employee_id' => $user_id,
                'attendance_date' => date('Y-m-d H:i:s'), // datetime format
                'attendance_status' => 'present'
            );
            $sql_attendance = "INSERT INTO attendance (employee_id, attendance_date, attendance_status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_attendance);
            $stmt->bind_param('iss', $attendance_data['employee_id'], $attendance_data['attendance_date'], $attendance_data['attendance_status']);
            $stmt->execute();

            // Redirect based on user role and password changed status
            if ($_SESSION['user_role'] == 'admin') {
                header('Location: admin/admin_dashboard.php');
            } else {
                if ($_SESSION['password_changed']) {
                    // Redirect to respective role page
                    if ($_SESSION['user_role'] == 'hr_manager') {
                        header('Location: hr/hr_dashboard.php');
                    } elseif ($_SESSION['user_role'] == 'department_manager') {
                        header('Location: manager/manager_dashboard.php');
                    } elseif ($_SESSION['user_role'] == 'employee') {
                        header('Location: Employee/employee_dashboard.php');
                    }
                } else {
                    header("Location: change_password.php");
                }
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
?>