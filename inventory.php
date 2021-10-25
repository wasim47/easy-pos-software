<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="inventory";
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
		$itemname = stripslashes($_POST['itemname']);
		$category = stripslashes($_POST['cat']);
		$manuf = stripslashes($_POST['man']);
		$barcode = stripslashes($_POST['bar']);
		$currentStock = stripslashes($_POST['cstock']);
		$costprice = stripslashes($_POST['price']);
		$minStock = stripslashes($_POST['mstock']);
		$bundleunit = stripslashes($_POST['bundleunit']);

		
		$sqlrec = "select * from HQinv where barcode = '".$barcode."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, bundle, minstock ) values ('".$itemname."', '".$category."','".$manuf."', '".$barcode."','".$costprice."','".$currentStock."','".$bundleunit."','".$minStock."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Product Successfully Added to Inventory';
			}
			else{
				$mesg = "New Product Creation Failed";			
			}
		}elseif($nrec > 0){		
		
			$query = "update HQinv set 
						pdtname = '".$itemname."', 
						category  = '".$category."',
						manufacturer  = '".$manuf."',
						barcode = '".$barcode."',
						cost = '".$costprice."',
						curstock = '".$currentStock."',
						bundle = '".$bundleunit."',
						minstock = '".$minStock."'
					 where barcode = '".$barcode."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Product Is Updated Successfully';
			}
			else{
				$mesg = "Product Updation Failed";			
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
                <h2><strong>Inventory</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="inventory.php" enctype="multipart/form-data" name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-6">
										<input type="text" id="itemname" name="itemname"  maxlength="50" onkeyup "ValidateText(this)" class="form-control" placeholder="Product Name" value="<?php if ($edtinv!=''){echo $rowedtinv['pdtname']; }?>" />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Category</label>
									<div class="col-sm-6">
										<input type="text" id="cat" maxlength="50" name="cat" onKeyUp="ValidateText(this)" class="form-control" placeholder="Category"  value="<?php if ($edtinv!=''){echo $rowedtinv['category']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">Manufacturer</label>
									<div class="col-sm-6">
										<input type="text" id="man" name="man"  maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="Manufacturer" value="<?php if ($edtinv!=''){echo $rowedtinv['manufacturer']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Barcode</label>
									<div class="col-sm-6">
										<input type="number" id="bar" name="bar" minlength="8" maxlength="8" size="8" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Barcode" value="<?php if ($edtinv!=''){echo $rowedtinv['barcode']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="price" class="col-sm-3 control-label">Cost Price</label>
									<div class="col-sm-6">
										<input type="float" id="price" name="price" min='1' max='99.99' maxlength="5" onChange="priceTimer(this)" class="form-control" placeholder="Cost Price" value="<?php if ($edtinv!=''){echo $rowedtinv['cost']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="cstock" class="col-sm-3 control-label">Current Stock</label>
									<div class="col-sm-6">
										<input type="number" id="cstock" name="cstock" onChange="intTimer(this)" class="form-control" placeholder="Current Stock" value="<?php if ($edtinv!=''){echo $rowedtinv['curstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="mstock" class="col-sm-3 control-label">Minimum Stock</label>
									<div class="col-sm-6">
										<input type="number" id="mstock" name="mstock" onChange="intTimer(this)" class="form-control" placeholder="Minimum Stock" value="<?php if ($edtinv!=''){echo $rowedtinv['minstock']; }?>" >
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
                    
                     <!--div>
                    <form name="search" id="search" method="POST">
                        <div class="form-group">
                            
                            <div class="col-sm-6">
                            <table>
                            <tr>
                            <td> <label for="mstock" class="col-sm-3 control-label">Search</label></td>
                            <td> <input type="text" id="search" name="search" class="form-control" placeholder="Barcode" ></td>
                            <td><input type="submit" value="Search"  name="searchbtn" id="searchbtn"/></td>
                            </tr>
                            </table>
                            </div>
                        </div>
                    </form>
                    </div-->
                    
                    <?php 	
						/*	if(isset($_POST['search'])){
								$query = "SELECT * FROM HQinv  where barcode = '".stripslashes($_POST['search'])."' order by recdate desc"; ;
							}else {
								$query = "SELECT * FROM HQinv order by recdate desc"; //ERE barcode='".$barcode."' ";
							}
					
							
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
								echo "<td><a href='inventory.php?del=".$row['barcode']."'>Delete</a>
								<a href='inventory.php?edt=".$row['barcode']."'>Edit</a>
								</td>";
								echo "</tr>";
							}
							echo "</table>";
						} */
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