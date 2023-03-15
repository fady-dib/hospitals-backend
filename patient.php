<?php

include('connection.php');

$user_id = $_POST['user_id'];

$query_department = $mysqli->prepare('SELECT DISTINCT id,name  from departments inner join hospital_users on departments.hospital_id = hospital_users.hospital_id where user_id=?');
$query_department->bind_param('i', $user_id);
$query_department->execute();
$query_department->store_result();
$num_rows_department = $query_department->num_rows();
$query_department->bind_result($department_id, $department_name);

$query_medications = $mysqli->prepare('SELECT id, name, cost,quantity from medications where quantity>0');
$query_medications->execute();
$query_medications->store_result();
$num_rows_medications = $query_medications->num_rows();
$query_medications->bind_result($medication_id, $medication_name, $medication_cost, $medication_quantity);

$response = [
    'departments' => [],
    'medications' => [],
];

 if ($num_rows_department >0){
    while ($query_department->fetch()) {
        $department_data = [
            'department_id' => $department_id,
            'department_name' => $department_name,
        ];
        array_push($response['departments'], $department_data);
    }
}
else  {
    $response['status'] = 100; // no available departments
}


if ($num_rows_medications > 0) {
    while ($query_medications->fetch()) {
        $medications_data = [
            'medication_id' => $medication_id,
            'medication_name' => $medication_name,
            'medication_cost' => $medication_cost,
            'medication_quantity' => $medication_quantity
        ];
        array_push($response['medications'], $medications_data);
    }
} else {
    $response['status'] = 101; // no available medictions
}


$query_department->free_result();
$query_department->close();


$query_medications->free_result();
$query_medications->close();

echo json_encode($response);

?>