<?php

    include("../../bd.php");

    if($_GET['txtID'])
    {
        $txtId = (isset($_GET['txtID'])?$_GET['txtID']:"");
        $sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id = :id");
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();

        $usuarioresultado = $sentencia->fetch(PDO::FETCH_LAZY);
        $usuario = $usuarioresultado['usuario'];
        $password = $usuarioresultado['password'];
        $correo = $usuarioresultado['correo'];
    }

    if($_POST)
    {
        $txtId = (isset($_POST['txtId'])?$_POST['txtId']:"");
        $usuario = (isset($_POST['usuario'])?$_POST['usuario']:"");
        $password = (isset($_POST['password'])?$_POST['password']:"");
        $correo = (isset($_POST['email'])?$_POST['email']:"");

        $sentencia = $conexion->prepare("UPDATE tbl_usuarios SET usuario=:usuario,
        password=:password,correo=:correo WHERE id = :id");

        $sentencia ->bindParam(":id",$txtId);
        $sentencia ->bindParam(":usuario",$usuario);
        $sentencia ->bindParam(":password",$password);
        $sentencia ->bindParam(":correo",$correo);

        $sentencia ->execute();
        $mensaje = "Registro actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>



<?php include("../../templates/header.php"); ?>
    <br/>
    <div class="card">
        <div class="content">
            <div class="title">
                <h3 id="Titulo"><strong>Editar Usuario</strong></h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="txtId" class="form-label">Id</label>
                        <input type="text"
                        value="<?php echo $txtId;?>"
                        class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID">
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text"
                        value="<?php echo $usuario;?>"
                        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                        value="<?php echo $password;?>"
                        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                        value="<?php echo $correo?>"
                        class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Email">
                    </div>
                    </br>
                    <button id="guardar" type="submit" class="btn">Guardar</button>
                    &nbsp&nbsp
                    <a id="cancelar" class="btn" href="index.php" role="button">cancelar</a>
                </form>
            </div>
        </div>
    </div>
    
<?php include("../../templates/footer.php"); ?>