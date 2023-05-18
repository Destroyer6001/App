<?php 
    include("../../bd.php");

    if($_POST)
    {
        $validacion; 
        //recibimos el dato desde el metodo post y lo asignamos a una variable
        $nombredelpuesto=(isset($_POST['nombredelpuesto'])?$_POST['nombredelpuesto']:"");
        /*realizamos una validacion interna en la base de datos para preguntat si el dato existe en el 
        en el sistema*/
        $validacion = Validar($nombredelpuesto,$conexion);
        if($validacion == false)
        {
            //definimos la sentencia de insersion del dato en la tabla de la base de datos
            $sentencia = $conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) 
            VALUES (null,:nombredelpuesto)");
            //pasamo el parametro con la instruccion bindparam y el campo que se recibio desde el formulario post
            $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
            $sentencia->execute();
            //redireccionamos al index y actualizamos la tabla de puesto
            $mensaje="Registro Creado";
            header("Location:index.php?mensaje=".$mensaje);
        }
        else
        {
            $mensajederesultado = "El puesto ya se encuentra registrado en el sistema";
        }
    }

    function Validar($nombredelpuesto,$conexion)
    {
        $resultado; 
        $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE nombredelpuesto = :nombredelpuesto");
        $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
        $sentencia->execute();
        $puesto = $sentencia->fetch(PDO::FETCH_LAZY);

        if($puesto != null)
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
            <h3 id="Titulo"><strong>Crear Puesto</strong></h3>
            </div>
            <div class="card-body">
                <?php if(isset($mensajederesultado)) {?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $mensajederesultado ?></strong>
                    </div>
                <?php }?>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombredelpuesto" class="form-label">Nombre del puesto</label>
                        <input type="text"
                        value="<?php if(isset($nombredelpuesto)) echo $nombredelpuesto?>"
                        class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
                    </div>
                    <button id="guardar" type="submit" class="btn">Agregar</button>
                    &nbsp&nbsp
                    <a name="" id="cancelar" class="btn" href="index.php" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

<?php include("../../templates/footer.php"); ?>