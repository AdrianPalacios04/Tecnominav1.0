<?php
include("../conexion.php");
include("../verificacion.php");
if()
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cambio de Numero Telefonico</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="content">
			<h2>Detalle del personal &raquo; Editar Numeros telefonicos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($con, "SELECT p.dni,p.paterno,p.materno,p.nombre,t.tipo_nombre,a.numero  
    				FROM personal p INNER JOIN agenda a
            		ON a.dni = p.dni
         			INNER JOIN tipo_numero t
            		ON t.idnumero = a.tipo_numero AND a.numero='$nik'");
			if(mysqli_num_rows($sql) == 0){
				echo "No se puede ver nada";
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$tipo = mysqli_real_escape_string($con,(strip_tags($_POST["tipo_numero"],ENT_QUOTES)));//Escanpando caracteres 
				$numero = mysqli_real_escape_string($con,(strip_tags($_POST["numero"],ENT_QUOTES)));//Escanpando caracteres 
				$update = mysqli_query($con, "UPDATE agenda SET tipo_numero='$tipo' , numero='$numero'where numero='$nik'") or die(mysqli_error());
				if($update){
					header("Location: table.php");
				}else{
					echo "no se logro editar";
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Tipo</label>
					<div class="col-sm-4">
						<select name="tipo_numero" class="form-control">
							<option value=""> ----- </option>
                           <option value="1">Empresa</option>
							<option value="2">Personal</option>
							
							 <option value="3">Anexo</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Numero Completo</label>
					<div class="col-sm-4">
						<input type="text" name="numero" value="<?php echo $row ['numero']; ?>" class="form-control" placeholder="Numero" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="table.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>