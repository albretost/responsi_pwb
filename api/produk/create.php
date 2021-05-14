<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->judul) &&
    !empty($arr->kategori_id) &&
    !empty($arr->deskripsi) &&
    !empty($arr->harga)
) {
    $data = [
        'judul' => htmlspecialchars(strip_tags($arr->judul)),
        'kategori_id' => htmlspecialchars(strip_tags($arr->kategori_id)),
        'deskripsi' => htmlspecialchars(strip_tags($arr->deskripsi)),
        'harga' => htmlspecialchars(strip_tags($arr->harga))
    ];

    $penjual_id = $_SESSION['logged_in'];
    
    $query = "CALL KelolaProduk('','$data[kategori_id]','$penjual_id','$data[judul]','$data[deskripsi]','$data[harga]',1)";
    $r = mysqli_query($conn, $query);
    if ($r === true) {
        http_response_code(201);
        echo json_encode(array("message" => "Produk was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create produk."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create produk. Data is incomplete."));
}
