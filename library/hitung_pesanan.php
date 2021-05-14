<?php
include '../config.php';

$id = htmlspecialchars(strip_tags($_POST['id_pembeli']));
if ($_SESSION['level'] == 'user' && isset($id)) {
    $query = "SELECT count(id) AS hitungPesanan FROM pesanan WHERE pembeli_id = $id";
    $r = mysqli_query($conn, $query);
    $row = mysqli_fetch_object($r);
    echo $row->hitungPesanan;
}
