<?php
    include("../../bd.php");

    $sentencia=$conexion->prepare("SELECT *,
    (SELECT nombredelpuesto
    FROM tbl_puestos
    WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto
    FROM `tbl_empleados`");
    $sentencia->execute();
    $lista_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_GET['txtID']))
    {
        //se recepciona el id del empleado
        $txtID = (isset($_GET['txtID'])?$_GET['txtID']:"");
        //se obtienen los datos de la foto y el cv guardados del empleado
        $sentencia = $conexion->prepare("SELECT foto,cv FROM tbl_empleados WHERE id=:id");
        $sentencia -> bindParam(":id",$txtID);
        $sentencia -> execute();
        $empleado = $sentencia->fetch(PDO::FETCH_LAZY);

        //se comprueba que en el arreglo empleado que tiene el resultado de la busqueda de la foto y el cv del cliente exista un dato foto y este sea diferente a vacio
        if(isset($empleado['foto']) && $empleado['foto'] !="" )
        {
            // se valida que en la carpeta de archivos exista una foto con el nombre del archivo correpondiente al empleado
            if(file_exists("../../archivos/".$empleado['foto']))
            {
                // se retira la foto de la carpeta
                unlink("../../archivos/".$empleado['foto']);
            }
        }
        //se comprueba que en el arreglo empleado que tiene el resultado de la busqueda de la foto y el cv del cliente exista un dato cv y este sea diferente a vacio
        if(isset($empleado['cv']) && $empleado['cv'] != "")
        {
            // se valida que en la carpeta de archivos exista un cv con el nombre del archivo correpondiente al empleado
            if(file_exists("../../archivos/".$empleado['cv']))
            {
                // se retira el cv de la carpeta
                unlink("../../archivos/".$empleado['cv']);
            }
        }


        // se elimina el registro del empleado del sistema
        $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id = :id");
        $sentencia ->bindParam(":id",$txtID);
        $sentencia ->execute();

        $mensaje="Registro borrado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>


<?php include("../../templates/header.php"); ?>
    <br>
    <div class="card">
        <div class="content">
            <div class="title">
                <h3 id="Titulo"><strong>Empleados</strong></h3>
            </div>
            <div class="card-body">
                <a name="" id="btncrear" class="btn btn-primary" href="crear.php" role="button">Agregar</a>
                <div class="table-responsive-sm">
                    <table class="table" id="tabla_id">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Foto</th>
                                <th scope="col">CV</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Fecha De Ingreso</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lista_empleados as $empleados){ ?>
                                <tr class="">
                                    <td><?php echo $empleados['id'];?></td>
                                    <td scope="row">
                                    <?php echo $empleados['primernombre'];?>
                                    <?php echo $empleados['segundonombre'];?>
                                    <?php echo $empleados['primerapellido'];?>
                                    <?php echo $empleados['segundoapellido'];?>
                                    </td>
                                    <td>
                                        <img width="60" src="../../archivos/<?php echo $empleados['foto'];?>" class="img-fluid rounded" alt="" />
                                    </td>
                                    <td>
                                        <a href="../../archivos/<?php echo $empleados['cv'];?>" target="_blank" ><?php echo $empleados['cv']; ?></a>
                                    </td>
                                    <td><?php echo $empleados['puesto'];?></td>
                                    <td><?php echo $empleados['fechadeingreso'];?></td>
                                    <td><a name="" id="hojaderecomendacion" class="btn" href="carta_recomendacion.php?txtID=<?php echo $empleados['id'];?>" role="button">Carta</a>
                                    <a name=""  id="editar" class="btn" href="editar.php?txtID=<?php echo $empleados['id'];?>" role="button">Editar</a>
                                    <a name=""  id="borrar" class="btn btn-danger" href="javascript:borrar(<?php echo $empleados['id'];?>);" role="button">Borrar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div>
    


<?php include("../../templates/footer.php"); ?>