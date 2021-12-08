<?php
include("../includes/conexion.php");
$id = $_POST['id'];
$sql="DELETE FROM usuarios WHERE id_usuario = '$id'";	

if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo "2";
}else {
	mysqli_close($mysqli); 
    echo "3";
}
?>