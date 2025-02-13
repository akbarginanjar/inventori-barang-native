<!-- Begin Page Content -->
<div class="container-fluid">
  
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Jenis Barang</h6>
      <a href="?page=jenisbarang&aksi=tambahjenis" class="btn btn-primary">Tambah Jenis Barang</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Jenis Barang</th>

              <th>Pengaturan</th>

            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("select * from jenis_barang");
            while ($data = $sql->fetch_assoc()) {

            ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['jenis_barang'] ?></td>



                <td>
                  <a href="?page=jenisbarang&aksi=ubahjenis&id=<?php echo $data['id'] ?>" class="btn btn-success">Ubah</a>
                  <a href="javascript:void(0);" 
                  onclick="confirmDelete('<?php echo $data['id']; ?>')" class="btn btn-danger">Hapus</a>
                </td>
              </tr>
            <?php } ?>

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