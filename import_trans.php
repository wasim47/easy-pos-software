<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="import_trans";
?>
<html>
	<head>
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script>
			function hist()
			{
				window.location = "http://-/inventory.php";
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
                <h2><strong>Mass Import (Transactions)</strong></h2>
				<div class="tab-content">
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-inline" role="form" method="post" action="import_trans.php" enctype="multipart/form-data">
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
							$file = fopen( $filename, "r" ) or die ("Error in opening File");
							$filesize = filesize( $filename );
							$filetext = fread( $file, $filesize );
							fclose( $file );

							// Splitting up the Delimiter \n 
							$content= explode("\n", $filetext);
							echo "Text file uploaded!";
							
							foreach($content as $line)
							{
								list($transactionid, $cashierid, $productName, $barcode, $amt, $date) = explode(":", $line);
								$query = "insert into HQtransactions (trnid, barcode,shopid, qtysold, itemprice, timedate) 
											values ('".$transactionid."', '".$barcode."', '".$cashierid."', ".$amt.",".rand(1,99.9).",'".$date."')";
								$result = mysql_query($query);
							}	

							$query = "Select * From hqtransactions";
							$result = mysql_query($query);
							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Trans ID</th><th>Shop ID</th><th>Barcode</th><th>Qty Sold</th><th>Item Price</th><th>Date</th></thead><tbody>";
							
							while ($row = mysql_fetch_array($result)) 
							{
								echo "<tr>";
								echo "<td>".$row['trnid']."</td>";
								echo "<td>".$row['shopid']."</td>";						
								echo "<td>".$row['barcode']."</td>";
								echo "<td>".$row['qtysold']."</td>";
								echo "<td>".$row['itemprice']."</td>";
								echo "<td>".$row['timedate']."</td>";
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