




<!-- Begin Page Content -->
<div class="container-fluid">
  
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Data Supplier</h6>
      <a href="?page=supplier&aksi=tambahsupplier" class="btn btn-primary" >Tambah Data Supplier</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                                        <tr>
											<th>No</th>
											<th>Kode Supplier</th>
											<th>Nama Supplier</th>
											<th>Alamat</th>
											<th>Telepon</th>
											<th>Pengaturan</th>
                                         
                                        </tr>
										</thead>
										
               
                  <tbody>
                    <?php 
									
									$no = 1;
									$sql = $koneksi->query("select * from tb_supplier");
									while ($data = $sql->fetch_assoc()) {
										
									?>
									
                                        <tr>
                                            <td><?php echo $no++; ?></td>
											<td><?php echo $data['kode_supplier'] ?></td>
											<td><?php echo $data['nama_supplier'] ?></td>
											<td><?php echo $data['alamat'] ?></td>
											<td><?php echo $data['telepon'] ?></td>
                                         

											<td>
                        <div class="d-flex">
                          <a href="?page=supplier&aksi=ubahsupplier&kode_supplier=<?php echo $data['kode_supplier'] ?>" class="btn btn-success mr-2" >Ubah</a>
                          <a href="javascript:void(0);" 
   onclick="confirmDelete('<?php echo $data['kode_supplier']; ?>')" 
   class="btn btn-danger">
   Hapus
</a>                        </div>
											</td>
                                        </tr>
									<?php }?>

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
                window.location.href = "?page=supplier&aksi=hapussupplier&id=" + kode_supplier;
            }
        });
    }
</script>











