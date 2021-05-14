<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include "../../config.php";

$id = isset($_GET['id']) ? $_GET['id'] : die();
$query = "SELECT pe.id AS id_pesanan, pe.*, pr.*, pem.*, kat.judul AS nama_kategori FROM pesanan pe JOIN produk pr ON pe.produk_id = pr.id JOIN kategori kat ON pr.kategori_id = kat.id JOIN pembeli pem ON pe.pembeli_id = pem.id WHERE pe.id = '$id'";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r) > 0) {
    while ($row = mysqli_fetch_array($r)) {
        $arr = [
            'id' => $row['id_pesanan'],
            'nama_produk' => $row['judul'],
            'nama_kategori' => $row['nama_kategori'],
            'nama_pembeli' => $row['nama'],
            'harga' => $row['harga'],
            'jumlah_beli' => $row['jumlah_beli'],
            'created_at' => date('d F Y', strtotime($row['created_at']))
        ];
    }
    
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No pesanan found.")
    );
}
?>