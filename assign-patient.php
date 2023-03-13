<?php

include('connection.php');

$patient_id = $_POST['patient_id'];
$hospital_id = $_POST['hospital_id'];

$assigned = 1;
$is_active = 1;
$date_joined = date('d-m-Y');

$response= [];


if(isset($patient_id, $hospital_id)){

$query = $mysqli ->prepare('INSERT INTO hospital_users (hospital_id, user_id, is_active, date_joined) values(?,?,?,?)');
$query->bind_param('iiss',$hospital_id, $patient_id, $is_active, $date_joined);
if($query -> execute()){
    $response['response'] = "Patient was succesfuly assigned";
    $query_assigned = $mysqli -> prepare('UPDATE users set assigned = 1 where id =?');
    $query_assigned ->bind_param('i',$patient_id);
    $query_assigned->execute();
}
else{
    $response['response'] = mysqli_stmt_error($query);
}
}
else{
    $response['response']= "missing fields";
}


echo json_encode($response);

?>