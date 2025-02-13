




 <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; justify-content: space-between;">
              <h6 class="m-0 font-weight-bold text-primary">Barang Masuk</h6>
			  <a href="?page=barangmasuk&aksi=tambahbarangmasuk" class="btn btn-primary" >Tambah Barang Masuk</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                                        <tr>
											<th>No</th>
											<th>Id Transaksi</th>
											<th>Tanggal Masuk</th>
											<th>Kode Barang</th>
											<th>Nama Barang</th>
											<th>Pengirim</th>
											<th>Jumlah Masuk</th>
											<th>Satuan Barang</th>
											<th>Nominal</th>
											<th>Total</th>
											<th>Pengaturan</th>
                                         
                                        </tr>
										</thead>
										
               
                  <tbody>
                    <?php 
									
									$no = 1;
									$sql = $koneksi->query("select * from barang_masuk");
									while ($data = $sql->fetch_assoc()) {
										
									?>
									
                                        <tr>
                                            <td><?php echo $no++; ?></td>
											<td><?php echo $data['id_transaksi'] ?></td>
											<td><?php echo $data['tanggal'] ?></td>
											<td><?php echo $data['kode_barang'] ?></td>
											<td><?php echo $data['nama_barang'] ?></td>
											
											<td><?php echo $data['pengirim'] ?></td>
									
                                         
											<td><?php echo $data['jumlah'] ?></td>
											<td><?php echo $data['satuan'] ?></td>
											<td>300.000</td>
											<td>900.000</td>
								

											<td>
											
											<a href="javascript:void(0);" 
											onclick="confirmDelete('<?php echo $data['id_transaksi']; ?>')" class="btn btn-danger" >Hapus</a>
											</td>
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
                window.location.href = "?page=barangmasuk&aksi=hapusbarangmasuk&id_transaksi=" + id;
            }
        });
    }
</script>











