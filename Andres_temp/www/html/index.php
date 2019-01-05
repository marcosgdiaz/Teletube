<!DOCTYPE html>
<?php
session_start();
?>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="estilos.css" media="all" >

        <!-- importo bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" > <!-- iconos-->
        <link rel="shortcut icon" href="media/other/icono.png">

        <!-- Importo scripts para dinamismo de bootstrap y popper -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



        <title> Teletube</title>
    </head>

    <body class="d-flex flex-column">

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
                        <a class="nav-link disabled" href="#"><span class="fa fa-home"></span> <b>Inicio</b></a> 
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
                        <a class="nav-link" href="login.php"> <b>Iniciar sesión</b></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <?php
        if(isset($_GET["err"])){

            if($_GET["err"]=="1"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center mt-3">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> Debes hacer login para poder subir vídeos.
        </div>
        <?php
            }
            elseif($_GET["err"]=="2"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center mt-3">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> ¡Ya has iniciado sesión!
        </div>

        <?php
            }
        }
        ?>
        <!--Cabecera del contenido-->
        <div class="container-fluid my-5">
            <div class="container">
                <h1 class="cabecera"> ¡Bienvenido!</h1>
            </div>
            <div id="vidcontainer">

                <form class="form-inline my-4 container mx-auto" action="ivideoframe.php" method="get" target="ividframe">    <!--Buscador de vídeos-->
                    <input class="form-control" type="text" placeholder="Título" name="title" style="width:450px">

                    <div class="form-group mx-4 my-2"> 
                        <label class="mx-2 d-inline" for="sel1">Categoría: </label>
                        <select class="form-control d-inline" id="sel1" name="c">
                            <option>Todas</option>
                            <option>Deportes</option>
                            <option>Juegos</option>
                            <option>Vlogs</option>
                            <option>Música</option>
                            <option>Acción</option>
                            <option>Otras</option>
                        </select>
                    </div>
                    <div class="form-group mx-4 my-2"> 
                        <label class="ml-4 mr-2 d-inline" for="sel2">Resultados por página: </label>
                        <select class="form-control d-inline" id="sel2" name="perpage">
                            <option>3</option>
                            <option>6</option>
                            <option selected>9</option>
                            <option>12</option>
                        </select>
                    </div>
                    <button type="submit" class="btn mx-auto"><span class="fa fa-search"></span></button>
                </form>


                <iframe id="ividframe" src="ivideoframe.php?perpage=9" name="ividframe" onload="AdjustIframeHeightOnLoad()"></iframe>


                <!-- Script para ajustar dinámicamente el alto del iframe-->
                <script> 
                    function AdjustIframeHeightOnLoad() { document.getElementById("ividframe").style.height = (document.getElementById("ividframe").contentWindow.document.body.scrollHeight +3) + "px"; }
                    function AdjustIframeHeight(i) { document.getElementById("ividframe").style.height = parseInt(i) + "px"; }
                </script>

            </div>
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
