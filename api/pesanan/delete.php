<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../config.php";

$arr = json_decode(file_get_contents("php://input"));

$data = [
    'id_pesanan' => htmlspecialchars(strip_tags($arr->id_pesanan))
];

$query = "CALL KelolaPesanan('$data[id_pesanan]','','','','','3')";
$r = mysqli_query($conn, $query);
if ($r === true) {
    http_response_code(200);
    echo json_encode(array("message" => "Pesanan was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete pesanan."));
}
?>