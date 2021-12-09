<!DOCTYPE html>
<html>
<head>
 <title>Join Table</title>
</head>
<body>
    <style>
        h1{
            text-align: center;
        @page{
            margin:0;
        }
    </style>
<h1><font size="3" face="Comic Sans">Tanda Bukti Reservasi</h1>
<center>
 <table border="1">
  <tr>
   <td><center>No. Transaksi</td>
   <td><center>No. Pembayaran</td>
   <td><center>Tanggal</td>
   <td><center>Waktu</td>
   <td><center>Status Pembayaran</td>
  </tr>
  <?php
  $koneksi = new mysqli("localhost","root","","mbg");
  session_start();

  $id = $_GET['id'];
 

  function query($query)
  {
      global $koneksi;
      $result = mysqli_query($koneksi, $query);
      $rows = [];
      while ($row = mysqli_fetch_assoc($result)) {
          $rows[] = $row;
      }
      return $rows;
  }

  $queryTransaksi = query("SELECT * FROM transaksi WHERE kd_transaksi = '$id'")[0];
  $transaksi =  $queryTransaksi['kd_transaksi'];
  $queryPaket = query("SELECT * FROM detail_transaksi WHERE kd_transaksi = '$transaksi'")[0];  

  // $email = $_POST['email'];
  // $password = md5($_POST['password']);
  
  // $query = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN jenis ON transaksi.kd_transaksi = jenis.id_jenis 
  // INNER JOIN pelanggan ON biodatakucing.id_pelanggan = pelanggan.id_pelanggan");

//   $query = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN biodatakucing ON transaksi.kd_transaksi = biodatakucing.id_kucing ");
?>

    <tr>
        <td><center><?= $queryTransaksi['kd_transaksi'] ?></td>
        <td><center><?= $queryTransaksi['no_pembayaran'] ?></td>
        <td><center><?= $queryTransaksi['tanggal'] ?></td>
        <td><center><?= $queryTransaksi['timeslot'] ?></td>
        <td><center><?= $queryTransaksi['bayar'] ?></td>
    </tr>  
 </table>
 <p><font size="3" face="Comic Sans">Terima kasih telah melakukan Reservasi di Mbok Berek Garden <br> Tunjukan Tanda Bukti Reservasi ini kepada kasir saat datang ke lokasi untuk konfirmasi pesanan anda</p>
 <p><font size="2" face="Comic Sans">Untuk Informasi Lainnya Silahkan Menghubungi Admin <br> CP Admin : +62 812-1480-0813</p>

 </center>
<script>
    window.print();
</script>
</body>

</html>