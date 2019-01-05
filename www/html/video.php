<!DOCTYPE html>

<?php
if(!isset($_GET['v'])){
    header("Location: index.php");
}
$player="htmlplayer.php";
if (isset($_GET['player'])){   //Mayor seguridad así que concatenando algo modificable por el usuario a un include
    if($_GET['player']=="flash1"){
        $player="flash1player.php";
    }
    elseif($_GET['player']=="dash"){
        $player="dashplayer.php";
    }  
}

include "gestion/config.php";
$vidsql = "SELECT * FROM Videos WHERE id_video = ".$_GET["v"];
$vidresult = $conexion->query($vidsql);

if ($vidresult->num_rows > 0) {     
    $vidrow = $vidresult->fetch_array(MYSQLI_ASSOC);
}	
$usql = "SELECT * FROM Usuarios WHERE id_usuario = ".$vidrow['id_usuario'];
$uresult = $conexion->query($usql);

if($uresult->num_rows > 0){
    $urow = $uresult->fetch_array(MYSQLI_ASSOC);
}
mysqli_close($conexion);
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

        <!-- Importo scripts para dinamismo de bootstrap y popper. Innecesarios (de momento?)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <title> Teletube</title>
    </head>

    <body id="mainbody">

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
        <!-- FIN BARRA NAVEGACIÓN -->


        <div class="container-fluid my-5">
            <div class="container my-3">
                Reproductor: 
                <select onchange="window.location.href=this.value" id="selectServer">
                    <option value="video.php?v=<?php echo $_GET["v"]; ?>&player=html" <?php if($player=="htmlplayer.php"){ echo "selected";} ?>>HTML5</option>
                    <option value="video.php?v=<?php echo $_GET["v"]; ?>&player=flash1" <?php if($player=="flash1player.php"){ echo "selected";} ?>> Flash RTMP</option>
                    <option value="video.php?v=<?php echo $_GET["v"]; ?>&player=dash" <?php if($player=="dashplayer.php"){ echo "selected";} ?>>DASH-MPEG</option>
                </select>
            </div>
            <div id="playerdiv">
                <?php
                include "players/".$player;
                ?>
            </div>
            <div class="container my-3" id="vidinfo">
                <div id="vidheaders" style="display:inline-block;">
                    <h1 class="ml-3"><?php echo $vidrow['titulo']; ?> </h1>
                </div>
                <div class="dropdown-divider"></div>
                <div id="vidmisc">
                    <p>Subido por: <a href="perfil.php?id=<?php echo $urow['id_usuario']; ?>"> <?php echo $urow['nombre']; ?></a>  </p>
                    <p>Fecha de subida: <?php echo $vidrow['fecha']; ?></p>

                    <div id="desc">
                        <button class="btn btn-light ml-4" data-toggle="collapse" data-target="#descbody"> Mostrar/ocultar descripción</button>
                        <div id="descbody" class="collapse">
                            <pre><?php echo $vidrow['descripcion']; ?></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>

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
