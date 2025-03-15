<?php
include('../config/db.php');

$date = date('Y-m-d');

// Check database connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Function to execute query and handle errors
function fetchCount($conn, $query) {
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }
    return mysqli_num_rows($result);
}

// Fetch total employees
$results = mysqli_query($conn, "SELECT * FROM employee");
if (!$results) {
    die("Query Failed: " . mysqli_error($conn));
}
$empCount = mysqli_num_rows($results);

// Fetch attendance counts
    $presentCount = fetchCount($conn, "SELECT DISTINCT * FROM attendance WHERE AttendanceDate='$date'");
    $lateCount = fetchCount($conn, "SELECT DISTINCT * FROM attendance WHERE AttendanceDate='$date'");
    $absentCount = fetchCount($conn, "SELECT DISTINCT * FROM attendance WHERE AttendanceDate='$date'");

// Fetch attendance records
$run_attendance_query = mysqli_query($conn, "SELECT * FROM employee 
    INNER JOIN attendance ON employee.EmployeeId = attendance.EmployeeId 
    WHERE attendance.AttendanceDate='$date'");

if (!$run_attendance_query) {
    die("Query Failed: " . mysqli_error($conn));
}

$attendances = mysqli_fetch_all($run_attendance_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat-box {
            padding: 20px;
            width: 22%;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            color: white;
            font-weight: bold;
        }
        .stat-box.present { background: #4caf50; }
        .stat-box.late { background: #ff9800; }
        .stat-box.absent { background: #f44336; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #333;
            color: #fff;
        }
    </style>
</head>
<body>

<header class="header">
    <h2 class="u-name">EMPLOYEE <b>ATTENDANCE</b>
        <label for="checkbox">
            <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
        </label>
    </h2>
    <h3>Welcome, <?php echo isset($_SESSION['AdminName']) ? $_SESSION['AdminName'] : 'Admin'; ?></h3>
    <i class="fa fa-user" aria-hidden="true"></i>
</header>

<div class="body">
    <nav class="side-bar">
        <ul>
            <li><a href="dash.php"><i class="fa fa-desktop"></i><span>Dashboard</span></a></li>
            <li><a href="employee.php"><i class="fa fa-users"></i><span>Employee</span></a></li>
            <li><a href="attendance.php"><i class="fa fa-calendar"></i><span>Attendance</span></a></li>
            <li><a href="../auth/logout.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
        </ul>
    </nav>

    <section class="section-1">
        <div class="container">
            <h2>Attendance Overview - <?php echo $date; ?></h2>
            <div class="stats">
                <div class="stat-box present"><h3>Present</h3><p><?php echo $presentCount; ?></p></div>
                <div class="stat-box late"><h3>Late</h3><p><?php echo $lateCount; ?></p></div>
                <div class="stat-box absent"><h3>Absent</h3><p><?php echo $absentCount; ?></p></div>
            </div>

            <h2>Attendance Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendances)) { ?>
                        <?php foreach ($attendances as $index => $attendance) { ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $attendance['EmployeeId']; ?></td>
                                <td><?php echo $attendance['Name']; ?></td>
                                <td><?php echo ucfirst($attendance['Status']); ?></td>
                                <td><?php echo $attendance['TimeIn']; ?></td>
                                <td><?php echo $attendance['TimeOut']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="6">No attendance records found for today.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>
