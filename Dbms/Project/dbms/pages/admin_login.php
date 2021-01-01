<?php
session_start();

$er='';
    if(isset($_POST['login'])){
      $mail=$_POST['email'];
      $pass=$_POST['password'];
      $connection=new mysqli('localhost','root','','hostel');
        if(!($connection))
        echo 'connection error';
        $check_mail="SELECT * FROM Admin WHERE Mail='$mail'";
        $result_mail=mysqli_query($connection,$check_mail);
        $arr=mysqli_fetch_array($result_mail);
        if($arr && $arr['password']==$pass){
          $_SESSION['arr'] = $arr;
          header("Location:http://localhost/dbms/pages/admin_land.php");
         
        }
        else{
          $er="Invalid Login..Please enter the correct details..";
        }

    }
    if(isset($_POST['alter'])){
        header("Location:http://localhost/dbms/pages/index.php");
    }
    // $sen="Login as".$role2;
    // echo $sen;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
    <div class="container">
		<div class="img">
			<img src="../img/admin1.svg">
    </div>
    
		<div class="login-content" >
			<form action="admin_login.php" autocomplete="off" method="POST">
				<img src="../img/avatar.svg">
                <h2 class="title">ADMIN</h2>
                <br>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Admin-ID</h5>
           		   		<input type="text" name="email"class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" name="password" class="input">
                   </div>
                </div>
                <small class="error" style="color:red"><?php
          if($er)
            echo $er
            ?></small>
                <br>
              <input type="submit" class="btn" name='login'value=Login>
              <input type="submit" class="btn" name='alter'value='Login as Student'>
            </form>
        </div>
    </div>
    <script src="../main.js"></script>
</body>
</html>