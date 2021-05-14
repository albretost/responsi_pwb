 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="card-header py-3">
         <div class="d-flex align-items-center justify-content-between">
             <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
             <button id="btnModal" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm mr-1 text-white-50"></i> Tambah Data</button>
         </div>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th width=50>No.</th>
                         <th>Nama</th>
                         <th width=100>Aksi</th>
                     </tr>
                 </thead>
                 <tbody>
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
                     <div class="form-group">
                         <label for="judul">Judul Kategori</label>
                         <input type="text" class="form-control" id="judul">
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <button id="saveButton" class="btn btn-primary" type="button">Simpan</button>
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
                     <input type="hidden" id="id1" name="id1" value="">
                     <div class="form-group">
                         <label for="judul">Judul Kategori</label>
                         <input type="text" class="form-control" id="judul1" name="judul1">
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <button id="editButton" class="btn btn-primary" type="button">Perbaharui</button>
             </div>
         </div>
     </div>
 </div>
 <script type="text/javascript">
     $(document).ready(function() {
         var table = $('#dataTable').DataTable({
             processing: true,
             serverSide: false,
             ajax: "api/kategori/read.php",
             columns: [{
                     data: 'id',
                     name: 'id'
                 },
                 {
                     data: 'judul',
                     name: 'judul'
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
             $("#exampleModalLabel").html("Tambah Kategori");
             $('#frm_tambah').trigger("reset");
             $('#tambahModal').modal('show');
         });
         $('#saveButton').click(function(e) {
             e.preventDefault();
             $(this).html('Menyimpan...');
             var judul = $('#judul').val();
             var data = {
                 judul: judul
             };
             $.ajax({
                 data: JSON.stringify(data),
                 url: "api/kategori/create.php",
                 type: "POST",
                 dataType: 'json',
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
             var data = {
                 id: id,
                 judul: judul
             };
             $.ajax({
                 data: JSON.stringify(data),
                 url: "api/kategori/update.php",
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
                 url: "api/kategori/read_one.php?id=" + cek,
                 type: "GET",
                 dataType: "JSON",
                 success: function(data) {
                     $('#editButton').val("edit");
                     $("#frm_update").find("input[name=id1]").val(data.id);
                     $("#frm_update").find("input[name=judul1]").val(data.judul);
                     $("#exampleModalLabel1").text("Perbaharui Kategori");
                     $('#editModal').modal('show');
                 }
             });
         });
         $('body').on('click', '#btnDelete', function() {
             var id = $(this).attr('data-id');
             var data = {
                 id: id
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
                         url: "api/kategori/delete.php",
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