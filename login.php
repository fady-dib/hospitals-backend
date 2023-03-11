<?php

include('connection.php');

$email = $_POST['email'];
$password = $_POST['password'];

$query = $mysqli->prepare('Select id,name,email,password,dob,usertype_id from users where email=?');
$query -> bind_param('s', $email);
$query -> execute();
$query -> store_result();
$num_rows = $query -> num_rows();
$query -> bind_result($id,$name,$email,$hashed_password,$dob,$usertype_id);
$query -> fetch();
$response =[];
if($num_rows == 0){
    $response['response'] = "User not found";
}
else{
    if(password_verify($password, $hashed_password)){
        $response['response'] = "Logged in";
        $response['usertype'] = $usertype_id;
    }
    else{
        $response['response'] = "Incorrect password";
    }
}

echo json_encode($response)

    ?>