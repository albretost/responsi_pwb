<?php
include '../config.php';

echo "<option value=''>Pilih Detail</option>";

$query = "SELECT db.id_detail, db.jumlah_beli, s.id_sepatu, s.id_merk, s.ukuran, m.nama_merk FROM detail_bayar db LEFT JOIN sepatu s ON db.id_sepatu = s.id_sepatu LEFT JOIN merk m ON m.id_merk = s.id_merk";
$r = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($r)) {
    echo "<option value='" . $row['id_detail'] . "'>" . $row['id_detail'] . "-jumbel:" . $row['jumlah_beli'] . "</option>";
}
