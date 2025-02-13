




 <!-- Begin Page Content -->
 <div class="container-fluid">
   
   <!-- DataTales Example -->
   <div class="card shadow mb-4">
     <div class="card-header py-3" style="display: flex; justify-content: space-between;">
       <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
       <a href="?page=pengguna&aksi=tambahpengguna" class="btn btn-primary" >Tambah Pengguna</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                                        <tr>
											<th>No</th>
											<th>NIK</th>
											<th>Nama</th>
											
											<th>Telepon</th>
											<th>Username</th>
                                            <th>Password</th>
                                            <th>Level</th>
                                            <th>Foto</th>
											<th>Aksi</th>
											
                                        </tr>
										</thead>
										
               
                  <tbody>
                    <?php 
									
									$no = 1;
									$sql = $koneksi->query("select * from users");
									while ($data = $sql->fetch_assoc()) {
										
									?>
									
                                        <tr>
                                            <td><?php echo $no++; ?></td>
											<td><?php echo $data['nik'] ?></td>
											<td><?php echo $data['nama'] ?></td>
											
											<td><?php echo $data['telepon'] ?></td>
                                            <td><?php echo $data['username'] ?></td>
								
											<td><?php echo $data['password'] ?></td>
											<td><?php echo $data['level'] ?></td>
											<td><img src="img/<?php echo $data['foto'] ?>"width="50" height="50" alt=""> </td>
										
											<td>
                        <div class="d-flex">
                          <a href="?page=pengguna&aksi=ubahpengguna&id=<?php echo $data['id'] ?>" class="btn mr-1 btn-success" >Ubah</a>
                          <a href="javascript:void(0);" 
                          onclick="confirmDelete('<?php echo $data['id']; ?>')" class="btn btn-danger" >Hapus</a>
                        </div>
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
                window.location.href = "?page=pengguna&aksi=hapuspengguna&id=" + id;
            }
        });
    }
</script>











