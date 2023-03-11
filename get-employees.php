<?php

include('connection.php');

$query_employees = $mysqli -> prepare('select id, name from users where usertype_id = 1');
$query_employees->execute();
$query_employees->store_result();
$num_rows_employees = $query_employees->num_rows();
$query_employees->bind_result($employee_id, $employee_name);

$query_hospitals = $mysqli->prepare('select id,name from hospitals');
$query_hospitals->execute();
$query_hospitals->store_result();
$num_rows_hospitals = $query_hospitals->num_rows();
$query_hospitals->bind_result($hospital_id, $hospital_name);

$response = [
    'employees' => [],
    'hospitals' => [],
];

if ($num_rows_employees == 0) {
    $response['response'] = 'Unavailable employees';
}
else if($num_rows_hospitals == 0 ){
    $response['response'] = "No hospital available";
}
else{
    while($query_employees -> fetch()){
        $employees_data = [
            'employee_id' => $employee_id,
            'employee_name' => $employee_name,
        ];
        array_push($response['employees'], $employees_data);
    }
    while($query_hospitals -> fetch()) {
        $hospitals_data = [
            'hospital_id' => $hospital_id,
            'Hospital_name' => $hospital_name,
        ];
        array_push($response['hospitals'], $hospitals_data);
    }
}

echo json_encode(($response));

?>