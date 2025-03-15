<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include authentication & database connection
include("../auth/auth.php");
include("../config/db.php");

// Ensure `id` is valid
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("<script>alert('Invalid Employee ID'); window.location.href = './employee.php';</script>");
}

// Fetch employee data using prepared statements
$stmt = $conn->prepare("SELECT * FROM employee WHERE EmployeeId = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// Check if employee exists
if (!$data) {
    die("<script>alert('Employee not found'); window.location.href = './employee.php';</script>");
}

// Handle form submission
if (isset($_POST['edit'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $phone = htmlspecialchars($_POST['phone']);
    $department = htmlspecialchars($_POST['department']);

    // Validate input
    if (empty($fname) || empty($lname) || empty($gender) || empty($dob) || empty($phone) || empty($department)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Update employee data using prepared statements
        $stmt = $conn->prepare("UPDATE employee SET FirstName=?, LastName=?, Gender=?, DOB=?, PhoneNumber=?, Department=? WHERE EmployeeId=?");
        $stmt->bind_param("ssssssi", $fname, $lname, $gender, $dob, $phone, $department, $id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Employee updated successfully!');
                window.location.href = './employee.php';
            </script>";
        } else {
            echo "<script>alert('Error updating employee: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../scss/style.css">
</head>
<body>
    <div class="form-cont">
        <h1>Edit Employee</h1>
        <form action="" class="form-style" method="post">
            <div>
                <label for="fname">First Name:</label>
                <input type="text" value="<?php echo htmlspecialchars($data['FirstName']); ?>" required name="fname">
            </div>
            <div>
                <label for="lname">Last Name:</label>
                <input type="text" value="<?php echo htmlspecialchars($data['LastName']); ?>" required name="lname">
            </div>
            <div>
                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option disabled>Choose your gender</option>
                    <option value="male" <?php if ($data['Gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($data['Gender'] == 'female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div>
                <label for="dob">Date of Birth:</label>
                <input type="date" value="<?php echo htmlspecialchars($data['DOB']); ?>" required name="dob">
            </div>
            <div>
                <label for="phone">Phone Number:</label>
                <input type="tel" value="<?php echo htmlspecialchars($data['PhoneNumber']); ?>" required name="phone">
            </div>
            <div>
                <label for="department">Department:</label>
                <input type="text" value="<?php echo htmlspecialchars($data['Department']); ?>" required name="department">
            </div>
            <button name="edit">Edit Employee</button>
        </form>
        <a href="./employee.php">Go Back</a>
    </div>
</body>
</html>
