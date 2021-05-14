<?php
error_reporting(0);
session_start();
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "responsi_pwb";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn->connect_error;
  exit();
}

$namaWebsite = "Toko Pakaian";

function rupiah($angka)
{
  $hasil_rupiah = "Rp " . number_format($angka, 0, '', '.');
  return $hasil_rupiah;
}