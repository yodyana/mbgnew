<?php
session_start();
require_once "../koneksi.php";

$data_trx = $_POST["transaksi"];
$data_detail_trx = $_POST['detail'];

$tanggal        = $data_trx['tgl'];
$idpelanggan       = $data_trx['id_pelanggan'];
$timeslot = $data_trx['time_slot'];
$total = $data_trx['gross_amount'];
$no_pembayaran = $data_trx['order_id'];

$jml_pengunjung = $data_trx['jml_pengunjung'];

$pdf = "";

$cektransaksi = mysqli_query($koneksi, "select no_pembayaran from transaksi where no_pembayaran = '{$no_pembayaran}' LIMIT 1");
$jmltransaksi = mysqli_num_rows($cektransaksi);

if ($jmltransaksi > 0) {
    json_encode(["hasil" => 1]);
    return;
}

$query = "INSERT INTO transaksi(id_pelanggan,tanggal,timeslot,total,bayar,status,no_pembayaran,jml_pengunjung,pdf)
 VALUES ('{$idpelanggan}','$tanggal','{$timeslot}',{$total},'sudah','online','{$no_pembayaran}','{$jml_pengunjung}','{$pdf}')";

mysqli_query($koneksi, $query);
$idtransaksi = mysqli_insert_id($koneksi);

foreach ($data_detail_trx as $value) {
    $total = (int)$value['unitprice'] * (int)$value['quantity'];
    $query = "INSERT INTO detail_transaksi(kd_transaksi,kd_paket,jumlah,total) 
    VALUES('{$idtransaksi}','{$value['kd_paket']}','{$value['quantity']}','{$total}')";
    mysqli_query($koneksi, $query);
}


// echo json_encode(["hasil" => mysqli_affected_rows($koneksi)]);