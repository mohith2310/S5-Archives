<?php
session_start();
    $arr=$_SESSION['arr'] ;
    $connection=new mysqli('localhost','root','','hostel');
    $rol_no=$arr['Student_ID'];
    $noti_q="SELECT * FROM NOTICES WHERE student_id='0'";
    $result_n=mysqli_fetch_array(mysqli_query($connection,$noti_q));
    $next=0;
    if($result_n!=NULL){
      $next=1;
    }
    $req_q="SELECT * FROM room_requests WHERE receiver_id='$rol_no'";
    $r_req=mysqli_query($connection,$req_q);
    $requests=array();
    $sub=array();
    foreach($r_req as $ar){
      $sender=$ar['sender_id'];
      $q="SELECT * FROM STUDENTS WHERE Student_ID='$sender'";
      $an=mysqli_fetch_array(mysqli_query($connection,$q));
      $sub['roll']=$sender;
      $sub['name']=$an['full_name'];
      array_push($requests,$sub);
    }
    
    $count_req_q="SELECT COUNT(*) FROM room_requests WHERE receiver_id='$rol_no' AND flag='0'";
    $count_r_req=mysqli_fetch_array(mysqli_query($connection,$count_req_q));
    
    $stu_q="SELECT * FROM STUDENTS WHERE Student_ID='$rol_no'";
      $student=mysqli_fetch_array(mysqli_query($connection,$stu_q));
      $snack_text="";
    if(isset($_POST['submit'])){
      $s_name=$arr['full_name'];
      $roll=$arr['Student_ID'];
      $room_no=$arr['Room_No'];
      $Admin=$arr['Admin_ID'];
      $h_id=$arr['Hostel_ID'];

      $msg=$_POST['msg'];
      $sql=$connection->prepare("INSERT INTO COMPLAINTS(Complaint_Status,Student_ID,Subject,Admin_ID,Hostel_ID,room_no) 
      VALUES('0','$roll','$msg','$Admin','$h_id','$room_no')");
      $sql->execute();
      //echo 'Data inserted successfully';
      $sql->close();
      $snack_text="Complaint sent...";
    }


$f1=0;

if($next==1){
  $f1=0;
    if(isset($_POST['Proceed'])){
      $roomie_id= $_POST['roomie_id'];
      $hostel= $_POST['hostel'];
      $you=$arr['Student_ID'];
      $roomie_q="SELECT * FROM STUDENTS WHERE Student_ID='$roomie_id'";
      $hostel_q="SELECT * FROM HOSTELS WHERE Hostel_name='$hostel'";
      $rom_res=mysqli_query($connection,$roomie_q);
      $rom_res=mysqli_fetch_array($rom_res);
      $vacant=mysqli_query($connection,$hostel_q);
      $vacant=mysqli_fetch_array($vacant);
      if($rom_res['Roomate_ID']==NULL && $vacant['Vacant_rooms']!=0 ){
        if($student['Roomate_ID'])
        $snack_text="You are already Paired..";
        else{
      $sql=$connection->prepare("INSERT INTO room_requests(sender_id,receiver_id) VALUES('$you','$roomie_id')");
      $sql->execute();
      
      $room_no=$vacant['No_of_rooms']-$vacant['Vacant_rooms']+1;
      $hos_id=$vacant['Hostel_ID'];
      $snack_text="Response recorded and room request sent...";
      if($student['Hostel_ID']==NULL && $student['Room_No']==NULL){
      $upd_cand="UPDATE STUDENTS SET Hostel_ID='$hos_id',Room_No='$room_no' WHERE Student_ID='$you'";
      $temp=$vacant['Vacant_rooms']-1;
      $upd_host="UPDATE HOSTELS SET Vacant_rooms='$temp' WHERE Hostel_ID='$hos_id'";
      $sql=$connection->prepare($upd_cand);
      $sql->execute();
      $sql=$connection->prepare($upd_host);
      $sql->execute();
      $upd_room="UPDATE ROOM SET Vacancies='1' WHERE Hostel_ID='$hos_id' AND Room_No='$room_no'";
      $sql=$connection->prepare($upd_room);
      $sql->execute();
      }
    }
  }
      
      elseif($rom_res['Roomate_ID'])
      $snack_text="Student already Paired..";
      elseif($student['Roomate_ID'])
      $snack_text="You are already Paired..";
      else
      $snack_text="Hostel has no vacencies..";
      $f1=1;
    }
  
      //echo $arr['name'];
      $curr_year = date("Y"); 
      $curr_month=date("m");
      #echo $curr_month;
      $curr_year=substr($curr_year,2,4);
      $stu_year=$arr['Student_ID'];
      $stu_year=substr($stu_year,1,2);
      $batch=(int)$curr_year-(int)$stu_year;
      if($curr_month>7) $batch=$batch+1;
      $connection=new mysqli('localhost','root','','hostel');
      $check="SELECT *  FROM HOSTELS WHERE Batch='$batch'";
      $result=mysqli_query($connection,$check);
     // $array=mysqli_fetch_array($result_mail);
     $i=0;
     $array=array();
      while($row = mysqli_fetch_array($result)) {
         // print_r($row);
          $array[$i]=$row['Hostel_name'];
          $i=$i+1;
      }
      $i=0;
      $roomate_q="SELECT * FROM STUDENTS WHERE Student_ID LIKE '_$stu_year%'";
      $rresult=mysqli_query($connection,$roomate_q);
      $roomies=array();
      while($row = mysqli_fetch_array($rresult)) {
        // print_r($row);
        if($row['Student_ID']!=$arr['Student_ID']){
         $roomies[$i]=$row['Student_ID'];
         $i=$i+1;
        }
     }
    
    if(isset($_POST['accept'])){
      $mate_id= $_POST['mate_id'];
      $q="SELECT * FROM STUDENTS WHERE Student_ID='$mate_id'";
      $res_q=mysqli_fetch_array(mysqli_query($connection,$q));
      $q1="UPDATE room_requests SET flag='1' WHERE sender_id='$mate_id' AND receiver_id='$rol_no'";
      $sql=$connection->prepare($q1);
      $sql->execute();
      $q1="UPDATE room_requests SET flag='-1' WHERE sender_id!='$mate_id' AND receiver_id='$rol_no'";
      $sql=$connection->prepare($q1);
      $sql->execute();
      $r_no=$res_q['Room_No'];
      $h_id=$res_q['Hostel_ID'];
      $q2="UPDATE STUDENTS SET Hostel_ID='$h_id',Roomate_ID='$mate_id',Room_No='$r_no' WHERE Student_ID='$rol_no'" ;
      $sql=$connection->prepare($q2);
      $sql->execute();
      $q2="UPDATE STUDENTS SET Roomate_ID='$rol_no' WHERE Student_ID='$mate_id'";
      $sql=$connection->prepare($q2);
      $sql->execute();
      $q3="UPDATE ROOM SET Vacancies='0' WHERE Hostel_ID='$h_id' AND Room_No='$r_no'";
      $sql=$connection->prepare($q3);
      $sql->execute();
      header("Location:http://localhost/dbms/pages/student_main.php");

    }
    if(isset($_POST['reject'])){
    
      $mate_id= $_POST['mate_id'];
      $q1="UPDATE room_requests SET flag='-1' WHERE sender_id='$mate_id' AND receiver_id='$rol_no'";
      echo $q1;
      $sql=$connection->prepare($q1);
      $sql->execute();
    
      header("Location:http://localhost/dbms/pages/student_main.php");
    }
    
   
  }
  $q="SELECT * FROM STUDENTS WHERE Student_ID='$rol_no'";
  $q_res=mysqli_fetch_array(mysqli_query($connection,$q));
  if($q_res['Admin_ID']==NULL && $q_res['Hostel_ID']){
    $ho_id=$q_res['Hostel_ID'];
    $q="SELECT * FROM HOSTELS WHERE Hostel_ID='$ho_id'";
    $ad=mysqli_fetch_array(mysqli_query($connection,$q));
    $ad_id=$ad['Admin_ID'];
    $q2="UPDATE STUDENTS SET Admin_ID='$ad_id' WHERE Student_ID='$rol_no'" ;
    $sql=$connection->prepare($q2);
    $sql->execute();
    $q="SELECT * FROM STUDENTS WHERE Student_ID='$rol_no'";
    $q_res=mysqli_fetch_array(mysqli_query($connection,$q));
  }
  $_SESSION['arr']=$q_res;
  if($q_res['Hostel_ID']!=NULL){
    $ad_id=$q_res['Admin_ID'];
    $updates_q="SELECT * FROM NOTICES WHERE student_id='1' AND Admin_ID='$ad_id'";
    $result_updates=mysqli_query($connection,$updates_q);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/landing1.css" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar">
  <!--brand image-->
  <a href="#" class="brand">
                <!-- <img src="https://image.flaticon.com/icons/svg/753/753354.svg" alt="logo"> -->
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
    <div class="heading" >
        <!-- just to make scrolling effect possible -->
      <img src="http://localhost/dbms/img/bg.svg" alt=""> 
      <div class="content">
        <h2 class="myH2">Welcome, <?php echo $arr['full_name']?></h2>
        <?php
      if($result_n!=NULL){ ?>
     <input data-toggle="modal" data-target="#myModal" type="submit" class='mybtn' name="choose" value="Hostel update">
       
       <?php }?>
        
        <?php if($count_r_req[0]){?>
        <input data-toggle="modal" data-target="#myModal_tab"type="submit" class='mybtn' name="choose" value="Check Requests">
        <?php }?>  
    </div>
      <!-- <h4 class="myH4">Notifications</h4> -->
    
    </div>
    
    <div>  

      <div class="container">
 <!-- The Modal -->
 <div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h1 class="modal-title">Welcome</h1>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="display:flex; justify-content:center;padding:2%">
        <div class="form">
    <form action="student_main.php" method="POST">
        <div style="width:25%">
      <select name="hostel"  required >
        <?php if($student['Hostel_ID']==NULL){?>
        <option selected>Pick an Hostel</option>
        <?php foreach ($array as $num) : ?>
        <option ><?= htmlspecialchars($num) ?></option>
        <?php endforeach ?>
        <?php }else{?>
        <option selected><?php $dum=$student['Hostel_ID'];
        $q="SELECT * FROM HOSTELS WHERE Hostel_ID='$dum'";
                              $ans=mysqli_fetch_array(mysqli_query($connection,$q));
                              echo $ans['Hostel_name'];      }?></option>
      </select>
    </div>
    <br>
    <div >
        <datalist id="suggestions">
            <?php foreach ($roomies as $num) :?>
        <option ><?= htmlspecialchars($num) ?></option>
        <?php endforeach ?>
        </datalist>
        <input  autoComplete="off" name="roomie_id"  placeholder="search for roomie with id.."list="suggestions"/>     
    
  </div>
  <br>
  <input type="submit" name="Proceed"  value="Proceed" />
   </form>
   </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div> 
  <div class="modal" id="myModal_tab">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h1 class="modal-title">Rooms Requests</h1>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="display:flex; justify-content:center;padding:2%">
        <div class="container">
  
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>From</th>
        <th>ID</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    
      <?php $i=1; foreach($requests as $r){?>
        <form action="student_main.php" method="POST">
      <tr>
        <td><?php echo $i?></td>
        <td><?php echo $r['name']?></td>
        <td><input name="mate_id" type="hidden" value="<?php echo $r['roll']?>"><?php echo $r['roll']?></td>
        <td><input type="submit" name="accept" class="btn btn-sm  btn-link"value="Accept" style="position:relative;top:-5px">
        <span style="position:relative;top:-5px">(or)</span>
        <input type="submit" name="reject" class="btn  btn-sm btn-link"value="Reject" style="position:relative;top:-5px"></td>
        </form>
      </tr>
      </form>
      <?php $i=$i+1;}?>
     
    </tbody>
  </table>
  </div>
</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
  
</div>  
      </div>
      </div>	
    </div>
    
    <div class="complaint">
    
    <!-- <button class="open-button fas fa-comments" aria-hidden="true" onclick="openForm()">Chat</button> -->
    <script>var flag=true; </script>
    <div id="toggle"class="chat" onclick="classList.toggle('active'); function fun_toggle(){ flag? openForm() : closeForm();} fun_toggle();">
      <div class="background" ></div>
      <svg class="chat-bubble" width="100" height="100" viewBox="0 0 100 100">
        <g class="bubble">
          <path class="line line1" d="M 30.7873,85.113394 30.7873,46.556405 C 30.7873,41.101961
          36.826342,35.342 40.898074,35.342 H 59.113981 C 63.73287,35.342
          69.29995,40.103201 69.29995,46.784744" />
          <path class="line line2" d="M 13.461999,65.039335 H 58.028684 C
            63.483128,65.039335
            69.243089,59.000293 69.243089,54.928561 V 45.605853 C
            69.243089,40.986964 65.02087,35.419884 58.339327,35.419884" />
        </g>
        <circle class="circle circle1" r="1.9" cy="50.7" cx="42.5" />
        <circle class="circle circle2" cx="49.9" cy="50.7" r="1.9" />
        <circle class="circle circle3" r="1.9" cy="50.7" cx="57.3" />
      </svg>
    </div>
    <div class="chat-popup" id="myForm">
  <form action="student_main.php" class="form-container" method="POST">
    <h1>Complaint</h1>
    <textarea placeholder="Type your issue.." name="msg" required></textarea>

    <button type="submit" class="btn" name="submit">Send</button>
   
  </form>
</div>

    </div> 

    </main>

<!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../main.js"></script>
    <script >
      function openForm(){
  flag=false;
 document.getElementById("myForm").style.display = "block";

}

function closeForm() {
  flag=true;
  document.getElementById("myForm").style.display = "none";
}
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
<?php if($f1==1){?>
<link rel="stylesheet" href="../css/new.css">
<script>
 function myF(){
  Snackbar.show({text: "<?php echo $snack_text?>"});
 }
 
!function(a,b){"use strict";"function"==typeof define&&define.amd?define([],function(){return a.Snackbar=b()}):"object"==typeof module&&module.exports?module.exports=a.Snackbar=b():a.Snackbar=b()}(this,function(){var a={};a.current=null;var b={text:"Default Text",textColor:"#FFFFFF",width:"auto",showAction:!0,actionText:"Dismiss",actionTextAria:"Dismiss, Description for Screen Readers",alertScreenReader:!1,actionTextColor:"#4CAF50",showSecondButton:!1,secondButtonText:"",secondButtonAria:"Description for Screen Readers",secondButtonTextColor:"#4CAF50",backgroundColor:"#323232",pos:"bottom-left",duration:8e3,customClass:"",onActionClick:function(a){a.style.opacity=0},onSecondButtonClick:function(a){},onClose:function(a){}};a.show=function(d){var e=c(!0,b,d);a.current&&(a.current.style.opacity=0,setTimeout(function(){var a=this.parentElement;a&&
// possible null if too many/fast Snackbars
a.removeChild(this)}.bind(a.current),500)),a.snackbar=document.createElement("div"),a.snackbar.className="snackbar-container "+e.customClass,a.snackbar.style.width=e.width;var f=document.createElement("p");if(f.style.margin=0,f.style.padding=0,f.style.color=e.textColor,f.style.fontSize="14px",f.style.fontWeight=300,f.style.lineHeight="1em",f.innerHTML=e.text,a.snackbar.appendChild(f),a.snackbar.style.background=e.backgroundColor,e.showSecondButton){var g=document.createElement("button");g.className="action",g.innerHTML=e.secondButtonText,g.setAttribute("aria-label",e.secondButtonAria),g.style.color=e.secondButtonTextColor,g.addEventListener("click",function(){e.onSecondButtonClick(a.snackbar)}),a.snackbar.appendChild(g)}if(e.showAction){var h=document.createElement("button");h.className="action",h.innerHTML=e.actionText,h.setAttribute("aria-label",e.actionTextAria),h.style.color=e.actionTextColor,h.addEventListener("click",function(){e.onActionClick(a.snackbar)}),a.snackbar.appendChild(h)}e.duration&&setTimeout(function(){a.current===this&&(a.current.style.opacity=0,
// When natural remove event occurs let's move the snackbar to its origins
a.current.style.top="-100px",a.current.style.bottom="-100px")}.bind(a.snackbar),e.duration),e.alertScreenReader&&a.snackbar.setAttribute("role","alert"),a.snackbar.addEventListener("transitionend",function(b,c){"opacity"===b.propertyName&&"0"===this.style.opacity&&("function"==typeof e.onClose&&e.onClose(this),this.parentElement.removeChild(this),a.current===this&&(a.current=null))}.bind(a.snackbar)),a.current=a.snackbar,document.body.appendChild(a.snackbar);getComputedStyle(a.snackbar).bottom,getComputedStyle(a.snackbar).top;a.snackbar.style.opacity=1,a.snackbar.className="snackbar-container "+e.customClass+" snackbar-pos "+e.pos},a.close=function(){a.current&&(a.current.style.opacity=0)};
// Pure JS Extend
// http://gomakethings.com/vanilla-javascript-version-of-jquery-extend/
var c=function(){var a={},b=!1,d=0,e=arguments.length;"[object Boolean]"===Object.prototype.toString.call(arguments[0])&&(b=arguments[0],d++);for(var f=function(d){for(var e in d)Object.prototype.hasOwnProperty.call(d,e)&&(b&&"[object Object]"===Object.prototype.toString.call(d[e])?a[e]=c(!0,a[e],d[e]):a[e]=d[e])};d<e;d++){var g=arguments[d];f(g)}return a};return a});
//# sourceMappingURL=snackbar.min.js.map
</script>

<?php 
  echo '<script type="text/javascript">',
  'myF();',
  '</script>'
;

?>
<?php }?>
</body>

</html>