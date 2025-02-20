<!-- Begin Page Content -->
<div class="container-fluid">
  
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Gaji Karyawan</h6>
      <a href="?page=gajikaryawan&aksi=tambahgaji" class="btn btn-primary">Tambah Gaji Karyawan</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Karyawan</th>
              <th>Gaji</th>
              <th>Pengaturan</th>
            </tr>
          </thead>


          <tbody>
              <tr>
                <td>1</td>
                <td>Akbar Ginanjar</td>
                <td>1jt</td>
                <td>
                  <a href="?page=gajikaryawan&aksi=ubahgaji&id=1" class="btn btn-success">Ubah</a>
                  <a href="javascript:void(0);" 
                  onclick="confirmDelete('1')" class="btn btn-danger">Hapus</a>
                </td>
              </tr>

          </tbody>
        </table>
        </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "?page=jenisbarang&aksi=hapusjenis&id=" + id;
            }
        });
    }
</script>