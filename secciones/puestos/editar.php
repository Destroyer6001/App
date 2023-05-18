<?php 

    include("../../bd.php");

    if(isset($_GET['txtID']))
    {
        //reseccion del dato txtid enviado desde un metodo get en el index
        $txtID = (isset($_GET['txtID'])?$_GET['txtID']:"");
        //query de consulta para obtener los datos del registro a buscar
        $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE id = :id");
        // parametro de entrada para poder hacer la busqueda con el select
        $sentencia ->bindParam(":id",$txtID);
        $sentencia ->execute();
        // instruccion para seleccionar un solo registro de la lista retornada
        $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        //asignacion de datos a una variable para ser enviada al formulario y asi poder 
        //mostrar los datos que trajo la conuslta
        $nombredelpuesto = $registro['nombredelpuesto'];
    }

    if($_POST)
    {
        $validacion;
        //validacion del envio de los datos id y nombre del puesto desde el formulario post
        $txtID = (isset($_POST['txtId'])?$_POST['txtId']:"");
        $nombredelpuesto = (isset($_POST['nombredelpuesto'])?$_POST['nombredelpuesto']:"");
        /*realizamos una validacion interna en la base de datos para preguntar si el dato existe en el 
        en el sistema a la hora de realizar la actualizacion*/
        $validacion = validar($txtID,$nombredelpuesto,$conexion);

        if($validacion == false)
        {
            //construccion del query de actualizacion de datos 
            $sentencia = $conexion ->prepare("UPDATE tbl_puestos SET nombredelpuesto = :nombredelpuesto
            WHERE id = :id");
            //entrada de paramatros al query
            $sentencia ->bindParam(":id",$txtID);
            $sentencia ->bindParam(":nombredelpuesto",$nombredelpuesto);
            $sentencia ->execute();
            //redireccion al index de puestos
            $mensaje="Registro actualizado";
            header("Location:index.php?mensaje=".$mensaje);
        }
        else
        {
            $mensajevalidacion = "El puesto ya se encuentra registrado en la base de datos";
        }
    }


    function validar($Id, $nombre, $conexion)
    {
        $resultado;
        $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE nombredelpuesto = :nombredelpuesto
        AND id != :id");
        $sentencia->bindParam(":id",$Id);
        $sentencia->bindParam(":nombredelpuesto",$nombre);
        $sentencia->execute();
        $resultadoconsulta = $sentencia->fetch(PDO::FETCH_LAZY);

        if($resultadoconsulta != null)
        {
            $resultado = true;
        }
        else
        {
            $resultado = false;
        }

        return $resultado;
    }
?>
<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
        <div class="content">
            <div class="title">
                <h3 id="Titulo"><strong>Editar Puesto</strong></h3>
            </div>
            <?php if(isset($mensajevalidacion)) {?>
                <div class="alert alert-danger" role="alert">
                    <strong><?php echo $mensajevalidacion ?></strong>
                </div>
            <?php } ?>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="txtId" class="form-label">Id</label>
                        <input type="text"
                        value="<?php echo $txtID;?>"
                        class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID">
                    </div>
                    <div class="mb-3">
                        <label for="nombredelpuesto" class="form-label">Nombre Del Puesto</label>
                        <input type="text"
                        value="<?php echo $nombredelpuesto;?>"
                        class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
                    </div>
                    <button type="submit" id="guardar" class="btn">Guardar</button>
                    &nbsp&nbsp
                    <a class="btn" id="cancelar" href="index.php" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>  
<?php include("../../templates/footer.php"); ?>