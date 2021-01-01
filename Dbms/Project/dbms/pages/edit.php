<?php
session_start();
$arr=$_SESSION['arr'] ;
   if(isset($_POST['update'])){
       $name=$_POST['name'];
       $roll=$_POST['roll'];
       $state=$_POST['state'];
       $email=$_POST['email'];
       $dob=$_POST['dob'];
       $password=$_POST['password'];
       $gender=$_POST['gender'];
       $phn=$_POST['phone'];

       $connection=new mysqli('localhost','root','','hostel');
       if(!($connection))
       echo 'connection error';

        $query="UPDATE STUDENTS SET gender='$gender',full_name='$name',DOB='$dob',
        PhoneNo='$phn',State='$state' WHERE Student_ID='$roll'"  ;
       $sql=$connection->prepare($query);
       $sql->execute();
     //  echo 'Data inserted successfully';
       $sql->close();
      // $connection->close();
      $arr=array();
      $check_mail="SELECT * FROM STUDENTS WHERE mail='$email'";
        $result_mail=mysqli_query($connection,$check_mail);
        $arr=mysqli_fetch_array($result_mail);
          $_SESSION['arr'] = $arr;
        //  print_r($_SESSION['arr']);
       header("Location:http://localhost/dbms/pages/profile.php");
      }
   

//echo $arr['name'];
//session_destroy(); 
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile1.css">
</head>
<body>
    
<nav class="navbar">
<a href="#" class="brand">
              <!-- //  <img src="https://image.flaticon.com/icons/svg/753/753354.svg" alt="logo"> -->
           </a>
  <!--toggler-->
  <button class="toggler">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>

  <div class="nav-list-container">
    <ul class="nav-list">
    <li><a href="student_main.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="index.php">Log Out</a></li>
    </ul>
  </div>
</nav>

<main>
 
<div  class="contain">
      <!-- <div class="forms-container"> -->
      <div class="img">
			<img src="../img/signup.svg">
    </div>
        <div class="login-content" >
			<form action="edit.php" autocomplete="off" method="POST">
           		<div class="input-div one">
           		   <div class="i">
                              <i class="fas fa-user"></i>
                              
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="name"class="input" value=<?php echo $arr['full_name'];?> required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-phone"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="phone"class="input" value=<?php echo $arr['PhoneNo'];?> required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-id-badge"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="roll"class="input" value=<?php echo $arr['Student_ID'];?> readonly>
                  </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-search-location"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="state"class="input" value=<?php echo $arr['State'];?> required>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="far fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="email" name="email"class="input" value=<?php echo $arr['mail'];?> readonly>
                  </div>
               </div>
               <div class="input-div">
           		   <div class="i"> 
           		    	<i class="fas fa-birthday-cake"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="date" name="dob" class="input" value=<?php echo $arr['DOB'];?> required>
                   </div>
                </div>
                <div class="input-div">
           		   <div class="i"> 
                  <i class="fas fa-male"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="text" name="gender" class="input" value=<?php echo $arr['gender'];?> required>
                   </div>
                   
                </div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="text" name="password" class="input" value=<?php echo $arr['password'];?> required>
                   </div>
                </div>
              
              <input type="submit" class="btn" name='update'value=Update>
            </form>
        </div>
       <!-- </div>  -->
</div>
</main>

<script >
    const toggler = document.querySelector('.navbar > .toggler'),
  navListContainer = document.querySelector('.navbar > .nav-list-container');

/*when toggler button is clicked*/
toggler.addEventListener(
  "click",
  () => {
    //convert hamburger to close
    toggler.classList.toggle('cross');
    //make nav visible
    navListContainer.classList.toggle('nav-active');
  },
  true
);

</script>
<script src="../main.js"></script>
</body>
</html>