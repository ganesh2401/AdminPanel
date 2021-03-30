<?php
include_once '../Config.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_name = '';
$email = '';
$password = '';


// $data = json_decode(file_get_contents("php://input"));


// $user_name = $data->user_name;
// $email = $data->email;
// $password = $data->password;

$user_id = $_POST['user_id'];


$table_name = 'hospital_list';

$query = "SELECT * FROM ".$table_name."";

$result = mysqli_query($db,$query);


if(mysqli_num_rows($result)){
    http_response_code(200);
    echo '{"Dataset":[';

    $first = true;
    //$row=mysqli_fetch_assoc($result);
    while($row=mysqli_fetch_assoc($result)){
        //  cast results to specific data types

        if($first) {
            $first = false;
        } else {
            echo ',';
        }
        echo json_encode($row);
    }
    echo ']}';
} else {
    echo '[]';
}

mysqli_close($db);

// if($result  === TRUE){

//     http_response_code(200);
//     echo json_encode(array("message" => "User was successfully registered."));
// }
// else{
//     http_response_code(400);

//     echo json_encode(array("message" => "Unable to register the user."));
// }
?>
