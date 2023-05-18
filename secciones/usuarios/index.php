<?php 
    include("../../bd.php");

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
    $sentencia -> execute();
    $listado_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID']))
    {
        $txtid = (isset($_GET['txtID'])?$_GET['txtID']:"");
        $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE id = :id");
        $sentencia ->bindParam(":id",$txtid);
        $sentencia ->execute();
        header("Location:index.php");
    }

?>
<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
        <div class="content">
            <div class="title">
                <h3 id="Titulo"><strong>Usuarios</strong></h3>
            </div>
            <div class="card-body">
                <a name="" id="btncrear" class="btn" href="crear.php" role="button">Agregar</a>
                <div class="table-responsive-sm">
                    <table class="table" id="tabla_id">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre del usuario</th>
                                <th scope="col">Contraseña</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>   
                            <?php foreach($listado_tbl_usuarios as $usuarios) {?>
                                <tr class="">
                                    <td scope="row"><?php echo $usuarios['id']; ?></td>
                                    <td><?php echo $usuarios['usuario']; ?></td>
                                    <td>*******</td>
                                    <td><?php echo $usuarios['correo'];?></td>
                                    <td> <a id="editar" class="btn" href="editar.php?txtID=<?php echo $usuarios['id']; ?>" role="button">Editar</a>
                                    <a id="borrar" class="btn"  href="javascript:borrar(<?php echo $usuarios['id']; ?>);" role="button">Borrar</a>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include("../../templates/footer.php"); ?>