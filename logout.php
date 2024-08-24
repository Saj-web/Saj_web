<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Login style.css-->
    <link rel ="stylesheet" href="login.css">

</head>

<body>
    <!-- Form container-->
    <div class="borderStyle">
        <form action="#login.php" method="post">
            <?php
            session_start();
            session_unset();
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
            echo "<div style='color:red;text-align: center;'>Invalid password.</div>";
        }
    } else {
        echo "<div style='color:red;text-align: center;'>No user found with this username.</div>";
    }
}
?>
            <!--Image container-->
            <div class="imgcontainer">
            <img src="images/Sandy_Tsp-03_Single-02.jpg" alt="signin logo" class="avatar">
            </div>

            <!--Employee field--> 
            <div class="container">
            <label for="userId"></label>
            </label><b>Name</b>
            <span class="star">
            <sup>
            *
            </sup>
            </span>
            </label>
            <input type="text" id="employeeId" placeholder="Enter Username" name="name" required>
          
    
            <!-- Password field-->
            <label for="password">
            <b>
            Password
            </b>
            <span class="star">
            <sup>
            *
            </sup>
            </span>
            </label>
            <div class="password-container">
              <input type="password" name="password" id="Password" placeholder="Enter Password" required>
              <span class="lock-icon" onclick="togglePasswordVisibility()">&#x1F512;</span>
            </div>

            <!-- Login field-->
            <button type="submit" id="login">
            Login
            </button>
            <!-- Checkbox field-->
            <label>
            <input type="checkbox" name="remember" style="margin-bottom:0px "> Remember me
            </label>

            </form>
            

<!-- Cancel button & password field-->
<div class="cancel-container">
    <a href="homePage.html">
    <button type="button" class="cancelbtn">Cancel</button>
    </a>
    <span class="password">
    Forgot <a href="password.php">password?</a></span>
</div>
</div>

<script>

            // Create a toggle for password visibility
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("Password");
                var lockIcon = document.querySelector(".lock-icon");
    
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    lockIcon.innerHTML = "&#x1F513;"; // Unicode for the unlocked icon
                } else {
                    passwordInput.type = "password";
                    lockIcon.innerHTML = "&#x1F512;"; // Unicode for the closed Lock icon
                }

                passwordInput.classList.toggle("visible");
            }

            //Disable the browser's back button
            history.pushState(null,null,location.href);
            window.onpopstate=function(){
              history.go(1);
            };
        </script>
</body>
</html>