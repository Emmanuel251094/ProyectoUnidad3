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
			function deleteUser(user, id){
				swal({   
				title: "¿Está usted seguro?",   
				text: "Se eliminará el usuario " + user,   
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
						url: "queries/delete_user.php",
						data: { "id" : id
								},
							success: function(data){
									window.location="usuarios.php?n=" + data; 
								  }
							 });
					} else {     
					swal("Cancelado", "El usuario no se eliminó", "error");   
					} 
				});
			}
			function changeUser(user, password, id){
				$("#change-container").attr("hidden", false);
				$("#insert-container").attr("hidden", true);
				$("#c_usuario").val(user);
				$("#c_password").val(password);
				$("#c_id").val(id);
			}
			function changeUserCancel(){
				$("#change-container").attr("hidden", true);
				$("#insert-container").attr("hidden", false);
				$("#c_usuario").val('');
				$("#c_password").val('');
				$("#c_id").val('');
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
									<form class="form-horizontal" role="form" method="post" action="queries/insert_user.php">
										<div class='form-group'>
											<label for='usuario' class="col-sm-2 control-label">
												USUARIO
											</label>
											<div class="col-sm-9">
												<input type='text' name='usuario' class='form-control' id='usuario' />
											</div>
										</div>
										<div class='form-group'>
											<label for='password' class="col-sm-2 control-label">
												CONTRASEÑA
											</label>
											<div class="col-sm-9">
												<input type='text' name='password' class='form-control' id='password' />
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
								<form class="form-horizontal" role="form" method="post" action="queries/change_user.php">
									<div class='form-group'>
										<label for='c_usuario' class="col-sm-2 control-label">
											USUARIO
										</label>
										<div class="col-sm-9">
											<input type='text' name='usuario' class='form-control' id='c_usuario' />
											<div hidden><input type='text' name='id' readonly class='form-control' id='c_id' /></div>
										</div>
									</div>
									<div class='form-group'>
										<label for='c_password' class="col-sm-2 control-label">
											CONTRASEÑA
										</label>
										<div class="col-sm-9">
											<input type='text' name='password' class='form-control' id='c_password' />
										</div>
									</div>
									<div class='modal-footer'>
										<button type='button' onclick='changeUserCancel()' class='btn btn-danger'>
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
										<th>Nombre</th>
										<th>Contraseña</th>
									</tr>
								</thead>
								<tbody>
									<?php
										include("includes/conexion.php");
										$sql2="SELECT * FROM usuarios";
										$result = mysqli_query($mysqli, $sql2);
										while ($var= mysqli_fetch_array($result)){ ?>
											<tr>
												<td style='text-align:center;'><a style='text-align:center;' href='#' onclick='deleteUser("<?php echo $var['usuario'];?>","<?php echo $var['id_usuario'];?>")' role='button' class='btn'><img src='img/cancel.png' width='25px'/></a>
												</td>
												<td style='text-align:center;'><a style='text-align:center;' href='#' onclick='changeUser("<?php echo $var['usuario'];?>","<?php echo $var['password'];?>","<?php echo $var['id_usuario'];?>")' role='button' class='btn'> <img src='img/pencil.png' width='25px'/></a>
												</td>
												<td style='text-align:center;'><?php echo $var['usuario'];?></td>
												<td style='text-align:center;'><?php echo $var['password'];?></td>
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
