<?php
// Report All PHP Errors
error_reporting(E_ALL);

// Session start
session_start();

// Currency symbol, you can change it
$currency = "Rp";
include "koneksi.php";

// session_start();

// require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/Midtrans.php';


if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $koneksi->prepare("select * from pesanan where tanggal = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            
            $stmt->close();
        }
    }
}

$duration = 60;
$cleanup = 0;
$start = "08:30";
$end = "22:00";

//jam booking

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:iA")." - ". $endPeriod->format("H:iA");   
    }   
    return $slots;
}
$msg = "";
$v = "1.6.2";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PHP Session Based Cart System is pretty simple and fast way for listing small amount of products. This script doesn't include any payment method or payment page. This script lists manually added products, you can add that products to your shopping cart, remove them, change quantity via sessions.">
    <meta name="author" content="anbarli.org">

    <title>Mbok Berek Garden</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script language="Javascript">
	<!-- Allows only numeric chars -->
	function isNumberKey(evt)
	{
		var charCode=(evt.which)?evt.which:event.keyCode
		if(charCode>31&&(charCode<48||charCode>57))
		return false;return true;
	}
	</script>

	<style>
	.quantity { width: 20px; float: left; margin-right: 10px; height: 23px; font-size: 12px; padding: 5px; }
	</style>

    

  </head>

  <body>
	<div class="formbayar">
	<?php
	$timeslot = $_POST['pesanan_start'] . " - " . $_POST['pesanan_end'];
	$tanggal = $_POST['tanggal'];

	// Add item to cart
	if (empty($_POST['item']) || empty($_POST['price']) || empty($_POST['quantity']))
	{ } else {

		# Take values
		$SBCSprice = $_POST['price'];
		$SBCSitem = $_POST['item'];
		$SBCSquantity = $_POST['quantity'];
		$SBCSuniquid = rand();
		$SBCSexist = false;
		$SBCScount = 0;
		// If SESSION Generated?
		if($_SESSION['SBCScart']!="")
		{
			// Look for item
			foreach($_SESSION['SBCScart'] as $SBCSproduct)
			{
				// Yes we found it
				if($SBCSitem == $SBCSproduct['item']) {
					$SBCSexist = true;
					break;
				}
				$SBCScount++;
			}
		}
		// If we found same item
		if($SBCSexist)
		{
			// Update quantity
			$_SESSION['SBCScart'][$SBCScount]['quantity'] += $SBCSquantity;
			// Write down the message and then we open in modal at the bottom
			$msg = "
			<script type=\"text/javascript\">
				$(document).ready(function(){
					$('#myDialogText').text('".$SBCSitem." quantity updated..');
					$('#modal-cart').modal('show');
				});
			</script>
			";

		} else {

			// If we do not found, insert new
			$SBCSmycartrow = array(
				'item' => $SBCSitem,
				'unitprice' => $SBCSprice,
				'quantity' => $SBCSquantity,
				'id' => $SBCSuniquid
			);

			// If session not exist, create
			if (!isset($_SESSION['SBCScart']))
				$_SESSION['SBCScart'] = array();

			// Add item to cart
			$_SESSION['SBCScart'][] = $SBCSmycartrow;

			// Write down the message and then we open in modal at the bottom
			$msg = "
			<script type=\"text/javascript\">
				$(document).ready(function(){
					$('#myDialogText').text('".$SBCSitem." added to your cart');
					$('#modal-cart').modal('show');
				});
			</script>
			";

		}
	}

	// Clear cart
	if(isset($_GET["clear"]))
	{
		session_unset();
		session_destroy();
		// Write down the message and then we open in modal at the bottom
		$msg = "
		<script type=\"text/javascript\">
			$(document).ready(function(){
				$('#myDialogText').text('Your cart is empty now..');
				$('#modal-cart').modal('show');
			});
		</script>
		";
	}

	// Remove item from cart (Updating quantity to 0)
	$remove = isset($_GET['remove']) ? $_GET['remove'] : '';
	if($remove!="")
	{
		$_SESSION['SBCScart'][$_GET["remove"]]['quantity'] = 0;
	}
	?>

    <div class="navbar navbar-inverse" role="navigation">
      <div class="container">
      <img src="logoo.png"  class="u-logo-image u-logo-image-1" width="100">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="beranda.php" >Beranda</a></li>
			<li class="active"><a href="reservasi.php" >Reservasi</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</button>
          </p>
          <div class="jumbotron">
            <p>Silahkan cek pesanan anda :)</p>
          </div><!-- /.jumbotron -->
          <div class="col-sm-13">
			<div class="panel panel-success">
			    <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Well done!</div>
			    <div class="panel-body">
				    <b>Detail Pesanan</b>
				    <br><br>
				    <?php echo $_POST["OrderDetail"];?>
			    </div>
                <div class="container mb-4">
                    <a href="reservasi.php" class="btn btn-primary">Kembali Ke Keranjang</a>
                    
                        <button class="btn btn-primary" id="pay-button">Pesan</button>
                        <br><br>
						<b>
						<?php echo "Tanggal Booking ". $date."<br>"?>
                        <?php echo "Jam Booking ". $timeslot."<br>"?>
                        </b>



                </div>
			
			</div>
            <!--  -->

            

			

          </div><!--/row-->
        </div><!--/span-->
						<?php
						// List cart items
						// We store order detail in HTML
						$OrderDetail = '
						<table border=1 cellpadding=5 cellspacing=5>
							<thead>
								<tr>
									<th>Nama Paket</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Total Harga</th>
								</tr>
							</thead>
							<tbody>';

						// Equal total to 0
						$total = 0;

						// For finding session elements line number
						$linenumber = 0;

						// Run loop for cart array
						foreach($_SESSION['SBCScart'] as $SBCSitem)
						{
							// Don't list items with 0 qty
							if($SBCSitem['quantity']!=0) {

							// For calculating total values with decimals
							$pricedecimal = str_replace(",",".",$SBCSitem['unitprice']);
							$qtydecimal = str_replace(",",".",$SBCSitem['quantity']);

							$pricedecimal = (float)$pricedecimal;
							$qtydecimal = (float)$qtydecimal;
							// $qtydecimaltotal = $qtydecimaltotal + $qtydecimal;

							$totaldecimal = $pricedecimal*$qtydecimal;

							// We store order detail in HTML
							$OrderDetail .= "<tr><td>".$SBCSitem['item']."</td><td>".$currency." ".$SBCSitem['unitprice']." </td><td>".$SBCSitem['quantity']."</td><td>".$currency." ".$totaldecimal." </td></tr>";

							$item_details[] = [
								'id' => 'ITEM',
								'price' => $SBCSitem['unitprice'],
								'quantity' => $SBCSitem['quantity'],
								'name' => $SBCSitem['item']
							  ];

							// Total
							$total += $totaldecimal;

							}
							$linenumber++;
						}

						// We store order detail in HTML
						$OrderDetail .= "<tr><td>Total</td><td></td><td></td><td>".$currency." ".$total." </td></tr></tbody></table>";

						require_once  'vendor/midtrans/midtrans-php/Midtrans.php';



// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-I109K2ta733LxRmDjnL2Qatg';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

$pembeli = $_SESSION['username'];
$email = $_SESSION['email'];
//$telepon = $_SESSION['telepon'];

$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => $totaldecimal, 
  );

//   $item_details[] = [
//     'id' => 'ITEM',
//     'price' => $SBCSitem['unitprice'],
//     'quantity' => $SBCSitem['quantity'],
//     'name' => $SBCSitem['item']
//   ];

// Optional
$billing_address = array(
    'first_name'    =>  $pembeli,
    // 'phone'         =>  $telepon,
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    =>  $pembeli,
    // 'phone'         =>  $telepon,
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    => $pembeli,
    'email'         => $email,
    // 'phone'         => $telepon,
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

//   $enable_payments = array('credit_card','cimb_clicks','mandiri_clickpay','echannel','alfamart');

  $transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
  );

  $snapToken = \Midtrans\Snap::getSnapToken($transaction);

?>
</div>

      <hr>

    </div><!--/.container-->

	<div id="modal-cart" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<p class="text-center" id="myDialogText"></p>
				</div>
			</div>
		</div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- ALL JS FILES -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	
    <!-- ALL PLUGINS -->

    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav55.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
	<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-wIqbRlm2FytPobdR"></script>
	<script type="text/javascript">

				function transaksi(trx, detail_trx) {
					const sendData = {
						transaksi: trx,
						detail: detail_trx
					};
					$.ajax({
						url: "payment/insert.php",
						data: sendData,
						method: "POST",
						success: function(data) {
							const dataobj = JSON.parse(data);
							if (dataobj.hasil) {
								alert("Pesanan berhasil dibuat silahkan lakukan pembayaran");
								document.location.href = 'reservasi.php';
							} else {
								alert("Pesanan gagal dibuat silahkan coba beberapa saat lagi");
								document.location.href = 'reservasi.php';
							}
						}
					})
				}

				// document.getElementById('pay-butto').onclick = function() {
				// 	const data_trx = {
				// 		email: "<?= $_SESSION['email'] ?>",
				// 		id_pelanggan: "<?= $_SESSION['id_pelanggan'] ?>",
				// 		time_slot: "<?= $timeslot ?>",
				// 		tgl: "<?= $tanggal ?>",
				// 	};
				// 	const detail_trx = <?= json_encode($_SESSION['SBCScart']) ?>;
				// 	transaksi(data_trx, detail_trx);
				// }

      document.getElementById('pay-button').onclick = function(){
        snap.pay('<?=$snapToken?>', {
          onSuccess: function(result){
						const data_trx = {
							email: "<?= $_SESSION['email'] ?>",
							id_pelanggan: "<?= $_SESSION['id_pelanggan'] ?>",
							time_slot: "<?= $timeslot ?>",
							tgl: "<?= $tanggal ?>",
							jml_pengunjung: <?= $_POST['jml_pengunjung'] ?>,
							...result,
						};
						const detail_trx = <?= json_encode($_SESSION['SBCScart']) ?>;
						transaksi(data_trx, detail_trx);
          },
          onPending: function(result){
						const data_trx = {
							email: "<?= $_SESSION['email'] ?>",
							id_pelanggan: "<?= $_SESSION['id_pelanggan'] ?>",
							time_slot: "<?= $timeslot ?>",
							tgl: "<?= $tanggal ?>",
							jml_pengunjung: <?= $_POST['jml_pengunjung'] ?>,
							...result,
						};
						const detail_trx = <?= json_encode($_SESSION['SBCScart']) ?>;
						transaksi(data_trx, detail_trx);
          },
          onError: function(result){
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
    </script>
	<!-- // <?php 
			// $idtransaksi = mysqli_insert_id($koneksi);
			// $jambooking = $_POST['pesanan'];
			
			// $query = "INSERT INTO transaksi (id_transaksi, nama, email, tanggal, timeslot, trans_status) VALUES ($idtransaksi ,$pembeli,$email,$date,$jambooking,'Success')";

			// mysqli_query($koneksi, $query);

			// // foreach ($_SESSION['SBCScart'] as $SBCSitem) {
			// // 		$query = "INSERT INTO detail_transaksi(kd_transaksi,kd_buku,qty) VALUES({$idtransaksi},$key,{$value['jumlah']})";
			// // 		mysqli_query($koneksi, $query);
			// // 		unset($_SESSION['SBCScart'][$SBCSitem]);
			// // }
			// ?> -->
    <script>
        

    $(document).ready(function() {
        $("#login").click(function() {
                alert("Login dulu");
                document.location.href = 'login.php';
            })

            $("#pesan").click(function() {
                let form = document.getElementById("formcheckout");
                var fd = new FormData(form);

                $.ajax({
                    url: "ajax/payment/checkout.php",
                    data: fd,
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    method: "post",
                    dataType: "json",
                    success: Response => {
                        snap.pay(Response.token, {
                            // Optional
                            onSuccess: function(result) {
                                /* You may add your own js here, this is just example */
                                fd.append("data", JSON.stringify(result))
                                transaksi(fd);
                            },
                            // Optional
                            onPending: function(result) {
                                /* You may add your own js here, this is just example */
                                fd.append("data", JSON.stringify(result))
                                transaksi(fd);
                            },
                            // Optional
                            onError: function(result) {
                                /* You may add your own js here, this is just example */
                                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            }
                        });
                    }
                })
            })
    });
    </script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    

	<?php if($msg != "") { echo $msg; } ?>

	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-928914-3', 'anbarli.org');
	ga('send', 'pageview');

	</script>

  </body>
</html>