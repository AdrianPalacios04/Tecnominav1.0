<?php
include("../conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agregar</title>
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
			<h2>Datos del Personal &raquo; Agregar Numero Telefonico</h2>
			<hr />
			<?php
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($con, "SELECT * FROM personal WHERE dni='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: table.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['add'])){
				$dni = mysqli_real_escape_string($con,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$tipo = mysqli_real_escape_string($con,(strip_tags($_POST["tipo_numero"],ENT_QUOTES)));//Escanpando caracteres 
				$numero = mysqli_real_escape_string($con,(strip_tags($_POST["numero"],ENT_QUOTES)));//Escanpando caracteres 
				$cek = mysqli_query($con, "SELECT * FROM agenda WHERE dni='$dni'");
				//if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($con, "INSERT INTO agenda(dni, tipo_numero, numero) VALUES('$dni','$tipo', '$numero')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				//}else{
					//echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El DNI ya exite!</div>';
				//}
			}
			?>

			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">DNI</label>
					<div class="col-sm-3">
						<input type="text" name="dni" class="form-control" placeholder="DNI" value="<?php echo $row ['dni']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Tipo</label>
					<div class="col-sm-3">
						<select name="tipo_numero" class="form-control">
							<option value=""> ----- </option>
                           <option value="1">Empresa</option>
							<option value="2">Personal</option>
							
							 <option value="3">Anexo</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Numero Telefonico</label>
					<div class="col-sm-3">
						<input type="text" name="numero" class="form-control" placeholder="Numero Telefonico" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
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
