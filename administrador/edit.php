<?php
include("../conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del personal &raquo; Editar datos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($con, "SELECT * FROM personal WHERE dni='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: table.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$dni = mysqli_real_escape_string($con,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$paterno = mysqli_real_escape_string($con,(strip_tags($_POST["paterno"],ENT_QUOTES)));//Escanpando caracteres 
				$materno = mysqli_real_escape_string($con,(strip_tags($_POST["materno"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$update = mysqli_query($con, "UPDATE personal SET dni='$dni', paterno='$paterno', materno='$materno', nombre='$nombre'WHERE dni='$nik'") or die(mysqli_error());
				if($update){
					header("Location: edit.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">DNI</label>
					<div class="col-sm-2">
						<input type="text" name="dni" value="<?php echo $row ['dni']; ?>" class="form-control" placeholder="NIK" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Apellido Paterno</label>
					<div class="col-sm-4">
						<input type="text" name="paterno" value="<?php echo $row ['paterno']; ?>" class="form-control" placeholder="Apellido Paterno" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Apellido Materno</label>
					<div class="col-sm-4">
						<input type="text" name="materno" value="<?php echo $row ['materno']; ?>" class="form-control" placeholder="Apellido Materno" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre Completo</label>
					<div class="col-sm-3">
						<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre Completo" required>
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