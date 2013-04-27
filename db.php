<?php
$mysqlhost="0.0.0.0:0000"; // MySQL-Host 

$mysqluser="dbuser"; // MySQL-User 

$mysqlpwd="dbpass"; // Password
// Whiteliste Datenbank
$mysqldb="dbname"; // DB-Name

if(@mysql_connect($mysqlhost, $mysqluser, $mysqlpwd))
{ 
	if(@mysql_select_db($mysqldb))
	{
		
	} else {
		die("Die Datenbank konnte nicht selektiert werden!");
	}
} else {
	die ("Verbindungsversuch fehlgeschlagen");
}

?>
