<?php
// session_start();
// //Koneksi
include "../koneksi.php";
?>
<?php
$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
// $pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan = '$_GET[id]'");

echo "<script>alert('User Terhapus');</script>";
echo "<script>location='pelanggan.php';</script>";
?>