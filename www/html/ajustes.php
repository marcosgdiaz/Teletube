<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}

include "gestion/config.php";
$usql = "SELECT * FROM Usuarios WHERE id_usuario = ".$_SESSION['id'];
$uresult = $conexion->query($usql);

if($uresult->num_rows > 0){
    $urow = $uresult->fetch_array(MYSQLI_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="es">


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="estilos.css" media="all" >

        <!-- importo bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" > <!-- iconos-->
        <link rel="shortcut icon" href="media/other/icono.png">

        <!-- Importo scripts para dinamismo de bootstrap y popper. Innecesarios (de momento?)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
            function check(input) {
                if (input.value != document.getElementById('password').value) {
                    input.setCustomValidity('Las contraseñas no coinciden');
                } else {
                    // input válida - Se resetea el mensaje
                    input.setCustomValidity('');
                }
            }

            function muestraCambiaPW(){ //Muestra el formulario de cambio de PW
                $("#pwbutton").hide();
                $("#cambiapw").show();
            }
        </script>



        <title> Teletube</title>
    </head>


    <body>  
        <!-- Barra de navegación-->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top" >
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="true">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                <img src="media/other/icono.png" alt="Logo" style="width:40px;">
            </a>
            <div class="navbar-collapse collapse" id="navb">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mr-1">
                        <a class="nav-link" href="index.php"><span class="fa fa-home"></span> <b>Inicio</b></a> <!-- OJO: Habrá que cambiar los links y los ACTIVE en <a> -->    
                    </li>

                    <li class="nav-item mx-1">
                        <a class="nav-link" href="upform.php"><span class="fa fa-upload"></span> <b>Subir vídeo</b></a>
                    </li>
                </ul>

                <form class="form-inline mx-1" action="users.php" method="get">   <!-- Buscador de usuarios -->
                    <input class="form-control mr-1 " type="text" placeholder="Nombre de usuario" name="u"> 
                    <button class="btn my-2 my-sm-0 mr-1" type="submit" style="margin-left:5px"> <span class="fa fa-search"></span> </button>
                </form>

                <ul class="navbar-nav mr-5">

                    <?php 
                    if(isset($_SESSION['id'])) {
                    ?>
                    <li class="nav-item dropdown mr-2">
                        <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href=#> <b>Mi cuenta</b> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="perfil.php?id=<?php echo $_SESSION['id']; ?>"> Mi perfil</a>
                            <a class="dropdown-item" href="#"><span class="fa fa-cog"></span> Ajustes</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="gestion/cerrar-sesion.php"><span class="fa fa-power-off"></span> Cerrar sesión</a>
                        </div>   
                    </li>

                    <?php
                    } else{
                    ?>

                    <li class="nav-item mx-1">
                        <a class="nav-link" href="login.php"> <b>Iniciar sesión</b></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <br>
        <?php
        if(isset($_GET["state"])){

            if($_GET["state"]=="2"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Hemos tenido un problema subiendo el archivo.
        </div>

        <?php
            }
            elseif($_GET["state"]=="1"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Fichero demasiado pesado. Recuerda: <strong>Hasta 100MB</strong>.
        </div>

        <?php
            }
            elseif($_GET["state"]=="5"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Contraseña incorrecta!</strong> Vuelve a intentarlo.
        </div>
        
        <?php
            }
            elseif($_GET["state"]=="3"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Algo ha ido mal!</strong> Hemos tenido un error subiendo la foto.
        </div>
        <?php
            }
            elseif($_GET["state"]=="4"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Problemas con nuestra base de datos.
        </div>
        <?php
            }
            elseif($_GET["state"]=="7"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">   
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Sesión no iniciada!</strong> ¿Cómo has llegado hasta aquí, para empezar?
        </div>
        <?php
            }
            elseif($_GET["state"]=="0"){
        ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong> ¡Éxito! </strong> Los cambios han sido guardados.
        </div>

        <?php
            }
            else{
        ?>

        <div class="alert alert-danger alert-dismissible fade show text-center">    
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error desconocido!</strong> No sabemos qué ha podido ir mal.
        </div>

        <?php
            }
        }
        ?>


        <!-- Alertas (POR IMPLEMENTAR)--> 
        <br>

        <!-- Confirmación local de coincidencia de contraseñas -->


        <div class="container my-5">
            <form action="gestion/cambiar-datos.php" method="POST" enctype="multipart/form-data">
                <div class="row my-5">
                    <div class="col-md-5">
                        <img class="imgsettings d-block mx-auto" src="media/perfil/<?php echo $urow['foto']; ?>" alt="UsuarioImg"> <!-- TEMPORAL -->
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="file"> Seleccionar nueva imagen:</label>
                            <input type="file" class="form-control" id="file" name="imgfile" accept="image/*">  
                        </div>
                    </div>


                </div>




                <div class="form-group my-5">
                    <label for="desc">Descripción del perfil:</label>
                    <textarea class="form-control" id="desc" name="profdesc" rows="6" maxlength="500"><?php echo $urow['descripcion']; ?></textarea>
                </div>
                <div class="my-5" id="pwbutton">
                    <a href="javascript:muestraCambiaPW()"> Cambiar contraseña</a>
                </div>

                <div class="form-group hiddenform my-5" id="cambiapw">
                    <input type="password" name="newpw" placeholder="Nueva contraseña" id="password">
                    <input type="password" placeholder="Confirmar nueva contraseña" id="confirm_password" oninput="check(this)">
                </div>

                <input type="password" name="pw" placeholder="Contraseña actual" required>

                <button class="my-3" type="submit" class="btn btn-default mx-3">Guardar cambios</button>
            </form>

        </div>


        <!-- FOOTER -->
        <footer id="foot">
            <div class="row">
                <div class="col-sm-4 mt-2">
                    <div class="container mx-auto">
                        <h5 class="d-inline mx-3">¡Síguenos!</h5>
                        <div class="d-inline">
                            <a href="https://www.facebook.com/"><i class="face fa fa-2x fa-facebook redes" aria-hidden="true"></i></a>

                            <a href="https://twitter.com/"><i class="twitter fa fa-2x fa-twitter redes" aria-hidden="true"></i></a>

                            <a href="https://www.instagram.com/"><i class="insta fa fa-2x fa-instagram redes" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-2">
                    <h5 class="d-inline mx-3">¡99% libre de errores! </h5>
                    <div class="d-inline">
                        <a href="http://validator.w3.org/check?uri=referer"><img src="media/other/HTMLlogo.png" width="34" height="34" alt="HTML5logo"></a> 
                    </div>
                </div>
                <div class="col-sm-4 mt-2">
                    <a href="#" onclick="alert('¡Nope!');"><h5>Contacta con nosotros</h5></a>
                </div>

            </div>
        </footer>

    </body>
</html>
