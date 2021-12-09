<?php
include "koneksi.php";

session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($koneksi, "select * from pelanggan where username='$username' and password='$password'");

$r = mysqli_fetch_array($query); //pecah data nama user saja

$cek = mysqli_num_rows($query);

if($cek > 0) {
    $_SESSION['username'] = $r['username'];
    $_SESSION['password'] = $r['password'];
    $_SESSION['email'] = $r['email'];
    $_SESSION['id_pelanggan'] = $r['id_pelanggan'];
    // header("location:beranda.php");
    echo "<script>alert('Berhasil Masuk!'); window.location='beranda.php'</script>";
    
} else {
    // header("location:login.php"); 
    echo "<script>alert('Gagal Masuk Silahkan Periksa Username dan Password Anda!'); window.location='login.php'</script>";
}
?>