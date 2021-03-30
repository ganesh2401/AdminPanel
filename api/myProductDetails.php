<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_id = '';
$policy_no = '';



$post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
$user_id = $post['user_id'];
$policy_no = $post['policy_no'];




$query = "SELECT N.* FROM new_policy N WHERE N.policy_id = '$policy_no'";

$result = mysqli_query($db,$query);

    if(mysqli_num_rows($result)){
        http_response_code(200);
        //$row=mysqli_fetch_assoc($result);
        while($row=mysqli_fetch_assoc($result)){
            //  cast results to specific data types
            
            $msg["Policy_data"][] = $row;
        }
    
    } else {
        $msg["Policy_data"][]= [];
    }
$user_query = "SELECT U.*,UP.payment_staus ,UP.policy_purchase_dt 	 FROM user U, users_policy UP WHERE U.user_id = '$user_id' AND UP.up_user_id = U.user_id";
$user_result = mysqli_query($db,$user_query);

    if(mysqli_num_rows($user_result)){
        http_response_code(200);
        //$row=mysqli_fetch_assoc($result);
        while($user_row=mysqli_fetch_assoc($user_result)){
            //  cast results to specific data types
            
            $msg["User_data"] = $user_row;
            unset($msg["User_data"]['password']);
        }
    
    } else {
        $msg["User_data"]= [];
    }

    
    echo json_encode($msg);
    mysqli_close($db);

?>