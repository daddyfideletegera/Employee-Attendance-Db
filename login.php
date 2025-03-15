<?php 
include('../config/db.php');
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin where AdminName = '$username' AND Password ='$password'";
    $runsql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($runsql) > 0){
        $row = mysqli_fetch_assoc($runsql);
        $_SESSION['AdminName'] = $row['AdminName'];
        $_SESSION['Password'] = $row['Password'];

        echo "<script>alert('Login Successful'); window.location.href='../dashboard/dash.php';</script>";
    } else {
        echo "<script>alert('Login Unsuccessful'); window.location.href='login.php';</script>";
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/all.css">
    
</head>
<body>
    <div class="form">
        <form action="login.php" method="POST">
            <div class="input">
                <p>EMPLOYEE ATTENDANCE DATABASE </p>
            </div>
        
            <div class="input">
                <label for="">UserName:</label><br>
                <input type="text" name="username" required>                
            </div>
            <div class="input">
                <label for="">Password:</label><br>
                <input type="password" name="password" required>
            </div>
            <div class="input">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>