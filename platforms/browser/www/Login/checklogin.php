<?php
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Check login</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
	
<div id="contenedor">


<div id="cuerpo">

<div id="contenido">


	 
<?php
include "../archivosbase/conexion.php";
	
	$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
     
	 if ($conexion->connect_error) {
	 die("La conexion falló: " . $conexion->connect_error);
	}
	 
	$username = $_POST['username'];
	$password = $_POST['password'];
	  
	 
	 
	 
	$sql = "SELECT * FROM USUARIOS WHERE Usuario = '$username'";
	 
	$result = $conexion->query($sql);
	 
	 
if ($result->num_rows > 0) {     
	 }
	 $row = $result->fetch_array(MYSQLI_ASSOC);
	 if (password_verify($password, $row['Contra'])) { 
		if($row['BAN']!=1){
			$tiempo=time();
	$sql="UPDATE USUARIOS SET Actividad='$tiempo' WHERE ID='$row[ID]'";
	if ($conexion->query($sql) === TRUE) {
	$exitotiempo=1;
		}
		$_SESSION['ID'] = $row['ID'];
		$_SESSION['Nivel'] = $row['Nivel'];
		$_SESSION['Nombre'] = $row['Nombre'];
		$_SESSION['Direccion'] = $row['Direccion'];
		$_SESSION['Mail'] = $row['Mail'];
		$_SESSION['Telefono'] = $row['Telefono'];
	    $_SESSION['loggedin'] = true;
	    $_SESSION['Usuario'] = $username;
	    $_SESSION['start'] = time();
	    $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);
	 mysqli_close($conexion);
	     $nom = "../";
	   header("Location: $nom");
		
		}else{
		mysqli_close($conexion);
	     $nom = "index.php?entrar=no&ban=1";
	   header("Location: $nom");	
		}
	 } else { 
	 mysqli_close($conexion);
	 $nom = "index.php?entrar=no";
	   header("Location: $nom");
	  
	 }
	 mysqli_close($conexion);
	
	 ?>


</div>
<div id="menu_flotante_dere" class="menu">

</div>
</div>
<div id="pie">
</div>
</div>
</body>
</html>