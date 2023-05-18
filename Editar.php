<?php 
    include("bd.php");
    session_start();
    if(isset($_GET['UsuarioId']))
    {
        $txtId = (isset($_GET['UsuarioId'])?$_GET['UsuarioId']:"");
        $sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id = :id");
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $datosdelusuario = $sentencia->fetch(PDO::FETCH_LAZY);

        $usuario = $datosdelusuario['usuario'];
        $correo = $datosdelusuario['correo'];
        $password = $datosdelusuario['password'];
    }

    if($_POST)
    {
        $txtId = (isset($_POST['txtId'])?$_POST['txtId']:"");
        $usuario = (isset($_POST['usuario'])?$_POST['usuario']:"");
        $correo = (isset($_POST['correo'])?$_POST['correo']:"");
        $password = (isset($_POST['password'])?$_POST['password']:"");

        $sentencia = $conexion->prepare("UPDATE tbl_usuarios SET usuario = :usuario, correo = :correo, 
        password = :password WHERE id = :id");
        $sentencia->bindParam(":id",$txtId);
        $sentencia->bindParam(":correo",$correo);
        $sentencia->bindParam(":usuario",$usuario);
        $sentencia->bindParam(":password",$password);
        $sentencia->execute();
        session_destroy();
        header("Location:login.php");
    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>Editar Usuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="http://localhost/app/Css/editar.css" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container">
    <br/><br/>
        <div class="card">
            <div class="content">
                <div class="title">
                <h3 id="TituloEditar"><strong>Editar Usuario</strong></h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="form">
                        <div class="mb-3">
                            <label for="txtId" class="form-label">Id</label>
                            <input type="text"
                            value="<?php echo $txtId;?>"
                            class="form-control"  readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text"
                            value="<?php echo $usuario;?>"
                            class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Email</label>
                            <input type="text"
                            value="<?php echo $correo?>"
                            class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                            value="<?php echo $password;?>"
                            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">
                        </div>
                        <br/>
                        <button type="submit" id="GuardarEditar" class="btn">Guardar</button>
                        &nbsp&nbsp
                        <a class="btn" id="CancelarEditar" href="index.php" role="button">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>