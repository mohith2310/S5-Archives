<?php
    $connection=new mysqli('localhost','root','','hostel');
    session_start();
$ar=$_SESSION['arr'];
$ad_id=$ar['Admin_ID'];
    if(!($connection))
    echo 'connection error';
    if(isset($_POST['add'])){
        $h_name=$_POST['h_name'];
        $h_rooms=$_POST['h_rooms'];
        $h_gender=$_POST['h_gender'];
        $h_landmark=$_POST['h_landmark'];
        $h_batch=$_POST['h_batch'];
        $h_admin=$_POST['h_admin'];
        $q="INSERT INTO HOSTELS(Hostel_name,No_of_rooms,Vacant_rooms,Landmark,Gender_flag,Admin_ID,Batch)
        VALUES('$h_name','$h_rooms','$h_rooms','$h_landmark','$h_gender','$h_admin','$h_batch')";
        $sql=$connection->prepare($q);
        $sql->execute();
        $q_a="UPDATE Admin SET Hostel_ID=(SELECT HOSTELS.Hostel_ID FROM HOSTELS WHERE HOSTELS.Admin_ID=Admin.Admin_ID)";
        $sql=$connection->prepare($q_a);
        $sql->execute();
       
        $sql->close();
        $q="SELECT Hostel_ID FROM HOSTELS WHERE Admin_ID='$h_admin'";
        $ans=mysqli_fetch_array(mysqli_query($connection,$q));
        $an=$ans[0];
        for($i=1;$i<=$h_rooms;$i=$i+1){
          $q=$connection->prepare("INSERT INTO ROOM VALUES('$an','$i','2')");
          $q->execute();
        }
        $connection->close();

       header("Location:http://localhost/dbms/pages/update_hostels.php");
    }
    $query="SELECT * FROM HOSTELS WHERE 1";
    $total=mysqli_query($connection,$query);
    $_SESSION['arr']=$ar;
    if(isset($_POST['Send'])){
       
        $null=NULL;
        $q="UPDATE STUDENTS SET Roomate_ID=NULL,Hostel_ID=NULL,Admin_ID=NULL,Room_No=NULL WHERE 1";
        $sql=$connection->prepare($q);
        $sql->execute();

        $q="UPDATE ROOM SET Vacancies='2' WHERE 1";
        $sql=$connection->prepare($q);
        $sql->execute();

        $q="DELETE FROM room_requests WHERE 1";
        $sql=$connection->prepare($q);
        $sql->execute();
        $q="DELETE FROM NOTICES WHERE 1";
        $sql=$connection->prepare($q);
        $sql->execute();
        $q="DELETE FROM COMPLAINTS WHERE 1";
        $sql=$connection->prepare($q);
        $sql->execute();
        $sql=$connection->prepare("ALTER TABLE room_requests AUTO_INCREMENT=1");
        $sql->execute();
        $sql=$connection->prepare("ALTER TABLE NOTICES AUTO_INCREMENT=1");
        $sql->execute();
        $sql=$connection->prepare("ALTER TABLE COMPLAINTS AUTO_INCREMENT=1");
        $sql->execute();

        $sql=$connection->prepare("UPDATE HOSTELS SET Vacant_rooms=No_of_rooms");
        $sql->execute();

        $q="INSERT INTO NOTICES(Subject,Admin_ID,student_id) VALUES('New Hostel Update','1','0')";
        $sql=$connection->prepare($q);
        $sql->execute();

        

        header("Location:http://localhost/dbms/pages/update_hostels.php");
    }
    if(isset($_POST['Remove'])){
      $q="DELETE FROM NOTICES WHERE student_id='0'";
      $sql=$connection->prepare($q);
      $sql->execute();
      header("Location:http://localhost/dbms/pages/update_hostels.php");
  }


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
          <li class="nav-item  ">
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
            <a class="nav-link" href="admin_list.php">
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
            <a class="navbar-brand" href="javascript:void(0)">Hostels</a>
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
        <?php if($ad_id==1){?>
        <div style="display: flex;justify-content:center">
              <form action="update_hostels.php" method="POST">
                <button type="submit"  name='Send'class="btn btn-primary ">Send Hostel Update</button>
                <button type="submit"  name='Remove'class="btn btn-warning">Remove Hostel Update</button>
                </form>
                </div>
                <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Hostels</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          # of rooms
                        </th>
                        <th>
                          vacant rooms
                        </th>
                        <th>
                          Gender
                        </th>
                        <th>
                          Batch
                        </th>
                        <th>
                          Landmark
                        </th>
                        <th>
                          Admin
                        </th>
                      </thead>
                      <tbody>
                          <?php foreach ($total as $row){ ?>
                        <tr>
                          <td>
                          <?php echo $row['Hostel_ID'] ?>
                          </td>
                          <td>
                          <?php echo $row['Hostel_name'] ?>
                          </td>
                          <td class="text-primary">
                          <?php echo $row['No_of_rooms'] ?>
                          </td>
                          <td>
                          <?php echo $row['Vacant_rooms'] ?>
                          </td>
                          <td >
                          <?php echo $row['Gender_flag']?>
                          </td>
                          <td >
                          <?php echo $row['Batch']?>
                          </td>
                          <td >
                          <?php echo $row['Landmark']?>
                          </td>
                          <td class="text-primary">
                          <?php echo $row['Admin_ID']?>
                          </td>
                         
                        </tr>
                          <?php }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Add Hostels</h4>
                </div>
            <div class="card-body">
                  <form action="update_hostels.php" method="POST">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Hostel Name</label>
                          <input type="text" name="h_name" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating"># of rooms</label>
                          <input type="text" name="h_rooms" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Batch</label>
                          <input type="text" name="h_batch" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          
                          <input type="radio" name="h_gender" value="M" id="male" checked>
                          <label for="male">Male</label><br>
                          <input type="radio" name="h_gender" id="female" value="F"  >
                          <label for="female">Female</label><br>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Landmark</label>
                          <input type="text" name="h_landmark"class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin-ID</label>
                          <input type="text" name="h_admin" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <button type="submit"  name='add'class="btn btn-primary pull-right">Add Hostel</button>
                    <div class="clearfix"></div>
                  </form>
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