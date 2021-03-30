<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_id = '';

$post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
$user_id = $post['user_id'];

$query = "SELECT is_doc_verified  FROM `user` WHERE user_id = '$user_id'";

$result = mysqli_query($db,$query);

    if(mysqli_num_rows($result)){
        http_response_code(200);
        //$row=mysqli_fetch_assoc($result);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            
            $msg["is_varify"] = $row;
        }
    
    } else {
        $msg["is_varify"]= "";
    }

echo json_encode($msg);
mysqli_close($db);

?>
