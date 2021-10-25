<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="shop_list";
$delshop = $_GET['del'];
if($delshop != ""){
	$sqldelshop = "delete from shopslist where shopid = '".$delshop."'";
	$resdelshop = mysql_query($sqldelshop);
}

$edtshop = $_GET['edt'];
if($edtshop != ""){
	$sqledtshop = "select * from shopslist where shopid = '".$edtshop."'";
	$resedtshop = mysql_query($sqledtshop);
	$rowedtshop = mysql_fetch_assoc($resedtshop);
}



	if(isset($_POST['submit'])){
		$shopname = stripslashes($_POST['shopname']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);
	/*	$barcode = $_POST['bar'];
		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];
     */
		//echo "shop id = ".$shopid;
		$sqlrec = "select * from shopslist where shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into shopslist (shopname, city) values ('".$shopname."', '".$city."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Shop Successfully Added';
			}
			else{
				$mesg = "New Shop Addition Failed";			
			}
		}elseif($nrec > 0){		
		
			$query = "update shopslist set 
						shopname = '".$shopname."', 
						city  = '".$city."'
					 where shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Shop Is Updated Successfully';
			}
			else{
				$mesg = "Shop Updation Failed";			
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
                <h2><strong>Shops List</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php echo $mesg; ?> </div>
					<?php /*?><div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="shop.php"  name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
										<input type="number" id="shopid" name="shopid" onkeyup "ValidateText(this)" class="form-control" placeholder="shopid" value="<?php if ($edtshop!=''){echo $rowedtshop['shopid']; }?>" />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Shop Name</label>
									<div class="col-sm-6">
										<input type="text" id="shopname" name="shopname"  maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="shopname"  value="<?php if ($edtshop!=''){echo $rowedtshop['shopname']; }?>" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="man" class="col-sm-3 control-label">City</label>
									<div class="col-sm-6">
										<input type="text" id="city" name="city" maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="city" value="<?php if ($edtshop!=''){echo $rowedtshop['city']; }?>" >
									</div>
								</div>
								
							
								
								<div class="form-group">
								<div class="col-sm-6">
									<input type="submit" value="Submit" onsubmit="return validateField()" name="submit" id="submit"/>
								</div>
								</div>
	
							</form>														
					</div><?php */?>
                    <div>
                    <form name="search" id="search" method="POST" action="shop_list.php">
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
                    </div>
                    
                    <?php 	
					
							if(isset($_POST['search'])){
								$query = "SELECT * FROM shopslist  where shopid = '".stripslashes($_POST['search'])."' order by shopid desc"; ;
							}else {
								$query = "SELECT * FROM shopslist order by shopid desc"; 
							}
							
							
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<table class="table table-condensed table-hover table-bordered">';
							echo "<thead><th>Shop ID</th><th>Shop Name</th><th>City</th>
								  <th>Action</th></tr></thead><tbody>";
							
							while($row = mysql_fetch_array($result)) 
							{
								echo "<tr>";
								echo "<td>".$row['shopid']."</td>";
								echo "<td>".$row['shopname']."</td>";
								echo "<td>".$row['city']."</td>";
								echo "<td><a href='shop_list.php?del=".$row['shopid']."'>Delete</a>
								<a href='shop.php?edt=".$row['shopid']."'>Edit</a>
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