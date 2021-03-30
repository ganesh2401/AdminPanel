<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php
   require '../session.php';
   $UserData = array();
   $DocInfo = array();
   $ClaimInfo = array();
   $i = 0;
   $error=""; 
   $success ="";
   $row = array();
   $user_id = "";
   $DocFlag = false;
   if($_SERVER["REQUEST_METHOD"] == "POST") {
    //  print_r($_POST); 
    //  die();
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
        if(isset($_POST['Document_Varify'])){

          foreach ($_POST['Document_Varify'] as $doc_id){
              $update_query = "UPDATE `user_document` SET `is_verified`='Y' WHERE `user_id` = '$user_id' AND `doc_id` = '$doc_id'";
            //  print_r($update_query);
              $update_result = mysqli_query($db,$update_query);
              if($update_result){
                $success = "Profile data Is Updated";  
              }
          }
          $doc_query = "SELECT is_verified from user_document WHERE user_id = '$user_id'";
          $doc_result = mysqli_query($db,$doc_query);
          while ($doc_result_row = mysqli_fetch_array($doc_result)){
                    
                    if($doc_result_row['is_verified'] =='N'){
                      $DocFlag = true;
                    }
                         
          }
          if($DocFlag==false){
            $update_query = "UPDATE `user` SET `is_doc_verified`='Y' WHERE `user_id` = '$user_id'";
            $update_result = mysqli_query($db,$update_query);

          }
         
        }
        if(isset($_POST['Payment_Varify'])){
          foreach ($_POST['Payment_Varify'] as $up_id){
            $update_query = "UPDATE `users_policy` SET `payment_status`='Approved' WHERE `up_user_id` = '$user_id' AND `up_id` = '$up_id'";
          //  print_r($update_query);
            $update_result = mysqli_query($db,$update_query);
            if($update_result){
              $success = "Profile Data Is Updated"; 
            }
          }
        }
        if(isset($_POST['Claim_Varify'])){
          foreach ($_POST['Claim_Varify'] as $up_id){
            $update_query = "UPDATE `claim` SET `claim_status`='Approved' WHERE  `up_id` = '$up_id'";
          //  print_r($update_query);
            $update_result = mysqli_query($db,$update_query);
            if($update_result){
              $success = "Profile Data Is Updated"; 
            }
          }
        }
        if(isset($_POST['Renew_Varify'])){
          foreach ($_POST['Renew_Varify'] as $up_id){
            $update_query = "UPDATE `renew_policy` SET `renew_status`='Approved' WHERE  `up_id` = '$up_id'";
          //  print_r($update_query);
            $update_result = mysqli_query($db,$update_query);
            if($update_result){
              $success = "Profile Data Is Updated"; 
            }
          }
        }
        $profile_query = "SELECT * from user WHERE user_id = '$user_id'";
        $profile_result = mysqli_query($db,$profile_query);
        $up_query = "SELECT NP.*,UP.* from users_policy UP,new_policy NP,user U WHERE UP.up_user_id =  '$user_id' AND U.user_id = '$user_id' AND UP.up_policy_id = NP.policy_id";
        $up_result = mysqli_query($db,$up_query);
        $count = mysqli_num_rows($up_result);
        //$UPData = mysqli_fetch_assoc($up_result);
        // print_r($UPData);
        // die();
        $doc_query = "SELECT * from user_document WHERE user_id = '$user_id'";
        $doc_result = mysqli_query($db,$doc_query);
        while ($doc_result_row = mysqli_fetch_array($doc_result)){
                  
                  if($doc_result_row['is_verified'] =='N'){
                    $DocFlag = true;
                  }
                  $DocInfo[$doc_result_row['doc_id']] = $doc_result_row;       
        }
        $renew_query = "SELECT RP.*,NP.policy_name FROM renew_policy RP,users_policy UP, new_policy NP WHERE UP.up_user_id = '$user_id' AND RP.up_id = UP.up_id AND UP.up_policy_id = NP.policy_id";
        $renew_result = mysqli_query($db,$renew_query);
        // $renewData = mysqli_fetch_array($renew_result);
        // print_r($renewData);
        // die();
        $claim_query = "SELECT C.*,HL.hospital_name,CD.* from claim C,claim_doc CD,hospital_list HL,users_policy UP WHERE UP.up_user_id = '$user_id' AND UP.up_id = C.up_id AND C.claim_hospital_no = HL.hospital_id AND C.claim_id = CD.claim_id";
        $claim_result = mysqli_query($db,$claim_query); 
        while ($claim_result_row = mysqli_fetch_assoc($claim_result)){
                  
                  if($claim_result_row['claim_status'] =='Pending'){
                    $DocFlag = true;
                  }
                  $ClaimInfo[$claim_result_row['claim_id']] = $claim_result_row; 
                       
        }

        if($profile_result){
          $UserData = mysqli_fetch_array($profile_result);
          //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $count = mysqli_num_rows($profile_result);
        }
      else
      {
        $count = 0;
      }
    }
    if(isset($_POST['updateDocumentVarify'])){
      $updateDocumentVarify = $_POST["updateDocumentVarify"];


    }
   }
   else{

    header("location:../dashboard.php");
   }

