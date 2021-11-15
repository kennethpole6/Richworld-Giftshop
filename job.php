<?php
include 'include/head.inc.php';
include 'include/dbc.inc.php';
session_start();
if(isset($_GET["error"])){
  if($_GET["error"]=="file"){
    echo '<script> alert("Invalid file type")</script>';
  }
  if($_GET["error"]=="alreadyapply"){
    echo '<script> alert("You can only apply once")</script>';
  }
}
if(isset($_GET["success"])){
  if($_GET["success"]=="successfully apply"){
  echo '<script> alert("Send Application Form Successfully!")</script>';
  }
}
if($_SESSION["acc_type"] == "admin"){
  header("location:dashboard.php");
  exit();
  }
$accid = $_SESSION["userId"];
$sqlcheck = "SELECT * from account_complete where acc_id = '$accid'";
$resultcheck = mysqli_query($conn,$sqlcheck);
if(mysqli_num_rows($resultcheck) > 0){
  while($row = mysqli_fetch_assoc($resultcheck)){
    if($row["age"] == "none" || $row["birthday"] == "none" || $row["civilstatus"] == "none" || $row["caddress"] == "none" || $row["gender"] == "none"){
      header("location:index.php?error=complete-your-info");
      exit();
    }
  } 
}
?>

</body>
</html>
<nav class="navbar navbar-expand-lg navbar-light" id="nav_index">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><p>R<span>G</span></p></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
      <li class="nav-item">
            <a class="nav-link active"aria-current="page" href="index.php#nav-body">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php#download">Download</a>
            </li>
            <li class="nav-item">
            <script src="js/script.js?v=<?php echo time(); ?>"></script>
            <a class="nav-link active" aria-current="page" href="job.php" style="margin-right:20px">Job Listing</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php#about" style="margin-right:20px">About</a>
            </li>   
      <li class="nav-item">
            <?php
            if(isset($_SESSION["profile-name"])){
              $accid = $_SESSION["userId"];
              $sql = "SELECT * from account where acc_id = '$accid'";
              $result = mysqli_query($conn,$sql);
              if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                  $_SESSION["refreshpath"] = $row["prof_path"];
                }
              }
              echo '<div class="account-dashboard">
              <div class="dropdown">       
                      <div class="btn-group">';
                          
                          $prof_name = "img/account-profile/".$_SESSION["refreshpath"];?>
                          <img src="<?php echo $prof_name;?>" class="profile_img" alt="profile">
                          <?php
                          echo '<p class="name">'.$_SESSION["profile-name"].'</p>';
                      echo '<button type="button" style="background-color:#FD5757 !important" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="visually-hidden">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu">
                      <li><p class="dropdown-item" style="color:red">Account : <span style="color:green">'.$_SESSION["acc_type"].'<span></p></li>
                      <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewprofile">View Profile</a></li>
                          <li><a class="dropdown-item" href="messages.php">Messages</a></li>
                          <li><a class="dropdown-item" href="status.php">Status</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><form action="include/logout.inc.php" method="POST"><a class="dropdown-item"><button type="submit" name="logout" style="color:red">Log out</button></a></form></li>
                      </ul>
                      </div>
              </div>     
              </div>';
            }else{
            echo '<a href="login.php"><button type="button" class="nav-login">Login</button></a>';}?>
            </li>
      </ul>
    </div>
  </div>
</nav>

<!-- start modal create profile -->

