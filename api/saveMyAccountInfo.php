<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_name  = '';
$first_name = '';
$middle_name = '';
$last_name = '';
$mobile_no = '';
$password = '';






// $user_name = $data->user_name;
// $email = $data->email;
// $password = $data->password;
$post = json_decode(file_get_contents("php://input"),true);
    //$post = json_decode($data, true);
$user_id = $post['user_id'];
$date_of_birth = $post['date_of_birth'];
$Gender = $post['Gender'];
$address = $post['address'];
$city = $post['city'];
$state = $post['state'];
$addhar_no = $post['addhar_no'];
$pan_no = $post['pan_no'];
$bank_acc_no = $post['bank_acc_no'];
$ifsc_code   = $post['ifsc_code'];
$bank_branch_name = $post['bank_branch_name'];
$bank_address = $post['bank_address'];
$DocString[] = $post['photostring'];
$DocString[] = $post['PANString'];
$DocString[]= $post['aadharString'];
$DocString[] = $post['bankString'];
$table_name = 'user';


foreach($DocString as $document){

    $insert_query = "INSERT INTO user_document ('user_id',document) VALUES ('$user_id','$document')";
    $insert_result = mysqli_query($db,$insert_query);
}
$query = "UPDATE user SET `date_of_birth`='$date_of_birth',`address`='$address, `Gender`='$Gender',`city`='$city',`state`='$state',`pan_no`='$pan_no',`addhar_no`='$addhar_no',`bank_acc_no`='$bank_acc_no',`ifsc_code`='$ifsc_code',`bank_branch_name`='$bank_branch_name',`bank_address`='$bank_address' WHERE user_id ='$user_id'";


$result = mysqli_query($db,$query);

//echo $db->error;

if($result  === TRUE){

    http_response_code(200);
    echo '{"msg":[{"success":"User information updated Successfully. Please, Wait for Verifing Document."}]"}';

}
else{
    http_response_code(400);

    echo '{"msg":[{"error": "'.str_replace("'", "",$db->error).'" }]}';
}
?>
