<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_id  = '';
$password = '';
$msg= array();

//$futureDate=date('Y-m-d', strtotime('+one year', $startDate));
//$date = date('Y-m-d', strtotime('+1 month', $startDate));

// $data = json_decode(file_get_contents("php://input"));


// $user_id = $data->user_id;
// $email = $data->email;
// $password = $data->password;

$post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
$user_id = $post['user_id'];

$table_name = 'users_policy';

$query = "SELECT * FROM `users_policy` WHERE NOW() BETWEEN policy_purchase_dt+INTERVAL 11 MONTH AND policy_purchase_dt+INTERVAL 12 MONTH AND payment_status = 'Approved'";

$result = mysqli_query($db,$query);
$rowcount=mysqli_num_rows($result);


if($rowcount>0){

    http_response_code(200);

    while($row=mysqli_fetch_assoc($result)){
        //  cast results to specific data types
        $msg['Dataset'][] = $row;
    }

       
}
else{
    http_response_code(400);
    $msg["error"] = "No Policy Going to expire";
    //echo '{"msg":[{"error":"username is not exist"}]}';
}
echo json_encode($msg);
?>