<div class="modal fade" id="viewprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
     <div class="modal-header">
         <h5 class="modal-titles" id="exampleModalLongTitle">Your Profile</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
     </div>
     <div class="modal-body">
      <div class="profileall">
        <?php
        include "include/dbc.inc.php";
        $accid = $_SESSION["userId"];
        $sql = "SELECT * from account where acc_id = '$accid'";
        $result = mysqli_query($conn,$sql);
        $name = "";
        $pic = "";
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            $name = $row["firstname"]." ".$row["lastname"];
            $pic = $row["prof_path"];
          }
        }
        echo '<img src="img/account-profile/'.$pic.'">';
        echo '<span>'.$name.'</span>';
        ?>
              <br><br>
        <form action="include/profile_complete.inc.php" method="POST">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
            <?php
            $accid = $_SESSION["userId"];
            $sqlshow = "SELECT * from account_complete where acc_id = '$accid'";
            $result2 = mysqli_query($conn,$sqlshow);
            $age = "";
            $bday = "";
            $status = "";
            $address = "";
            $gender = "";
            if(mysqli_num_rows($result2) > 0){
              while($row = mysqli_fetch_assoc($result2)){
                $age = $row["age"];
                $bday = $row["birthday"];
                $status = $row["civilstatus"];
                $address = $row["caddress"];
                $gender = $row["gender"];
              }
            }
            echo '<label for="age">Age</label>
            <input class="form-control" type="text" id="age" name="age" class="currentage" style="pointer-events: none;" value="'.$age.'">
            </div>
            <div class="col-lg-6">
            <label for="bday">Birthday</label>
            <input class="form-control" type="date" id="bday" name="bday" onchange="calculate_age();" value="'.$bday.'" required>
            </div>
            <div class="col-lg-6">
            <label for="civil" style="padding-bottom: 4%;">Civil Status</label>
            <br>
            <select class="form-select" aria-label="Default select example" name="type" id="civil">
                  <option>'.$status.'</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Seperated">Seperated</option>
                    <option value="Divorce">Divorce</option>
            </select>
            </div>
            <div class="col-lg-6">
            <label for="address">Address</label>
            <input class="form-control" type="text" id="address" name="address" value="'.$address.'" required>
            </div>
            <div class="col-lg-6">
            <label for="gender" style="padding-bottom: 4%;">Gender</label>
            <br>
            <select class="form-select" aria-label="Default select example" name="gender" id="gender">
                  <option>'.$gender.'</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
            </select>
            </div>
            ';
            ?> 
          </div>
       
        </div>
      </div>
     </div>
     <div class="modal-footer">
         <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
         <button type="submit" class="btn btn-primary" style="width:100%">Save Changes</button>
     </div>
     </div>
     </form>
 </div>
</div>
<!-- end modal create profile -->

<section id="job-body">
    <div class="job">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <h1 style="margin-left:8%">Job Vacancies</h1>
              </div>
              <div class="col-sm-12 col-lg-6">
                <input type="text" class="searchI" name="search_input" id="search_name">
                <button type="button" class="searchB" name="button_input" onclick="search_click();">Search</button>
               
              </div>
            </div>
          </div>
          
          <div id="job-listIndex">
            <div class="container">
            <div class="row">
            <?php
              include 'include/showjobIndex.inc.php';?>
            </div>
            </div>
          </div>
           
          
    </div>
    <!-- start modal view job index -->
  <form action="applyindex.php" method="POST">
          <div class="modal fade" id="viewjobIndex" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                <div class="row">
                <!-- <div class="col-12">
                <input type="text" class="form-control" placeholder="ID"></div> -->
                <div class="col-4 salary-min">
                  <p class="min"></p>
                  <input type="hidden" class="job_id" name="job_id">
                </div>
                <div class="col-1 salary-min">
                  <p>-</p>
                </div>
                <div class="col-4 salary-max">
                  <p class="max"></p>
                </div>
                <div class="col-sm-12 col-lg-12 job-des">
                  <h6>Job Description</h6>
                  <p class="desc"></p>
                </div>                                             
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary" style="width:100%" name="applyB">Apply Now</button>
                <p style="width:100%;text-align:center" class="pdf">* You must sign in to upload your pdf resume *</p>
                <div id="add"></div>
            </div>
            </div>
        </div>
        </div>
  </form>
    <!-- end modal view job index -->
    
</section>