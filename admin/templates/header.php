<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="adm.css">
    <style>
        .profile {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            height: 100vh;
            background-color: #f0f0f0;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .profile.show {
            transform: translateX(0);
        }

        .profile h2 {
            margin-top: 0;
        }

        .profile form {
            margin-top: 20px;
        }

        .profile label {
            display: block;
            margin-bottom: 10px;
        }

        .profile input[type="email"], .profile input[type="text"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .profile input[type="submit"] {
        background-color: rgb(255, 213, 0);
        color: #000;
        font-size: 16px;
        padding: 10px 5px;
        margin: 12px 0;
        border: none;
        cursor: pointer;
        transition: background-color 0.10s;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="admin_dashboard.php">
        HRMS
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="mailto:gbenartey19@gmail.com" style="margin-top:10px;">Support</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../user_image.jpg" alt="User Profile" class="profile-pic">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#" id="toggle-profile">Profile</a>
                    <a class="dropdown-item" href="change_password.php" id="toggle-profile">Change Password</a>
                    <a class="dropdown-item" href="../logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

    <div class="profile">
        <h2>Profile</h2>
        <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ../logout.php');
            exit;
        }
        
        $employee_id = $_SESSION['user_id'];
        
        // Include the database connection file
        require_once '../db.php';
        
        // Retrieve the employee's details from the database
        $sql = "SELECT e.employee_name, e.employee_email, e.employee_address, e.employee_mobile, ur.role
                FROM employee e
                LEFT JOIN userroles ur ON e.employee_id = ur.user_id
                WHERE e.employee_id = '$employee_id'";
        $result = $conn->query($sql);
        
        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $employee_name = $row['employee_name'];
            $employee_email = $row['employee_email'];
            $employee_address = $row['employee_address'];
            $employee_mobile = $row['employee_mobile'];
            $role = $row['role'];
        } else {
            die("No employee found with ID $employee_id");
        }
        
        // Check if the form has been submitted
        if (isset($_POST['update_profile'])) {
            // Get the updated values from the form
            $updated_name = $_POST['employee_name'];
            $updated_email = $_POST['employee_email'];
            $updated_address = $_POST['employee_address'];
            $updated_mobile = $_POST['employee_mobile'];
        
            // Update the employee's details in the database
            $sql = "UPDATE employee
                    SET employee_name = '$updated_name',
                        employee_email = '$updated_email',
                        employee_address = '$updated_address',
                        employee_mobile = '$updated_mobile'
                    WHERE employee_id = '$employee_id'";
            $result = $conn->query($sql);
        
            if (!$result) {
                die("Query failed: " . $conn->error);
            }
        
            // Update the session variables with the new values
            $_SESSION['employee_name'] = $updated_name;
            $_SESSION['employee_email'] = $updated_email;
            $_SESSION['employee_address'] = $updated_address;
            $_SESSION['employee_mobile'] = $updated_mobile;
        
            // Display a success message
            echo "<p>Profile updated successfully!</p>";
            header('Location: admin_dashboard.php');
exit;
        }
        
        // Close the database connection
        $conn->close();
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="employee_name">Name:</label>
            <input type="text" id="employee_name" name="employee_name" value="<?php echo $employee_name; ?>">
            <br>
            <label for="employee_email">Email:</label>
            <input type="email" id="employee_email" name="employee_email" value="<?php echo $employee_email; ?>">
            <br>
            <label for="employee_address">Address:</label>
            <input type="text" id="employee_address" name="employee_address" value="<?php echo $employee_address; ?>">
            <br>
            <label for="employee_mobile">Mobile:</label>
            <input type="text" id="employee_mobile" name="employee_mobile" value="<?php echo $employee_mobile; ?>">
            <br>
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="<?php echo $role; ?>">
            <br>
            <input type="submit" name="update_profile" value="Update Profile">
        </form>
    </div>

    <script>
    const toggleProfileBtn = document.getElementById('toggle-profile');
    const profile = document.querySelector('.profile');

    toggleProfileBtn.addEventListener('click', () => {
    profile.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
    if (!profile.contains(event.target) && !toggleProfileBtn.contains(event.target)) {
        profile.classList.remove('show');
    }
    });
    </script>
</body>
</html>