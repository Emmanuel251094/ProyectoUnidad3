<?php
include("../includes/conexion.php");
$id = $_POST['id'];
$sql="DELETE FROM programas WHERE id_programa = '$id'";	

if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo "14";
}else {
	mysqli_close($mysqli); 
    echo "15";
}
?>