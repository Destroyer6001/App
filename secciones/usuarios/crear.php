<?php 

  include("../../bd.php");

  if($_POST)
  {
    $usuario = (isset($_POST['usuario'])?$_POST['usuario']:"");
    $password = (isset($_POST['password'])?$_POST['password']:"");
    $email = (isset($_POST['email'])?$_POST['email']:"");

    $sentencia = $conexion->prepare("INSERT INTO tbl_usuarios(id,usuario,password,correo) 
    VALUES(null,:usuario,:password,:correo)");
    $sentencia->bindParam(":usuario",$usuario);
    $sentencia->bindParam(":password",$password);
    $sentencia->bindParam(":correo",$email);
    $sentencia->execute();
    $mensaje="Registro creado";
    header("Location:index.php?mensaje=".$mensaje);
  }
?>
<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
      <div class="content">
        <div class="title">
          <h3 id="Titulo"><strong>Crear Usuario</strong></h3>
        </div>
        <div class="card-body">
          <form action="" method="post" class="form" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text"
                  class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuarios">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                  class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escribe su contraseña">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email"
                  class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Escribe su correo electronico">
              </div>
              </br>
              <button type="submit" id="guardar" class="btn">Agregar</button>
              &nbsp&nbsp
              <a name="" id="cancelar" class="btn" href="index.php" role="button">Cancelar</a>
          </form>
        </div>
    </div>
  </div>
    
<?php include("../../templates/footer.php"); ?>