<?php
session_start();
if(isset($_SESSION['username'])) {
    header("Location: index.php");
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
                            <a class="dropdown-item" href="ajustes.php"><span class="fa fa-cog"></span> Ajustes</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="gestion/cerrar-sesion.php"><span class="fa fa-power-off"></span> Cerrar sesión</a>
                        </div>   
                    </li>

                    <?php
                    } else{
                    ?>

                    <li class="nav-item mx-1">
                        <a class="nav-link disabled" href="#"> <b>Iniciar sesión</b></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <br>
        <!-- Alertas -->
        <?php
        if(isset($_GET["state"])){

            if($_GET["state"]=="err1"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Usuario o contraseña incorrectos.
        </div>

        <?php
            }
            elseif($_GET["state"]=="err2"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> El Nombre de Usuario o el email ya se han tomado.
        </div>
        <?php
            }
            elseif($_GET["state"]=="err3"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Algo ha ocurrido creando tu cuenta. ¡Vigila esos caracteres extraños!.
        </div>
        <?php
            }
            elseif($_GET["state"]=="success"){
        ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Bienvenido!</strong> Ya puedes iniciar sesión con tu nueva cuenta.
        </div>

        <?php
            }
        }
        ?>

        <br>

        <div class="container">
            <div class="row">
                <div class="col-sm-6 my-sm-0">
                    <h1 class="text-center">Iniciar Sesion</h1>
                    <div class="container-fluid">
                        <form action="/gestion/iniciar-sesion.php" method="post">
                            <div class="form-group">
                                <label for="usuario">Usuario:</label>
                                <input id="usuario" type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-default">Iniciar sesión</button>
                        </form>
                    </div>


                </div>
                <div class="col-sm-6 my-5 my-sm-0">
                    <h1 class="text-center">Registrarse</h1>
                    <div class="container-fluid">
                        <form action="/gestion/registrar-usuario.php" method="post">
                            <div class="form-group">
                                <label for="usuario">Usuario:</label>
                                <input id="usuario" type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-default">Comenzar</button>
                        </form>

                    </div>



                </div>
            </div>
        </div>

        <br><br>

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
