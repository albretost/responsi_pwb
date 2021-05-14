<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Produk</h6>
            <button id="btnModal" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm mr-1 text-white-50"></i> Tambah Data</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-xs">
                        <th width=10>No.</th>
                        <th width=80>Judul</th>
                        <th width=150>Deskripsi</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Penjual</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diubah</th>
                        <th width=100>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Tambah Data Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_tambah">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judul">Nama</label>
                                <input type="text" class="form-control form-control-sm" id="judul">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_id">Kategori</label>
                                <select name="kategori_id" id="kategori_id" class="custom-select custom-select-sm form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="harga">Rp.</label>
                                    </div>
                                    <input type="number" name="harga" id="harga" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="saveButton" class="btn btn-primary" type="button">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Data Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_update">
                    <input type="hidden" name="id1" id="id1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judul1">Nama</label>
                                <input type="text" class="form-control form-control-sm" id="judul1" name="judul1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_id1">Kategori</label>
                                <select name="kategori_id1" id="kategori_id1" class="custom-select custom-select-sm form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi1">Deskripsi</label>
                                <textarea name="deskripsi1" id="deskripsi1" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="harga1">Rp.</label>
                                    </div>
                                    <input type="number" name="harga1" id="harga1" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="editButton" class="btn btn-primary" type="button">Perbaharui</button>
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
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                                <td class="px-0">
                                <button id="btnEdit" data-id="` + data + `" class="btn btn-sm btn-info"><i class="fa fa-pencil-alt text-black"></i></button>
                                <button id="btnDelete" data-id="` + data + `" class="btn btn-sm btn-danger"><i class="fa fa-trash text-black"></i></button>
                                </td>
                                `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#btnModal').click(function() {
            $('#saveButton').val("tambah");
            $('#judul').val('');
            $('#kategori_id').val('');
            $('#deskripsi').val('');
            $('#harga').val('');
            $("#exampleModalLabel").html("Tambah Produk");
            $('#frm_tambah').trigger("reset");
            $('#tambahModal').modal('show');
        });
        $.ajax({
            type: 'GET',
            url: "library/get_kategori.php",
            cache: false,
            success: function(msg) {
                $("#kategori_id").html(msg);
            }
        });
        $('#saveButton').click(function(e) {
            e.preventDefault();
            $(this).html('Menyimpan...');
            var nama = $('#judul').val();
            var kategori_id = $('#kategori_id').val();
            var deskripsi = $('#deskripsi').val();
            var harga = $('#harga').val();
            var data = {
                judul: nama,
                kategori_id: kategori_id,
                deskripsi: deskripsi,
                harga: harga
            }
            $.ajax({
                data: JSON.stringify(data),
                url: "api/produk/create.php",
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#frm_tambah').trigger("reset");
                    $('#saveButton').html('Simpan');
                    $('#tambahModal').modal('hide');
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
                    $('#saveButton').html('Gagal simpan ulang');
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