?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <!-- <link rel="icon" type="image/png" href="../assets/img/favicon.png"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Show Profile
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
  <?php include_once 'Views/Sidebar.html'; ?>
  <form action="" method="post"> 
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">User</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <!-- <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form> -->
            <ul class="navbar-nav">
              <!-- <li class="nav-item">
                <a class="nav-link" href="javascript:;">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li> -->
              <!-- <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Mike John responded to your email</a>
                  <a class="dropdown-item" href="#">You have 5 new tasks</a>
                  <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                  <a class="dropdown-item" href="#">Another Notification</a>
                  <a class="dropdown-item" href="#">Another One</a>
                </div>
              </li> -->
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item"  href = "logout.php">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
          <div class="col-md-12">
            <?php if($error) { 
                                echo '<div class="form-group alert alert-danger alert-dismissable">';
                                echo $error;
                                echo '</div>';
                                } elseif($success){
                                    echo '<div class="form-group alert alert-success alert-dismissable">';
                                    echo $success;
                                    echo '</div>';
                                
                                }?>
            </div>
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">User Info</h4>
                    <p class="card-category">New users who apply for policy</p>
                 
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                  <thead class="text-info text-center"><th colspan="8">User Details</th></thead>
                    <thead>
                      <th class="text-warning">User Name</th>
                      <th><?php echo $UserData ['user_name']; ?></th>
                      <th class="text-warning">Mobile No.</th>
                      <th><?php echo $UserData ['mobile_no']; ?></th>
                      <th class="text-warning">Date Of Birth</th>
                      <th><?php echo $UserData ['date_of_birth']; ?></th>
                    </thead>
                    <tbody>
                    <thead>
                      <th class="text-warning">First Name</th>
                      <th><?php echo $UserData ['first_name']; ?></th>
                      <th class="text-warning">Middle Name</th>
                      <th><?php echo $UserData ['middle_name']; ?></th>
                      <th class="text-warning">Last Name</th>
                      <th><?php echo $UserData ['last_name']; ?></th>
                    </thead>
                    <thead>
                      <th class="text-warning">Email Id</th>
                      <th><?php echo $UserData ['email_id']; ?></th>
                      <th class="text-warning">Address</th>
                      <th colspan="3" rowspan="2"><?php echo $UserData ['address']; ?></th>
                    </thead>
                    <thead>
                      <th class="text-warning">City</th>
                      <th><?php echo $UserData ['city']; ?></th>
                      <th class="text-warning">State</th>
                      <th><?php echo $UserData ['state']; ?></th>
                      <th class="text-warning">PAN No</th>
                      <th><?php echo $UserData ['pan_no']; ?></th>
                    </thead>
                    <thead>
                      <th class="text-warning">Addhar No</th>
                      <th><?php echo $UserData ['addhar_no']; ?></th>
                      <th class="text-warning">Bank Account No.</th>
                      <th><?php echo $UserData ['bank_acc_no']; ?></th>
                      <th class="text-warning">Ifsc Code</th>
                      <th><?php echo $UserData ['ifsc_code']; ?></th>
                    </thead>
                    <thead>
                      <th class="text-warning">Bank Branch Name</th>
                      <th><?php echo $UserData ['bank_branch_name']; ?></th>
                      <th class="text-warning">Bank Address</th>
                      <th><?php echo $UserData ['bank_address']; ?></th>
                      <th class="text-warning">Document Varified</th>
                      <th><?php echo $UserData ['is_doc_verified']== "Y"? 'Yes':'No' ; ?></th>
                    </thead>
                    <thead class="text-info text-center"><th colspan="8">User Policy List</th></thead>
                    <thead class="text-warning">
                      <th>ID</th>
                      <th>Policy Name</th>
                      <th>Policy Code</th>
                      <th>Policy Assured Amt</th>
                      <th>Policy Purchase Dt</th>
                      <th>Payment status</th>
                      <th>Varify Payment</th>
                    </thead>
                   <?php 
                        $i = 1;
                        
                   while($UPData = mysqli_fetch_assoc($up_result))
                    {   ?>
                   
                    <thead>
                      <th><?php echo $i ?></th>
                      <th><?php echo $UPData ['policy_name']; ?></th>
                      <th><?php echo $UPData ['policy_code']; ?></th>
                      <th><?php echo $UPData ['policy_assured_amt'];?></th>
                      <th><?php echo $UPData ['policy_purchase_dt'];?></th>
                      <th><?php echo $UPData ['payment_status'];  ?></th>
                      <?php if($UPData ['payment_status'] == 'Pending'){

                        $DocFlag = true;
                        ?>
                        <th><div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" name="Payment_Varify[]" value=<?php echo $UPData ['up_id']; ?> >
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>
                        </div> </th>
                      <?php }else{  ?>

                        <th><p class="text-success"><?php echo $UPData ['payment_status'];  ?></p></th>
                        
                     <?php } ?>
                    </thead>
                        

                    <?php 
                $i++;    
                } 
                 if($i ==1) {
                        ?>

                        <thead class="text-center"><th colspan="8">No policy added</th></thead>
                        <?php
                }?>
                     <thead class="text-info text-center"><th colspan="8">Users Documents</th></thead>
                     <thead class="text-warning">
                      <th>ID</th>
                      <th>Document Varify</th>
                      <th colspan="2">Show Document</th>
                      <th>Varify</th>
                    </thead>
                    <?php 
                        $i = 1;
                        
                   foreach($DocInfo as $Doc_Data )
                    {  ?>
                        <thead>
                        <thead>
                        <th><?php echo $i ?></th>
                        <th><?php echo $Doc_Data ['is_verified']=='N'? 'No':'Yes'; ?></th>
                      
                        <th colspan="2"><button type="button" data-id =<?php echo $Doc_Data ['doc_id']; ?> rel="tooltip" data-toggle="modal" title="Show Detail" name = "Document_Varify" data-target ="#DocModal" class="flow-left btn btn-success ShowDocModal">
                                                Show Document
                                    </button></th>
                        <th class="">
                        <?php  
                 if($Doc_Data ['is_verified'] =='N') {
                        ?>  
                        
                        <div class="form-check">
                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" name="Document_Varify[]" value=<?php echo $Doc_Data ['doc_id']; ?>>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                                </div>
                                <?php } elseif($Doc_Data ['is_verified'] =='Y') { ?>
                                  <p class="text-success">Varified</p>

                              <?php  } 

                              ?>
                              </th>
                        </thead>                   
                    <?php 
                $i++;    
                } 
                 if($i ==1) {
                        ?>

                        <thead class="text-center"><th colspan="8">No Document added</th></thead>
                        <?php
                }?>
                    <thead class="text-info text-center"><th colspan="8">Renew Request</th></thead>
                        <thead class="text-warning">
                          <th>ID</th>
                          <th>Policy Name</th>
                          <th>Renew Amount</th>
                          <th>Renew Date</th>
                          <th>Renew Expiry Date</th>
                          <th>Payment status</th>
                          <th>Varify Payment</th>
                        </thead>
                        <?php 
                        $i = 1;
                        
                   while($RenewData = mysqli_fetch_assoc($renew_result))
                    {   ?>

                    <thead>
                      <th><?php echo $i ?></th>
                      <th><?php echo $RenewData ['policy_name']; ?></th>
                      <th><?php echo $RenewData ['renew_amt']; ?></th>
                      <th><?php echo $RenewData ['renew_dt'];?></th>
                      <th><?php echo $RenewData ['renew_expire_dt'];?></th>
                      <th><?php echo $RenewData ['renew_status'];  ?></th>
                      <?php if($RenewData ['renew_status'] == 'Pending'){

                        $DocFlag = true;
                        ?>
                        <th><div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" name="Renew_Varify[]" value=<?php echo $RenewData ['up_id']; ?> >
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>
                        </div> </th>
                      <?php }else{  ?>

                        <th><p class="text-success"><?php echo $RenewData ['renew_status'];  ?></p></th>
                        
                     <?php } ?>
                    </thead>
                    <?php 
                $i++;    
                } 
                 if($i ==1) {
                        ?>

                        <thead class="text-center"><th colspan="8">No Renew Request added</th></thead>
                        <?php
                }?>
                        <thead class="text-info text-center"><th colspan="8">Claim Request</th></thead>
                        <thead class="text-warning">
                          <th>ID</th>
                          <th>Claim Hosp FM dt</th>
                          <th>Claim_Hosp_To_dt</th>
                          <th>Claim Hospital Name</th>
                          <th>Claim Dsc</th>
                          <th>Claim Amt</th>
                          <th colspan="2">Show Document</th>
                          <th>Varify</th>
                        </thead>
                        <?php 
                        $i = 1;
                        
                   foreach($ClaimInfo as $Doc_Data )
                    {  ?>
                        <thead>
                        <thead>
                        <th><?php echo $i; ?></th>
                        <th><?php echo $Doc_Data ['claim_hosp_from_dt']; ?></th>
                        <th><?php echo $Doc_Data ['claim_hosp_to_dt']; ?></th>
                        <th><?php echo $Doc_Data ['hospital_name']; ?></th>
                        <th><?php echo $Doc_Data ['claim_dsc']; ?></th>    
                        <th><?php echo $Doc_Data ['claim_amt']; ?></th>
                      
                        <th colspan="2"><button type="button" data-id =<?php echo $Doc_Data ['claim_id']; ?> rel="tooltip" data-toggle="modal" title="Show Detail" name = "Document_Varify" data-target ="#DocModal" class="flow-left btn btn-success ShowClaimModal">
                                                Show Document
                                    </button></th>
                        <th class="">
                        <?php  
                 if($Doc_Data ['claim_status'] =='Pending') {
                        ?>  
                        
                        <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" name="Claim_Varify[]" value=<?php echo $Doc_Data ['claim_id']; ?>>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                                </div>
                                <?php } elseif($Doc_Data ['claim_status'] =='Approved') { ?>
                                  <p class="text-success"><?php echo $Doc_Data ['claim_status']; ?></p>

                              <?php  } 

                              ?>
                              </th>
                        </thead>                   
                    <?php 
                $i++;    
                } 
                 if($i ==1) {
                        ?>

                        <thead class="text-center"><th colspan="8">No Claim Request</th></thead>
                        <?php
                }?>
                        
                    </tbody>
                  </table>
                  <?php if($DocFlag) {  ?>
                      <button type="submit" name= "user_id" value=<?php echo $user_id; ?> class="btn btn-primary pull-right">Update Profile<div class="ripple-container"></div></button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="https://creative-tim.com/presentation">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
              <li>
                <a href="https://www.creative-tim.com/license">
                  Licenses
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
          </div>
        </div>
      </footer>
    </div>
  </form>
  </div>

  <!-- Modal -->

  <!-- <div id="DocModal" class="modal hide fade" role="dialog" aria-labelledby="DocModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3>Order</h3>

    </div>
    
    <div id="orderItems" class="modal-body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div> -->
 <div class="modal fade" id="DocModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div id="ModalDetails" class="modal-body text-center">
      <?php foreach($DocInfo as $Doc_Data )

                    { 
                        echo '<img style="display:none" src="'.$Doc_Data['document'].'"  width="300" height="300" class = "doc'.$Doc_Data['doc_id'].' rounded mx-auto "/>';
                    }

           ?> 
      <?php foreach($ClaimInfo  as $Doc_Data )

          { 
              echo '<img style="display:none" src="'.$Doc_Data['doc'].'"  width="300" height="300" class = "claim'.$Doc_Data['claim_id'].' rounded mx-auto "/>';
          }

                  ?>  
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../assets/js/plugins/arrive.minorderModal"></script>
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert").slideUp(500);
        });

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }
        $(".ShowDocModal").click(function(event){
           
               // $('#ModalDetails').html($('<b> Order Id selected:'+ $(this).data('id')+' </b>'));
               

        })

        $(document).on('click', '.ShowDocModal',  function () { 
                        $('img').hide();      
                        $('.doc'+$(this).data('id')).show();
                    });

            $(document).on('click', '.ShowClaimModal',  function () { 
                $('img').hide();      
                $('.claim'+$(this).data('id')).show();
            });


        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

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
      // Javascript method's body can be found in /AdminPanel/assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>
</body>

</html>




