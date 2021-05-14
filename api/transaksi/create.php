<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

if (
    !empty($arr->pesanan_id) &&
    !empty($arr->bayar) &&
    !empty($arr->total_pembelian)
) {
    $data = [
        'pesanan_id' => htmlspecialchars(strip_tags($arr->pesanan_id)),
        'bayar' => htmlspecialchars(strip_tags($arr->bayar)),
        'total_pembelian' => htmlspecialchars(strip_tags($arr->total_pembelian))
    ];

    $sisa = ($data['bayar'] - $data['total_pembelian']);

    $query = "CALL KelolaTransaksi('','$data[pesanan_id]','$data[bayar]','$data[total_pembelian]','$sisa',1)";
    $r = mysqli_query($conn, $query);
    if ($r === true) {
        http_response_code(201);
        echo json_encode(array("message" => "Transaksi was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create transaksi."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create transaksi. Data is incomplete."));
}
