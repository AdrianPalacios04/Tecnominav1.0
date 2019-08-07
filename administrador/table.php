<?php
include("../conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agenda</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 40px;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h4 style="margin-top: 51px">Listado del Personal</h4>
			<hr style="margin-bottom: -15px" />
			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM personal WHERE dni='$nik'");
				$cek = mysqli_query($con, "SELECT * FROM agenda WHERE numero='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM personal WHERE dni='$nik'");
					$delete = mysqli_query($con, "DELETE FROM agenda WHERE numero='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="POST">
				<!--<div class="form-group">
					<div class="col-sm-4">
						<input type="text" name="filter" class="form-control" placeholder="Busqueda" required>
					</div>
				</div>-->
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped" id="tabla">
				<thead>
					<tr>
                    <th>No</th>
					<th>DNI</th>
					<th>Paterno</th>
                    <th>Materno</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
				</tr>
				</thead>
				<tbody>
					
				
				<?php
				// para mostrar los datos de la tabla
				$sql = mysqli_query($con, "SELECT * FROM personal");

				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['dni'].'</td>
							<td><a data-toggle="modal" data-target="#dataModal" class="view_data" id='.$row["dni"].'><span class="glyphicon glyphicon-user" aria-hidden="true"></span>'.$row['paterno'].'</a></td>
                            <td>'.$row['materno'].'</td>
                            <td>'.$row['nombre'].'</td>
							';
						echo '
							</td>
							<td>
							<a href="add-agenda.php?nik='.$row['dni'].'" title="Agregar mas numeros" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
								<a href="edit.php?nik='.$row['dni'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="table.php?aksi=delete&nik='.$row['dni'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos de '.$row['nombre'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
				</tbody>
			</table>
			<!-- Modal de detalle -->
			<div id="dataModal" class="modal fade">
				 <div class="modal-dialog">
				  <div class="modal-content">
				   <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">&times;</button>
				    <h4 class="modal-title">Personal Detalles</h4>
				   </div>
				   <div class="modal-body" id="personal_detalles">
				    
				   </div>
				   <div class="modal-footer">
				    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				   </div>
				  </div>
				 </div>
				</div>
			</div>
		</div> 
		<!-- agregar mas numeros -->
		<?php
			//$aumento = mysqli_query($con,"SELECT * FROM personal where dni");
			//$row = mysqli_fetch_assoc($aumento);
			?>
			<?php
		if(isset($_POST['add'])){
				$dni = mysqli_real_escape_string($con,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$tipo = mysqli_real_escape_string($con,(strip_tags($_POST["tipo_numero"],ENT_QUOTES)));//Escanpando caracteres 
				$numero = mysqli_real_escape_string($con,(strip_tags($_POST["numero"],ENT_QUOTES)));//Escanpando caracteres
				$sql = mysqli_query($con, "SELECT * FROM agenda WHERE dni='$dni'");
				$row = mysqli_fetch_assoc($sql);
				if(mysqli_num_rows($sql) == 0){
						$insert = mysqli_query($con, "INSERT INTO agenda(dni, tipo_numero, numero) VALUES('$dni','$tipo', '$numero')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}	 
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El DNI ya exite!</div>';
				}
			}
		?>
			<!-- Modal --><form action="" method="post">
			<div class="modal fade" id="data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Agregar Numero Telefonico</h5>
			      </div>
			      <div class="modal-body">
						<div class="form-group">
							<label >DNI</label>
							<input type="text" name="dni" class="form-control" value="<?php echo $row['dni']; ?>"  required>
					  </div>
					<div class="form-group">
						<label>Tipo</label>	
							<select name="tipo_numero" class="form-control">
								<option value=""> ----- </option>
                           		<option value="1">Empresa</option>
								<option value="2">Personal</option>
							 	<option value="3">Anexo</option>
							</select>
					</div>
					  <div class="form-group">
						    <label>Numero</label>
							<input type="number" name="numero" class="form-control" >
					  </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" name="add">Save changes</button>
			      </div>
			    </div>
			  </div>
			</div>
		</form>
	</div>
	
	<center>
		<form action="excel.php" method="POST">
		<input type="submit" name="export" value="Exportar a Excel" class="btn btn-success" style="margin-bottom: 10px">
	</form>
	<p>&copy; Sistemas Tecnomina <?php echo date("Y");?></p>
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabla').dataTable();
		})
	</script>
	<script type="text/javascript">
		$('#tabla').dataTable( {
  		scrollY: 470,
  		//paging: true

		} );

	</script>
	<script>  
 $(document).on('click', '.view_data', function(){
  //$('#dataModal').modal();
  var personal_id1 = $(this).attr("id");
  $.ajax({
   url:"VistaPrevia.php",
   method:"POST",
   data:{personal_id1:personal_id1},
   success:function(data){
    $('#personal_detalles').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
 </script>
</body>
</html>
