

<?php
      if ($_SESSION['admin']) {
        $user = $_SESSION['admin'];
      }
      $sql = $koneksi->query("select * from users where id='$user'");
      $dataUser = $sql->fetch_assoc();
      ?>


 <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; justify-content: space-between;">
              <h6 class="m-0 font-weight-bold text-primary" >
				
			  <?php
                        if ($dataUser['level'] == 'marketing') {
							echo 'Fee Marketing';
						} else {
							echo 'Barang Keluar';
						}
                        ?></h6>
						<?php
                        if ($dataUser['level'] != 'marketing') {
                        ?>
						<a href="?page=barangkeluar&aksi=tambahbarangkeluar" class="btn btn-primary" >Tambah Barang Keluar</a>
						<?php } ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                                        <tr>
											<th>No</th>
											<th>Id Transaksi</th>
											<th>Tanggal Keluar</th>
											<th>Kode Barang</th>
											<th>Nama Barang</th>
											<th>Satuan</th>
											<th>Jumlah Keluar</th>
											<th>Nominal</th>
											<th>Total</th>
											
											<th>Nama Konsumen</th>
											<?php
                        if ($dataUser['level'] == 'marketing' && 'admin') {
							?>
											<th>Fee Marketing</th>
											<?php } ?>
											<?php
                        if ($dataUser['level'] != 'marketing') {
                        ?>
											<th>Pengaturan</th>
											<?php } ?>
                                         
                                        </tr>
										</thead>
										
               
                  <tbody>
                    <?php 
									
									$no = 1;
									$sql = $koneksi->query("select * from barang_keluar");
									while ($data = $sql->fetch_assoc()) {
										
									?>
									
                                        <tr>
                                            <td><?php echo $no++; ?></td>
											<td><?php echo $data['id_transaksi'] ?></td>
											<td><?php echo $data['tanggal'] ?></td>
											<td><?php echo $data['kode_barang'] ?></td>
											<td><?php echo $data['nama_barang'] ?></td>
											<td><?php echo $data['satuan'] ?></td>
											<td><?php echo $data['jumlah'] ?></td>
											<td>30.000</td>
											<td>100.000</td>
											
											<td><?php echo $data['tujuan'] ?></td>
											<?php
                        if ($dataUser['level'] == 'marketing' && 'admin') {
							?>
						<td>20.000</td> 
						<?php } ?>
											<?php
                        if ($dataUser['level'] != 'marketing') {
                        ?>
											<td>
											
											<a href="javascript:void(0);" 
											onclick="confirmDelete('<?php echo $data['id_transaksi']; ?>')" class="btn btn-danger" >Hapus</a>
											</td>
											<?php } ?>
                                        </tr>
									<?php }?>

										   </tbody>
                                </table>
								
                  </tbody>
                </table>
				<h4 class="text-right mt-3 text-primary">Total : Rp. 700.000</h4>
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
                window.location.href = "?page=barangkeluar&aksi=hapusbarangkeluar&id_transaksi=" + id;
            }
        });
    }
</script>









