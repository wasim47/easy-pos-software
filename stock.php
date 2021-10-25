<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="stock";
$act = $_GET['act'];
if($act!="" && $act=='del'){
	$sqldelstock = "delete from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resdelstock = mysql_query($sqldelstock);
	
}else if ($act!="" && $act=='edt'){
	$sqledtstock = "select * from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resedtstock = mysql_query($sqledtstock);
	$rowedtstock = mysql_fetch_assoc($resedtstock);

}



if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);
		$barcode = stripslashes($_POST['barcode']);
		$citycurstock = stripslashes($_POST['citycurstock']);
		$citylastprice = stripslashes($_POST['citylastprice']);

/*		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];
*/
		
		$sqlrec = "select * from hqstock where barcode = '".$barcode."' and shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into hqstock (shopid, barcode, citycurstock, citylastprice) values ('".$shopid."', '".$barcode."','".$citycurstock."', '".$citylastprice."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Record Successfully Added to stock';
			}
			else{
				$mesg = "New Record Insertion Failed";			
			}
		}elseif($nrec > 0){		
		
			$query = "update hqstock set 
						shopid = '".$shopid."', 
						barcode  = '".$barcode."',
						citycurstock  = '".$citycurstock."',
						citylastprice = '".$citylastprice."'
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
                <h2><strong>Stock</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="stock.php" enctype="multipart/form-data" name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
										<input type="number" id="shopid" name="shopid"  maxlength="4" onkeyup "ValidateText(this)" class="form-control" placeholder="Shop ID" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>" />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Barcode</label>
									<div class="col-sm-6">
										<input type="number" id="barcode" name="barcode" maxlength="8" minlength="8" onKeyUp="ValidateText(this)" class="form-control" placeholder="Bar code"  value="<?php if ($act=='edt'){echo $rowedtstock['barcode']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">Current Stock</label>
									<div class="col-sm-6">
										<input type="number" id="citycurstock" name="citycurstock" onKeyUp="ValidateText(this)" class="form-control" placeholder="Current Stock" value="<?php if ($act=='edt'){echo $rowedtstock['citycurstock']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Last Price</label>
									<div class="col-sm-6">
										<input type="number" id="citylastprice" name="citylastprice" min="1" max="99.99" maxlength="5" size="5" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Last Price" value="<?php if ($act=='edt'){echo $rowedtstock['citylastprice']; }?>" >
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
                    <!--div>
                    <form name="search" id="search" method="POST">
                        <div class="form-group">
                            
                            <div class="col-sm-6">
                            <table>
                            <tr>
                            <td> <label for="mstock" class="col-sm-3 control-label">Search</label></td>
                            <td> <input type="text" id="search" name="search" class="form-control" placeholder="Shop ID" ></td>
                            <td><input type="submit" value="Search"  name="searchbtn" id="searchbtn"/></td>
                            </tr>
                            </table>
                            </div>
                        </div>
                    </form>
                    </div-->
                    
                    
                    <?php 	
					/*
					
							if(isset($_POST['search'])){
								$query = "SELECT * FROM hqstock  where shopid = '".stripslashes($_POST['search'])."' order by shopid desc"; ;
							}else {
								$query = "SELECT * FROM hqstock order by recdate desc"; 
							}
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Shop ID</th><th>Barcode</th><th>Current Stock</th>
								  <th>Last Price</th><th>Action</th></tr></thead><tbody>";
							
							while($row = mysql_fetch_array($result)) 
							{
								echo "<tr>";
								echo "<td>".$row['shopid']."</td>";
								echo "<td>".$row['barcode']."</td>";
								echo "<td>".$row['citycurstock']."</td>";
								echo "<td>".$row['citylastprice']."</td>";
								echo "<td><a href='stock.php?act=del&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Delete</a>
								<a href='stock.php?act=edt&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Edit</a>
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