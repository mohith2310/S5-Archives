<?php
session_start();
$ar=$_SESSION['arr'];
$ad_id=$ar['Admin_ID'];

$connection=new mysqli('localhost','root','','hostel');

$f1=0;
if(isset($_POST['insert'])){
    $feed=$_POST['feed'];
    $a_id=$ar['Admin_ID'];
    $q="INSERT INTO NOTICES(Subject,Admin_ID,student_id) 
  VALUES('$feed','$a_id','1')";
  $sql=$connection->prepare($q);
      $sql->execute();
      $f1=1;
}
$_SESSION['arr']=$ar;
if(isset($_POST['clear'])){
  $n_id=$_POST['n_id'];
  $q="DELETE FROM NOTICES WHERE Notice_ID='$n_id'";
  $sql=$connection->prepare($q);
      $sql->execute();

}
$q="SELECT * FROM NOTICES WHERE Admin_ID='$ad_id' AND student_id='1'";
$total=mysqli_query($connection,$q);

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
          <li class="nav-item  "><input type="hidden" name="feed">
            <a class="nav-link" href="../pages/admin_land.php">
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
          <li class="nav-item  ">
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
         
          <li class="nav-item active">
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
            <a class="navbar-brand" href="javascript:void(0)">Feed</a>
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
          <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Feed</h4>
                </div>
                <div class="card-body">
                  <form action="admin_feed.php" method="POST">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="form-group">
                            <textarea name="feed" placeholder="Write your feed here..."class="form-control" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" name="insert" class="btn btn-primary pull-right">Post</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Recent Feeds</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          #
                        </th>
                        <th>
                          Feed
                        </th>
                        <th>
                          Clear
                        </th>
                        
                      </thead>
                      <tbody>
                          <?php $var=1;foreach ($total as $row){ ?>
                            <form action="admin_feed.php" method="POST">
                        <tr>
                          <td>
                          <?php echo $var ?>
                          </td>
                          <td>
                          <?php echo $row['Subject'] ?>
                          </td>
                          <td>
                            <input type="hidden" name="n_id" value="<?php echo $row['Notice_ID'] ?>">
                          <button type="submit" name="clear" class="btn btn-primary">Clear</button>
                          </td>
                        </tr>
                        </form>
                          <?php $var=$var+1;}?>
                      </tbody>
                    </table>
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



<?php if($f1==1){?>
<link rel="stylesheet" href="../css/new.css">
<script>
 function myF(){
  Snackbar.show({text: "Feed Posted Successfully..."});
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