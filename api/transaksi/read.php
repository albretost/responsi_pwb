<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../config.php";

$query = "SELECT * FROM transaksi";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r) > 0) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'id' => $row['id'],
            'pesanan_id' => $row['pesanan_id'],
            'bayar' => $row['bayar'],
            'total_pembelian' => $row['total_pembelian'],
            'sisa_bayar' => $row['sisa_bayar'],
            'created_at' => date('d F Y', strtotime($row['created_at']))
        ];
        array_push($arr['data'], $item);
    }
    
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No transaksi found.")
    );
}
?>