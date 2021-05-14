<?php
switch ($_GET['page']) {
    case 'kategori':
        $_SESSION['level'] == 'admin' ? include "content/admin/kategori.php" : '';
        break;
    case 'produk':
        $_SESSION['level'] == 'admin' ? include "content/admin/produk.php" : include "content/user/produk.php";
        break;
    case 'pembeli':
        $_SESSION['level'] == 'admin' ? include "content/admin/pembeli.php" : include "content/user/pembeli.php";
        break;
    case 'pesanan':
        $_SESSION['level'] == 'admin' ? include "content/admin/pesanan.php" : include "content/user/pesanan.php";
        break;    
    case 'transaksi':
        $_SESSION['level'] == 'admin' ? include "content/admin/transaksi.php" : include "content/user/transaksi.php";
        break;
    default:
        break;
}
?>