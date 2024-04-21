<?php
  $con = mysqli_connect("localhost", "root", "", "admin");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login Panel</title>
  <link rel="stylesheet" href="CSS/adminLogin.css">
</head>
<body>
  
  <div class="container">
    <div class="myform">
      <form method="POST" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <h2>ADMIN LOGIN</h2>
        <input type="text" placeholder="Admin Name" name="AdminName">
        <input type="password" placeholder="Password" name = "AdminPass">
        <button type="submit" name = "login">LOGIN</button>
      </form>
    </div>
    <div class="image">
      <img src="images/image.jpg">
    </div>
  </div>


  <?php
    if(isset($_POST['login'])){
      $AdminName =  $_POST['AdminName'];
      $AdminPass = $_POST['AdminPass'];

      $query = "SELECT * FROM `admin_login` WHERE `Admin_Name` = ? AND `Admin_Password` = ?";

      if($stmt = mysqli_prepare($con, $query)){
        mysqli_stmt_bind_param($stmt, "ss", $AdminName, $AdminPass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt)==1){
            session_start();
            $_SESSION['AdminLoginId'] = $AdminName;
            header("location: Admin Panel.php");
        }
        else{
          echo "<script>alert('Invalid Admin Name or Password');</script>";
        }
        mysqli_stmt_close();
      }
      else{
        echo "<script>alert('SQL Query Not prepared');</script>";
      }
    }
  ?>

</body>
</html>