<?php
include("../includes/conexion.php");
$id = $_POST['id'];
$numero_laptop = $_POST['numero_laptop'];
$numero_serie = $_POST['numero_serie'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$sql="UPDATE laptops SET numero_laptop='$numero_laptop', numero_serie='$numero_serie', marca='$marca', modelo='$modelo' WHERE id_laptop = '$id' ";
if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../laptops.php?n=8"</script>';
}else {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../laptops.php?n=9"</script>';
}
?>