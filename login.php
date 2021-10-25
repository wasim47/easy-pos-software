<?php  session_start(); ob_start();

include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="login";
if(isset($_POST['submit'])){
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);


		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."' and password = '".$password."'";
		$resrec = mysql_query($sqlrec);
		$rowuser = mysql_fetch_assoc($resrec);
		
		
		
		if($rowuser['emailid'] == ""){		
			$errmsg = "Invalid Email ID or Passowrd";
		}elseif($rowuser['shopid'] != ""  && $errmsg == ""){		
		
			$_SESSION['shopid'] = $rowuser['shopid'];
			$_SESSION['emailid'] = $rowuser['emailid'];
			header('location:transaction.php');
			
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
                <h2><strong>Login</strong></h2>
				<div class="tab-content">
                <div align="center"> <?php if($errmsg!=""){ echo $errmsg; } else {echo $mesg;} ?> </div>
					<div class="tab-pane active" id="tabs1-pane1">
						<form class="form-horizontal" role="form" method="post" action="login.php"  name="test">
								
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
        <div style="text-align:right; margin-top:400px">
        		<?php include('footer.php'); ?>
        </div>
	</body>
</html>