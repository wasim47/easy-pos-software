<?php   session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="stock_shopwise";
$loginshopid = $_SESSION['shopid'];

$act = $_GET['act'];
if($act!="" && $act=='del'){
	$sqldelstock = "delete from temptrans where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resdelstock = mysql_query($sqldelstock);
	
}else if ($act!="" && $act=='edt'){
	$sqledtstock = "select * from temptrans where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resedtstock = mysql_query($sqledtstock);
	$rowedtstock = mysql_fetch_assoc($resedtstock);

}


/*if(isset($_POST['save'])){
	$sqltransmaster = "insert into hqtrnmaster (shopid)
							values ('".$loginshopid."')";
	//echo $sqltransmaster;
	$restransmaster = mysql_query($sqltransmaster);
	$mastertransid = mysql_insert_id();
	if($restransmaster){
		$sqltrans = "insert into hqtransactions (`trnid`, `barcode`, `shopid`, `qtysold`, `itemprice`)
						select ".$mastertransid.", barcode, shopid, qtysold, itemprice 
						from temptrans 
						where shopid  = '".$loginshopid."'";
		//echo $sqltrans;
		$restrans = mysql_query($sqltrans);
		if($restrans){
			$sqldeltemp = "delete from temptrans where shopid = '".$loginshopid."'";
			//echo $sqldeltemp;
			$resdeltemp = mysql_query($sqldeltemp);
		}
	}
}
*/

if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);

/*		$barcode = $_POST['barcode'];
		$itemprice = $_POST['itemprice'];
		$qtysold = $_POST['qtysold'];

		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];

		
		$sqlrec = "select * from temptrans where barcode = '".$barcode."' and shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into temptrans (shopid, barcode, itemprice, qtysold) values ('".$shopid."', '".$barcode."','".$itemprice."', '".$qtysold."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Record Successfully Added to stock';
			}
			else{
				$mesg = "New Record Insertion Failed";			
			}
		}elseif($nrec > 0){		
		
			$query = "update temptrans set 
						shopid = '".$shopid."', 
						barcode  = '".$barcode."',
						itemprice  = '".$itemprice."',
						qtysold = '".$qtysold."'
					 where barcode = '".$barcode."' and shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Record Is Updated Successfully';
			}
			else{
				$mesg = "Record Updation Failed";			
			}
		}
		*/

		
	}					
?>


<html>
	<head>
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script>
			function hist()
			{
				window.location = "http://-/transaction.php";
			}
		</script>
		<style>
			form { padding-top: 20px; }
			body { padding: 20px; }
		</style>
	</head>
	<body>
		<?php include('pageheader.php'); ?>
		<div>
			<div class="row">
				<?php include('leftmenu.php'); ?> 
				<div class="col-sm-9">
                <h2><strong>Stock (Shop Wise)</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="stock_shopwise.php" enctype="multipart/form-data" name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
                                        <input type="text" id="shopid" name="shopid" onkeyup "ValidateText(this)" class="form-control" placeholder="Shop ID" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>" />
									</div>
								</div>	
								
							<?php /*	<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Barcode</label>
									<div class="col-sm-6">
										<input type="text" id="barcode" name="barcode" onKeyUp="ValidateText(this)" class="form-control" placeholder="Bar code"  value="<?php if ($act=='edt'){echo $rowedtstock['barcode']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">Item Price</label>
									<div class="col-sm-6">
										<input type="text" id="itemprice" name="itemprice" onKeyUp="ValidateText(this)" class="form-control" placeholder="Item Price" value="<?php if ($act=='edt'){echo $rowedtstock['itemprice']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Qty Sold</label>
									<div class="col-sm-6">
										<input type="text" id="qtysold" name="qtysold" maxlength="8" size="8" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Qty Sold" value="<?php if ($act=='edt'){echo $rowedtstock['qtysold']; }?>" >
									</div>
								</div>
								
							<?php /*	<div class="form-group">
									<label for="price" class="col-sm-3 control-label">Cost Price</label>
									<div class="col-sm-6">
										<input type="text" id="price" name="price" onChange="priceTimer(this)" class="form-control" placeholder="Cost Price" value="<?php if ($edtstock!=''){echo $rowedtstock['cost']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="cstock" class="col-sm-3 control-label">Current Stock</label>
									<div class="col-sm-6">
										<input type="text" id="cstock" name="cstock" onChange="intTimer(this)" class="form-control" placeholder="Current Stock" value="<?php if ($edtstock!=''){echo $rowedtstock['curstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="mstock" class="col-sm-3 control-label">Minimum Stock</label>
									<div class="col-sm-6">
										<input type="text" id="mstock" name="mstock" onChange="intTimer(this)" class="form-control" placeholder="Minimum Stock" value="<?php if ($edtstock!=''){echo $rowedtstock['minstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bundleunit" class="col-sm-3 control-label">Bundle Unit</label>
									<div class="col-sm-6">
										<input type="text" id="bundleunit" name="bundleunit" onChange="intTimer(this)" class="form-control" placeholder="Bundle Unit" value="<?php if ($edtstock!=''){echo $rowedtstock['bundle']; }?>" >
									</div>
								</div>  */ ?>
								
								<div class="form-group">
								<div class="col-sm-6">
									<input type="submit" value="Submit" onsubmit="return validateField()" name="submit" id="submit"/>
								</div>
								</div>
	
							</form>														
					</div>
                    
							<?php 	$query = "SELECT hqstock.shopid, shopslist.shopname, shopslist.city, hqstock.barcode, 
												hqstock.citycurstock, hqstock.citylastprice, hqstock.recdate 
											FROM hqstock , shopslist
											WHERE hqstock.shopid = shopslist.shopid 
											and shopslist.shopid = '".$_POST['shopid']."' 
											order by hqstock.recdate desc";
									//echo $query;
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><tr>
							<th>ID</th>
							<th>Shop Name</th>
							<th>City</th>
							<th>Barcode</th>
							<th>Prod Name</th>
							<th>Curr Stock</th>
							<th>Last Price</th>
							<th>Rec Date</th>
							
							</tr></thead><tbody>";
							$invtotal = 0;
							while($row = mysql_fetch_array($result)) 
							{
								$sqlitem = "SELECT `barcode`, pdtname
											FROM hqinv
											WHERE  barcode = '".$row['barcode']."'";
								//echo $sqlitem;
								$resitem = mysql_query($sqlitem);
								$rowitem = mysql_fetch_assoc($resitem);

								echo "<tr>";
								echo "<td>".$row['shopid']."</td>";
								echo "<td>".$row['shopname']."</td>";
								echo "<td>".$row['city']."</td>";
								echo "<td>".$row['barcode']."</td>";
								echo "<td>".$rowitem['pdtname']."</td>";
								echo "<td>".$row['citycurstock']."</td>";
								echo "<td>".$row['citylastprice']."</td>";
								echo "<td>".$row['recdate']."</td>";
								echo "</tr>";
							}
							
							//echo "<tr><td colspan='6'> Total:".$invtotal."</td></tr>  ";
							echo "</table>";
						}
					?>
				</div>
				</div>
			</div>
		</div>
        <div style="text-align:right">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>