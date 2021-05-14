<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include "../../config.php";

$id = isset($_GET['id']) ? $_GET['id'] : die();
$query = "SELECT * FROM produk WHERE id = '$id'";
$r = mysqli_query($conn, $query);
if (mysqli_num_rows($r)) {
    while ($row = mysqli_fetch_array($r)) {
        $arr = [
            'id' => $row['id'],
            'kategori_id' => $row['kategori_id'],
            'penjual_id' => $row['penjual_id'],
            'judul' => $row['judul'],
            'deskripsi' => $row['deskripsi'],
            'harga' => $row['harga'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
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