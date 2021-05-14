<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->id_produk)&&
    !empty($arr->jumlah_beli)
) {
    $data = [
        'id_produk' => htmlspecialchars(strip_tags($arr->id_produk)),
        'jumlah_beli' => htmlspecialchars(strip_tags($arr->jumlah_beli))
    ];

    $pembeli_id = $_SESSION['logged_in'];
    
    $query = "CALL KelolaPesanan('','$data[id_produk]','$pembeli_id','$data[jumlah_beli]','0',1)";
    $r = mysqli_query($conn, $query);
    if ($r === true) {
        http_response_code(201);
        echo json_encode(array("message" => "Pesanan was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create pesanan."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create detail_bayar. Data is incomplete."));
}
?>