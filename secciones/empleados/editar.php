<?php 

    include("../../bd.php");

    $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
    $sentencia -> execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID']))
    {
        $txtID = (isset($_GET['txtID'])?$_GET['txtID']:"");
        $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id = :id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $empleado = $sentencia->fetch(PDO::FETCH_LAZY);

        $primernombre = $empleado['primernombre'];
        $segundonombre = $empleado['segundonombre'];
        $primerapellido = $empleado['primerapellido'];
        $segundoapellido = $empleado['segundoapellido'];
        $foto = $empleado['foto'];
        $cv = $empleado['cv'];
        $idPuesto = $empleado['idpuesto'];
        $fechadeingreso = $empleado['fechadeingreso'];
    }


    if($_POST)
    {
        $txtID = (isset($_POST['txtId'])?$_POST['txtId']:"");
        $primernombre = (isset($_POST['primernombre'])?$_POST['primernombre']:"");
        $segundonombre = (isset($_POST['segundonombre'])?$_POST['segundonombre']:"");
        $primerapellido = (isset($_POST['primerapellido'])?$_POST['primerapellido']:"");
        $segundoapellido = (isset($_POST['segundoapellido'])?$_POST['segundoapellido']:"");
        $fechadeingreso = (isset($_POST['fechadeingreso'])?$_POST['fechadeingreso']:"");
        $idPuesto = (isset($_POST['idpuesto'])?$_POST['idpuesto']:"");

        $sentencia = $conexion->prepare("
        UPDATE tbl_empleados SET 
        primernombre = :primernombre,
        segundonombre = :segundonombre,
        primerapellido = :primerapellido,
        segundoapellido = :segundoapellido
        ,idpuesto = :idpuesto,
        fechadeingreso = :fechadeingreso 
        WHERE id = :id");
        $sentencia->bindParam(":primernombre",$primernombre);
        $sentencia->bindParam(":segundonombre",$segundonombre);
        $sentencia->bindParam(":primerapellido",$primerapellido);
        $sentencia->bindParam(":segundoapellido",$segundoapellido);
        $sentencia->bindParam(":idpuesto",$idPuesto);
        $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
        $sentencia->bindParam(":id", $txtID);
        $sentencia-> execute();


        $fecha = new DateTime();


        $foto = (isset($_FILES['foto']['name'])?$_FILES['foto']['name']:"");
        $nombredelarchivofoto = ($foto != '')?$fecha->getTimestamp()."_".$_FILES['foto']['name']:"";
        $tmp_foto = $_FILES['foto']['tmp_name'];
        
        if($tmp_foto != '')
        {
            $sentencia = $conexion->prepare("SELECT foto FROM tbl_empleados WHERE id=:id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $datosfoto = $sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($datosfoto['foto']) && $datosfoto['foto'] != "")
            {
                if(file_exists("../../archivos/".$datosfoto['foto']))
                {
                    unlink("../../archivos/".$datosfoto['foto']);
                }
            }
            move_uploaded_file($tmp_foto,"../../archivos/".$nombredelarchivofoto);
            $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto = :foto Where id = :id");
            $sentencia->bindParam(":foto",$nombredelarchivofoto);
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
        }

        $cv = (isset($_FILES['cv']['name'])?$_FILES['cv']['name']:"");
        $nombredelarchivopdf = ($cv != "")?$fecha->getTimestamp()."-".$_FILES['cv']['name']:"";
        $tmp_archivo = $_FILES['cv']['tmp_name'];

        if($tmp_archivo != '')
        {
            $sentencia = $conexion->prepare("SELECT cv FROM tbl_empleados WHERE id = :id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $datosarchivo = $sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($datosarchivo['cv'])&& $datosarchivo['cv'] != "")
            {
                if(file_exists("../../archivos/".$datosarchivo['cv']))
                {
                    unlink("../../archivos/".$datosarchivo['cv']);
                }
            }

            move_uploaded_file($tmp_archivo,"../../archivos/".$nombredelarchivopdf);
            $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv = :cv WHERE id=:id");
            $sentencia->bindParam(":cv",$nombredelarchivopdf);
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
        }

        $mensaje = "Registro actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
        <div class="content">
            <div class="title">
            <h3 id="Titulo"><strong>Editar Empleado</strong></h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="txtId" class="form-label">Id</label>
                        <input type="text"
                        value="<?php echo $txtID;?>"
                        class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID">
                    </div>
                    <div class="mb-3">
                        <label for="primernombre" class="form-label">Primer Nombre</label>
                        <input type="text"
                        value="<?php echo $primernombre;?>"
                        class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
                    </div>
                    <div class="mb-3">
                        <label for="segundonombre" class="form-label">Segundo Nombre</label>
                        <input type="text"
                        value="<?php echo $segundonombre;?>"
                        class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
                    </div>
                    <div class="mb-3">
                        <label for="primerapellido" class="form-label">Primer Apellido</label>
                        <input type="text"
                        value="<?php echo $primerapellido;?>"
                        class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
                    </div>
                    <div class="mb-3">
                        <label for="segundoapellido" class="form-label">Segundo Apellido</label>
                        <input type="text"
                        value = "<?php echo $segundoapellido;?>"
                        class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apelido">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <br/>
                        <img width="100" src="../../archivos/<?php echo $foto;?>" class="rounded" alt="" />
                        <br/></br>
                        <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" aria-describedby="fileHelpId">
                    </div>
                    <div class="mb-3">
                        <label for="cv" class="form-label">CV(PDF):</label>
                        <br/>
                        <a href="../../archivos/<?php echo $cv;?>" target="_blank" ><?php echo $cv; ?></a>
                        <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
                    </div>
                    <div class="mb-3">
                        <label for="idpuesto" class="form-label">Puesto:</label>
                        <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                            <?php foreach($lista_tbl_puestos as $puestos) {?>
                                <option <?php echo ($idPuesto == $puestos['id'])?"selected":""; ?> value="<?php echo $puestos['id']; ?>">
                                <?php echo $puestos['nombredelpuesto'];?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fechadeingreso" class="form-label">Fecha De Contratacion</label>
                        <input type="date" class="form-control" 
                        value="<?php echo $fechadeingreso?>"
                        name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha De Contratacion">
                    </div>
                    <br/>
                    <button type="submit" id="guardar" class="btn">Guardar</button>
                    &nbsp&nbsp
                    <a name="" id="cancelar" class="btn" href="index.php" role="button">Cancelar</a>
                    <br/>
                </form>
            </div>
        </div>
    </div>

<?php include("../../templates/footer.php"); ?>