<?php
   require_once "Config.php";
   session_start();
   $error="";   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
          
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword =  crypt(mysqli_real_escape_string($db,$_POST['password']),'rl'); 
      $sql = "SELECT user_id FROM user WHERE user_name = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      if($result){
         $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
         $count = mysqli_num_rows($result);
        }
      else
      {
        $count = 0;
      }
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         header("location: dashboard.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      
      <style type = "text/css"> 
        body {
            margin: 0;
            padding: 0;
            background-color: #28C1E7; 
            height: 100vh;
            }
        #login .container #login-row #login-column #login-box {
            margin-top: 120px;
            max-width: 600px;
            height: 320px auto;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
            }
        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
            }
        #login .container #login-row #login-column #login-box #login-form #register-link {
                margin-top: -85px;
            }
      </style>
      
   </head>
<!------ Include the above in your HEAD tag ---------->

<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Admin Login</h3>
                            <?php if($error) { 
                            echo '<div class="form-group alert alert-danger">';
                            echo $error;
                            echo '</div>';
                             } ?>

                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" value="Admin">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>