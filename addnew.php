<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="product";

$delinv = $_GET['del'];
if($delinv != ""){
	$sqldelinv = "delete from HQinv where barcode = '".$delinv."'";
	$resdelinv = mysql_query($sqldelinv);
}

$edtinv = $_GET['edt'];
if($edtinv != ""){
	$sqledtinv = "select * from HQinv where barcode = '".$edtinv."'";
	$resedtinv = mysql_query($sqledtinv);
	$rowedtinv = mysql_fetch_assoc($resedtinv);
}



	if(isset($_POST['submit'])){
		$itemname = $_POST['itemname'];
		$category = $_POST['cat'];
		$manuf = $_POST['man'];
		$barcode = $_POST['bar'];
		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];

		$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle) values ('".$itemname."', '".$category."','".$manuf."', '".$barcode."','".$costprice."','".$currentStock."','".$minStock."','".$bundleunit."')";
		$result = mysql_query($query);

		if($result)
		{
			//header("Location: http://-/page/addnew.php");
			$mesg = 'New Product Successfully Added to Inventory';
			
		}
		else
			echo "New Product Creation Failed";			
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
                <h2><strong>Inventory</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="addnew.php" enctype="multipart/form-data" name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-6">
										<input type="text" id="itemname" name="itemname" onkeyup "ValidateText(this)" class="form-control" placeholder="Product Name" value="<?php if ($edtinv!=''){echo $rowedtinv['pdtname']; }?>" />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Category</label>
									<div class="col-sm-6">
										<input type="text" id="cat" name="cat" onKeyUp="ValidateText(this)" class="form-control" placeholder="Category"  value="<?php if ($edtinv!=''){echo $rowedtinv['category']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">Manufacturer</label>
									<div class="col-sm-6">
										<input type="text" id="man" name="man" onKeyUp="ValidateText(this)" class="form-control" placeholder="Manufacturer" value="<?php if ($edtinv!=''){echo $rowedtinv['manufacturer']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Barcode</label>
									<div class="col-sm-6">
										<input type="text" id="bar" name="bar" maxlength="8" size="8" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Barcode" value="<?php if ($edtinv!=''){echo $rowedtinv['barcode']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="price" class="col-sm-3 control-label">Cost Price</label>
									<div class="col-sm-6">
										<input type="text" id="price" name="price" onChange="priceTimer(this)" class="form-control" placeholder="Cost Price" value="<?php if ($edtinv!=''){echo $rowedtinv['cost']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="cstock" class="col-sm-3 control-label">Current Stock</label>
									<div class="col-sm-6">
										<input type="text" id="cstock" name="cstock" onChange="intTimer(this)" class="form-control" placeholder="Current Stock" value="<?php if ($edtinv!=''){echo $rowedtinv['curstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="mstock" class="col-sm-3 control-label">Minimum Stock</label>
									<div class="col-sm-6">
										<input type="text" id="mstock" name="mstock" onChange="intTimer(this)" class="form-control" placeholder="Minimum Stock" value="<?php if ($edtinv!=''){echo $rowedtinv['minstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bundleunit" class="col-sm-3 control-label">Bundle Unit</label>
									<div class="col-sm-6">
										<input type="text" id="bundleunit" name="bundleunit" onChange="intTimer(this)" class="form-control" placeholder="Bundle Unit" value="<?php if ($edtinv!=''){echo $rowedtinv['bundle']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
								<div class="col-sm-6">
									<input type="submit" value="Submit" onsubmit="return validateField()" name="submit" id="submit"/>
								</div>
								</div>
	
							</form>														
					</div>
                    
                    <?php 	$query = "SELECT * FROM HQinv order by recdate desc"; //ERE barcode='".$barcode."' ";
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Product Name</th><th>Category</th><th>Manufacturer</th><th>
								  Barcode</th><th>Cost Price</th><th>Current Stock</th><th>
								  Minimum Stock</th><th>Bundle Unit</th><th>Action</th></tr></thead><tbody>";
							
							while($row = mysql_fetch_array($result)) 
							{
								echo "<tr>";
								echo "<td>".$row['pdtname']."</td>";
								echo "<td>".$row['category']."</td>";
								echo "<td>".$row['manufacturer']."</td>";
								echo "<td>".$row['barcode']."</td>";
								echo "<td>".$row['cost']."</td>";
								echo "<td>".$row['curstock']."</td>";
								echo "<td>".$row['minstock']."</td>";
								echo "<td>".$row['bundle']."</td>";
								echo "<td><a href='addnew.php?del=".$row['barcode']."'>Delete</a>
								<a href='addnew.php?edt=".$row['barcode']."'>Edit</a>
								</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
					?>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>