<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Produk</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width=10>No.</th>
                        <th width=80>Judul</th>
                        <th width=150>Deskripsi</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Penjual</th>
                        <th width=100>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: "api/produk/read.php",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'harga',
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'penjual',
                    name: 'penjual'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                                <td class="px-0">
                                <div class="d-flex align-items-center">
                                <input type="number" min="1" id="jumlah` + data + `" name="jumlah` + data + `" class="form-control form-control-sm w-50 mr-2">
                                <button id="btnAdd" data-id="` + data + `" class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart text-black"></i></button>
                                </div>
                                </td>
                                `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('body').on('click', '#btnAdd', function() {
            var id = $(this).attr('data-id');
            var jumlah = $("#jumlah" + id + "").val();
            var data = {
                id_produk: id,
                jumlah_beli: jumlah
            }
            $.ajax({
                data: JSON.stringify(data),
                url: "api/pesanan/create.php",
                type: "POST",
                cache: false,
                success: function() {
                    $("#jumlah"+id+"").val("");
                    $.ajax({
                        data: {
                            id_pembeli: <?= $_SESSION['logged_in'] ?>
                        },
                        type: 'POST',
                        url: "library/hitung_pesanan.php",
                        cache: false,
                        success: function(msg) {
                            $("#hitungPesanan").html('(' + msg + ')');
                        }
                    });
                }
            });
        });
        $('#editButton').click(function(e) {
            e.preventDefault();
            $(this).html('Memperbaharui...');
            var id = $('#id1').val();
            var judul = $('#judul1').val();
            var kategori_id = $('#kategori_id1').val();
            var deskripsi = $('#deskripsi1').val();
            var harga = $('#harga1').val();
            var data = {
                id_produk: id,
                judul: judul,
                kategori_id: kategori_id,
                deskripsi: deskripsi,
                harga: harga
            };
            $.ajax({
                data: JSON.stringify(data),
                url: "api/produk/update.php",
                type: "PUT",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $('#frm_update').trigger("reset");
                    $('#editButton').html('Perbaharui');
                    $('#editModal').modal('hide');
                    Swal.fire({
                        title: 'Sukses',
                        type: 'success',
                        text: 'Data anda telah diperbaharui!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    table.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#editButton').html('Gagal memperbaharui');
                }
            });
        });

        $('body').on('click', '#btnEdit', function() {
            var cek = $(this).attr('data-id');
            $.ajax({
                url: "api/produk/read_one.php?id=" + cek,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $.ajax({
                        data: {
                            id_kategori: data.kategori_id
                        },
                        type: 'POST',
                        url: "library/get_kategori.php",
                        cache: false,
                        success: function(msg) {
                            $("#kategori_id1").html(msg);
                        }
                    });
                    $('#editButton').val("edit");
                    $("#frm_update").find("input[name=id1]").val(data.id);
                    $("#frm_update").find("input[name=judul1]").val(data.judul);
                    $("#deskripsi1").val(data.deskripsi);
                    $("#frm_update").find("input[name=harga1]").val(data.harga);
                    $("#exampleModalLabel1").text("Perbaharui Kategori");
                    $('#editModal').modal('show');
                }
            });
        });
        $('body').on('click', '#btnDelete', function() {
            var id = $(this).attr('data-id');
            var data = {
                id_produk: id
            }
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#324cdd',
                cancelButtonColor: '#f5365c',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        data: JSON.stringify(data),
                        url: "api/produk/delete.php",
                        type: "DELETE",
                        error: function() {
                            table.ajax.reload();
                            Swal.fire({
                                title: 'Gagal',
                                type: 'error',
                                text: 'Data anda gagal disimpan!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire({
                                title: 'Sukses',
                                type: 'success',
                                text: 'Data anda telah dihapus!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                } else {
                    Swal.fire("Dibatalkan", "Data anda aman!", "error");
                }
            });
        });
    })
</script>