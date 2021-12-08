<?php
include("../includes/conexion.php");
$id = $_POST['id'];
$sql="DELETE FROM laptops WHERE id_laptop = '$id'";	

if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo "10";
}else {
	mysqli_close($mysqli); 
    echo "11";
}
?>