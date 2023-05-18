<?php 
  include ("../../bd.php");

  //lista de puestos para el selected list item
  $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
  $sentencia->execute();
  $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);


  if($_POST)
  {
    $primernombre = (isset($_POST['primernombre'])?$_POST['primernombre']:"");
    $segundonombre = (isset($_POST['segundonombre'])?$_POST['segundonombre']:"");
    $primerapellido = (isset($_POST['primerapellido'])?$_POST['primerapellido']:"");
    $segundoapellido = (isset($_POST['segundoapellido'])?$_POST['segundoapellido']:"");
    $fechadeingreso = (isset($_POST['fechadeingreso'])?$_POST['fechadeingreso']:"");
    $puesto = (isset($_POST['idpuesto'])?$_POST['idpuesto']:"");
    //recuperacion de datos tipo file del formulario
    $foto = (isset($_FILES['foto']['name'])?$_FILES['foto']['name']:"");
    $cv = (isset($_FILES['cv']['name'])?$_FILES['cv']['name']:"");

    $sentencia = $conexion->prepare("INSERT INTO tbl_empleados (id,primernombre,segundonombre,primerapellido
    ,segundoapellido,foto,cv,idpuesto,fechadeingreso)
    VALUES(null,:primernombre,:segundonombre,:primerapellido,:segundoapellido,:foto,:cv,:idpuesto,:fechadeingreso)");
    $sentencia->bindParam(":primernombre",$primernombre);
    $sentencia->bindParam(":segundonombre",$segundonombre);
    $sentencia->bindParam(":primerapellido",$primerapellido);
    $sentencia->bindParam(":segundoapellido",$segundoapellido);

    //declaracion de uan variable temporal con la fecha del arcivo que se creo
    $fecha = new DateTime();

    //declracion del nombre del archivo con la validacionde un if ternario que cumple la funcion de comprobar que el dato foto no este vacio
    //el nuevo nombre se obtiene mezclando en tal caso de que si halla un archivo en la variable foto, el nombre de la foto original mas la
    //fecha en que esta fue subida 
    $nombredelarchivofoto = ($foto != '')?$fecha->getTimestamp()."_".$_FILES['foto']['name']:"";
    // se obtiene el archivo temporal mediante el envio file y la recepcion de la propiedad del arreglo temp_name
    $tmp_foto = $_FILES['foto']['tmp_name'];
    // se verifica que si exista un dato dentro de temp_name
    if($tmp_foto != '')
    {
      //se mueve la foto a con la funcion move uploaded usanddo la variable tmp_foto donde esta la foto, la direccion de la carpeta donde se va guardar la foto y el nuevo nombre de la foto
      move_uploaded_file($tmp_foto,"../../archivos/".$nombredelarchivofoto);
    }

    //declracion del nombre del archivo con la validacionde un if ternario que cumple la funcion de comprobar que el dato cv no este vacio
    //el nuevo nombre se obtiene mezclando en tal caso de que si halla un archivo en la variable cv, el nombre del cv original mas la
    //fecha en que esta fue subido 
    $nombredelarchivopdf = ($cv != '')?$fecha->getTimestamp()."_".$_FILES['cv']['name']:"";
    // se obtiene el archivo temporal mediante el envio file y la recepcion de la propiedad del arreglo temp_name
    $tmp_archivo = $_FILES['cv']['tmp_name'];
     // se verifica que si exista un dato dentro de temp_name
    if($tmp_archivo != '')
    {
      //se mueve el cv a con la funcion move uploaded usanddo la variable tmp_cv donde esta el cv, la direccion de la carpeta donde se va guardar el cv y el nuevo nombre del cv
      move_uploaded_file($tmp_archivo,"../../archivos/".$nombredelarchivopdf);
    }

    // se guarda el nombre del archivo foto en la bd
    $sentencia->bindParam(":foto",$nombredelarchivofoto);
    $sentencia->bindParam(":cv",$nombredelarchivopdf);
    $sentencia->bindParam(":idpuesto",$puesto);
    $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
    $sentencia->execute();
    $mensaje="Registro Creado";
    header("Location:index.php?mensaje=".$mensaje);
  }
  
?>


<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
      <div class="content">
        <div class="title">
          <h3 id="Titulo"><strong>Crear Empleado</strong></h3>
        </div>
        <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="primernombre" class="form-label">Primer Nombre</label>
            <input type="text"
              class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
          </div>
          <div class="mb-3">
            <label for="segundonombre" class="form-label">Segundo Nombre</label>
            <input type="text"
              class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
          </div>
          <div class="mb-3">
            <label for="primerapellido" class="form-label">Primer Apellido</label>
            <input type="text"
              class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
          </div>
          <div class="mb-3">
            <label for="segundoapellido" class="form-label">Segundo Apellido</label>
            <input type="text"
              class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apelido">
          </div>
          <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" aria-describedby="fileHelpId">
          </div>
          <div class="mb-3">
            <label for="cv" class="form-label">CV(PDF):</label>
            <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
          </div>
          <div class="mb-3">
              <label for="idpuesto" class="form-label">Puesto:</label>
              <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                <?php foreach($lista_tbl_puestos as $puestos) {?>
                  <option value="<?php echo $puestos['id']; ?>"><?php echo $puestos['nombredelpuesto'];?></option>
                <?php }?>
              </select>
          </div>
          <div class="mb-3">
            <label for="fechadeingreso" class="form-label">Fecha De Contratacion</label>
            <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha De Contratacion">
          </div>
          <br/>
          <button id="guardar" type="submit" class="btn">Guardar</button>
          &nbsp&nbsp
          <a name="" id="cancelar" class="btn" href="index.php" role="button">Cancelar</a>
        </form>
        </div>
      </div>
    </div>
    
    
<?php include("../../templates/footer.php"); ?>