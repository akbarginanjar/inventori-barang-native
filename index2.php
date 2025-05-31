<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();

$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

if (empty($_SESSION['marketing'])) {

  header("location:login.php");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Inventaris Barang</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo-mms.png" width="45px" style="border-radius: 13px; border: 1px solid white;" alt="">
        </div>
        <div class="sidebar-brand-text mx-2">Chips Supplier</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <?php
      if ($_SESSION['marketing']) {
        $user = $_SESSION['marketing'];
      }
      
      $sql = $koneksi->query("select * from users where id='$user'");
      $userData = $sql->fetch_assoc();
      ?>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php echo ($current_page == 'home2') ? 'active' : ''; ?>">
        <a class="nav-link" href="?page=home2">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Pilih Menu
      </div>
      <li class="nav-item <?php echo ($current_page == 'gudang') ? 'active' : ''; ?>">
        <a class="nav-link" href="?page=gudang">
          <i class="fas fa-fw fa-box"></i>
          <span>Stok Barang</span></a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'feemarketing') ? 'active' : ''; ?>">
        <a class="nav-link" href="?page=feemarketing">
          <i class="fa-solid fa-face-smile"></i>
          <span>Fee Marketing</span></a>
      </li>

      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Laporan
      </div>



      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Laporan:</h6>
            <a class="collapse-item" href="?page=laporan_feemarketing">Laporan Fee Marketing</a>
          </div>
        </div>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                      placeholder="Search for..." aria-label="Search"
                      aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-none d-lg-inline text-gray-600"><?php echo  $userData['nama']; ?></span>
                <img class="img-profile rounded-circle"
                  src="img/<?php echo $userData['foto'] ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <section class="content">


            <?php
            $page = $_GET['page'];
            $aksi = $_GET['aksi'];


            if ($page == "pengguna") {
              if ($aksi == "") {
                include "page/pengguna/pengguna2.php";
              }
              if ($aksi == "tambahpengguna2") {
                include "page/pengguna/tambahpengguna2.php";
              }
            }

            if ($page == "feemarketing") {
              if ($aksi == "") {
                include "page/barangkeluar/barangkeluar.php";
              }
            }


            if ($page == "supplier") {
              if ($aksi == "") {
                include "page/supplier/supplier.php";
              }
              if ($aksi == "tambahsupplier") {
                include "page//supplier/tambahsupplier.php";
              }
              if ($aksi == "ubahsupplier") {
                include "page/supplier/ubahsupplier.php";
              }

              if ($aksi == "hapussupplier") {
                include "page/supplier/hapussupplier.php";
              }
            }


            if ($page == "jenisbarang") {
              if ($aksi == "") {
                include "page/jenisbarang/jenisbarang.php";
              }
              if ($aksi == "tambahjenis") {
                include "page//jenisbarang/tambahjenis.php";
              }
              if ($aksi == "ubahjenis") {
                include "page/jenisbarang/ubahjenis.php";
              }

              if ($aksi == "hapusjenis") {
                include "page/jenisbarang/hapusjenis.php";
              }
            }

            if ($page == "satuanbarang") {
              if ($aksi == "") {
                include "page/satuanbarang/satuan.php";
              }
              if ($aksi == "tambahsatuan") {
                include "page//satuanbarang/tambahsatuan.php";
              }
              if ($aksi == "ubahsatuan") {
                include "page/satuanbarang/ubahsatuan.php";
              }

              if ($aksi == "hapussatuan") {
                include "page/satuanbarang/hapussatuan.php";
              }
            }




            if ($page == "barangmasuk") {
              if ($aksi == "") {
                include "page/barangmasuk/barangmasuk.php";
              }
              if ($aksi == "tambahbarangmasuk") {
                include "page/barangmasuk/tambahbarangmasuk.php";
              }
              if ($aksi == "ubahbarangmasuk") {
                include "page/barangmasuk/ubahbarangmasuk.php";
              }

              if ($aksi == "hapusbarangmasuk") {
                include "page/barangmasuk/hapusbarangmasuk.php";
              }
            }


            if ($page == "gudang") {
              if ($aksi == "") {
                include "page/gudang/gudang.php";
              }
              if ($aksi == "tambahgudang") {
                include "page/gudang/tambahgudang.php";
              }
              if ($aksi == "ubahgudang") {
                include "page/gudang/ubahgudang.php";
              }

              if ($aksi == "hapusgudang") {
                include "page/gudang/hapusgudang.php";
              }
            }


            if ($page == "barangkeluar") {
              if ($aksi == "") {
                include "page/barangkeluar/barangkeluar.php";
              }
              if ($aksi == "tambahbarangkeluar") {
                include "page/barangkeluar/tambahbarangkeluar.php";
              }
              if ($aksi == "ubahbarangkeluar") {
                include "page/barangkeluar/ubahbarangkeluar.php";
              }

              if ($aksi == "hapusbarangkeluar") {
                include "page/barangkeluar/hapusbarangkeluar.php";
              }

              if ($aksi == "invoice") {
                include "page/barangkeluar/invoice.php";
              }
            }

            if ($page == "laporan_feemarketing") {
              if ($aksi == "") {
                include "page/laporan/laporan_feemarketing.php";
              }
            }



            if ($page == "") {
              include "home2.php";
            }
            if ($page == "home2") {
              include "home2.php";
            }
            ?>


          </section>


        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <!-- <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; 2019 . Sistem Informasi Inventaris Barang</span>
            </div>
          </div>
        </footer> -->
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keluar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin ingin keluar?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Keluar</a>
        </div>
      </div>
    </div>
  </div>


  <!-- Logout Modal-->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <!--script for this page-->
  <script>
    jQuery(document).ready(function($) {
      $('#cmb_barang').change(function() { // Jika Select Box id provinsi dipilih
        var tamp = $(this).val(); // Ciptakan variabel provinsi
        $.ajax({
          type: 'POST', // Metode pengiriman data menggunakan POST
          url: 'page/barangmasuk/get_barang.php', // File yang akan memproses data
          data: 'tamp=' + tamp, // Data yang akan dikirim ke file pemroses
          success: function(data) { // Jika berhasil
            $('.tampung').html(data); // Berikan hasil ke id kota
          }


        });
      });
    });
  </script>

  <script>
    jQuery(document).ready(function($) {
      $('#cmb_barang').change(function() { // Jika Select Box id provinsi dipilih
        var tamp = $(this).val(); // Ciptakan variabel provinsi
        $.ajax({
          type: 'POST', // Metode pengiriman data menggunakan POST
          url: 'page/barangmasuk/get_satuan.php', // File yang akan memproses data
          data: 'tamp=' + tamp, // Data yang akan dikirim ke file pemroses
          success: function(data) { // Jika berhasil
            $('.tampung1').html(data); // Berikan hasil ke id kota
          }


        });
      });
    });
  </script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(function() {
        $('#Myform1').submit(function() {
          $.ajax({
            type: 'POST',
            url: 'page/laporan/export_laporan_barangmasuk_excel.php',
            data: $(this).serialize(),
            success: function(data) {
              $(".tampung1").html(data);
              $('.table').DataTable();

            }
          });

          return false;
          e.preventDefault();
        });
      });
    });
  </script>


  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(function() {
        $('#Myform2').submit(function() {
          $.ajax({
            type: 'POST',
            url: 'page/laporan/export_laporan_feemarketing_excel.php',
            data: $(this).serialize(),
            success: function(data) {
              $(".tampung2").html(data);
              $('.table').DataTable();

            }
          });

          return false;
          e.preventDefault();
        });
      });
    });
  </script>






</body>

</html>