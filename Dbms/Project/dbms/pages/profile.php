<?php
session_start();
    $arr=$_SESSION['arr'] ;
    $connection=new mysqli('localhost','root','','hostel');
    $id=$arr['Student_ID'];
    $f=0;
    if($arr['Hostel_ID']!=NULL){
      $hostel=$arr['Hostel_ID'];
      $room=$arr['Room_No'];
      $q="SELECT  Hostel_name FROM HOSTELS WHERE Hostel_ID='$hostel'";
      $h=mysqli_fetch_array(mysqli_query($connection,$q));
      $hostel=$h['Hostel_name'];
      $f=1;
    }
    if($arr['Roomate_ID']!=NULL){
      $r_id=$arr['Roomate_ID'];
      $q="SELECT * FROM STUDENTS WHERE Student_ID='$r_id'";
      $r=mysqli_fetch_array(mysqli_query($connection,$q));
      $r_name=$r['full_name'];
      $r_phone=$r['PhoneNo'];
      $f=2;
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
  <!--brand image-->
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
           		   		<input type="text" name="name"class="input" value=<?php echo $arr['full_name'];?> readonly>
           		   </div>
               </div>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-phone"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="phone"class="input" value=<?php echo $arr['PhoneNo'];?> readonly>
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
               <?php if($f==1 || $f==2){?>
                <div class="input-div one">
           		   <div class="i">
                              <i class="fa fa-building"></i>     
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="hostel"class="input" value=<?php echo $hostel;?> readonly>
           		   </div>
               </div>
               <div class="input-div one">
           		   <div class="i">
                  <i class="fa fa-credit-card" aria-hidden="true"></i>
   
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="room"class="input" value=<?php echo $room;?> readonly>
           		   </div>
               </div>
               
               <?php } ?>
               <?php if($f==2){?>
                <div class="input-div one">
           		   <div class="i">
                  <i class="fa fa-users" aria-hidden="true"></i>
   
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="roomie_n"class="input" value=<?php echo $r_name;?> readonly>
           		   </div>
               </div>
               <div class="input-div one">
           		   <div class="i">
                  <i class="fa fa-credit-card" aria-hidden="true"></i>
   
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="room"class="input" value=<?php echo $room;?> readonly>
           		   </div>
               </div>
               
               <?php } ?>
               <div class="input-div">
           		   <div class="i">
           		   		<i class="fas fa-search-location"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" name="state"class="input" value=<?php echo $arr['State'];?> readonly>
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
           		    	<input type="date" name="dob" class="input" value=<?php echo $arr['DOB'];?> readonly>
                   </div>
                </div>
                <div class="input-div">
           		   <div class="i"> 
                  <i class="fas fa-male"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="text" name="gender" class="input" value=<?php echo $arr['gender'];?> readonly>
                   </div>
                   
                </div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="password" name="password" class="input" value=<?php echo $arr['password'];?> readonly>
                   </div>
                </div>
              
              <input type="submit" class="btn" name='Edit'value=Edit>
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