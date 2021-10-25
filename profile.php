<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="editprofile";


if(isset($_POST['submit'])){
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);

		

		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		if($nrec == 0){		
			$errmsg = "Email is does not exist in the DB.";
		}elseif($errmsg == ""){		
		
			$query = "update users set 
				`fname`= '".$fname."',
				`lname`= '".$lname."',
				`password` = '".$password."',
				`city` = '".$city."',
				`shopid` = '".$shopid."'
				where emailid = ".$emailid."' ";

			//echo $query;
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Record is Updated successfully';
			}
			else{
				$errmsg = "Record Updation Failed";			
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
                    <?php
                    	$sqlusr = "select * from users where emailid = '".$_SESSION['emailid']."'";
						$resusr = mysql_query($sqlusr);
						$rowusr = mysql_fetch_assoc($resusr);
                    
                    ?>
						<form class="form-horizontal" role="form" method="post" action="register.php"  name="test">
								<div class="form-group">
									<label for="itemname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-6">
										<input type="text" id="fname" name="fname" maxlength="50" onkeyup "ValidateText(this)" class="form-control" placeholder="First Name" value="<?php echo $rowusr['fname']; ?>" required />
									</div>
								</div>	
								
								<div class="form-group">
									<label for="cat" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-6">
										<input type="text" id="lname" name="lname"  maxlength="50" onKeyUp="ValidateText(this)" class="form-control" placeholder="Last Name"  value="<?php echo $rowusr['lname']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="emailid" class="col-sm-3 control-label">Email ID</label>
									<div class="col-sm-6">
										<input type="email" id="emailid" name="emailid" maxlength="50" disabled onKeyUp="ValidateText(this)" class="form-control" placeholder="Email ID" value="<?php echo $rowusr['emailid']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="bar" class="col-sm-3 control-label">Password</label>
									<div class="col-sm-6">
										<input type="password" id="password" name="password"  maxlength="20" onKeyUp="ValidateBarcode(this)" class="form-control" placeholder="Password" value="<?php echo $rowusr['password']; ?>" required >
									</div>
								</div>
								
								
								<div class="form-group">
									<label for="cstock" class="col-sm-3 control-label">City</label>
									<div class="col-sm-6">
										<input type="text" id="city" name="city"  maxlength="40" onChange="intTimer(this)" class="form-control" placeholder="City Name" value="<?php echo $rowusr['city']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
									<label for="mstock" class="col-sm-3 control-label">Shop ID</label>
									<div class="col-sm-6">
										<input type="number" id="shopid" name="shopid" onChange="intTimer(this)" class="form-control" placeholder="Shop ID" value="<?php echo $rowusr['shopid']; ?>" required >
									</div>
								</div>
								
								<div class="form-group">
								<div class="col-sm-6">
									<input type="submit" value="Submit" onsubmit="return validateField()" name="submit" id="submit"/>
								</div>
								</div>
	
							</form>														
					</div>
				</div>
				</div>
			</div>
		</div>
        <div style="text-align:right; margin-top:150px">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>