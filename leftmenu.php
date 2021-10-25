<div class="col-sm-3">
					<ul class="nav nav-pills nav-stacked well">
						<li>
							<a href="index.php">Index</a>
						</li>
                        
                        
                        <?php if ($_SESSION['shopid'] != "") {?>
                        
						<li  <?php if($_SESSION['curpage']=="inventory"){echo "class = 'active'";} ?> >
							<a href="inventory.php">Inventory</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="inventory_list"){echo "class = 'active'";} ?> >
							<a href="inventory_list.php">Inventory List</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="stock"){echo "class = 'active'";} ?> >
							<a href="stock.php">Stock</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="stock_list"){echo "class = 'active'";} ?> >
							<a href="stock_list.php">Stock List</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="stock_shopwise"){echo "class = 'active'";} ?> >
							<a href="stock_shopwise.php">Stock Shop-wise</a>
						</li>
						<li  <?php if($_SESSION['curpage']=="transaction"){echo "class = 'active'";} ?> >
							<a href="transaction.php">Daily Transactions</a>
						</li>
						<li  <?php if($_SESSION['curpage']=="transaction_hist"){echo "class = 'active'";} ?> >
							<a href="transaction_hist.php">Transactions Shop-wise</a>
						</li>
						<li <?php if($_SESSION['curpage']=="shop"){echo "class = 'active'";} ?> >
							<a href="shop.php">Shops</a>
						</li>
                        <li <?php if($_SESSION['curpage']=="shop_list"){echo "class = 'active'";} ?> >
							<a href="shop_list.php">Shops List</a>
						</li>
						</br>
                        <li  <?php if($_SESSION['curpage']=="import_inv"){echo "class = 'active'";} ?> >
							<a href="import_inv.php">Mass Import (Inventory)</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="import_trans"){echo "class = 'active'";} ?> >
							<a href="import_trans.php">Mass Import (Transactions)</a>
						</li>
                         <li  <?php if($_SESSION['curpage']=="export"){echo "class = 'active'";} ?> >
							<a href="export.php">Export</a>
						</li>
                         <li  <?php if($_SESSION['curpage']=="editprofile"){echo "class = 'active'";} ?> >
							<a href="profile.php">Edit Profile</a>
						</li>
                         <li  <?php if($_SESSION['curpage']=="logout"){echo "class = 'active'";} ?> >
							<a href="logout.php">Logout</a>
						</li>
                        
                        <?php  } else { ?>
                        <li  <?php if($_SESSION['curpage']=="login"){echo "class = 'active'";} ?> >
							<a href="login.php">Login</a>
						</li>
                        <li  <?php if($_SESSION['curpage']=="register"){echo "class = 'active'";} ?> >
							<a href="register.php">Register</a>
						</li>
                        <?php } ?>
					</ul>
				</div>