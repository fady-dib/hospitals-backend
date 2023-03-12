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
    $query_rooms->bind_param('i', $department_id);
    $query_rooms->execute();
    $query_rooms->store_result();
    $num_rows_rooms = $query_rooms -> num_rows();
    $query_rooms -> bind_result($room_id, $room_number, $bed_id, $bed_number);

    // if($num_rows_rooms > 0){
    //     $query_beds =$mysqli -> prepare('SELECT id, bed_number from beds where room_id=? and occupied = 0');
    //     $query_beds -> bind_param('i',$room_id);
    //     $query_beds->execute();
    //     $query_beds->store_result();
    //     $num_rows_beds = $query_beds -> num_rows();
    //     $query_beds -> bind_result($bed_id, $bed_number);
    //     if($num_rows_beds == 0){
    //         $response['']
    //     }

    //}

}

?>