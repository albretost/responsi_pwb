<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

$data = [
    'id_produk' => htmlspecialchars(strip_tags($arr->id_produk))
];

$query = "CALL KelolaProduk('$data[id_produk]','','','','','','3')";
$r = mysqli_query($conn, $query);
if ($r === true) {
    http_response_code(200);
    echo json_encode(array("message" => "Produk was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete produk."));
}
?>