<?php include '../db.php';

$errors = array(
    'unableToRegister' => ''
);

$successful = array(
    'vacated' => ''
);

if(isset($_POST['submit'])) {
    $employee_name = $_POST['employee_name'];
    $title = $_POST['title'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $reason = $_POST['reason'];

    // Get the employee ID from the employee table
    $sql = "SELECT employee_id FROM employee WHERE employee_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee_id = $result->fetch_assoc()['employee_id'];

    if($employee_id) {
        // Insert the vacation request into the vacation table
        $sql = "INSERT INTO vacation (employee_id, vacation_title, vacation_from_date, vacation_to_date, reason) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $employee_id, $title, $from, $to, $reason);
        if($stmt->execute()) {
            $successful['vacation'] = 'Employee vacation submit successfully';
            header("Location: emp_vacation.php" );
        }else {
            $errors['unableToRegister'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    }else {
        $errors['unableToRegister'] = 'Employee not found';
    }
    $conn->close();
}

?>

<?php include 'templates/header.php' ?>
<div class="d-flex">
<?php include 'templates/aside.php' ?>
    <div class="content">
            <div class="container-fluid mt-4">
                <h1 class="h3 mb-4 text-gray-800 text-center">Vacation Form</h1>
                <form action="emp_vac.php" method="post">
                <div class="form-group mb-3">
                    <label for="employee_name">Employee Name:</label>
                    <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Enter employee name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter your title" required>
                </div>
                <div class="form-group mb-3">
                    <label for="from">From:</label>
                    <input type="date" class="form-control" id="from" name="from" required>
                </div>
                <div class="form-group mb-3">
                    <label for="to">To:</label>
                    <input type="date" class="form-control" id="to" name="to" required>
                </div>
                <div class="form-group form-check mb-3">
                    <label class="form-check-label" for="rememberMe">Reason</label>
                    <textarea name="reason" id="reason" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">submit</button>
                </form>
            </div>
    </div>
</div>
<?php include 'templates/footer.php' ?>