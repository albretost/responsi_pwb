<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pesanan</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width=50>No.</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Jumlah Beli</th>
                        <th>Tanggal Pesan</th>
                        <th>Status</th>
                        <th width=100>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Bayar Modal -->
<div class="modal fade" id="bayarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_bayar">
                <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <small class="font-weight-bold" id="nama" name="nama"></small>
                                <div class="d-flex justify-content-between">
                                    <small id="harga" name="harga"></small>
                                    <small class="font-weight-bold" id="jumbel" name="jumbel"></small>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <small>Total Pembayaran</small>
                                    <small class="font-weight-bold" id="total_pembayaran" name="total_pembayaran"></small>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bayar">Jumlah Bayar</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="bayar">Rp.</label>
                                    </div>
                                    <input type="number" name="bayar" id="bayar" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="bayarButton" class="btn btn-success" type="button">Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: "api/pesanan/read.php",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_produk',
                    name: 'nama_produk'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori'
                },
                {
                    data: 'harga',
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: 'jumlah_beli',
                    name: 'jumlah_beli'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (data == '1') {
                            return `<span id="btnBayar" class="badge bg-warning text-white">Sudah Bayar</span>`;
                        } else {
                            return `<span id="btnBayar" class="badge bg-info text-white">Belum Bayar</span>`;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (row.status == '1') {
                            return `
                                <td class="px-0">
                                <button id="btnDelete" data-id="` + data + `" class="btn btn-sm btn-danger"><i class="fa fa-trash text-black"></i></button>
                                </td>
                                `;
                        } else {
                            return `
                                <td class="px-0">
                                <button id="btnBayar" data-id="` + data + `" class="btn btn-sm btn-success">Bayar</button>
                                <button id="btnDelete" data-id="` + data + `" class="btn btn-sm btn-danger"><i class="fa fa-trash text-black"></i></button>
                                </td>
                                `;
                        }
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('body').on('click', '#btnBayar', function() {
            var cek = $(this).attr('data-id');
            $.ajax({
                url: "api/pesanan/read_one.php?id=" + cek,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#btnPesan').val("bayar");
                    $("#frm_bayar").find("input[name=id]").val(data.id);
                    $("#nama").html(data.nama_kategori+" - "+data.nama_produk);
                    $("#harga").html(convertToRupiah(data.harga));
                    $("#jumbel").html('x' + data.jumlah_beli + '');
                    $("#total_pembayaran").html(convertToRupiah(data.harga * data.jumlah_beli));
                    $("#exampleModalLabel").text("Pembayaran");
                    $('#bayarModal').modal('show');
                }
            });
        });
        $('#bayarButton').click(function(e) {
            e.preventDefault();
            $(this).html('Membayar...');
            var pesanan_id = $("#frm_bayar").find("input[name=id]").val();
            var bayar = $('#bayar').val();
            var total_pembayaran = convertToAngka($('#total_pembayaran')[0].outerText);
            var data = {
                pesanan_id: pesanan_id,
                bayar: bayar,
                total_pembelian: total_pembayaran
            }
            $.ajax({
                data: JSON.stringify(data),
                url: "api/transaksi/create.php",
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#frm_bayar').trigger("reset");
                    $('#bayarButton').html('Simpan');
                    $('#bayarModal').modal('hide');
                    Swal.fire({
                        title: 'Sukses',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    table.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveButton').html('Gagal membayar');
                }
            });
        });
        $('body').on('click', '#btnDelete', function() {
            var id = $(this).attr('data-id');
            var data = {
                id_pesanan: id
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
                        url: "api/pesanan/delete.php",
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