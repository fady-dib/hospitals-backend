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
    $hash_p = md5($password);
    // $a =password_verify()
    if(($password == $hashed_password)){
        $response['response'] = "Loggedin";
        $response['usertype'] = $usertype_id;
        $response['user_id'] = $id;
    }
    else{
        $response['response'] = "Incorrect password";
    }
}

echo json_encode($response)

    ?>