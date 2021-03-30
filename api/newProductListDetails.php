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





$query = "SELECT * FROM `new_policy`";

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


?>
