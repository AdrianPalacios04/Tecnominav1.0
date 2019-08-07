<?php
$connect = mysqli_connect("localhost", "root", "", "tecnomina");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT p.dni,p.paterno,p.materno,p.nombre,t.tipo_nombre,a.numero  
        FROM personal p INNER JOIN agenda a
                ON a.dni = p.dni
             INNER JOIN tipo_numero t
                ON t.idnumero = a.tipo_numero ORDER BY paterno";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>DNI</th>  
                         <th>Paterno</th>  
                         <th>Medrano</th>
                         <th>Nombre</th>  
                         <th>Tipo_nombre</th>  
                         <th>Numero</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["dni"].'</td>  
                         <td>'.$row["paterno"].'</td>  
                         <td>'.$row["materno"].'</td>
                         <td>'.$row["nombre"].'</td>  
                         <td>'.$row["tipo_nombre"].'</td>  
                         <td>'.$row["numero"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=listado_telefonico.xls');
  echo $output;
 }
}
?>
