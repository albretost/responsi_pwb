<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include "../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->name) &&
    !empty($arr->username) &&
    !empty($arr->password) &&
    !empty($arr->repeatPassword)
) {
    session_start();
    $data = [
        'name' => htmlspecialchars(strip_tags($arr->name)),
        'username' => htmlspecialchars(strip_tags($arr->username)),
        'password' => htmlspecialchars(strip_tags($arr->password)),
        'repeatPassword' => htmlspecialchars(strip_tags($arr->repeatPassword))
    ];

    if ($data['password'] == $data['repeatPassword']) {
        $passwordEnkripsi = hash('sha512', $data['password']);
        $sql = "CALL KelolaPembeli('','$data[name]','$data[username]','$passwordEnkripsi',1)";
        $r = mysqli_query($conn, $sql);
        if ($r) {
            http_response_code(201);
            echo json_encode(array("message" => "Pembeli was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create pembeli."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create pembeli. Data is incomplete."));
}
