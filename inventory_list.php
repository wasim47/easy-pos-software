<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="inventory_list";
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
                <h2><strong>Inventory List</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
                    
                     <div>
                    <form name="search" id="search" method="POST" action="inventory_list.php">
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
                    </div>
                    
                    <?php 	
							if(isset($_POST['search'])){
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
								echo "<td><a href='inventory_list.php?del=".$row['barcode']."'>Delete</a>
								<a href='inventory.php?edt=".$row['barcode']."'>Edit</a>
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
        <div style="text-align:right">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>