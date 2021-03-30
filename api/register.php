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

$user_name = $post['user_name'];
$first_name = $post['first_name'];
$middle_name = $post['middle_name'];
$last_name = $post['last_name'];
$mobile_no = $post['mobile_no'];
$password = $post['password'];

$table_name = 'user';
$password_hash = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO ".$table_name ."(user_name, first_name, middle_name, last_name, mobile_no, password) VALUES ('$user_name','$first_name','$middle_name','$last_name','$mobile_no','$password_hash')";

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
