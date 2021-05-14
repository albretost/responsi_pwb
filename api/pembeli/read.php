<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../config.php";

$query = "SELECT * FROM pembeli";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r)) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'username' => $row['username'],
            'password' => $row['password'],
            'created_at' => date('d F Y', strtotime($row['created_at'])),
            'updated_at' => date('d F Y', strtotime($row['updated_at']))
        ];
        array_push($arr['data'], $item);
    }
    
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No header_bayar found.")
    );
}
?>