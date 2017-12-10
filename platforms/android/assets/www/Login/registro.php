<?php
session_start();
$now = time();
if($now > $_SESSION['expire']) {
session_destroy();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php
if ($_SERVER['HTTPS']) {
  
} else {
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
    header("Location: https://$host"."$url");
}
header('Content-Type: text/html; charset=ISO-8859-1');
?>
    <title>Registro</title>
    <script type="text/javascript" src="../archivos_base/script/isMobile.js"></script>
    <link rel="stylesheet" type="text/css" href="../archivosbase/CSS/cabeza.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/iniciosesion.css">
	<link rel="shortcut icon" href="archivosbase/icons/favicon.ico" />
</head>
<?php

	
	
	if(isset($_POST['Submit']) && $_POST['Submit']=='Registrarse'){
		include "../archivosbase/conexion.php";
	$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
	 
	 if ($conexion->connect_error) {
	 die("La conexion fall&oacute;: " . $conexion->connect_error);
	}
		
		$usuario=$_POST['username'];
		$nombre=$_POST['nombre'];
		$mail=$_POST['mail'];
		$contra=$_POST['password'];
		$contra2=$_POST['passwordOtra'];
		$consul="SELECT * FROM USUARIOS WHERE Usuario='$usuario'";
		$result = $conexion->query($consul);
			if ($result->num_rows == 0) {
				$consul="SELECT * FROM USUARIOS WHERE Mail='$mail'";
		$result = $conexion->query($consul);
			if ($result->num_rows == 0) {
		if($contra==$contra2){
		$form_pass = $_POST['password'];
$clave=$form_pass;
$error_clave = "nada";
   if(strlen($clave) < 8){
      $error_clave = "ocho";
	  $error_clave1 = "ocho";
  
   }
   if(strlen($clave) > 16){
      $error_clave = "seis";
	   $error_clave2 = "seis";

   }
   if (!preg_match('`[a-z]`',$clave)){
      $error_clave = "min";
	  $error_clave3 = "min";

   }
   if (!preg_match('`[A-Z]`',$clave)){
      $error_clave = "may";
	  $error_clave4 = "may";

   }
   if (!preg_match('`[0-9]`',$clave)){
      $error_clave = "num";
	  $error_clave5 = "num";

   }
     if (!preg_match('`[@]`',$_POST['mail'])){
      $error_clave = "min";
	  $error_clave8 = "maile";

   }
        if (!preg_match('`[.com]`',$_POST['mail'])){
      $error_clave = "min";
	  $error_clave8 = "maile";

   }
	if($error_clave == "nada"){	
		if($_POST['prioridad']=='empresa'){
		$prioridad=2;
		}elseif($_POST['prioridad']=='particular'){
			$prioridad=3;
		}
		$direccion=$_POST['direccion'];
		$hash=password_hash("$contra",  PASSWORD_BCRYPT);
		$query = "INSERT INTO USUARIOS
 (Usuario, Nombre, Contra, Direccion, Mail, Nivel)
	           VALUES ('$usuario', '$nombre', '$hash', '$direccion', '$mail', '$prioridad')";
if ($conexion->query($query) === TRUE) {
	$exito=1;
	mysqli_close($conexion);
	header("Location: administrar.php");
}else{
	$error=1;
	echo '<h1>EROR</h1>';
}
		}else{
			$errormailcontra=1;
		}
		}else{
		$errorconfirmacion=1;
	}}else{
		$errorUsuario=1;
			}}else{
				$errorMail=1;
			}}
?>
<body>
    <div id="container">
        <div id="cabecera">
            <?php
                include_once "../archivosbase/php/cabeza.php";
            ?>
        </div>
		<div id='contenido'>
		<div id='form_inicio_sesion' class='form_inicio'>
		<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
header("Location: ../");
}else{
	echo "
	<div class='login'>
	<form method='post' action='$_SERVER[PHP_SELF]' name='f1'>
	<label for='userName'><div class='textLabel'>Usuario</div></label>
<input type='text' name='username' id='userName' required>
<br/>
<label  for='nombre'><div class='textLabel'>Nombre*</div></label>
<input type='text' name='nombre' id='nombre'  required>
<br/>
<label for='userPwd' class='fontawesome-lock'><div class='textLabel'>Contrase&ntilde;a</div></label>
<input type='password' name='password' id='userPwd' required>
<br/>

<label for='passwordOtra'><div class='textLabel'>Volver&nbsp;a&nbsp;escribir&nbsp;la&nbsp;Contrase&ntilde;a*</div></label>
<input type='password' name='passwordOtra' id='passwordOtra' required>
<br/>
<label for='mail'><div class='textLabel'>Correo&nbsp;Electr&oacute;nico*</div></label>
<input type='text' name='mail' id='mail' required>
<br/>

<label  for='direccion'><div class='textLabel'>Direcci&oacute;n</div></label>
<input type='text' name='direccion' id='direccion'>
<div class='caja'>
<select name='prioridad' required>
<option value=''>Seleccione una Opci&oacute;n</option>
<option value='empresa'>Empresa</option>
<option value='particular'>Particular</option>
</select></div>

<input type='submit' name='Submit' value='Registrarse'>
</form>

</div>";
}
?>
		</div>
		<div id='footer'>
		 <?php
                include_once "../archivosbase/php/cabeza.php";
            ?>
		</div>
    </div>
</body>
<?php
mysqli_close($conexion);
?>
</html>

