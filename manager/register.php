<?php 
include '../db.php'; 

$errors = array(
    'username' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => '',
    'mobile' => '',
    'role' => '',
    'address' => '',
    'userexit' => '',
    'unableToRegister' => '',
);

$successful = array(
    'registered' => '',
);

if(isset($_POST['register'])) {
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['role'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    

    // Validate user name
    if(empty($userName)) {
        $errors['username'] = 'Enter user name';
    }

    // Validate email
    if(empty($email)) {
        $errors['email'] = 'Enter email';
    } else {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email';
        }
    }

    // Validate password
    if(empty($password)) {
        $errors['password'] = 'Enter password';
    } else {
        if(strlen($password) < 8) {
            $errors['password'] = 'Password should have at least 8 characters';
        } 
    }

    // Validate confirm password
    if(empty($confirmPassword)) {
        $errors['confirmPassword'] = 'Confirm password';
    } else {
        if($password != $confirmPassword) {
            $errors['confirmPassword'] = 'Passwords do not match';
        }
    }

    // Validate mobile number
    if(empty($mobile)) {
        $errors['mobile'] = 'Enter mobile number';
    } else {
        if(!preg_match('/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/', $mobile)) {
            $errors['mobile'] = 'Invalid mobile number';
        }
    }

        // Validate address number
        if(empty($address)) {
            $errors['address'] = 'Enter address';
        }
                // Validate address number
                if(empty($role)) {
                    $errors['role'] = 'select role';
                }


    if(empty($errors['username']) && empty($errors['email'])) {
        $sql = "SELECT * FROM employee WHERE employee_name = ? OR employee_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userName, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $errors['userexit'] = 'Username or email already exists';
        }
        $stmt->close();
    }

// If no errors, proceed with database insertion
if(!array_filter($errors)) {
    $sql = "INSERT INTO employee (employee_name, employee_email, employee_password, employee_address, employee_mobile) VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql);
    if ($stmt1) {
        $stmt1->bind_param("sssss", $userName, $email, $password, $address, $mobile);
        if($stmt1->execute()) {
            $employee_id = $conn->insert_id; // Get the employee ID of the newly inserted employee
            $successful['registered'] = 'User registered successfully';

            // Insert role into userroles table
            $sql = "INSERT INTO userroles (user_id, role) VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql);
            if ($stmt2) {
                $stmt2->bind_param("is", $employee_id, $role);
                if($stmt2->execute()) {
                    // Role inserted successfully
                } else {
                    $errors['unableToRegister'] = 'Error: ' . $stmt2->error;
                }
                $stmt2->close();
            } else {
                $errors['unableToRegister'] = 'Error preparing statement: ' . $conn->error;
            }
        } else {
            $errors['unableToRegister'] = 'Error: ' . $stmt1->error;
        }
        $stmt1->close();
    } else {
        $errors['unableToRegister'] = 'Error preparing statement: ' . $conn->error;
    }
    $conn->close();
}
        header("Location: manager_dashboard.php");
        exit();
}
?>

<?php include 'templates/header.php'; ?>
<div class="d-flex">
<?php include 'templates/aside.php'; ?>
<div class="content mt-4">
    <div class="container p-3">
        <h2 class="text-center mb-4">Register</h2>
        <?php if($successful['registered']) : ?>
            <p class="text-success text-center"><?php echo $successful['registered']; ?></p>
        <?php endif; ?>
        <?php if($errors['userexit']) : ?>
            <p class="text-danger text-center"><?php echo $errors['userexit']; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">

                <div class="form-group">
                    <label for="userName">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" value="<?php echo isset($_POST['userName']) ? $_POST['userName'] : ''; ?>">
                    <p class="text-danger"><?php echo $errors['username']; ?></p>
                </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <p class="text-danger"><?php echo $errors['email']; ?></p>
            </div>
            <div class="row g-3 align-items-center">
                <div class="form-group col-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <p class="text-danger"><?php echo $errors['password']; ?></p>
                </div>
                <div class="form-group col-6">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                    <p class="text-danger"><?php echo $errors['confirmPassword']; ?></p>
                </div>
            </div>
            <div class="row g-3 align-items-center">
                <div class="form-group col-6">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ''; ?>">
                    <p class="text-danger"><?php echo $errors['mobile']; ?></p>
                </div>
                <div class="form-group col-6">
                    <label for="role">role</label>
                    <select name="role" class="form-control">
                        <option selected disabled class="text-center">---Select Role---</option>
                        <option value="employee" <?php echo (isset($_POST['role']) && $_POST['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
                        <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="department_manager" <?php echo (isset($_POST['role']) && $_POST['role'] == 'department_manager') ? 'selected' : ''; ?>>Department_manager</option>
                    </select>
                    <p class="text-danger"><?php echo $errors['role']; ?></p>
                </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
                    <p class="text-danger"><?php echo $errors['address']; ?></p>
                </div>

            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
        <?php if($successful['registered']) : ?>
            <p class="text-success"><?php echo $successful['registered']; ?></p>
        <?php endif; ?>
    </div>
</div>
</div>
<?php include 'templates/footer.php'; ?>
