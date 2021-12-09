<?php 
include 'koneksi.php';
						if (isset($_POST["submit"])) 
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