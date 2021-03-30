<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


 $user_id = $post["user_id"];
 $date_of_birth = $post["date_of_birth"]; 
 $email_id = $post["email_id"]; 
 $address = $post["address"];
 $city = $post["city"]; 
 $state = $post["state"]; 
 $pan_no = $post["pan_no"]; 
 $addhar_no = $post["addhar_no"]; 
 $bank_acc_no = $post["bank_acc_no"];
 $ifsc_code = $post["ifsc_code"]; 
 $bank_branch_name = $post["bank_branch_name"]; 
 $bank_address = $post["bank_address"]; 
 $is_active = $post["is_active"];



// $data = json_decode(file_get_contents("php://input"));


// $user_name = $data->user_name;
// $email = $data->email;
// $password = $data->password;

$table_name = 'user';
$password_hash = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO ".$table_name ."(date_of_birth,email_id,address,city,state,pan_no,addhar_no,bank_acc_no,ifsc_code,bank_branch_name,bank_address,is_doc_verified,is_active) VALUES ('$date_of_birth','$email_id','$address','$city','$state','$pan_no','$addhar_no','$bank_acc_no','$ifsc_code','$bank_branch_name','$bank_address','$is_doc_verified','$is_active') WHERE user_id = '$user_id'";

$result = mysqli_query($db,$query);

//echo $db->error;

if($result  === TRUE){

    http_response_code(200);
    echo '{"msg":[{"success":"Your Successfully register Please Login With mentioned credential"}]"}';

}
else{
    http_response_code(400);

    echo '{"msg":[{"error": "'.str_replace("'", "",$db->error).'" }]}';
}
?>
