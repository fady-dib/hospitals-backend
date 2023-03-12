<?php

include('connection.php');

$user_id = $_POST['user_id'];

$query_department = $mysqli -> prepare('SELECT id,name  from departments inner join hospital_users on departments.hospital_id = hospital_users.hospital_id where user_id=?');
$query_department -> bind_param('i',$user_id);
$query_department -> execute();
$query_department -> store_result();
$num_rows_department = $query_department -> num_rows();
$query_department -> bind_result($department_id, $department_name);

$response= [
    'departments' => [],
    'rooms' => [],
    'beds' => []
];

if($num_rows_department > 0) {
    $query_rooms_beds =$mysqli -> prepare('SELECT rooms.id, room_number, beds.id, bed_number  from rooms inner join beds on rooms.id = beds.room_id where department_id=? and occupied = 0');
    $query_rooms_beds->bind_param('i', $department_id);
    $query_rooms_beds->execute();
    $query_rooms_beds->store_result();
    $num_rows_rooms_beds = $query_rooms_beds -> num_rows();
    $query_rooms_beds -> bind_result($room_id, $room_number, $bed_id, $bed_number);

    if($num_rows_rooms_beds == 0){
        $response['response'] = "No available rooms";
    }
    else{
        while($query_department -> fetch()){
            $department_data =[
                'department_id' => $department_id,
                'department_name' => $department_name,
            ];
            array_push($response['departments'], $department_data);
        }
        while($query_rooms_beds -> fetch()){
            $rooms_data =[
                'room_id' => $room_id,
                'room_number' => $room_number,
            ];
            $beds_data =[
                'bed_id' => $bed_id,
                'bed_number' => $bed_number,
            ];
            array_push($response['rooms'], $rooms_data);
            array_push($response['beds'], $beds_data);
        }
        
    }

}
else{
    $response['response'] = 'Patient is not assigned to a hospital';
}

echo json_encode($response);

?>