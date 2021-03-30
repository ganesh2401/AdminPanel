<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_id  = '';
$password = '';
$msg['msg'] = array();


// $data = json_decode(file_get_contents("php://input"));


// $user_id = $data->user_id;
// $email = $data->email;
// $password = $data->password;

$post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
$user_id = $post['user_id'];

$table_name = 'user';

$query = "SELECT  first_name, middle_name, last_name, date_of_birth FROM " . $table_name . " WHERE user_id = '$user_id' LIMIT 0,1";

$result = mysqli_query($db,$query);
$rowcount=mysqli_num_rows($result);

//echo $rowcount;



if($rowcount>0){

    http_response_code(200);
    $userrow = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($userrow['first_name'])
    {
        $table_name = '';
        $query = "SELECT C.claim_id claim_id, C.claim_status Claim_status FROM claim C,users_policy U WHERE U.up_user_id ='$user_id' AND C.up_id = U.up_id";
        $claim_result = mysqli_query($db,$query);
        if(mysqli_num_rows($claim_result)){
            //http_response_code(200);
        
            $first = true;
            //$row=mysqli_fetch_assoc($result);
            while($row=mysqli_fetch_assoc($claim_result)){
                //  cast results to specific data types
               
                $msg['msg']["claim_list"] = $row;
               
            }

        } else {
            $msg['msg']["claim_list"] = '[]'; 
        }

        $msg['msg']["user_data"] = $userrow;
        unset($msg['msg']["user_data"]['password']);
    }
    else{
        http_response_code(400);
        $msg['msg']["error"] = "Password is wrong please check password";

        //echo '{"msg":[{"error":"Password is wrong please check password"}]}';
        //echo json_encode($msg);
    }
}
else{
    http_response_code(400);
    $msg['msg']["error"] = "username is not exist";
    //echo '{"msg":[{"error":"username is not exist"}]}';
}
echo json_encode($msg);
?>
