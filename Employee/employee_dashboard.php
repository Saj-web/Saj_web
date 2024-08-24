<?php include 'templates/header.php'?>
<div class="d-flex">
<?php include 'templates/aside.php'?>
<div class="content">
    <div class="container">
    <?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role']!= 'employee') {
    header("Location: employee_dashboard.php");
    exit();
}

 include "../db.php";

// Get total number of accepted vacations
$vacation_query = "SELECT COUNT(*) as total_accepted_vacations  FROM vacation WHERE status = 'accepted' AND employee_id = ". $_SESSION['user_id'];
$vacation_result = mysqli_query($conn, $vacation_query);
$vacation_row = mysqli_fetch_assoc($vacation_result);
$total_accepted_vacations  = $vacation_row['total_accepted_vacations']; 

// Get total number of rejected vacations
$vacation_query = "SELECT COUNT(*) as total_rejected_vacations  FROM vacation WHERE status = 'rejected' AND employee_id = ". $_SESSION['user_id'];
$vacation_result = mysqli_query($conn, $vacation_query);
$vacation_row = mysqli_fetch_assoc($vacation_result);
$total_rejected_vacations  = $vacation_row['total_rejected_vacations']; 

// Get total number of pending vacations
$vacation_query = "SELECT COUNT(*) as total_pending_vacations FROM vacation WHERE status = 'pending' AND employee_id = ". $_SESSION['user_id'];
$vacation_result = mysqli_query($conn, $vacation_query);
$vacation_row = mysqli_fetch_assoc($vacation_result);
$total_pending_vacations = $vacation_row['total_pending_vacations'];

// Close the database connection
mysqli_close($conn);

echo "<div style='font-size: 36px; text-align: center;'><i>Welcome, Employee</i> <b style='color:blue;'>". $_SESSION['user_name']. "</b></div>";

// Display statistical results
echo "<div class='row'>";
echo "<div class='col-md-4'>";
echo "<div class='card stat-card'>";
echo "<div class='card-body'>";
echo "<h5 class='card-title' style='color:green'>Accepted Vacations</h5>";
echo "<p class='card-text'style='text-align: center;'>". $total_accepted_vacations. "</p>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-4'>";
echo "<div class='card stat-card'>";
echo "<div class='card-body'>";
echo "<h5 class='card-title'style='color:red'>Rejected Vacations</h5>";
echo "<p class='card-text'style='text-align: center;'>". $total_rejected_vacations. "</p>";
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