<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include "../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->username) &&
    !empty($arr->password)
) {
    session_start();
    $data = [
        'username' => htmlspecialchars(strip_tags($arr->username)),
        'password' => htmlspecialchars(strip_tags($arr->password))
    ];

    $passwordEnkripsi = hash('sha512', $data['password']);
    $tabelPengguna = ['pembeli', 'penjual'];
    $status = NULL;
    foreach ($tabelPengguna as $tabel) {
        $sql = "SELECT * FROM $tabel WHERE username = '$data[username]' AND password='$passwordEnkripsi'";
        $r = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($r);
        $num_rows = mysqli_num_rows($r);
        if ($num_rows >= 1) {
            $status = TRUE;
            break;
        } else {
            $status = FALSE;
        }
    }
    if ($status == TRUE) {
        $_SESSION['level'] = !empty($row['gaji']) ? 'admin' : 'user';
        $_SESSION['logged_in'] = $row['id'];
        http_response_code(200);
        echo json_encode(array(
            "login" => "true"
        ));
    } else {
        http_response_code(503);
        echo json_encode(array(
            "login" => "false",
            "message" => "Unable to login."
        ));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "login" => "false",
        "message" => "Field is incomplete."
    ));
}
