<?php
try {
     $db = new PDO("mysql:host=localhost;dbname=twitter", "root", "");
	 $db->query("SET NAMES UTF8");

	 
} catch ( PDOException $e ){
     print $e->getMessage();
}

/*$db=mysql_connect("localhost:8888", "root", "") or die('Could not connect');
mysql_select_db("twitter", $db) or die('wtf');
mysql_query('SET CHARACTER SET utf8');
*/
?>