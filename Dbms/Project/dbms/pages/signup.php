<?php
     $flag=0;
    $errors=array();
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $roll=$_POST['roll'];
        $state=$_POST['state'];
        $email=$_POST['email'];
        $dob=$_POST['dob'];
        $phn=$_POST['phone'];
        $password=$_POST['password'];
        $gender=$_POST['gender'];

        $connection=new mysqli('localhost','root','','hostel');
        if(!($connection))
        echo 'connection error';

       // echo $name;
        $check_roll="SELECT * FROM STUDENTS WHERE Student_ID='$roll'";
        $check_mail="SELECT * FROM STUDENTS WHERE mail='$email'";
        $result_roll=mysqli_query($connection,$check_roll);
        $result_mail=mysqli_query($connection,$check_mail);
       
        if(mysqli_fetch_array($result_roll)){
          $errors['roll']="User with this roll number already exists";
          $flag=1;
        }
        if(mysqli_fetch_array($result_mail)){
          $errors['mail']="This mail is already in use..";
          if($flag)
          $flag=3;
          $flag=2;
          echo "Working";
        }

        if($flag==0){
        $sql=$connection->prepare("INSERT INTO STUDENTS (full_name,PhoneNo,Student_ID,DOB,mail,password,gender,State)
        VALUES('$name','$phn','$roll','$dob','$email','$password','$gender','$state')");
        $sql->execute();
        echo 'Data inserted successfully';
        $connection->close();

       header("Location:http://localhost/dbms/pages/index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
   
           
    <div class="container">
      
      <div class="img">
			<img src="../img/signup.svg">
    </div>
        <div class="login-content" >
			<form action="signup.php" autocomplete="off" method="POST">
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Full name</h5>
           		   		<input type="text" name="name"class="input" required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-phone"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Phone number</h5>
           		   		<input type="text" name="phone"class="input" required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-id-badge"></i>
           		   </div>
           		   <div class="div">
           		   		
           		   		<input type="text" name="roll"class="input" required>
                  </div>
                  <br>
          <small class="error" style="color:red"><?php
          if($flag==1 || $flag==3)
            echo $errors['roll']?></small>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-search-location"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>State</h5>
           		   		<input type="text" name="state"class="input" required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="far fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input type="email" name="email"class="input" required>
                  </div>
                  <br>
           <small class='error' style="color:red"> <?php
           if($flag==2|| $flag==3)
            echo $errors['mail']?> </small>
               </div>
               <div class="input-div">
           		   <div class="i"> 
           		    	<i class="fas fa-birthday-cake"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Date of Birth</h5>
           		    	<input type="date" name="dob" class="input" required>
                   </div>
                </div>
                <div class="input-div">
           		   <div class="i"> 
                  <i class="fas fa-male"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Gender</h5>
           		    	<input type="text" name="gender" class="input" required>
                   </div>
                   
                </div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" name="password" class="input" required>
                   </div>
                </div>
              
              <input type="submit" class="btn" name='submit'value=Proceed>
            </form>
        </div>
     
    </div>
    <script src="../main.js"></script>
</body>
</html>