    <?php include("templates/header.php"); ?>
    <br/></br>
    <div class="card" id="cardindexpuestos">
      <div class="content">
        <div class="title">
          <h1 id="Titulo"><strong>Bienvenid@</strong></h1>
        </div>
        <div class="card-body">
          <p class="col-md-8 fs-4" id="titulo"><?php echo $_SESSION['usuario'];?></p>
          <a class="btn btn-primary" id="botonindex" href="Editar.php?UsuarioId=<?php echo $_SESSION['usuarioid'];?>" role="button">Editar Usuario</a>
        </div>
      </div>
    </div>
    <?php include("templates/footer.php"); ?>
