<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="estilos.css" media="all" >
        <!-- importo bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> <!-- iconos-->

        <!-- Importo scripts para dinamismo de bootstrap y popper. Innecesarios (de momento?)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


        <title>Teletube</title>
    </head>

    <body id="vidframebody">

        <?php
        include 'gestion/config.php';
        $baseurl= explode('&pag=', basename($_SERVER['REQUEST_URI']), 2)[0]; // Se queda con la URL entera salvo por la variable page (si existe)
        //$baseurl = rtrim($baseurl, "&")."&"; //Nos aseguramos de que la URL acabe con un &. Si había se quita y se repone. Si no había, se pone sin más.
        $consulta="FROM Videos WHERE";

        //NOTA: Si viene con ?...&pag=X, el & se deja. Así si viene únicamente con ?pag=X no da fallos al quitar "pag=X" y poner "pag=Y" en los links de abajo


        if(isset($_GET['uid'])){    //Se un user_id viene especificado, estamos en el perfil. Si no, es el index y deben ocultarse vídeos privados
            $consulta.=" id_usuario = '".$_GET['uid']."'";
        } else{
            $consulta.=" privado = ''";
        }

        if(isset($_GET['title'])){
            if($_GET['title']!==''){
                $consulta.=" AND titulo = '".$_GET['title']."'";
            }
        }

        if(isset($_GET['c'])){
            if($_GET['c']!=='Todas'){
                $consulta.=" AND categoria = '".$_GET['c']."'";
            }
        }

        $perpage=9; // Número máximo de vídeos por página por defecto. No debería ser necesario, es redundancia por seguridad  
        if(isset($_GET['perpage'])){
            if(intval($_GET['perpage'])>0){
                $perpage=intval($_GET['perpage']);
            }
        }

        $page=0;    /* Por cosas de la función int() se numerarán las páginas desde el cero internamente (evita que pete si nos meten cosas raras en pag desde la URL) */
        if(isset($_GET['pag'])){
            $page=intval($_GET['pag']);
        }


        //SÓLO PARA DEBUGGEAR
        /*
        echo "SELECT * ".$consulta." LIMIT ".$perpage." OFFSET ".($page*$perpage);
        echo '<br>'.$baseurl;
        */

        /* Se cuenta el número de elementos totales que coinciden */
        $result = $conexion->query("SELECT COUNT(*) ".$consulta);
        $numresul = $result->fetch_row()[0];   //Número de resultados totales a dividir entre las páginas

        /* Se obtienen los resultados asociados a esta página */
        $result = $conexion->query("SELECT * ".$consulta." LIMIT ".$perpage." OFFSET ".($page*$perpage));



        if ($result->num_rows > 0){
            do{
        ?>
        <div class="row mt-0 mb-5">   <!-- Cada 3 iteraciones del bucle interior se crea una nueva fila -->


            <?php
                $col=0;
                while(($row = $result->fetch_assoc())&&($col<3)){
            ?>

            <div class="col-md-4">
                <div class="card">
                    <a class="mx-auto" target="_parent" href="video.php?v=<?php echo $row['id_video']; ?>" >
                        <img class="card-img-top mx-auto " src="media/thumbnails/<?php echo $row['id_video']; ?>.jpg" alt="miniatura">
                    </a>
                    <div class="card-body mx-auto">
                        <h4 class="card-title"> <?php echo $row['titulo']; ?></h4>
                        <p class="card-text"> Fecha de subida: <?php echo $row['fecha']; ?></p>
                    </div>
                </div>
            </div>

            <?php
                } //while
            ?>
        </div>
        <?php
            } //do while
            while($row); //$row se vuelve booleana 'false' cuando ya no quedan resultados



            //CASO DE SI NO SE ENCUENTRAN RESULTADOS EN ESTA PÁGINA (no hay resultados en general, o metieron a mano una página rara por putear)
        }//if num_rows==0
        else{ 
        ?>
        <div>
            <h3 class="text-center mb-5"> No se han encontrado resultados </h3>
        </div>
        <?php
        } //FIN CASO DE SIN RESULTADOS
        mysqli_close($conexion);

        if(strpos($baseurl,'?')==false){    //Partimos del index.php sin variables. Hay que añadir la '?' para colocar la variable pag
            $baseurl.='?';
        }
        ?>


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
                            <a class="page-link" href="<?php echo $baseurl."&pag=".($page-1); ?>" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $baseurl; ?>">Inicio</a>
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
                            <a class="page-link" href="<?php echo $baseurl."&pag=".($page+1); ?>">Siguiente</a>
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
        </div>




        <!-- Script para llamar a la función de modificar el alto del iframe cuando se actualice -->
        <script>
            parent.AdjustIframeHeight(document.getElementById("page-container").scrollHeight+3);
        </script>






    </body>
</html>