<?php

include('connection.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$dob = $_POST['dob'];

$usertype_id = 2;

$email_verification = $mysqli->prepare('select email from users where email=?');
$email_verification->bind_param('s', $email);
$email_verification->execute();
$email_verification->store_result();
$exists = $email_verification->num_rows();

$response = [];

if (empty($email)) {
    $response['response'] = "email is required";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['response'] = 'Inavlid email format';
} else {
    if (empty($password)) {
        $response['response'] = 'Password is required';
    }


    if ($exists > 0) {
        $response['response'] = "Already registered";
    } else {
        $query = $mysqli->prepare('insert into users(name,email,password,dob,usertype_id) values(?,?,?,?,?)');
        $query->bind_param('ssssi', $name, $email, $password, $dob, $usertype_id);
        $query->execute();
        $response['response'] = 'Success';
    }
}

echo json_encode($response)

    ?>