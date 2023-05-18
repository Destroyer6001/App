<?php 

    include("../../bd.php");
    //consulta de los datos guardados en la tabla puesto de la base de datos
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    //instruccion que permite retornar los datos en una lista
    $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_GET['txtID']))
    {
        //reseccion del dato id enviado por la accion get desde el boton borrar del index
        $txtID = (isset($_GET['txtID'])?$_GET['txtID']:"");
        //definicion de la instruccion de borrado en mysql
        $sentencia=$conexion->prepare("DELETE FROM tbl_puestos WHERE id = :id");
        //envio de parametro al query por medio de la instruccion bindParam
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        //redireccion al index de puestos
        $mensaje = "Registro Eliminado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>

<?php include("../../templates/header.php"); ?>
    </br>
    <div class="card">
        <div class="content">
            <div class="title">
                <h3 id="Titulo"><strong>Puestos</strong></h3>
            </div>
            <div class="card-body">
                <a name="btncrear" id="btncrear" class="btn" href="crear.php" role="button">Agregar</a>
                <div class="table-responsive-sm" style="color:  #17202A;">
                    <table class="table" id="tabla_id" style="color:  #17202A;">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lista_tbl_puestos as $registro) {?>
                                <tr class="">
                                    <td scope="row"><?php echo $registro['id'];?></td>
                                    <td><?php echo $registro['nombredelpuesto'];?></td>
                                    <td><a id="editar" class="btn" href="editar.php?txtID=<?php echo $registro['id'];?>" role="button">Editar</a>
                                    <a id="borrar" class="btn" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Borrar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php include("../../templates/footer.php"); ?>