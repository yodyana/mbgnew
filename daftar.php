<?php 
include 'koneksi.php';
// $koneksi = new mysqli("localhost","root","","mbg");
// session_start();
						if (isset($_POST["daftar"])) 
						{
							# code...
							$nama_pelanggan = $_POST['nama_pelanggan'];
                            $email = $_POST['email'];
                            $username = $_POST['username'];
                            $password = md5($_POST['password']);
							// $alamat = $_POST['alamat'];
                            // $no_hp = $_POST['no_hp'];
	
							$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email = '{$email}'");
							$cocok = $ambil->num_rows;
							if ($cocok==1) 
							{
								# code...
								echo "<script>alert('Pendaftaran gagal email sudah digunakan silahkan gunakan email lain !');</script>";
								echo "<script>location='daftar.php';</script>";
							}
							else 
							{
								$koneksi->query("INSERT INTO pelanggan (nama_pelanggan, email, username, password) VALUES ('{$nama_pelanggan}','{$email}','{$username}','{$password}')");

								echo "<script>alert('Pendaftaran Sukses Silahkan Masuk !');</script>";
								echo "<script>location='login.php';</script>";
							}

						}
?>
<!Doctype html>
<html lang="en">
  <head>
  	<title>Daftar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
		
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(images/cek.jpg);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign Up</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
			      	</div>
									<form action="" method="POST" role="form" class="lead">
							<!-- <form action="cekdaftar.php" method="POST" class="signin-form"> -->
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Nama lengkap</label>
                            <input type="text" name="nama_pelanggan" placeholder="Nama Lengkap" id="nama_pelanggan" class="form-control input-md" required data-error="Please enter your name">
			      		</div>
		                <div class="form-group mb-3">
                            <label class="label" for="name">Email</label>
                            <input type="email" name="email" placeholder="Email" id="email" class="form-control input-md" required data-error="Please enter your email">
			      		</div>
                          <div class="form-group mb-3">
                            <label class="label" for="name">Username</label>
                            <input type="text" name="username" placeholder="Username" id="username" class="form-control input-md" required data-error="Please enter your username">
			      		</div>
                          <div class="form-group mb-3">
                            <label class="label" for="name">Password</label>
                            <input type="password" name="password" placeholder="Password" id="password" class="form-control input-md" required data-error="Please enter your password">
			      		</div>
		            <div class="form-group">
		            	<button type="submit" value="daftar" name="daftar" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
		            </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

