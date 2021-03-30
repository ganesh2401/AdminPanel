<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_name  = '';
$password = '';
$msg['msg'] = array();


// $data = json_decode(file_get_contents("php://input"));


// $user_name = $data->user_name;
// $email = $data->email;
// $password = $data->password;
if(isset($_POST['user_name']))
{
$user_name = $_POST['user_name'];
$password = $_POST['password'];
}
else{
    $post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
    $user_name = $post['user_name'];
    $password = $post['password'];
}




$table_name = 'user';
$password_hash = password_hash($password, PASSWORD_BCRYPT);

$query = "SELECT * FROM " . $table_name . " WHERE user_name = '$user_name' LIMIT 0,1";

$result = mysqli_query($db,$query);
$rowcount=mysqli_num_rows($result);

//echo $rowcount;



if($rowcount>0){

    http_response_code(200);
    $userrow = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(password_verify($password, $userrow['password']))
    {
        $msg['msg']["success"] = "Login done Successfully";
        $msg['msg']["is_varify"] = $userrow['is_doc_verified'];
        $table_name = '';
        $query = "SELECT * FROM hospital_list";
        $hospital_result = mysqli_query($db,$query);
        if(mysqli_num_rows($hospital_result)){
            //http_response_code(200);
        
            $first = true;
            //$row=mysqli_fetch_assoc($result);
            while($row=mysqli_fetch_row($hospital_result)){
                //  cast results to specific data types
                $msg['msg']["hospital_data"][] = $row;
            }

        } else {
            $msg['msg']["hospital_data"] = '[]'; 
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
