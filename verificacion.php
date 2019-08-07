<?php
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$tipo =$_POST['tipo'];
$conexion=mysqli_connect("localhost","root","","tecnomina");
$consulta="select * from usuario where  dni='$usuario' and clave='$clave' and tipo='$tipo'";//seleccion que debe ser verdadera 
$resultado=mysqli_query($conexion,$consulta);//ejecuta 
$fila=mysqli_num_rows($resultado);
if ($fila > 0 ) {  //si consigue un dato
	if ($tipo == "A") {
		header("location:administrador/table.php");
	}elseif ($tipo =="P") {
		header("location:usuario/table.php");
	}
}else{
	header("location:index.php");
}
?>