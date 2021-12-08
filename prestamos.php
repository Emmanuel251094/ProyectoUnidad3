<?php 
include('includes/validation.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Universidad Tecnológica de Aguascalientes</title>
		<meta name="description" content="UTA - Sistema de prestamo">
		<meta name="author" content="UTA">

		<link href="css/system/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="js/system/sweetalert.min.js"></script> 
		<link rel="stylesheet" type="text/css" href="js/system/sweetalert.css">
		<script src="js/system/jquery.min.js"></script>
		
		<link href="css/jquery.dataTables.min.css" rel="stylesheet">
		<script src="js/jquery.dataTables.min.js"></script>
		
		
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	
		<script>
			$(document).ready(function() {
				$('#table-uta').DataTable( {
					"scrollY": 350,
					"scrollX": true
				} );
			} );
			function deleteLaptop(laptop, id){
				swal({   
				title: "¿Está usted seguro?",   
				text: "Se eliminará la laptop número " + laptop,   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Confirmar",   
				cancelButtonText: "Cancelar",   
				closeOnConfirm: false,   
				closeOnCancel: false }, 
				function(isConfirm){  
					if (isConfirm) {  
						$.ajax({
						type: "POST",
						url: "queries/delete_laptop.php",
						data: { "id" : id
								},
							success: function(data){
									window.location="laptops.php?n=" + data; 
								  }
							 });
					} else {     
					swal("Cancelado", "La laptop no se eliminó", "error");   
					} 
				});
			}
			function changeLaptop(numero_laptop, numero_serie, id, marca, modelo){
				$("#change-container").attr("hidden", false);
				$("#insert-container").attr("hidden", true);
				$("#c_numero_laptop").val(numero_laptop);
				$("#c_numero_serie").val(numero_serie);
				$("#c_id").val(id);
				$("#c_marca").val(marca);
				$("#c_modelo").val(modelo);
			}
			function changeLaptopCancel(){
				$("#change-container").attr("hidden", true);
				$("#insert-container").attr("hidden", false);
				$("#c_numero_laptop").val('');
				$("#c_numero_serie").val('');
				$("#c_id").val('');
				$("#c_marca").val('');
				$("#c_modelo").val('');
			}
		</script>
		
	</head>
	<body style="background-color:green;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" style="padding-top:50px;">
					<?php include("menu.php");?>
				</div>
			</div>
			<p>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-8">
						<div class="jumbotron well">
							<p>
								<div class="form-group" id="insert-container">
									<form class="form-horizontal" role="form" method="GET" action="#">
										<div class='form-group'>
											<label for='filtro' class="col-sm-3 control-label">
												FILTRO
											</label>
											<div class="col-sm-9">
												<select class='form-control' id='filtro' name='filtro' required>
													<option <?php if(isset($_GET['filtro'])&&$_GET['filtro']=='Todas')echo 'selected';?>>Todas</option>
													<option <?php if(isset($_GET['filtro'])&&$_GET['filtro']=='Disponibles')echo 'selected';?>>Disponibles</option>
												</select>
											</div>
										</div>
										<div class='form-group'>
											<label for='programa' class="col-sm-3 control-label">
												PROGRAMA
											</label>
											<div class="col-sm-9">
												<select class='form-control' id='programa' name='programa' required>
													<option <?php if(isset($_GET['programa'])&&$_GET['programa']=='Ninguno')echo 'selected';?>>Ninguno</option>
													<?php
														include("includes/conexion.php");
														$sql2="SELECT * FROM programas GROUP BY programa";
														$result = mysqli_query($mysqli, $sql2);
														while ($var= mysqli_fetch_array($result)){ ?>
															<option <?php if(isset($_GET['programa'])&&$_GET['programa']==$var['programa'])echo 'selected';?>><?php echo $var['programa'];?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class='modal-footer'>
											<button type='submit' class='btn btn-success'>
												Consultar
											</button>
										</div>
									</form>
								</div>
							</p>
							<table id="table-uta" class="display nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Número de laptop</th>
										<th>Número de serie</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Estatus</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if(isset($_GET['filtro'])&&$_GET['filtro']!=''){
											$consulta = '';
											if($_GET['filtro']=='Disponibles'){ $consulta = " laptops.estatus = 'Disponible' ";}else{ $consulta = "  laptops.estatus != '' "; }
											if($_GET['programa']!='Ninguno'){ $consulta .= " and programas.programa = '".$_GET['programa']."' ";}
											
											$sql2="SELECT laptops.*, programas.id_laptop as id_lt, programas.programa FROM laptops INNER JOIN programas ON laptops.id_laptop = programas.id_laptop WHERE ".$consulta." GROUP BY laptops.id_laptop";
											
											//echo $sql2;
											$result = mysqli_query($mysqli, $sql2);
											while ($var= mysqli_fetch_array($result)){ ?>
												<tr>
													<td style='text-align:center;'><?php echo $var['numero_laptop'];?></td>
													<td style='text-align:center;'><?php echo $var['numero_serie'];?></td>
													<td style='text-align:center;'><?php echo $var['marca'];?></td>
													<td style='text-align:center;'><?php echo $var['modelo'];?></td>
													<td style='text-align:center;'><?php echo $var['estatus'];?></td>
													<?php 
													if($var['estatus']=='Disponible'){
														echo "<td style='text-align:center;'><a href='prestamo_laptop.php?id=".$var['id_laptop']."'><img class='prestamo' src='img/prestamo.png'></td>";
													}else{
														echo "<td style='text-align:center;'><img class='prestamo' src='img/no_disponible.png'></td>";
													}
													?>
												</tr>
										<?php } }
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-2">
					</div>
				</div>
			</p>
		</div>
		<script src="js/bootstrap.min.js"></script>
		<img id="background_logo" style="" src="img/logo_menu.png">
	</body>
	<?php include('includes/notifications.php');?>
</html>
