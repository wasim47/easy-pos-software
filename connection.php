<?php 
		$host = "localhost";
		$db_username = "root";
		$db_password = "";
		$database = "easypos";
			
		$conn = mysql_connect($host, $db_username, $db_password) 
				or die ('Error Cannot Connect to MySQL');
		@mysql_select_db($database) or die( "Unable to select database");

?>