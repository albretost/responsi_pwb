/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.14-MariaDB : Database - responsi_pwb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`judul`) values 
(1,'Celana'),
(2,'Baju'),
(3,'Topi'),
(8,'Jaket');

/*Table structure for table `pembeli` */

DROP TABLE IF EXISTS `pembeli`;

CREATE TABLE `pembeli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pembeli` */

insert  into `pembeli`(`id`,`nama`,`username`,`password`,`created_at`,`updated_at`) values 
(12,'Albreto Suryanata Timbung','albretost','425099d1514a4084ea2b867c4effff46e8e2eab8baede8ae3b40eed9ddbf51c25b33a1c551d51e174d3593dce87d7a63eab3abc196eed075993bd6735e5e9893','2021-05-04 22:40:06','2021-05-04 22:40:06'),
(17,'Albreto','eto','425099d1514a4084ea2b867c4effff46e8e2eab8baede8ae3b40eed9ddbf51c25b33a1c551d51e174d3593dce87d7a63eab3abc196eed075993bd6735e5e9893','2021-05-11 23:25:07','2021-05-11 23:25:07'),
(18,'eto','baru','c4940699a10a7089b8a4fdd8bea7c5d90b5f49577e482128198e5735c8a3a84a4f18e91a8fb1f4d0c19e26811d22cf719a1086ba82292dfe7a6aafa6147ae803','2021-05-11 23:34:45','2021-05-11 23:34:45');

/*Table structure for table `penjual` */

DROP TABLE IF EXISTS `penjual`;

CREATE TABLE `penjual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `gaji` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `penjual` */

insert  into `penjual`(`id`,`nama`,`username`,`password`,`gaji`,`created_at`,`updated_at`) values 
(1,'Admin','admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',2000000,'2021-05-04 22:34:20','2021-05-04 22:34:20');

/*Table structure for table `pesanan` */

DROP TABLE IF EXISTS `pesanan`;

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NOT NULL,
  `pembeli_id` int(11) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `status` enum('1','0') DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `pesanan_fk0` (`produk_id`),
  KEY `pesanan_fk1` (`pembeli_id`),
  CONSTRAINT `pesanan_fk0` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`),
  CONSTRAINT `pesanan_fk1` FOREIGN KEY (`pembeli_id`) REFERENCES `pembeli` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pesanan` */

insert  into `pesanan`(`id`,`produk_id`,`pembeli_id`,`jumlah_beli`,`status`,`created_at`) values 
(60,24,12,1,'1','2021-01-14 23:23:06'),
(61,25,12,3,'1','2021-02-14 23:23:09'),
(62,29,17,2,'1','2021-03-14 23:24:05'),
(63,28,17,1,'1','2021-04-14 23:24:07'),
(64,26,18,3,'1','2021-04-14 23:24:56'),
(65,27,18,2,'1','2021-05-14 23:24:59'),
(67,26,18,3,'1','2021-05-14 23:30:12');

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `penjual_id` int(11) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `penjual_id` (`penjual_id`),
  CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`penjual_id`) REFERENCES `penjual` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

/*Data for the table `produk` */

insert  into `produk`(`id`,`kategori_id`,`penjual_id`,`judul`,`deskripsi`,`harga`,`created_at`,`updated_at`) values 
(24,1,1,'Chino','Officia aute quis exercitation cupidatat culpa mollit.',100000,'2021-05-10 23:02:05','2021-05-10 23:02:05'),
(25,2,1,'Bloods','Reprehenderit nulla culpa quis excepteur consectetur exercitation et laboris adipisicing ullamco sunt amet.',70000,'2021-05-10 23:02:48','2021-05-10 23:02:48'),
(26,3,1,'3Second','Enim ipsum sint nulla aliqua culpa.',50000,'2021-05-10 23:03:33','2021-05-10 23:03:33'),
(27,2,1,'3Second','Qui id culpa cillum aliqua sint cillum commodo sit ut officia exercitation aliqua.',70000,'2021-05-10 23:04:32','2021-05-10 23:04:32'),
(28,2,1,'Erigo','Est aute labore ipsum ea non aliquip cupidatat nostrud eu aute non duis minim.',70000,'2021-05-10 23:05:14','2021-05-10 23:05:14'),
(29,8,1,'Erigo','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. ',150000,'2021-05-12 08:26:28','2021-05-12 08:26:28');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pesanan_id` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `sisa_bayar` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transaksi_fk0` (`pesanan_id`),
  CONSTRAINT `transaksi_fk0` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

/*Data for the table `transaksi` */

insert  into `transaksi`(`id`,`pesanan_id`,`bayar`,`total_pembelian`,`sisa_bayar`,`created_at`) values 
(42,60,100000,100000,0,'2021-01-14 23:23:22'),
(43,61,250000,210000,40000,'2021-02-14 23:23:31'),
(44,62,300000,300000,0,'2021-03-14 23:24:17'),
(45,63,100000,70000,30000,'2021-04-14 23:24:24'),
(46,64,150000,150000,0,'2021-04-14 23:25:12'),
(47,65,150000,140000,10000,'2021-05-14 23:25:20'),
(49,67,150000,150000,0,'2021-05-14 23:30:20');

/* Trigger structure for table `transaksi` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `after_insert_transaksi` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `after_insert_transaksi` AFTER INSERT ON `transaksi` FOR EACH ROW BEGIN
	UPDATE pesanan
	SET `status` = 1
	WHERE id = new.pesanan_id;
    END */$$


DELIMITER ;

/* Trigger structure for table `transaksi` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `hapus_transaksi` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `hapus_transaksi` AFTER DELETE ON `transaksi` FOR EACH ROW BEGIN
	UPDATE pesanan
	SET `status` = '0'
	WHERE id = old.pesanan_id;
    END */$$


DELIMITER ;

/* Function  structure for function  `jumlahGaji` */

/*!50003 DROP FUNCTION IF EXISTS `jumlahGaji` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahGaji`(jumlah_pendapatan INT(11)) RETURNS int(11)
BEGIN
	declare jumlahGaji INT;
	SELECT jumlah_pendapatan * (80/100) INTO jumlahGaji;
	return jumlahGaji;
    END */$$
