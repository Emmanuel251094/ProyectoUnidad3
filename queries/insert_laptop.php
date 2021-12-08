<?php
include("../includes/conexion.php");
$numero_laptop = $_POST['numero_laptop'];
$numero_serie = $_POST['numero_serie'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];

$sql="INSERT INTO laptops (numero_laptop, numero_serie, marca, modelo, estatus) VALUE ('$numero_laptop','$numero_serie','$marca','$modelo', 'Disponible')";
if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../laptops.php?n=6"</script>';
}else {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../laptops.php?n=7"</script>';
}
?>