<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../config.php";

$query = "SELECT produk.*, kategori.judul AS 'judul_kategori', penjual.nama FROM produk JOIN kategori ON produk.kategori_id = kategori.id JOIN penjual ON produk.penjual_id = penjual.id";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r) > 0) {
    $arr['data'] = [];
    while ($row = mysqli_fetch_array($r)) {
        $item = [
            'id' => $row['id'],
            'kategori' => $row['judul_kategori'],
            'penjual' => $row['nama'],
            'judul' => $row['judul'],
            'deskripsi' => $row['deskripsi'],
            'harga' => $row['harga'],
            'created_at' => date('d F Y', strtotime($row['created_at'])),
            'updated_at' => date('d F Y', strtotime($row['updated_at']))
        ];
        array_push($arr['data'], $item);
    }
    
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No produk found.")
    );
}
?>