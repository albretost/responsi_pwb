<?php
	include '../config.php';

	echo "<option value=''>Pilih Merk</option>";

	$query = "SELECT * FROM merk";
    $r = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($r)) {
		echo "<option value='" . $row['id_merk'] . "'>" . $row['id_merk'] . "-" . $row['nama_merk'] . "</option>";
	}
