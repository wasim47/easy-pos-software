<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="import_inv";
?>
<html>
	<head>
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script>
			function hist()
			{
				window.location = "http://localhost/inventory.php";
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
                <h2><strong>Mass Import (Inventory)</strong></h2>
				
				<div class="tab-content">
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-inline" role="form" method="post" action="import_inv.php" enctype="multipart/form-data">
							<div class="form-group">
								<input type="file" name="datatxtfile" id="datatxtfile"class="btn btn-default">
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-default" value="Upload">
							</div>
							<div class="form-group">
								<input type="button" name="a" class="btn btn-default" value="Cancel" onClick="hist()">
							</div>
						</form>	
					<?php
						if(isset($_FILES['datatxtfile']))
						{
							$allowedExts = array("txt", "csv");
							$extension = end(explode(".", $_FILES["datatxtfile"]["name"]));
							if(in_array($extension, $allowedExts))
							{
								if ($_FILES["datatxtfile"]["error"] > 0)
									echo "Error: " . $_FILES["datatxtfile"]["error"];
								else
									uploadTxtData($_FILES["datatxtfile"]["tmp_name"]);
							}
							else
								echo "Invalid File";
						}
						
						function uploadTxtData($filename)
						{	

							$file = fopen( $filename, "r" ) or die ('ERROR: fopen()');
							$filesize = filesize( $filename );
							$filetext = fread( $file, $filesize );
							fclose( $file );
							$content = explode("\n", $filetext);
							echo "Text file uploaded!";
							
							foreach($content as $line)
							{
								list($name, $category, $manuf, $barcode, $costprice, 
								$currentStock, $minStock, $bundleunit) = explode(":",$line);
								$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle) values ('".$name."','".$category."','".$manuf."','".$barcode."','".$costprice."','".$currentStock."','".$minStock."','".$bundleunit."')";
								$result = mysql_query($query);
							}	

							$query = "Select * From HQinv";
							$result = mysql_query($query);
							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Product Name</th><th>Category</th><th>Manufacturer</th><th>Barcode</th><th>Cost Price</th><th>Current Stock</th><th>Minimum Stock</th><th>Bundle Unit</th></tr></thead><tbody>";
							
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