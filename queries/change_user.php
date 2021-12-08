<?php
include("../includes/conexion.php");
$id = $_POST['id'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];	
$sql="UPDATE usuarios SET usuario='$usuario', password='$password' WHERE id_usuario = '$id' ";
if (mysqli_query($mysqli, $sql)) {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../usuarios.php?n=4"</script>';
}else {
	mysqli_close($mysqli); 
    echo'<script type="text/javascript">window.location="../usuarios.php?n=5"</script>';
}
?>