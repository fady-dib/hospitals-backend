<?php

include('connection.php');

$query_patients = $mysqli->prepare('select id,name from users where usertype_id = 2 and assigned = 0');
$query_patients->execute();
$query_patients->store_result();
$num_rows_patients = $query_patients->num_rows();
$query_patients->bind_result($patient_id, $patient_name);

$query_hospitals = $mysqli->prepare('select id,name from hospitals');
$query_hospitals->execute();
$query_hospitals->store_result();
$num_rows_hospitals = $query_hospitals->num_rows();
$query_hospitals->bind_result($hospital_id, $hospital_name);

$response = [
    'patients' => [],
    'hospitals' => [],
];

if ($num_rows_patients == 0) {
    $response['response'] = 'All patients are assigned';
}
else if($num_rows_hospitals == 0 ){
    $response['response'] = "No hospital available";
}
else{
    while($query_patients -> fetch()){
        $patient_data =array(
            'patient_name' => $patient_name,
            'patient_id' => $patient_id,
        );
        array_push($response['patients'], $patient_data);
    }
    while($query_hospitals -> fetch()) {
        $hospitals_data = array(
            'hospital_id' => $hospital_id,
            'hospital_name' => $hospital_name,
        );
        array_push($response['hospitals'], $hospitals_data);
    }
}

echo json_encode(($response));


?>