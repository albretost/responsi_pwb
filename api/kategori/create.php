<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "../../config.php";
$arr = json_decode(file_get_contents("php://input"));
if (
    !empty($arr->judul)
) {
    $data = [
        'judul' => htmlspecialchars(strip_tags($arr->judul))
    ];
    $query = "CALL KelolaKategori('','$data[judul]',1)";
    $r = mysqli_query($conn, $query);
    if ($r) {
        http_response_code(201);
        echo json_encode(array("message" => "Kategori was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create kategori."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create kategori. Data is incomplete."));
}
?>