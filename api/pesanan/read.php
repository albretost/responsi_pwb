<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../config.php";

$id_user = $_SESSION['logged_in'];

$query = $_SESSION['level'] == 'user' ? "SELECT pe.id AS id_pesanan, pe.*, pr.*, pem.*, kat.judul AS nama_kategori FROM pesanan pe JOIN produk pr ON pe.produk_id = pr.id JOIN pembeli pem ON pe.pembeli_id = pem.id JOIN kategori kat ON pr.kategori_id = kat.id WHERE pe.pembeli_id = '$id_user'" : "SELECT pe.id AS id_pesanan, pe.*, pr.*, pem.*, kat.judul AS nama_kategori FROM pesanan pe JOIN produk pr ON pe.produk_id = pr.id JOIN pembeli pem ON pe.pembeli_id = pem.id JOIN kategori kat ON pr.kategori_id = kat.id";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r)) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'id' => $row['id_pesanan'],
            'nama_produk' => $row['judul'],
            'nama_kategori' => $row['nama_kategori'],
            'nama_pembeli' => $row['nama'],
            'harga' => $row['harga'],
            'jumlah_beli' => $row['jumlah_beli'],
            'status' => $row['status'],
            'created_at' => date('d F Y', strtotime($row['created_at']))
        ];
        array_push($arr['data'], $item);
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