DELIMITER ;

/* Function  structure for function  `jumlahTransaksiPerUser` */

/*!50003 DROP FUNCTION IF EXISTS `jumlahTransaksiPerUser` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahTransaksiPerUser`(id_user INT(11)) RETURNS int(11)
BEGIN
	DECLARE total int;
	SELECT COUNT(tr.id) AS jumlah_transaksi FROM transaksi tr JOIN pesanan pe ON tr.pesanan_id = pe.id JOIN pembeli pem ON pe.pembeli_id = pem.id WHERE pem.id = id_user INTO total;
	return total;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `KelolaKategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `KelolaKategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `KelolaKategori`(IN idkategori INT(11), IN judulkategori VARCHAR(20), IN StatementType INT)
BEGIN
	IF StatementType = 1 THEN
		INSERT INTO kategori  
                        (judul)
		VALUES     (judulkategori);
	ELSEIF StatementType = 2 THEN
		UPDATE kategori  
		SET    judul = judulkategori  
		WHERE  id = idkategori;
	ELSEIF StatementType = 3 THEN
		DELETE FROM kategori  
		WHERE  id = idkategori;
	END IF;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `KelolaPembeli` */

/*!50003 DROP PROCEDURE IF EXISTS  `KelolaPembeli` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `KelolaPembeli`(IN idpembeli INT(11), IN namapembeli VARCHAR(50), IN usernamepembeli VARCHAR(50), IN passwordpembeli VARCHAR(128), IN StatementType INT)
BEGIN
	
	IF StatementType = 1 THEN
		INSERT INTO pembeli  
                        (nama,username,password)
		VALUES     (namapembeli,usernamepembeli,passwordpembeli);
	ELSEIF StatementType = 2 THEN
		UPDATE pembeli  
		SET    
		nama = namapembeli,
		username = usernamepembeli,
		password = passwordpembeli
		WHERE  id = idpembeli;
	ELSEIF StatementType = 3 THEN
		DELETE FROM pembeli  
		WHERE  id = idpembeli;
	END IF;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `KelolaPesanan` */

/*!50003 DROP PROCEDURE IF EXISTS  `KelolaPesanan` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `KelolaPesanan`(IN idpes INT(11), IN produkpes INT(11), IN pembelipes INT(11), IN jumlahpes INT(11), IN statustrans INT(11), IN StatementType INT)
BEGIN
	IF StatementType = 1 THEN
		INSERT INTO pesanan  
                        (produk_id,pembeli_id,jumlah_beli)
		VALUES     (produkpes,pembelipes,jumlahpes);
	ELSEIF StatementType = 2 THEN
		UPDATE produk  
		SET    
		kategori_id = kategoriprod,
		penjual_id = penjualprod,
		judul = judulprod,
		deskripsi = deskripsiprod,
		harga = hargaprod,
		status = statustrans
		WHERE  id = idprod;
	ELSEIF StatementType = 3 THEN
		DELETE FROM transaksi
		WHERE pesanan_id = idpes;
		DELETE FROM pesanan
		WHERE  id = idpes;
	END IF;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `KelolaProduk` */

