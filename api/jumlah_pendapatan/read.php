<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../config.php";

$query = "SELECT SUM(t.total_pembelian) as jumlah_pendapatan, MONTHNAME(t.created_at) as bulan FROM transaksi t GROUP BY YEAR(t.created_at), MONTH(t.created_at)";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r) > 0) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'bulan' => substr($row['bulan'], 0, 3),
            'jumlah_pendapatan' => $row['jumlah_pendapatan']
        ];
        array_push($arr['data'], $item);
    }
    
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No jumlah pendapatan found.")
    );
}
?>