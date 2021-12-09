
<?php
// Report All PHP Errors
error_reporting(E_ALL);

// Session start
session_start();

// Currency symbol, you can change it
$currency = "Rp";
$koneksi = new mysqli("localhost","root","","mbg");
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
$start = "10:00";
$end = "22:00";

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
        
        $slots[] = $intStart->format("H:iA");  
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
		if(charCode>31 && (charCode < 48||charCode > 57))
		return false;return true;
	}
	</script>

	<style>
	.quantity { width: 20px; float: left; margin-right: 10px; height: 23px; font-size: 12px; padding: 5px; }
	</style>

    

  </head>

  <body>

	<?php
	// Add item to cart
	if (empty($_POST['item']) || empty($_POST['price']) || empty($_POST['quantity']))
	{ } else {

		# Take values
		$SBCSprice = $_POST['price'];
		$SBCSitem = $_POST['item'];
		$SBCSquantity = $_POST['quantity'];
		$SBCSkd_paket = $_POST['kd_paket'];
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
				'id' => $SBCSuniquid,
				'kd_paket' => $SBCSkd_paket
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
		$_SESSION["SBCScart"] = array();
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
		unset($_SESSION['SBCScart'][$_GET["remove"]]);
		$_SESSION['SBCScart'] = array_values($_SESSION['SBCScart']);
	}
	?>

    <div class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="beranda.php">MBG</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="#" target="blank">Beranda</a></li>
			<!-- <li class="active"><a href="#" target="blank"></a></li> -->
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang</button>
          </p>
          <div class="jumbotron">
            <p>Silahkan pilih paket menu terlebih dahulu :)</p>
          </div><!-- /.jumbotron -->
          <div class="col-sm-13">
			<?php if(isset($_GET["pay"])) { ?>
			<div class="panel panel-success">
			  <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Well done!</div>
			  <div class="panel-body">
				Payment options for <b><?php echo $_POST["pesanan"];?></b>, here you can code, or simply change the forms action to another script page.<br><br>
				If you wish, you can write session variables into database (do not forget to clean the variables, for example you can use mysql_real_escape_string) or simply you can mail the form values. After  And then destroy & unset the session "SBCScart".
				<br><br>
				<b>Order Details</b>
				<br><br>
				<?php echo $_POST["OrderDetail"];?>
			  </div>
              <div class="container mb-4">
                    <a href="keranjang.php" class="btn btn-primary">Kembali Ke Keranjang</a>
                    
                        <button class="btn btn-primary" id="pay-button">Order</button>

						<p>
						<!-- <?php echo "Snap Token ".$snapToken?> -->
						</p>

						<p><pre>
						<div id="result-json">JSON Payment : <br></div>
						</pre></p>
                    

                </div>
				<form method="post" id="formcheckout">
            <div class="row">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Jam Booking</label>
                        <input type="text" name="total_berat" value="<?= $_POST["pesanan"] ?>" class="form-control" readonly>
                    </div>
                </div>
            </div>


        </form>
			</div><!-- /.panel -->
			<?php } ?>
			
            <!--  -->
			<!-- Products List W/Thumbs -->
			<div class="row">
            <?php
                $sql = mysqli_query($koneksi, 'select kd_paket, nama_paket, nama_kategori, harga_paket from paket natural join kategori_paket');
                // $varGbr = $data['gambar'];
                if (mysqli_num_rows($sql) == 0) {
                    echo "tidak ada produk";
                } else {
                    while ($data = mysqli_fetch_array($sql)) {
                ?>
				<!-- Product 4 -->
				<div class="col-xs-6 col-md-3">
					<div class="thumbnail text-center">
						<?php echo $data['nama_kategori']; ?>
						<div class="caption text-center">
							<h3><?php echo $data['nama_paket']; ?></h3>
							<span class="label label-warning"><?php echo $currency;?> <?php echo $data['harga_paket']; ?> </span>
							<br><br>
							<a href="paket.php" class="u-active-none u-align-center u-border-0 u-btn u-button-style u-hover-none u-none u-text-hover-palette-2-base u-text-palette-1-base u-btn-1"></path></svg><img></span>&nbsp;Detail
                			</a>
						</div>
						<form action="?date=<?= $date ?>&" method="post">
							<div class = "input-group">
							<input class="form-control" name="quantity" type="text" onkeypress="return isNumberKey(event)" maxlength="2" value="1">
							<span class = "input-group-btn"><input type="submit" class="btn btn-success" type="button" value="Add To Basket"></span>
							</div>
							<input type="hidden" name="item" value="<?php echo $data['nama_paket']; ?>" />
							<input type="hidden" name="price" value="<?php echo $data['harga_paket']; ?>" />
							<input type="hidden" name="kd_paket" value="<?php echo $data['kd_paket']; ?>" />
						</form>
					</div>
				</div>
                <?php
                    }
                }
                ?>
			</div>
			<!-- // Products List W/Thumbs -->

          </div><!--/row-->
        </div><!--/span-->

        <div class="col-xs-6 col-sm-4" id="sidebar" role="navigation">
          <div class="sidebar-nav">
			<?php
			// If cart is empty
			if (!isset($_SESSION['SBCScart']) || (count($_SESSION['SBCScart']) == 0)) {
			?>
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang</h3>
				  </div>
				  <div class="panel-body">Your cart is empty..</div>
				</div>
			<?php
			// If cart is not empty
			} else {
			?>
				<div class="panel panel-default">
					<div class="panel-heading" style="margin-bottom:0;">
						<h3 class="panel-title"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang</h3>
					</div>
					<div class="table-responsive">
					<table class="table">
						<tr class="tableactive"><th>Paket</th><th>Harga</th><th>Jumlah</th><th>Total</th></tr>
						<?php
						// List cart items
						// We store order detail in HTML
						$OrderDetail = '
						<table border=1 cellpadding=5 cellspacing=5>
							<thead>
								<tr>
									<th> Paket </th>
									<th> Harga </th>
									<th> Jumlah </th>
									<th> Total </th>
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

							// Write cart to screen
							echo
							"
							<tr class='tablerow'>
								<td><a href=\"?date=".$date."&remove=".$linenumber."\" class=\"btn btn-danger btn-xs\" onclick=\"return confirm('Are you sure?')\">X</a> ".$SBCSitem['item']."</td>
								<td>".$currency." ".$SBCSitem['unitprice']." </td>
								<td>".$SBCSitem['quantity']."</td>
								<td>".$currency." ".$totaldecimal." </td>
							</tr>
							";

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
						<tr class='tableactive'>
							<td><a href='?date=<?= $date ?>&clear'  class='btn btn-danger btn-xs' onclick="return confirm('Are you sure?')">Empty Cart</a></td>
							<td class='text-right'>Total</td>
							<!-- <td><?php echo $qtydecimaltotal;?></td> -->
							<td><?php echo $currency;?> <?php echo $total;?> </td>
						</tr>
					</table>
					</div>
				</div>
				<!-- // Cart -->

				<!-- Address -->
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title">Tentukan waktu dan jumlah pengunjung</h3>
				  </div>
				  <div class="panel-body">
					<form role="form" method="post" action="pesanan.php?date=<?= $date ?>">
                      	<div class="form-group">
                                    <label for="exampleFormControlSelect1">Jam Booking</label>
                                    <select name="pesanan_start" class="form-control" id="jambooking">
                                    <option value="0">----Pilih Jam---</option>
                                    <?php $timeslots = timeslots ($duration, $cleanup, $start, $end); 
                                            foreach($timeslots as $ts){
                                    ?>
                                    <?php if(in_array($ts, $bookings)){ ?>
                    					<option value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></option>
                					<?php }else{ ?>
                    					<option data-timeslot="<?php echo $ts; ?>" value="<?php echo $ts; ?>"><?php echo $ts; ?></option>
                					<?php } } ?>
                                	</select>
                        </div>
						<div class="form-group">
                                    <label for="exampleFormControlSelect1">Jam Berakhir</label>
                                    <select name="pesanan_end" class="form-control" id="jamberakhir">
                                    <option value="0">----Pilih Jam---</option>
                                    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
                                            foreach($timeslots as $ts){
                                    ?>
                                    <?php if(in_array($ts, $bookings)){ ?>
                    					<option value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></option>
                					<?php }else{ ?>
                    					<option data-timeslot="<?php echo $ts; ?>" value="<?php echo $ts; ?>"><?php echo $ts; ?></option>
                					<?php } } ?>
                                	</select>
                        </div>

						<!-- jumlah pengunjung -->
					  <div class="form-group">
						<label for="inputEmail4">Jumlah Pengunjung</label>
						<div>
						<input type="number" name="jml_pengunjung" value="1">
						</div>
					  </div>
					  <div class="form-group">
						<div>
						  <button type="submit" class="btn btn-success pull-right">Give Order</button>
						</div>
					  </div>
					<input type="hidden" name="total" value="<?php echo $total;?>">
					<input type="hidden" name="tanggal" value="<?= $_GET['date'] ?>">
					<input type="hidden" name="OrderDetail" value="<?php echo htmlentities($OrderDetail);?>">
					</form>
				  </div>
				</div>
				<!-- // Address -->

			<?php } # End Cart Listing ?>
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->

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
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
	<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-wIqbRlm2FytPobdR"></script>
	<script type="text/javascript">

	function transaksi(fd) {
            //  fd.append("payment", coba)
			let form = document.getElementById("formcheckout");
                var fd = new FormData(form);

            $.ajax({
                url: "ajax/payment/insert.php",
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                method: "post",
                dataType: "json",
                success: res => {
                    if (res.hasil) {
                        alert("Pesanan berhasil dibuat silahkan lakukan pembayaran");
                        document.location.href = 'pesanan.php';
                    } else {
                        alert("Pesanan gagal dibuat silahkan coba beberapa saat lagi");
                        document.location.href = 'pesanan.php';
                    }
                }
            })
        }

      document.getElementById('pay-button').onclick = function(){
        snap.pay('<?=$snapToken?>', {
          onSuccess: function(result){
			fd.append("data", JSON.stringify(result))
            transaksi(fd);
			
          },
          onPending: function(result){
            fd.append("data", JSON.stringify(result))
            transaksi(fd);
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
    <?php } ?>

  </body>
</html>
