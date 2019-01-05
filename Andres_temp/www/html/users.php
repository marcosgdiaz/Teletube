<!DOCTYPE html>
<?php
if(!isset($_GET['u'])){
    header("Location: index.php?err=1");
}

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
                        <a class="nav-link" href="login.php"> <b>Iniciar sesión</b></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <?php
        include 'gestion/config.php';

        if($_GET['u']==''){
            $consulta="FROM Usuarios";
        } else{
            $consulta="FROM Usuarios WHERE nombre LIKE '%".$_GET['u']."%'";
        }

        if(isset($_GET['pag'])){
            $page=intval($_GET['pag']);
        } else{
            $page=0;
        }

        // Se cuenta el número de elementos totales que coinciden
        $result = $conexion->query("SELECT COUNT(*) ".$consulta);
        $numresul = $result->fetch_row()[0];   //Número de resultados totales a dividir entre las páginas

        $perpage=10; //Número de usuarios a listar por página


        //Se obtienen los resultados asociados a esta página
        $result = $conexion->query("SELECT * ".$consulta." LIMIT ".$perpage." OFFSET ".($page*$perpage));


        if ($result->num_rows > 0){
            if($_GET['u']==''){ //Si no se introdujo ningún string a buscar, se representa toda la lista de usuarios
        ?>

        <div class="my-5">
            <h2 class="text-center mb-5"> Mostrando la completa lista de usuarios: </h2>
        </div>

        <?php   
            } else{ //Si no, se indica en la cabecera el contenido buscado
        ?>
        <div class="my-5">
            <h2 class="text-center mb-5"> Resultados que contienen "<?php echo $_GET['u'];?>": </h2>
        </div>

        <?php
            }
        ?>



        <!-- RESULTADOS -->
        <div class="container">
            <ul class="list-group">
                <?php
            while($row = $result->fetch_assoc()){
                ?>
                <li class=" lightgraybackg list-group-item">
                    <div class="row">
                        <div class="col-md-6 text-center usr_col font-weight-bold">
                            <a href="perfil.php?id=<?php echo $row['id_usuario']; ?>"> <?php echo $row['nombre']; ?></a>
                        </div>

                        <div class="col-md-6 text-center usr_col">
                            Registrado desde:     <?php echo $row['fecha']; ?>
                        </div>
                    </div>
                </li>


                <?php
            }
                ?> 
            </ul>



            <div class="mt-5"> <!-- PAGINACIÓN -->
                <nav class="row">
                    <div class="col-sm-6">
                        <ul class="pagination">
                            <?php
            if($page<1){ //Página 0 o inicial
                            ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Inicio</a>
                            </li>

                            <?php
            } else{ //Página distinta de 0
                            ?>

                            <li class="page-item">
                                <a class="page-link" href="users.php?u=<?php echo $_GET['u'] ?>&pag=<?php echo ($page-1); ?>" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="users.php?u=<?php echo $_GET['u'] ?>">Inicio</a>
                            </li>

                            <?php
            }// Fin comprobación si página inicial

            if( $numresul <= (($page+1)*$perpage) ){ //Si estamos ya en la última página (o más allá)
                            ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>

                            <?php
            }else{ //No se está aún en la última página: debe poderse avanzar
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="users.php?u=<?php echo $_GET['u'] ?>&pag=<?php echo ($page+1); ?>">Siguiente</a>
                            </li>

                            <?php
            } //Fin comprobación asi última página o no
                            ?>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h6><?php echo "Página ".($page+1)." de ".ceil($numresul/$perpage)."."; ?></h6>
                        <h6><?php echo $numresul." resultados encontrados."; ?></h6>
                    </div>


                </nav>
            </div> <!-- FIN PAGINACIÓN -->         
        </div>  <!-- FIN RESULTADOS -->











        <?php
        }else{ //Caso de no tener ningún resultado
        ?>

        <div class="my-5">
            <h3 class="text-center mb-5"> No se han encontrado resultados </h3>
        </div>

        <?php
        }
        ?>




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
