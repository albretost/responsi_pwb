        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="sidebar-brand-text mx-3"><?= $namaWebsite ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item<?= $_GET['page'] == NULL ? ' active' : '' ?>">
                <a class="nav-link" href="<?= $_SERVER['PHP_SELF'] ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                MENU
            </div>

            <?php
            $id_user = $_SESSION['logged_in'];
            if ($_SESSION['level'] == 'admin') {
            ?>
                <!-- Nav Item - Kategori -->
                <li class="nav-item<?= $_GET['page'] == 'kategori' ? ' active' : '' ?>">
                    <a class="nav-link" href="?page=kategori">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Kelola Kategori</span></a>
                </li>

                <!-- Nav Item - Produk -->
                <li class="nav-item<?= $_GET['page'] == 'produk' ? ' active' : '' ?>">
                    <a class="nav-link" href="?page=produk">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Kelola Produk</span></a>
                </li>

                <!-- Nav Item - Transaksi -->
                <li class="nav-item<?= $_GET['page'] == 'transaksi' ? ' active' : '' ?>">
                    <a class="nav-link" href="?page=transaksi">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Kelola Transaksi</span></a>
                </li>

                <!-- Divider -->
                <!-- <hr class="sidebar-divider"> -->

                <!-- Heading -->
                <!-- <div class="sidebar-heading">
                    SETTINGS
                </div> -->

                <!-- Nav Item - Pembeli -->
                <<!-- li class="nav-item<?= $_GET['page'] == 'pembeli' ? ' active' : '' ?>">
                    <a class="nav-link" href="?page=pembeli">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Kelola Pembeli</span></a>
                    </li> -->
                <?php
            } else {
                ?>
                    <!-- Nav Item - Produk -->
                    <li class="nav-item<?= $_GET['page'] == 'produk' ? ' active' : '' ?>">
                        <a class="nav-link" href="?page=produk">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>List Produk</span></a>
                    </li>

                    <!-- Nav Item - Pesanan -->
                    <li class="nav-item<?= $_GET['page'] == 'pesanan' ? ' active' : '' ?>">
                        <a class="nav-link" href="?page=pesanan">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>List Pesanan</span><span class="ml-2 text-bold" id="hitungPesanan"></span></a>
                    </li>
                <?php
            }
                ?>

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

        </ul>
        <!-- End of Sidebar -->

        <script type="text/javascript">
            var id = <?= $id_user ?>;
            var data = {
                id_pembeli: id
            };
            $.ajax({
                data: data,
                type: 'POST',
                url: "library/hitung_pesanan.php",
                cache: false,
                success: function(msg) {
                    $("#hitungPesanan").html('(' + msg + ')');
                }
            });
        </script>