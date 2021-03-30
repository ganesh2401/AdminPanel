<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_name  = '';
$policy_id = '';
$claim_hosp_from_dt = '';
$claim_hosp_to_dt = '';
$claim_amt = '';
$claim_dsc = '';



// $data = json_decode(file_get_contents("php://input"));


// $user_name = $data->user_name;
// $email = $data->email;
// $claim_dsc = $data->claim_dsc;
$post = json_decode(file_get_contents("php://input"),true);
$user_id = $post['user_id'];
$policy_id = $post['policy_id'];
$claim_hospital_no = $post['claim_hospital_no'];
$claim_hosp_from_dt = $post['claim_hosp_from_dt'];
$claim_hosp_to_dt = $post['claim_hosp_to_dt'];
$claim_amt = $post['claim_amt'];
$claim_dsc = $post['claim_dsc'];
$document_string = $post['document_string'];

$table_name = 'claim';

$upid_query = mysqli_query($db,"SELECT up_id FROM users_policy WHERE up_user_id ='$user_id' AND up_policy_id='$policy_id'");
$upidresult= mysqli_fetch_assoc($upid_query);
$up_id = $upidresult["up_id"];


$query = "INSERT INTO ".$table_name ."(claim_hosp_from_dt, claim_hosp_to_dt, claim_amt, claim_dsc,up_id, claim_hospital_no) VALUES ('$claim_hosp_from_dt','$claim_hosp_to_dt','$claim_amt','$claim_dsc','$up_id','$claim_hospital_no')";

$result = mysqli_query($db,$query);
$last_id = mysqli_insert_id($db);

$doc_query = "INSERT INTO claim_doc (claim_id,doc) VALUES ('$last_id','$document_string')";
$doc_result = mysqli_query($db,$doc_query);
//echo $db->error;

if($result  === TRUE){

    http_response_code(200);
    echo '{"msg":[{"success":"Claim Added Successfully"}]}';

}
else{
    http_response_code(400);

    echo '{"msg":[{"error": "'.str_replace("'", "",$db->error).'" }]}';
}
?>
