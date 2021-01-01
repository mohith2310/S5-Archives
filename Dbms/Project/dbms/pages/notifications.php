<?php
session_start();
$arr=$_SESSION['arr'];
$rol_no=$arr['Student_ID'];
$connection=new mysqli('localhost','root','','hostel');
    $q1="SELECT * FROM room_requests WHERE sender_id='$rol_no' AND flag!='0'";
    $q1_res=mysqli_query($connection,$q1);
    $notif=array();
    $sub=array();
    foreach($q1_res as $a){
      $sub['sender']=$a['receiver_id'];
      $dum= $sub['sender'];
      $q1_1="SELECT * FROM STUDENTS WHERE Student_ID='$dum'";
      $q1_1_res=mysqli_fetch_array(mysqli_query($connection,$q1_1));
      $sub['sender_name']=$q1_1_res['full_name'];
      $sub['flag']=$a['flag'];
      $sub['n_id']='-1';
      if($a['flag']==1)
      $sub['msg']=$q1_1_res['full_name']." has accepted your room request";
      else
      $sub['msg']=$q1_1_res['full_name']." has rejected your room request";
      array_push($notif,$sub);
    }
    $q1="SELECT * FROM NOTICES WHERE student_id='$rol_no' OR student_id='1' ";
    $q1_res=mysqli_query($connection,$q1);
    foreach($q1_res as $a){
      $sub['sender']=$a['Admin_ID'];
      $sub['n_id']=$a['Notice_ID'];
      if($a['student_id']==1)
        $sub['flag']='-2';
      else
      $sub['flag']='-3';

      $dum= $sub['sender'];
      $q1_1="SELECT * FROM Admin WHERE Admin_ID='$dum'";
      $q1_1_res=mysqli_fetch_array(mysqli_query($connection,$q1_1));
      $sub['sender_name']=$q1_1_res['Fname']." ".$q1_1_res['Lname']." (Admin)";
      $sub['msg']=$a['Subject'];
      array_push($notif,$sub);
    }
   
//echo $arr['name'];
if(isset($_POST['clear'])){
  $s_id=$_POST['sender'];
  $flag=$_POST['flag'];
  $n_id=$_POST['n_id'];
  if($n_id!=-1 && $flag==-3){
    $q="DELETE FROM NOTICES WHERE Notice_ID='$n_id'";
    $sql=$connection->prepare($q);
    $sql->execute();
    header("Location:http://localhost/dbms/pages/notifications.php");
  }
  elseif($n_id!=-1 && $flag==-2){
    echo "You don't have rights to delete this feed..";
  }
  else{
    $q="DELETE FROM room_requests WHERE sender_id='$rol_no' AND receiver_id='$s_id'";
    $sql=$connection->prepare($q);
    $sql->execute();
    header("Location:http://localhost/dbms/pages/notifications.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  <div style="display: flex;max-width:60%;justify-content:center; margin-left:auto;margin-right:auto">
<table class="table table-hover">
  <thead>
  
    <tr>
    <th scope="col">#</th>
      <th scope="col">From</th>
      <th scope="col">ID</th>
      <th scope="col">Message</th>
      <th scope="col">Clear</th>
    </tr>
  </thead>
  <tbody>
  <?php $i=1; foreach($notif as $not){ ?>
    <form action="notifications.php" method="POST">
    <tr>
      <th scope="row"><?php echo $i;?></th>
      <td><?php echo $not['sender_name'];?></td>
      <input type="hidden" name="n_id" value="<?php echo $not['n_id'];?>">
      <input type="hidden" name="flag" value="<?php echo $not['flag'];?>">
      <td><input type="hidden" name="sender" value="<?php echo $not['sender'];?>"><?php echo $not['sender'];?></td>
      <td><?php echo $not['msg'];?></td>
      <td><input class="btn btn-primary" type="submit" name="clear" value="Clear"></td>
    </tr>
    </form>
    <?php $i=$i+1;}?>
  </tbody>
</table>
</div>
</main>



</body>
</html>