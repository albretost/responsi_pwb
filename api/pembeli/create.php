<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->nama) &&
    !empty($arr->username) &&
    !empty($arr->password)
) {
    $data = [
        'nama' => htmlspecialchars(strip_tags($arr->nama)),
        'username' => htmlspecialchars(strip_tags($arr->username)),
        'password' => htmlspecialchars(strip_tags($arr->password))
    ];
    
    $passwordEnkripsi = hash('sha512', $data['password']);

    $query = "CALL KelolaPembeli('','$data[nama]','$data[username]','$passwordEnkripsi',1)";
    $r = mysqli_query($conn, $query);
    if ($r === true) {
        http_response_code(201);
        echo json_encode(array("message" => "Pembeli was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create pembeli."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create pembeli. Data is incomplete."));
}
?>