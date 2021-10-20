<?php
include "include/head.inc.php";
session_start();
if(!isset($_SESSION["userId"])){
    header("location:login.php");
    exit();
}
?>
<body>
<section id="messages">
<script src="js/script.js?v=<?php echo time(); ?>"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
            <br>
                <div class="message-left-top">
                    
                <button type="button" class="back" onclick="javascript:history.back()"></button>
                <h2><strong>Messages</strong></h2>
                <button type="button" class="searchM" data-toggle="modal" data-target="#searchMessage" onclick="clearSearch();"></button>
                <button type="button" class="message"></button>
                </div>
                <?php 
                include "include/dbc.inc.php";
                $id = $_SESSION["userId"];
                //$sql = "SELECT * from messages where msg_id in (select max(msg_id) from messages group by sender_id)";
                $sql = "SELECT account.acc_user,meet_date,meet_time,meet_link,meet_msg FROM `meeting` INNER JOIN account on meeting.acc_id = account.acc_id WHERE reciever_id = '$id'";
                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="msg-div">
                        <img src="img/active-emp.svg">
                        <h5> '.$row["acc_user"].'<span>'.$row["meet_time"].'</span></h5>
                        <p>'.$row["meet_msg"].'</p>
                        </div>';
                        }
                    }
                ?>
            </div>
            
            <div class="col-lg-6 p-0 right-bg">
          
                <div class="message-right-top">
                <img src="img/active-emp.svg" class="profile-right">
                <input type="hidden" class="rId" id="rId">
                <input type="hidden" id="sId" value="<?php echo $_SESSION["userId"];?>">
                <h2 class="rName">Ogie Sanchez <span><img src="img/active-emp.svg" class="bell"></span><span><img src="img/active-emp.svg" class="option"></span></h2>
                </div>
                <div class="msg-right">
                    <div class="msg-right-div-def">
                        
                    </div>
                </div>
                
                <div class="send-msg-parent">
                <div class="send-msg">
                    
                <input type="text" id="sMsg"><button type="button" onclick="sendmsgUser();"><img src="img/active-emp.svg"></button>
                </div>
                </div>
              
            </div>
           
        </div>
    </div>
</section>

<!-- start modal search message -->
<div class="modal fade" id="searchMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
     <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Search People</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
     </div>
     <div class="modal-body" id="input-body">
        <h5>Search </h5>
        <input type="search" id="searchP" oninput="searchMessage();">
        <div id="searchPerson"></div> 
    </div>
     </div>
 </div>
</div>
    <!-- end modal search message -->

</body>
</html>