<?php
session_start();
$ar=$_SESSION['arr'];
$ad_id=$ar['Admin_ID'];
$connection=new mysqli('localhost','root','','hostel');
if(isset($_POST['clear'])){
  $c_no=$_POST['c_no'];
  $stu_id=$_POST['stu_id'];
  $status=$_POST['status'];
  $sub=$_POST['sub'];
  $msg="";
  $f=0;
  $ad_id=$ar['Admin_ID'];
  $q="DELETE FROM COMPLAINTS WHERE Complaint_No='$c_no'";
  $sql=$connection->prepare($q);
      $sql->execute();
  if($status==0){
      $msg="Your complaint :".$sub." has been rejected.";
      $f=1;
    }
  elseif($status==1){
    $msg="Your complaint :".$sub." has been Cleared..";
    $f=1;
  }
  if($f==1){
  $q="INSERT INTO NOTICES(Subject,Admin_ID,student_id) 
  VALUES('$msg','$ad_id','$stu_id')";
  $sql=$connection->prepare($q);
      $sql->execute();
  }

}
elseif(isset($_POST['accept'])){
  $c_no=$_POST['c_no'];
  $stu_id=$_POST['stu_id'];
  $sub=$_POST['sub'];
  $ad_id=$ar['Admin_ID'];
  $q="UPDATE  COMPLAINTS SET Complaint_Status='1' WHERE Complaint_No='$c_no'";
  $sql=$connection->prepare($q);
      $sql->execute();
      $msg="Your complaint :".$sub." has been Accepted..";
      $q="INSERT INTO NOTICES(Subject,Admin_ID,student_id) 
  VALUES('$msg','$ad_id','$stu_id')";
  $sql=$connection->prepare($q);
      $sql->execute();

}
$q1="SELECT * FROM COMPLAINTS WHERE  Admin_ID='$ad_id' AND Complaint_Status>'-1'";
$result=mysqli_query($connection,$q1);
$c_no=0;
foreach($result as $r){
  $c_no=$c_no+1;
}
$q2="SELECT * FROM Admin";
$admins=mysqli_query($connection,$q2);
$ac=0;

$_SESSION['arr']=$ar;
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Material Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="dark-edition">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/sidebar-2.jpg">
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="admin_land.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php if($ad_id==1){?>
          <li class="nav-item ">
            <a class="nav-link" href="add_admins.php">
              <i class="material-icons">person_pin</i>
              <p>Add Admins</p>
            </a>
          </li>
          <?php }?>
          <li class="nav-item ">
            <a class="nav-link" href="../pages/admin_list.php">
              <i class="material-icons">content_paste</i>
              <p>Table List</p>
            </a>
          </li>
         
          <?php if($ad_id==1){?>
          <li class="nav-item">
            <a class="nav-link" href="update_hostels.php">
              <i class="material-icons">where_to_vote</i>
              <p>Hostels</p>
            </a>
          </li>
          <?php }?>
          <li class="nav-item ">
            <a class="nav-link" href="admin_feed.php">
              <i class="material-icons">announcement</i>
              <p>Post Feed</p>
            </a>
          </li>
         
         
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
             
              
              <li class="nav-item">
                <a class="nav-link" href="admin_login.php">
                  <i class="material-icons">login</i>
                  <p class="d-lg-none d-md-block">
                    Logout
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
         
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Dashboard</h4>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>ID</th>
                      <th>Email</th>
                      <th>Full name</th>
                      <th>Hostel</th>
                    </thead>
                    <tbody>
                        <?php foreach($admins as $a){?>
                      <tr>
                        <td><?php echo $a['Admin_ID']?></td>
                        <td><?php echo $a['Mail'] ?></td>
                        <td><?php echo $a['Fname']." ".$a['Lname']?></td>
                        <td><?php 
                        $dum=$a['Hostel_ID'];
                        $q="SELECT Hostel_name FROM HOSTELS WHERE Hostel_ID='$dum'";
                        $hostel=mysqli_query($connection,$q);
                        $h=mysqli_fetch_array($hostel);
                        echo $h['Hostel_name'];?></td>

                      </tr>
                        <?php }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-warning">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Complaints:</span>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table">
                      <thead class=" text-primary">
                        <th>
                          Roll number
                        </th>
                        <th>Room No.</th>
                        <th>
                          Complaint
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Clear
                        </th>
                        
                      </thead>
                        <tbody>
                        
                            <?php foreach($result as $ar) {?>
                              <form action="admin_land.php" method="post">
                          <tr>
                            <td> <input type="hidden" name="stu_id" value="<?php echo $ar['Student_ID']?>"><?php echo $ar['Student_ID']?></td>
                            <td><?php echo $ar['room_no']?></td>
                            <input type="hidden" name="status" value="<?php echo $ar['Complaint_Status']?>">
                            <td><input type="hidden" name="sub" value="<?php echo $ar['Subject']?>"><?php echo $ar['Subject']?></td>
                            <input type="hidden" name="c_no" value=<?php echo $ar['Complaint_No']?>>
                            <td>
                            <?php if($ar['Complaint_Status']==0){ ?>
                                  <input class="btn btn-primary btn-sm" type="submit" name="accept" value="Accept" >
                                  <?php }else{  ?>
                                    Accepted
                                    <?php } ?>

                            </td>
                            <td class="td-actions text-right">
                              <button type="submit" rel="tooltip" title="Remove" name='clear' class="btn btn-white btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          </form>
                            <?php }?>
                            
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
 
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://unpkg.com/default-passive-events"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Chartist JS -->
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.js?v=2.1.0"></script>
 
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();
    

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>


  
</body>

</html>