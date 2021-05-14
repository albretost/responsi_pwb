<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include "../../config.php";
$query = "SELECT * FROM kategori";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r) > 0) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'id' => $row['id'],
            'judul' => $row['judul']
        ];
        array_push($arr['data'], $item);
    }
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No kategori found.")
    );
}
?>