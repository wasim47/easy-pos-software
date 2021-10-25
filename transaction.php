<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="transaction";
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


if(isset($_POST['save'])){
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


if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);
		$barcode = stripslashes($_POST['barcode']);
		$itemprice = stripslashes($_POST['itemprice']);
		$qtysold = stripslashes($_POST['qtysold']);

/*		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];
*/
		
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
                <h2><strong>Transaction</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="transaction.php" enctype="multipart/form-data" name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
										<input type="number" id="shopid" name="shopid" onkeyup "ValidateText(this)" class="form-control" placeholder="Shop ID" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>" />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Barcode</label>
									<div class="col-sm-6">
										<input type="number" id="barcode" name="barcode" minlength="8" maxlength="8" onKeyUp="ValidateText(this)" class="form-control" placeholder="Bar code"  value="<?php if ($act=='edt'){echo $rowedtstock['barcode']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">Item Price</label>
									<div class="col-sm-6">
										<input type="number" id="itemprice" name="itemprice" min="1" max="99.99" maxlength="5" onKeyUp="ValidateText(this)" class="form-control" placeholder="Item Price" value="<?php if ($act=='edt'){echo $rowedtstock['itemprice']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Qty Sold</label>
									<div class="col-sm-6">
										<input type="number" id="qtysold" name="qtysold" maxlength="8" size="8" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Qty Sold" value="<?php if ($act=='edt'){echo $rowedtstock['qtysold']; }?>" >
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
                                    <input type="submit" value="Save / Print" onsubmit="return validateField()" name="save" id="save"/>
								</div>
								</div>
	
							</form>														
					</div>
                    
                    <?php 	$query = "SELECT * FROM temptrans order by timedate desc"; //ERE barcode='".$barcode."' ";
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Barcode</th><th>Item Name</th><th>Item Price</th>
								  <th>Qty Sold</th><th>Total Price</th><th>Action</th></tr></thead><tbody>";
							$invtotal = 0;
							while($row = mysql_fetch_array($result)) 
							{
								$sqlitem = "SELECT `barcode`, pdtname
											FROM hqinv
											WHERE  barcode = '".$row['barcode']."'";
								//echo $sqlitem;
								$resitem = mysql_query($sqlitem);
								$rowitem = mysql_fetch_assoc($resitem);

								$invtotal += $row['itemprice']*$row['qtysold'];
								
								echo "<tr>";
								echo "<td>".$row['barcode']."</td>";
								echo "<td>".$rowitem['pdtname']."</td>";
								echo "<td>".$row['itemprice']."</td>";
								echo "<td>".$row['qtysold']."</td>";
								echo "<td>".$row['itemprice']*$row['qtysold']."</td>";
								
								echo "<td><a href='transaction.php?act=del&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Delete</a>
								<a href='transaction.php?act=edt&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Edit</a>
								</td>";
								echo "</tr>";
							}
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td><strong>Total:</strong></td>";
							echo "<td><b>".$invtotal."</b></td>";
							echo "<td>&nbsp;</td>";
							echo "</tr>";
							
							
							
							//echo "<tr><td colspan='6'> Total:".$invtotal."</td></tr>  ";
							echo "</table>";
						}
					?>
				</div>
				</div>
			</div>
		</div>
        <div style="text-align:right; margin-top:150px">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>