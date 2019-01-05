<?php

 $host_db = "localhost";
 $user_db = "root";
 $pass_db = "Multimedia";
 $db_name = "trabajo_multi";
 $tbl_name = "Usuarios";
 
 $form_pass = $_POST['password'];
 
 $hash = password_hash($form_pass, PASSWORD_BCRYPT); 

 $conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
 
if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

 $buscarUsuario = "SELECT * FROM $tbl_name
 WHERE nombre = '$_POST[username]' OR email='$_POST[email]' LIMIT 1";

 $result = $conexion->query($buscarUsuario);

 $count = mysqli_num_rows($result);

 if ($count >= 1) {
 echo "<br />". "El Nombre de Usuario o el email ya se han tomado." . "<br />";

 echo "<a href='LogIn.html'>Por favor escoga otro Nombre o Email</a>";
 }
 else{

 $query = "INSERT INTO Usuarios (nombre, email, password) VALUES ('$_POST[username]' , '$_POST[email]' , '$hash' )";
;

 if ($conexion->query($query) === TRUE) {
 
 echo "<br />" . "<h2>" . "Usuario Creado Exitosamente!" . "</h2>";
 echo "<h4>" . "Bienvenido: " . $_POST['username'] . "</h4>" . "\n\n";
 echo "<h5>" . "Hacer Login: " . "<a href='LogIn.html'>Login</a>" . "</h5>"; 
 }

 else {
 echo "Error al crear el usuario." . $query . "<br>" . $conexion->error; 
   }
 }
 mysqli_close($conexion); 
?>
