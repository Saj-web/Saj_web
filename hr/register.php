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
    'department' => '',
    'userexit' => '',
    'unableToRegister' => '',
);

$successful = array(
    'registered' => '',
);

if (isset($_POST['register'])) {
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];

    // Validate user name
    if (empty($userName)) {
        $errors['username'] = 'Enter employee name';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Enter email';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email';
        }
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Enter password';
    } else {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password should have at least 8 characters';
        }
    }

    // Validate mobile number
    if (empty($mobile)) {
        $errors['mobile'] = 'Enter mobile number';
    } else {
        if (!preg_match('/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/', $mobile)) {
            $errors['mobile'] = 'Invalid mobile number';
        }
    }

    // Validate address
    if (empty($address)) {
        $errors['address'] = 'Enter address';
    }

    // Validate role
    if (empty($role)) {
        $errors['role'] = 'Select role';
    }

    // Validate department
    if (empty($department)) {
        $errors['department'] = 'Select department';
    }

    if (empty($errors['username']) && empty($errors['email'])) {
        $sql = "SELECT * FROM employee WHERE employee_name = ? OR employee_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userName, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors['userexit'] = 'Employee Name or email already exists';
        }
        $stmt->close();
    }

    // If no errors, proceed with database insertion
    if (!array_filter($errors)) {
        $sql = "INSERT INTO employee (employee_name, employee_email, employee_password, employee_address, employee_mobile) VALUES (?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bind_param("sssss", $userName, $email, $password, $address, $mobile);
        $stmt1->execute();
        $employee_id = $conn->insert_id; // Get the employee ID of the newly inserted employee
        $successful['registered'] = 'User registered successfully';

        // Insert role into userroles table
        $sql = "INSERT INTO userroles (user_id, role) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("is", $employee_id, $role);
        $stmt2->execute();

        // Insert department into employee_department table
        $sql = "INSERT INTO employee_department (employee_id, department_id) VALUES (?, ?)";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bind_param("ii", $employee_id, $department);
        $stmt3->execute();

        $stmt2->close();
        $stmt3->close();
        $stmt1->close();
        $conn->close();
    }
    header("Location: register.php");
    exit;
}
?>

<?php include 'templates/header.php'; ?>
<div class="d-flex">
    <?php include 'templates/aside.php'; ?>
    <div class="content mt-4">
        <div class="container p-3">
            <h2 class="text-center mb-4">Register</h2>
            <?php if ($successful['registered']) : ?>
                <p class="text-success text-center"><?php echo $successful['registered']; ?></p>
            <?php endif; ?>
            <?php if ($errors['userexit']) : ?>
                <p class="text-danger text-center"><?php echo $errors['userexit'];?></p>
            <?php endif;?>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="userName">Employee Name:</label>
                    <input type="text" class="form-control" id="userName" name="userName" value="<?php echo isset($_POST['userName'])? $_POST['userName'] : '';?>">
                    <?php if ($errors['username']) :?>
                        <p class="text-danger"><?php echo $errors['username'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : '';?>">
                    <?php if ($errors['email']) :?>
                        <p class="text-danger"><?php echo $errors['email'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php if ($errors['password']) :?>
                        <p class="text-danger"><?php echo $errors['password'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="hr_manager">HR Manager</option>
                        <option value="department_manager">Department Manager</option>
                        <option value="employee">Employee</option>
                    </select>
                    <?php if ($errors['role']) :?>
                        <p class="text-danger"><?php echo $errors['role'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="department">Department:</label>
                    <select class="form-control" id="department" name="department">
                        <option value="">Select Department</option>
                        <option value="1">CPS</option>
                        <option value="2">IT</option>
                    </select>
                    <?php if ($errors['department']) :?>
                        <p class="text-danger"><?php echo $errors['department'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address'])? $_POST['address'] : '';?>">
                    <?php if ($errors['address']) :?>
                        <p class="text-danger"><?php echo $errors['address'];?></p>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($_POST['mobile'])? $_POST['mobile'] : '';?>">
                    <?php if ($errors['mobile']) :?>
                        <p class="text-danger"><?php echo $errors['mobile'];?></p>
                    <?php endif;?>
                </div>

                <button type="submit" name="register" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/footer.php';?>