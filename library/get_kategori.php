<?php
include '../config.php';

if (isset($_POST['id_kategori'])) {
	echo "<option value=''>Pilih Kategori</option>";
	$id = htmlspecialchars(strip_tags($_POST['id_kategori']));
	$query = "SELECT * FROM kategori";
	$r = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($r)) {
		if ($id == $row['id']) {
			echo "<option value='$row[id]' selected>$row[judul]</option>";
		} else {
			echo "<option value='$row[id]'>$row[judul]</option>";
		}
	}
} else {
	echo "<option value=''>Pilih Kategori</option>";
	$query = "SELECT * FROM kategori";
    $r = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($r)) {
		echo "<option value='$row[id]'>$row[judul]</option>";
	}
}
