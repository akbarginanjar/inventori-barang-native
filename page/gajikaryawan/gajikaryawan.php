<!-- Begin Page Content -->
<?php
$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");
?>

<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Gaji Karyawan</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Karyawan</th>
              <th>Level</th>
              <th>Gaji /bulan</th>
              <th>Pengaturan</th>
            </tr>
          </thead>


          <tbody>
            <?php
            $no = 1;
            $sql1 = $koneksi->query("select SUM(gaji) AS total_gaji from users");
            $row = $sql1->fetch_assoc();
            $total_gaji = $row['total_gaji'];
            $sql = $koneksi->query("select * from users");
            while ($data = $sql->fetch_assoc()) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['level'] ?></td>
                <td><?= $data['gaji'] ? number_format($data['gaji'], 0, '', '.') : "0" ?></td>
                <td>
                  <a href="?page=gajikaryawan&aksi=ubahgaji&id=<?= $data['id'] ?>" class="btn btn-success">Ubah</a>

                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
        <h4 class="text-right mt-3 text-primary">Total Gaji : Rp. <?= number_format($total_gaji, 0, '', '.') ?></h4>

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