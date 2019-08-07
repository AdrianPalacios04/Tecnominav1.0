<?php  
//select.php  
if(isset($_POST["personal_id1"]))
{
 $output ='';
 $connect = mysqli_connect("localhost", "root", "", "tecnomina");
$query = "SELECT * FROM personal WHERE dni = '".$_POST["personal_id1"]."'";
$query1="SELECT t.tipo_nombre, a.numero FROM agenda a INNER JOIN tipo_numero t WHERE a.tipo_numero=t.idnumero AND a.dni = '".$_POST["personal_id1"]."'";
 $result = mysqli_query($connect, $query);
 $result1 = mysqli_query($connect, $query1);
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
     <tr>  
            <td width="30%"><label>DNI</label></td>  
            <td width="70%">'.$row["dni"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Paterno</label></td>  
            <td width="70%">'.$row["paterno"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Materno</label></td>  
            <td width="70%">'.$row["materno"].'</td>  
        </tr>
        <tr>
            <td width="30%"><label>Nombre</label></td>  
            <td width="70%">'.$row["nombre"].'</td>
        </tr>
     <tr>
     ';
    }while($row = mysqli_fetch_array($result1)){ 
     $output .='  <td width="30%" style="font-weight: bold">N°- '.$row["tipo_nombre"].'</td>  
        <td width="70%">'.$row["numero"].'<a href="edit-agenda.php?nik='.$row["numero"].'" title="Editar Numeros" class="btn btn-default btn-sm" style="margin-left:10px"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span></a>
        <a href="table.php?aksi=delete&nik='.$row['numero'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar el numero'.$row['numero'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </td>

    </tr>
    ';
}
    $output .= '</table></div>';
    echo $output;
}
?>
