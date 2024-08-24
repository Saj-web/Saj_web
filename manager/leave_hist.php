<?php 
    session_start();

    include '../db.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'department_manager') {
        header("Location: manager_dashboard.php");
        exit();
    }

    $current_manager_id = $_SESSION['user_id'];

    $sql = "SELECT  v.vacation_title, v.vacation_from_date, v.vacation_to_date, v.reason, v.status
    FROM vacation v
    WHERE v.employee_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $current_manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $vacations = [];

    while($row = mysqli_fetch_assoc($result)) {
        $vacations[] = $row;
    }

?>

<?php include 'templates/header.php'; ?>
<div class="d-flex">
    <?php include 'templates/aside.php'; ?>
    <div class="content mt-3">
        <div class="container p-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h2 class="text-center display-6 mb-4">My Vacation Requests</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th>Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Reasons</th>
                                        <th>Status</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($vacations as $vacation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($vacation['vacation_title']); ?></td>
                                        <td><?php echo htmlspecialchars($vacation['vacation_from_date']); ?></td>
                                        <td><?php echo htmlspecialchars($vacation['vacation_to_date']); ?></td>
                                        <td><?php echo htmlspecialchars($vacation['reason']); ?></td>
                                        <td><?php echo htmlspecialchars($vacation['status']); ?></td>

                                        
                                    </tr>
                <?php endforeach; ?>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php include 'templates/footer.php'; ?>