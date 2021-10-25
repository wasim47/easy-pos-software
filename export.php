<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="export";

if(isset($_POST['submit'])){
	if($_POST['exptype']=='Inventory'){
		
		$filename = "inventory.txt";
		$file_handle = fopen($filename, "a");
		
		$sqlinv = "select * from hqinv";
		$resinv = mysql_query($sqlinv);
		
		while($rowinv = mysql_fetch_assoc($resinv)){
			//pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle
			$file_contents = $rowinv['pdtname'].':'.$rowinv['category'].':'.$rowinv['manufacturer'].':'.$rowinv['barcode'].':'.$rowinv['cost'].':'.$rowinv['curstock'].':'.$rowinv['minstock'].':'.$rowinv['bundle'].':0';
			fwrite($file_handle, $file_contents);
		}
		
		fclose($file_handle);
		//echo '<a href="inventory.txt" >inventory.txt</a>';
		
	}
	
	
	if($_POST['exptype']=='Transactions'){
		
		$filename = "transactions.txt";
		$file_handle = fopen($filename, "a");
		
		$sqltrans = "select * from hqtransactions where trnid between '474359' and '474361'";
		$restrans = mysql_query($sqltrans);
		
		while($rowtrans = mysql_fetch_assoc($restrans)){
			//trnid, barcode,shopid, qtysold, itemprice, timedate
			$file_contents = $rowtrans['trnid'].':'.$rowtrans['barcode'].':'.$rowtrans['shopid'].':'.$rowtrans['qtysold'].':'.$rowtrans['itemprice'].':'.$rowtrans['timedate'].':0';
			fwrite($file_handle, $file_contents);
		}
		
		fclose($file_handle);
		//echo '<a href="inventory.txt" >inventory.txt</a>';
		
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
                <h2><strong>Export</strong></h2>
				
				<div class="tab-content">
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-inline" role="form" method="post" action="export.php" enctype="multipart/form-data">
                            
                            <div class="form-group">
								<label> Inventory </label>
                                <input type="radio" name="exptype" id="exptype"  value="Inventory" >
                               </div>
                                <div class="form-group">
                                <label> Transactions </label>
                                <input type="radio" name="exptype" id="exptype"  value="Transactions">
                                
							</div>
							
							<div class="form-group">
								<div class="col-sm-6">
									<input type="submit" value="Submit" onsubmit="return validateField()" name="submit" id="submit"/>
								</div>
								</div>
						</form>	
                       
                        
                        
					<?php
					
					 if(isset($_POST['submit'])){
						if($_POST['exptype']=='Inventory'){
							 if (file_exists($filename)) {
                        		echo '<br><a href="inventory.txt" >inventory.txt</a>';
							}
						}
					 }
						
					 if(isset($_POST['submit'])){
						if($_POST['exptype']=='Transactions'){
							 if (file_exists($filename)) {
                        		echo '<br><a href="transactions.txt" >transactions.txt</a>';
							}
						}
					 }
						

					?>
				
				</div>
				</div>
			</div>
		</div>
     		<?php include('footer.php'); ?>
	</body>
</html>