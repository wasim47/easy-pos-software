<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="register";
if(isset($_POST['submit'])){
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);
		$repassword = stripslashes($_POST['repassword']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);

		

		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		if($nrec > 0){		
			$errmsg = "Email is alrady selected, please choose a different one.";
		}elseif($password != $repassword){
			$errmsg = "Passowrds mismatched";
		}elseif($errmsg == ""){		
		
			$query = "insert into users (`fname`, `lname`, `emailid`, `password`, `city`, `shopid`)
			           values ('".$fname."','".$lname."','".$emailid."','".$password."','".$city."','".$shopid."')";
			//echo $query;
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Record is created successfully';
			}
			else{
				$errmsg = "Record Creation Failed";			
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
                <h2><strong>Registration</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php if($errmsg!=""){ echo $errmsg; } else {echo $mesg;} ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="register.php"  name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-6">
										<input type="text" id="fname" name="fname" maxlength="50" onkeyup "ValidateText(this)" class="form-control" placeholder="First Name" value="<?php echo $_POST['fname']; ?>" required />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-6">
										<input type="text" id="lname" name="lname"  maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="Last Name"  value="<?php echo $_POST['lname']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="emailid" class="col-sm-3 control-label">Email ID</label>
									<div class="col-sm-6">
										<input type="email" id="emailid" name="emailid" maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="Email ID" value="<?php echo $_POST['emailid']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Password</label>
									<div class="col-sm-6">
										<input type="password" id="password" name="password"  maxlength="20" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Password" value="<?php echo $_POST['password']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="price" class="col-sm-3 control-label">Re-Enter Password</label>
									<div class="col-sm-6">
										<input type="password" id="repassword" name="repassword" onChange="priceTimer(this)" class="form-control" placeholder="Re-Enter Password" value="<?php echo $_POST['repassword']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="cstock" class="col-sm-3 control-label">City</label>
									<div class="col-sm-6">
										<input type="text" id="city" name="city"  maxlength="40" onChange="intTimer(this)" class="form-control" placeholder="City Name" value="<?php echo $_POST['city']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="mstock" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
										<input type="number" id="shopid" name="shopid" onChange="intTimer(this)" class="form-control" placeholder="Shop ID" value="<?php echo $_POST['shopid']; ?>" required >
									</div>
								</div>
								
						<?php /*		<div class="form-group">
									<label for="bundleunit" class="col-sm-3 control-label">Bundle Unit</label>
									<div class="col-sm-6">
										<input type="text" id="bundleunit" name="bundleunit" onChange="intTimer(this)" class="form-control" placeholder="Bundle Unit" value="<?php if ($edtinv!=''){echo $rowedtinv['bundle']; }?>" >
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
                    
                    <?php 	/*
					
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
								echo "<td><a href='shop.php?del=".$row['shopid']."'>Delete</a>
								<a href='shop.php?edt=".$row['shopid']."'>Edit</a>
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
        <div style="text-align:right; margin-top:150px">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>