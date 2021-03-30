
<?php
include_once '../Config.php';





// $data = json_decode(file_get_contents("php://input"));


// $user_name = $data->user_name;
// $email = $data->email;
// $password = $data->password;


$table_name = 'claim_doc';

$query = "ALTER TABLE `user_document` CHANGE `document` `document` BLOB NOT NULL";

$result = mysqli_query($db,$query);
echo $result;
echo '{"msg":[{"error": "'.str_replace("'", "",$db->error).'" }]}';
die();

if(mysqli_num_rows($result)){

		    while($row=mysqli_fetch_row($result)){
        //  cast results to specific data types

        echo '<img src="'.$row[2].'" />';

        
    }

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


