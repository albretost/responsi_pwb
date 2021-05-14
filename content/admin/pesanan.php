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
                        <th>Pembeli</th>
                        <th>Jumlah Beli</th>
                        <th>Tanggal Pesan</th>
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
                    data: 'nama_pembeli',
                    name: 'nama_pembeli'
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
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                                <td class="px-0">
                                <button id="btnDelete" data-id="` + data + `" class="btn btn-sm btn-danger"><i class="fa fa-trash text-black"></i></button>
                                </td>
                                `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('body').on('click', '#btnDelete', function() {
            var id = $(this).attr('data-id');
            var data = {
                id_pembeli: id
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
                        url: "api/pembeli/delete.php",
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