/*!50003 DROP PROCEDURE IF EXISTS  `KelolaProduk` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `KelolaProduk`(IN idprod INT(11), IN kategoriprod INT(11), IN penjualprod INT(11), IN judulprod VARCHAR(255), IN deskripsiprod VARCHAR(255), IN hargaprod INT(11), IN StatementType INT)
BEGIN
	IF StatementType = 1 THEN
		INSERT INTO produk  
                        (kategori_id,penjual_id,judul,deskripsi,harga)
		VALUES     (kategoriprod,penjualprod,judulprod,deskripsiprod,hargaprod);
	ELSEIF StatementType = 2 THEN
		UPDATE produk  
		SET    
		kategori_id = kategoriprod,
		penjual_id = penjualprod,
		judul = judulprod,
		deskripsi = deskripsiprod,
		harga = hargaprod
		WHERE  id = idprod;
	ELSEIF StatementType = 3 THEN
		DELETE FROM produk  
		WHERE  id = idprod;
	END IF;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `KelolaTransaksi` */

/*!50003 DROP PROCEDURE IF EXISTS  `KelolaTransaksi` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `KelolaTransaksi`(IN idtrans INT(11), IN pesanantrans INT(11), IN bayartrans INT(11), IN totaltrans INT(11), IN sisatrans INT(11), IN StatementType INT)
BEGIN
	IF StatementType = 1 THEN
		INSERT INTO transaksi  
                        (pesanan_id,bayar,total_pembelian,sisa_bayar)
		VALUES     (pesanantrans,bayartrans,totaltrans,sisatrans);
	ELSEIF StatementType = 2 THEN
		DELETE FROM transaksi  
		WHERE  id = idtrans;
	END IF;
	
END */$$
DELIMITER ;

/*Table structure for table `jumlahkategori` */

DROP TABLE IF EXISTS `jumlahkategori`;

/*!50001 DROP VIEW IF EXISTS `jumlahkategori` */;
/*!50001 DROP TABLE IF EXISTS `jumlahkategori` */;

/*!50001 CREATE TABLE  `jumlahkategori`(
 `jumlahKategori` bigint(21) 
)*/;

/*Table structure for table `jumlahpendapatan` */

DROP TABLE IF EXISTS `jumlahpendapatan`;

/*!50001 DROP VIEW IF EXISTS `jumlahpendapatan` */;
/*!50001 DROP TABLE IF EXISTS `jumlahpendapatan` */;

/*!50001 CREATE TABLE  `jumlahpendapatan`(
 `jumlahPendapatan` decimal(32,0) 
)*/;

/*Table structure for table `jumlahtransaksi` */

DROP TABLE IF EXISTS `jumlahtransaksi`;

/*!50001 DROP VIEW IF EXISTS `jumlahtransaksi` */;
/*!50001 DROP TABLE IF EXISTS `jumlahtransaksi` */;

/*!50001 CREATE TABLE  `jumlahtransaksi`(
 `jumlah_transaksi` bigint(21) 
)*/;

/*View structure for view jumlahkategori */

/*!50001 DROP TABLE IF EXISTS `jumlahkategori` */;
/*!50001 DROP VIEW IF EXISTS `jumlahkategori` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlahkategori` AS (select count(`kategori`.`id`) AS `jumlahKategori` from `kategori`) */;

/*View structure for view jumlahpendapatan */

/*!50001 DROP TABLE IF EXISTS `jumlahpendapatan` */;
/*!50001 DROP VIEW IF EXISTS `jumlahpendapatan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlahpendapatan` AS (select sum(`tr`.`total_pembelian`) AS `jumlahPendapatan` from (((`transaksi` `tr` join `pesanan` `pe` on(`tr`.`pesanan_id` = `pe`.`id`)) join `produk` `pr` on(`pe`.`produk_id` = `pr`.`id`)) join `penjual` `pen` on(`pr`.`penjual_id` = `pen`.`id`))) */;

/*View structure for view jumlahtransaksi */

/*!50001 DROP TABLE IF EXISTS `jumlahtransaksi` */;
/*!50001 DROP VIEW IF EXISTS `jumlahtransaksi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlahtransaksi` AS (select count(`tr`.`id`) AS `jumlah_transaksi` from ((`transaksi` `tr` join `pesanan` `pe` on(`tr`.`pesanan_id` = `pe`.`id`)) join `pembeli` `pem` on(`pe`.`pembeli_id` = `pem`.`id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
