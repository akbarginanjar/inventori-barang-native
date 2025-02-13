<?php

session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");


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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
<br><br><br><br>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
								<center>
									<img src="img/login.png" class="img-fluid" alt="">
								</center>
							</div>
                            <div class="col-lg-6">
                                <div class="p-5 mt-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistem Inventaris Barang</h1>
                                    </div>
                                    <form class="user" role="form" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="username"
                                                id="exampleInputusername" aria-describedby="usernameHelp"
                                                placeholder="Masukan username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password"
                                                id="exampleInputPassword" placeholder="Masukan password">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit" name="login" value="Masuk" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php

$username = $_POST['username'];
$password = md5($_POST['password']);
$login = $_POST['login'];

if ($login) {
	$sql = $koneksi->query("select * from users where username='$username' and password='$password'");
	$ketemu = $sql->num_rows;
	$data = $sql->fetch_assoc();

    var_dump($data['level']);

	if ($ketemu >= 1) {
		session_start();

		if ($data['level'] == 'admin') {
			$_SESSION['admin'] = $data['id'];
			header("location:index.php");
		} else if ($data['level'] == 'marketing') {
			$_SESSION['marketing'] = $data['id'];
			header("location:index2.php");
		} else if ($data['level'] == 'gudang') {
			$_SESSION['gudang'] = $data['id'];
			header("location:index3.php");
		} else if ($data['level'] == 'keuangan') {
			$_SESSION['keuangan'] = $data['id'];
			header("location:index4.php");
		}
	} else {
		echo '<center><div class="alert alert-danger">Upss...!!! Login gagal. Silakan Coba Kembali</div></center>';
	}
}

?>