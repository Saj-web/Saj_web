<?php
include 'db.php';
include 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password !== $confirm_new_password) {
        echo "New passwords do not match.";
        exit();
    }

    // Fetch the current password from the database
    $sql = "SELECT employee_password FROM employee WHERE employee_id='$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($old_password == $row['employee_password']) {
        // Update with the new password
        $update_sql = "UPDATE employee SET employee_password='$new_password', password_changed=TRUE WHERE employee_id='$user_id'";

        if ($conn->query($update_sql) === TRUE) {
            echo "Password updated successfully.";

            // Redirect based on user role
            $role = $_SESSION['user_role'];
            if ($role == 'hr_manager') {
                header('Location: hr/hr_dashboard.php');
            } elseif ($role == 'department_manager') {
                header('Location: manager/manager_dashboard.php');
            } elseif ($role == 'employee') {
                header('Location: Employee/employee_dashboard.php');
            }
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Old password is incorrect.";
    }

    $conn->close();
}
?>
