<?php
// session_start();
// //Koneksi
$koneksi = new mysqli("localhost","root","","mbg");
session_start();
if(empty($_SESSION['username']) and empty($_SESSION['password'])) {
    echo '
    <center>
        <br><br><br><br><br><br><br><br><br>
        <b> Maaf silahkan Login </b><br>
        <b> Anda telah keluar dari sistem</b>
        <br>
        <a href="login.php" tittle="Klik Gambar Untuk Kembali ke Halaman MASUK">
        <img src="images/cek1.jpg" height="100" width="120"></img>
        </a>
    </center>';
} else{

?>

<!DOCTYPE html>
<html lang="in">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mbok Berek Garden</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Restaurantly - v3.6.0
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-center justify-content-md-between">

      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-phone d-flex align-items-center"><span>+62 812-1480-0813</span></i>
        <i class="bi bi-clock d-flex align-items-center ms-4"><span> Sen-Min: 08AM - 21PM</span></i>
      </div>
      <!--
      <div class="languages d-none d-md-flex align-items-center">
        <ul>
          <li>In</li>
          <li><a href="#">En</a></li>
        </ul>
      </div>-->
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

      <img src="assets/img/logo.png" width="100" height="60"><a href="index.php"></a></img>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="beranda.php">Beranda</a></li>
          <li><a class="nav-link scrollto active" href="#">Pesanan</a></li>
          <li class="dropdown"><a href="#"><span>Akun</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Profil</a></li>
              <!--<li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Logout</a></li>
                </ul>-->
              </li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
	<section id="home" class="home">
		<div class="intro-content">
			<div class="container">
				<div class="row">
					<div class="col-lg-10">
						<div class="form-wrapper">
						<div class="wow fadeInRight" data-wow-duration="2s" data-wow-delay="0.2s">
							<div class="panel panel-skin">
							<div class="panel-heading"><br><br><br><br>
								<table class="table table-bordered">
								<thead>
									<tr style="color:white";>
										<th>No</th>
										<th>No Pembayaran</th>
										<th>Tanggal Pemesanan</th>
										<th>Waktu</th>
										<th>Total</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php
			$nomor = 1;
		?>
		<?php 
			$ambil = $koneksi->query("SELECT * FROM transaksi WHERE id_pelanggan='$_SESSION[id_pelanggan]'");
			
		?>
		<?php
			while ($pecah = $ambil->fetch_assoc()) {
				# code...
		?>
		<tr style="color:white";>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['no_pembayaran']; ?></td>
			<td><?php echo $pecah['tanggal']; ?></td>
			<td><?php echo $pecah['timeslot']; ?></td>
			<td>Rp. <?php echo $pecah['total']; ?></td>
			<td>
				<!-- <a href="hapusdata.php?id=<?php echo $pecah['kd_transaksi']; ?>" class="btn-danger btn">Detail</a> -->
				<a href="pdf.php?id=<?php echo $pecah['kd_transaksi']; ?>" class="btn btn-warning">Cetak</a>
			</td>
		</tr>
		<?php
			$nomor++;
		?>
		<?php
			}
		?>
	</tbody>
</table>
						    </div>
						</div>
					</div>					
				</div>		
			</div>
		</div>		
    </section>

</body>

</html>

<?php
}
?>