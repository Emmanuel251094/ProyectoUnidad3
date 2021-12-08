<?php
$mysqli = new mysqli("localhost", "root", "", "uta_db");
if ($mysqli->connect_errno) {
	echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}else{
	$mysqli->set_charset("utf8");
	return $mysqli;
}
?>