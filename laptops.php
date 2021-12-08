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
									<form class="form-horizontal" role="form" method="post" action="queries/insert_laptop.php">
										<div class='form-group'>
											<label for='numero_laptop' class="col-sm-3 control-label">
												NÚMERO LAPTOP
											</label>
											<div class="col-sm-9">
												<input type='text' name='numero_laptop' class='form-control' id='numero_laptop' />
											</div>
										</div>
										<div class='form-group'>
											<label for='numero_serie' class="col-sm-3 control-label">
												NÚMERO DE SERIE
											</label>
											<div class="col-sm-9">
												<input type='text' name='numero_serie' class='form-control' id='numero_serie' />
											</div>
										</div>
										<div class='form-group'>
											<label for='marca' class="col-sm-3 control-label">
												MARCA
											</label>
											<div class="col-sm-9">
												<input type='text' name='marca' class='form-control' id='marca' />
											</div>
										</div>
										<div class='form-group'>
											<label for='modelo' class="col-sm-3 control-label">
												MODELO
											</label>
											<div class="col-sm-9">
												<input type='text' name='modelo' class='form-control' id='modelo' />
											</div>
										</div>
										<div class='modal-footer'>
											<button type='submit' class='btn btn-success'>
												Guardar
											</button>
										</div>
									</form>
								</div>
							</p>
							
							<div class="form-group" id="change-container" hidden>
								<form class="form-horizontal" role="form" method="post" action="queries/change_laptop.php">
									<div class='form-group'>
										<label for='c_numero_laptop' class="col-sm-3 control-label">
											NÚMERO LAPTOP
										</label>
										<div class="col-sm-9">
											<input type='text' name='numero_laptop' class='form-control' id='c_numero_laptop' />
											<div hidden><input type='text' name='id' readonly class='form-control' id='c_id' /></div>
										</div>
									</div>
									<div class='form-group'>
										<label for='c_numero_serie' class="col-sm-3 control-label">
											NÚMERO DE SERIE
										</label>
										<div class="col-sm-9">
											<input type='text' name='numero_serie' class='form-control' id='c_numero_serie' />
										</div>
									</div>
									<div class='form-group'>
										<label for='c_marca' class="col-sm-3 control-label">
											MARCA
										</label>
										<div class="col-sm-9">
											<input type='text' name='marca' class='form-control' id='c_marca' />
										</div>
									</div>
									<div class='form-group'>
										<label for='c_modelo' class="col-sm-3 control-label">
											MODELO
										</label>
										<div class="col-sm-9">
											<input type='text' name='modelo' class='form-control' id='c_modelo' />
										</div>
									</div>
									<div class='modal-footer'>
										<button type='button' onclick='changeLaptopCancel()' class='btn btn-danger'>
											Cancelar
										</button>
										<button type='submit' class='btn btn-success'>
											Guardar cambios
										</button>
									</div>
								</form>
							</div>
							
							<table id="table-uta" class="display nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th>Número de laptop</th>
										<th>Número de serie</th>
										<th>Marca</th>
										<th>Modelo</th>
									</tr>
								</thead>
								<tbody>
									<?php
										include("includes/conexion.php");
										$sql2="SELECT * FROM laptops";
										$result = mysqli_query($mysqli, $sql2);
										while ($var= mysqli_fetch_array($result)){ ?>
											<tr>
												<td style='text-align:center;'><a style='text-align:center;' href='#' onclick='deleteLaptop("<?php echo $var['numero_laptop'];?>","<?php echo $var['id_laptop'];?>")' role='button' class='btn'><img src='img/cancel.png' width='25px'/></a>
												</td>
												<td style='text-align:center;'><a style='text-align:center;' href='#' onclick='changeLaptop("<?php echo $var['numero_laptop'];?>","<?php echo $var['numero_serie'];?>","<?php echo $var['id_laptop'];?>","<?php echo $var['marca'];?>","<?php echo $var['modelo'];?>")' role='button' class='btn'> <img src='img/pencil.png' width='25px'/></a>
												</td>
												<td style='text-align:center;'><?php echo $var['numero_laptop'];?></td>
												<td style='text-align:center;'><?php echo $var['numero_serie'];?></td>
												<td style='text-align:center;'><?php echo $var['marca'];?></td>
												<td style='text-align:center;'><?php echo $var['modelo'];?></td>
											</tr>
										<?php } 
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
