<?php include 'templates/header.php'?>
<div class="d-flex">
<?php include 'templates/aside.php'?>
<div class="content">
    <div class="container">
    <?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role']!= 'department_manager') {
    header("Location: manager_dashboard.php");
    exit();
}

include "../db.php";

// Set department ID based on user's role or ID
$departmentId = 0;


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // Retrieve user's department ID from database
    $sql = "SELECT ed.department_id 
            FROM employee e 
            JOIN employee_department ed ON e.employee_id = ed.employee_id 
            WHERE e.employee_id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $departmentId = $row['department_id'];
}

$employee_query = "SELECT COUNT(*) as total_employees
        FROM employee e
        JOIN employee_department ed ON e.employee_id = ed.employee_id
        JOIN department d ON ed.department_id = d.department_id
        JOIN userroles ur ON e.employee_id = ur.user_id
        WHERE d.department_id = '$departmentId'";
$employee_result = mysqli_query($conn, $employee_query);
$employee_row = mysqli_fetch_assoc($employee_result);
$total_employees = $employee_row['total_employees'];

// Get total number of departments
$department_query = "SELECT COUNT(*) as total_departments FROM department";
$department_result = mysqli_query($conn, $department_query);
$department_row = mysqli_fetch_assoc($department_result);
$total_departments = $department_row['total_departments'];

// Get total number of pending vacations
$vacation_query = "SELECT COUNT(*) as total_pending_vacations FROM vacation WHERE status = 'pending' AND employee_id = ". $_SESSION['user_id'];
$vacation_result = mysqli_query($conn, $vacation_query);
$vacation_row = mysqli_fetch_assoc($vacation_result);
$total_pending_vacations = $vacation_row['total_pending_vacations'];

// Close the database connection
mysqli_close($conn);

echo "<div style='font-size: 36px; text-align: center;'><i>Welcome, Manager</i> <b style='color:blue;'>". $_SESSION['user_name']. "</b></div>";

// Display statistical results
echo "<div class='row'>";
echo "<div class='col-md-4'>";
echo "<div class='card stat-card'>";
echo "<div class='card-body'>";
echo "<h5 class='card-title'style='color:green'>Total Employees</h5>";
echo "<p class='card-text'style='text-align: center;'>". $total_employees. "</p>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-4'>";
echo "<div class='card stat-card'>";
echo "<div class='card-body'>";
echo "<h5 class='card-title' style='color:red'>Total Departments</h5>";
echo "<p class='card-text' style='text-align: center;'>". $total_departments. "</p>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-4'>";
echo "<div class='card stat-card'>";
echo "<div class='card-body'>";
echo "<h5 class='card-title' style='color:blue'>Pending Vacations</h5>";
echo "<p class='card-text' style='text-align: center;'>". $total_pending_vacations. "</p>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

// Add employee-specific content here
?>
        <p class="text-center">Select an option from the menu.</p>
    </div>
        
    </div>
</div>
<?php include 'templates/footer.php'?>
<style>
    .stat-card {
    background-color: #f0f0f0;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-size: larger;
    font-weight: bold;
}

.stat-card.card-title {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 10px;
}

.stat-card.card-text {
    font-size: 24px;
    font-weight: bold;
    color: #337ab7;
}
</style>