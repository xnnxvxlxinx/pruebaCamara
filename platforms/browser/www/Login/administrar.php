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
   header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
   header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
   header( "Cache-Control: no-cache, must-revalidate" );
 header( "Pragma: no-cache" );
?>
    <title>Administrar cuenta</title>
<meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
    <script type="text/javascript" src="../archivos_base/script/isMobile.js"></script>
    <link rel="stylesheet" type="text/css" href="../archivosbase/CSS/cabeza.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/administrar_usuarios.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/errores.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/productos_administrar.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/ajax-loader.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/administrar_tags.css">
	<link rel="stylesheet" type="text/css" href="../archivosbase/CSS/mensaje_javascript.css">
	<link rel="shortcut icon" href="../archivosbase/icons/favicon.ico" />
	<script src="../archivosbase/jquerymobile145/jquery-3.2.1.min.js"></script>
 <script src="../archivosbase/jquerymobile145/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript" 
    src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDfGxUMXZLtPNZzXgJ1xioFvsJranjPkiU"> 
</script> 
</head>
<?php
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
		/*-----Funcion Redimencionar------*/
	function redim($ruta1 , $ruta2 , $ancho , $alto) 
    { 
    # se obtene la dimension y tipo de imagen 

    $datos = getimagesize($ruta1); 

    $ancho_orig = $datos[0]; # Anchura de la imagen original 
    $alto_orig = $datos[1];    # Altura de la imagen original 
    $tipo = $datos[2]; 
 
    if ($tipo==1){ # GIF 
        if (function_exists("imagecreatefromgif")) {
            $img = imagecreatefromgif($ruta1); 
	}  else {
	return false; }
    } 
    else if ($tipo==2){ # JPG 
        if (function_exists("imagecreatefromjpeg")) {

			$img = imagecreatefromjpeg($ruta1); 

	}else {

	return false; }
    } 
    else if ($tipo==3){ # PNG 
        if (function_exists("imagecreatefrompng")){ 
			$img = imagecreatefrompng($ruta1); 
			 
			imagealphablending($img,true);
            imagesavealpha($img,true);

        }else {
		return false; }
    } 
     
    # Se calculan las nuevas dimensiones de la imagen 
    if ($ancho_orig>$alto_orig) 
        { 
        $ancho_dest=$ancho; 
        $alto_dest=($ancho_dest/$ancho_orig)*$alto_orig; 
        } 
    else 
        { 
        $alto_dest=$alto; 
        $ancho_dest=($alto_dest/$alto_orig)*$ancho_orig; 
        } 

    // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
    //
	$img2=@imagecreatetruecolor($ancho_dest,$alto_dest) or $img2=imagecreate($ancho_dest,$alto_dest);  
	
	/*
	$resized_image = imagecreatetruecolor($target_width, $target_height);
	switch ( $asset->a_mime_type )
	{
		case 'image/jpeg':
			imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $target_width, $target_height, $asset->a_image_width, $asset->a_image_height);
			$r = imagejpeg($resized_image,$file_name);
			break;
		case 'image/png':
			imagealphablending($resized_image, FALSE);
			imagesavealpha($resized_image, TRUE);
			imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $target_width, $target_height, $asset->a_image_width, $asset->a_image_height);
			$r = @imagepng($resized_image,$file_name);
			break;
		case 'image/gif':
			imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $target_width, $target_height, $asset->a_image_width, $asset->a_image_height);
			$background = imagecolorallocate($resized_image, 0, 0, 0); 
			imagecolortransparent($resized_image, $background);
			$r = @imagegif($resized_image,$file_name);
			break;
	}*/


    // Redimensionar 
    // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
   // 
   @imagecopyresampled($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig) or  imagecopyresized($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig); 

  

    // Crear fichero nuevo, según extensión. 
    if ($tipo==1){ // GIF 
        if (function_exists("imagegif")) {
            imagegif($img2, $ruta2); 
	} else {
            return false; 
	}}
    if ($tipo==2){ // JPG 
        if (function_exists("imagejpeg")) {

            imagejpeg($img2, $ruta2); 

	} else {

            return false; 
	}}
    if ($tipo==3) { // PNG 
        if (function_exists("imagepng")) {
			imagealphablending($img,true);
            imagesavealpha($img,true);
		imagepng($img2, $ruta2); }
	else {
		return false; }
	}
    return true; 
    } 
	/*-------------------------------*/
	include "../archivosbase/conexion.php";
	$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
	if ($conexion->connect_error) {
	 die("La conexion fall?: " . $conexion->connect_error);
	}
	if(isset($_POST['editar_nombre']) && $_POST['editar_nombre']=='Editar'){
		$query = "UPDATE USUARIOS SET Nombre='$_POST[nombre]' WHERE ID='$_SESSION[ID]'";
		if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente sus datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	$_SESSION['Nombre']=$_POST['nombre'];
}
	}
		if(isset($_POST['editar_mail']) && $_POST['editar_mail']=='Editar'){
		$query = "UPDATE USUARIOS SET Mail='$_POST[mail]' WHERE ID='$_SESSION[ID]'";
		if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente sus datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	$_SESSION['Mail']=$_POST['mail'];
}
	}
	if(isset($_POST['editar_direccion']) && $_POST['editar_direccion']=='Editar'){
		$query = "UPDATE USUARIOS SET Direccion='$_POST[direccion]' WHERE ID='$_SESSION[ID]'";
		if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente sus datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	$_SESSION['Direccion']=$_POST['direccion'];
}
	}
	if(isset($_POST['editar_telefono']) && $_POST['editar_telefono']=='Editar'){
		$query = "UPDATE USUARIOS SET Telefono='$_POST[telefono]' WHERE ID='$_SESSION[ID]'";
		if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente sus datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	$_SESSION['Telefono']=$_POST['telefono'];
}
	}	
	/*---------------------------*/
		$contra=$_POST['password'];
		$contra2=$_POST['passwordOtra'];
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
	if($error_clave == "nada"){	
		$hash=password_hash("$contra",  PASSWORD_BCRYPT);
		$query = "UPDATE USUARIOS SET Contra='$hash' WHERE ID='$_SESSION[ID]'";
if ($conexion->query($query) === TRUE) {
	$exitoEditarContra=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente sus datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
		}}else{
			$errorclave=1;
		}}else{
			$errorcomprobacion=1;
		}
	/*----------------------------*/
	/*--------Tag Principal---------*/
	if(isset($_POST['subir_tag_principal']) && $_POST['subir_tag_principal']=='Subir'){
	$TagPrincipal=$_POST['tag_principal'];
	$Link=$_POST['link'];
	$id=$_POST['id'];
	$exitoTagP=0;
	$exitoTagPedit=0;
		$concultaFtag="SELECT * FROM TagPrincipal ";
	$result2 = $conexion->query($concultaFtag);
	$numero2=mysqli_num_rows($result2);
	for($i=$numero2;$i<count($TagPrincipal); $i++){
	$query = "INSERT INTO TagPrincipal (Nombre, Imagen)
	VALUES('$TagPrincipal[$i]', '$Link[$i]')";
if ($conexion->query($query) === TRUE) {
	$exitoTagP=$exitoTagP+1;
}	
	}
	for($i=0;$i<$numero2; $i++){
	$query = "UPDATE TagPrincipal SET Nombre='$TagPrincipal[$i]', Imagen='$Link[$i]' WHERE ID='$id[$i]'";
if ($conexion->query($query) === TRUE) {
	$exitoTagPedit=$exitoTagPedit+1;
}	
	}
	if($exitoTagP!=0 || $exitoTagPedit!=0){
echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente las categor&iacute;as.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}else{
		echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al cargar la información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}
	}
	/*----------------------------*/
	/*--------Borrar Tag Principal---------*/
	if(isset($_POST['borrarTagPrincipal']) && $_POST['borrarTagPrincipal']=='Borrar'){
	
	$id=$_POST['id'];
	$query="DELETE FROM TagPrincipal WHERE ID='$id'";
if ($conexion->query($query) === TRUE) {
	$query2="DELETE FROM TagSecundario WHERE ID_TagPrincipal='$id'";
if ($conexion->query($query2) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha Borrado correctamente la categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al Borrar las Subcategor&iacute;as.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al Borrar la categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}	
	}
	/*----------------------------*/	
	/*--------Tag Secundarios---------*/
	if(isset($_POST['subir_tag_secundario']) && $_POST['subir_tag_secundario']=='Subir'){
	$TagPrincipal=$_POST['tag_principal'];
	$TagSecundario=$_POST['nombre_tag_secundario'];
	$TagSecundarioE_ID=$_POST['nombre_tag_secundarioE_ID'];
	$TagSecundarioE=$_POST['nombre_tag_secundarioE'];
	$concultatag="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$TagPrincipal' AND Nombre='$TagSecundario'";
	$result = $conexion->query($concultatag);
	$numero=mysqli_num_rows($result);
	if($numero==0){
		$query = "INSERT INTO TagSecundario (ID_TagPrincipal, Nombre)
	VALUES('$TagPrincipal', '$TagSecundario')";
if ($conexion->query($query) === TRUE) {
	for($i=0; $i<count($TagSecundarioE_ID); $i++){
	$query = "UPDATE TagSecundario SET Nombre='$TagSecundarioE[$i]' WHERE ID='$TagSecundarioE_ID[$i]'";
if ($conexion->query($query) === TRUE) {
$ExitoTagSecundario=1;
}
	}
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Etiquetas insertadas exitosamente</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';

}else{
	$errorTagSecundario=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al subir los datos.<br/>Por favor intentarlo de nuevo mas tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}
	}else{
		$errorTagSecundarioNombre=1;
			echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Ya existe una etiqueta con ese nombre dentro de esta categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}
	}
	/*----------------------------*/
	/*--------Tag Principal 2---------*/
	if(isset($_POST['subir_tag_principal_contra']) && $_POST['subir_tag_principal_contra']=='Subir'){
	$TagPrincipal=$_POST['tag_principal'];
	$Link=$_POST['link'];
	$id=$_POST['id'];
	$exitoTagP=0;
	$exitoTagPedit=0;
		$concultaFtag="SELECT * FROM TagPrincipalContra ";
	$result2 = $conexion->query($concultaFtag);
	$numero2=mysqli_num_rows($result2);
	for($i=$numero2;$i<count($TagPrincipal); $i++){
	$query = "INSERT INTO TagPrincipalContra (Nombre, Imagen)
	VALUES('$TagPrincipal[$i]', '$Link[$i]')";
if ($conexion->query($query) === TRUE) {
	$exitoTagP=$exitoTagP+1;
}	
	}
	for($i=0;$i<$numero2; $i++){
	$query = "UPDATE TagPrincipalContra SET Nombre='$TagPrincipal[$i]', Imagen='$Link[$i]' WHERE ID='$id[$i]'";
if ($conexion->query($query) === TRUE) {
	$exitoTagPedit=$exitoTagPedit+1;
}	
	}
	if($exitoTagP!=0 || $exitoTagPedit!=0){
echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente las categor&iacute;as.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}else{
		echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al cargar la información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}
	}
	/*----------------------------*/
	/*--------Borrar Tag Principal---------*/
	if(isset($_POST['borrarTagPrincipal_contra']) && $_POST['borrarTagPrincipal_contra']=='Borrar'){
	
	$id=$_POST['id'];
	$query="DELETE FROM TagPrincipalContra WHERE ID='$id'";
if ($conexion->query($query) === TRUE) {
	$query2="DELETE FROM TagSecundarioContra WHERE ID_TagPrincipal='$id'";
if ($conexion->query($query2) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha Borrado correctamente la categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al Borrar las Subcategor&iacute;as.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al Borrar la categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}	
	}
	/*----------------------------*/	
	/*--------Tag Secundarios---------*/
	if(isset($_POST['subir_tag_secundario_contra']) && $_POST['subir_tag_secundario_contra']=='Subir'){
	$TagPrincipal=$_POST['tag_principal'];
	$TagSecundario=$_POST['nombre_tag_secundario'];
	$concultatag="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$TagPrincipal' AND Nombre='$TagSecundario'";
	$result = $conexion->query($concultatag);
	$numero=mysqli_num_rows($result);
	if($numero==0){
		$query = "INSERT INTO TagSecundarioContra (ID_TagPrincipal, Nombre)
	VALUES('$TagPrincipal', '$TagSecundario')";
if ($conexion->query($query) === TRUE) {
	$ExitoTagSecundario=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Etiqueta insertada exitosamente</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}else{
	$errorTagSecundario=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al subir los datos.<br/>Por favor intentarlo de nuevo mas tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
}
	}else{
		$errorTagSecundarioNombre=1;
			echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Ya existe una etiqueta con ese nombre dentro de esta categor&iacute;a.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}
	}
	/*----------------------------*/	
	
	/*--------Ubicacion Empresa---------*/
	if(isset($_POST['ubicacion_empresa_nuevo']) && $_POST['ubicacion_empresa_nuevo']=='Enviar'){
	$exitoubicacion=0;
	$exitoubicacionedit=0; 
	$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];
	$id_editar_ubicacion=$_POST['id_editar_ubicacion'];
	$direccion=$_POST['direccion'];
	$concultaUbicacion2="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
	$result2 = $conexion->query($concultaUbicacion2);
	$numero2=mysqli_num_rows($result2);
	for($i=$numero2;$i<count($direccion); $i++){
	$query = "INSERT INTO UBICACION (ID_Usuario, LAT, LONGI, DIR)
	VALUES('$_SESSION[ID]', '$latitud[$i]', '$longitud[$i]', '$direccion[$i]')";
if ($conexion->query($query) === TRUE) {
	$exitoubicacion=$exitoubicacion+1;
}	
	}
	for($i=0;$i<$numero2; $i++){
	$query = "UPDATE UBICACION SET ID_Usuario='$_SESSION[ID]', LAT='$latitud[$i]', LONGI='$longitud[$i]', DIR='$direccion[$i]' WHERE ID='$id_editar_ubicacion[$i]'";
if ($conexion->query($query) === TRUE) {
	$exitoubicacionedit=$exitoubicacionedit+1;
}	
	}
	if($exitoubicacion!=0 || $exitoubicacionedit!=0){
echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado correctamente su ubicación.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}else{
		echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al cargar la información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button>
	</div>
	</div>';
	}	
	}
	/*---------------------------------*/
	/*---------Imagen Usuario-----------*/
	if(isset($_POST['subir_imagen_Usuario']) && $_POST['subir_imagen_Usuario']=='Subir'){
		$sql = "SELECT * FROM FotoUsuario WHERE ID_Usuario='$_SESSION[ID]'";
		$result = $conexion->query($sql);
		if ($result->num_rows == 1) {  
		$row = $result->fetch_array(MYSQLI_ASSOC);
		unlink("../$row[Link]");
		}
		$usuario=$_SESSION['Usuario'];
		$ID=$_SESSION['ID'];
		$carpetaDestino='ImagenUsuario/';
		$extension = end(explode(".", $_FILES['nombre_foto_in']['name']));
		$nombrearchivo=$ID.$usuario.".".$extension;
		if($_FILES["nombre_foto_in"]["type"]=="image/jpeg" || $_FILES["nombre_foto_in"]["type"]=="image/pjpeg" || $_FILES["nombre_foto_in"]["type"]=="image/gif" || $_FILES["nombre_foto_in"]["type"]=="image/png")
            {
				 $origen=$_FILES["nombre_foto_in"]["tmp_name"];
				 $destino=$carpetaDestino.$nombrearchivo;
				  # movemos el archivo
                    if(@move_uploaded_file($origen, $destino))
                    {
						$link="Login/$destino";
						//$nombrearchivo=$_FILES["archivo"]["name"][$i];
						$tipoarchivo=$_FILES["nombre_foto_in"]["type"];
						$sql = "SELECT * FROM FotoUsuario WHERE ID_Usuario='$_SESSION[ID]'";
						$result = $conexion->query($sql);
						if ($result->num_rows == 1) { 
				$query = "UPDATE FotoUsuario SET Link='$link' WHERE ID_Usuario='$ID' ";					
						}else{
							$query = "INSERT INTO FotoUsuario (ID_Usuario, Link)
						VALUES ('$ID','$link')";
						}
			    if ($conexion->query($query) === TRUE) {
                 ## CONFIGURACION ############################# 

    # ruta de la imagen a redimensionar 
    $imagen="$destino"; 
    # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe 
    $imagen_final="$destino"; 
    $ancho_nuevo=200; 
    $alto_nuevo=200; 

## FIN CONFIGURACION ############################# 


//REVISAR FUNCION-->
 if(redim ($imagen,$imagen_final,$ancho_nuevo,$alto_nuevo)=== TRUE){
	$contadorimagenes=1;
 }else{
	$errorimgredime=1;
	echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Error redimensionar</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
 }				
				}else{
					$contadorerrorimg=1;
					echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Error base</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
				}
                    }else{
						$errorimgmover=1;
						echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Error mover</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
                    }
			}else{
				$errortipoimg=1;
				echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Error tipo</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
			}
	
	
	}
	/*---------------------------------*/
	/*------Contratacion Empresas-------*/
	if(isset($_POST['subir_nuevo_oferta_E']) && $_POST['subir_nuevo_oferta_E']=='Subir'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$PUESTOS=$_POST['puestos'];
		$Titulo=$_POST['titulo'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$IdUsuario' AND TIPO='1'";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			//if($numero==0){
		$query = "INSERT INTO CONTRATACIONE (ID_Usuario, DESCRIPCION, TAG_PRIMARIO, TAG_SECUNDARIO, PUESTOS, Titulo, TIPO)
	VALUES('$_SESSION[ID]', '$descripcion', '$tagprincipal', '$textTagSecundario', '$PUESTOS', '$Titulo', '1')";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}

	}
	if(isset($_POST['subir_editar_oferta_E']) && $_POST['subir_editar_oferta_E']=='Subir'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$PUESTOS=$_POST['puestos'];
		$Titulo=$_POST['titulo'];
		$ID=$_POST['ID'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$IdUsuario' ";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			//if($numero==0){
		$query = "UPDATE CONTRATACIONE SET DESCRIPCION='$descripcion', TAG_PRIMARIO='$tagprincipal', TAG_SECUNDARIO='$textTagSecundario', PUESTOS='$PUESTOS', Titulo='$Titulo'
			WHERE ID='$ID'";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
/*			}else{
			
			}*/
	}
	/*------Fin Contratacion Empresa----------*/
	/*------Contratacion Particular-------*/
	if(isset($_POST['subir_nuevo_oferta_P']) && $_POST['subir_nuevo_oferta_P']=='Subir'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$PUESTOS=$_POST['puestos'];
		$Titulo=$_POST['titulo'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$IdUsuario' AND TIPO='2'";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			//if($numero==0){
		$query = "INSERT INTO CONTRATACIONE (ID_Usuario, DESCRIPCION, TAG_PRIMARIO, TAG_SECUNDARIO, PUESTOS, Titulo, TIPO)
	VALUES('$_SESSION[ID]', '$descripcion', '$tagprincipal', '$textTagSecundario', '$PUESTOS', '$Titulo', '2')";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}

	}
	if(isset($_POST['subir_editar_oferta_p_E']) && $_POST['subir_editar_oferta_p_E']=='Subir'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$PUESTOS=$_POST['puestos'];
		$Titulo=$_POST['titulo'];
		$ID=$_POST['ID'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$IdUsuario' ";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			//if($numero==0){
		$query = "UPDATE CONTRATACIONE SET DESCRIPCION='$descripcion', TAG_PRIMARIO='$tagprincipal', TAG_SECUNDARIO='$textTagSecundario', PUESTOS='$PUESTOS', Titulo='$Titulo'
			WHERE ID='$ID'";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
	}
	/*------Fin Contratacion Particular----------*/
	/*------Descripcion Empresas-------*/
	if(isset($_POST['descripcion_empresa']) && $_POST['descripcion_empresa']=='Enviar'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM DESCRIPCION WHERE ID_Usuario='$IdUsuario' ";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			if($numero==0){
		$query = "INSERT INTO DESCRIPCION (ID_Usuario, DESCRIPCION, TagPrincipal, TagSecundario)
	VALUES('$_SESSION[ID]', '$descripcion', '$tagprincipal', '$textTagSecundario')";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}
			}else{
			$query = "UPDATE DESCRIPCION SET DESCRIPCION='$descripcion', TagPrincipal='$tagprincipal', TagSecundario='$textTagSecundario' 
			WHERE ID_Usuario='$_SESSION[ID]'";
if ($conexion->query($query) === TRUE) {
	$exitodescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	$errordescripcionEmp=1;
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
			}
	}
	/*------Fin Descripcion Empresa----------*/	
	/*------Descripcion Particular-------*/
	if(isset($_POST['descripcion_particular']) && $_POST['descripcion_particular']=='Enviar'){
		$descripcion=$_POST['descripcion'];
		$tagprincipal=$_POST['tag_principal'];
		$tagsecundario=$_POST['subtag'];
		$IdUsuario=$_SESSION['ID'];
		$textTagSecundario='';
		for($i=0; $i<count($tagsecundario);$i++){
			$textTagSecundario.="#$tagsecundario[$i];";
		}
		$busc="SELECT * FROM DESCRIPCION WHERE ID_Usuario='$IdUsuario' ";
		$result = $conexion->query($busc);
			$numero=mysqli_num_rows($result);
			if($numero==0){
		$query = "INSERT INTO DESCRIPCION (ID_Usuario, DESCRIPCION, TagPrincipal, TagSecundario)
	VALUES('$_SESSION[ID]', '$descripcion', '$tagprincipal', '$textTagSecundario')";
if ($conexion->query($query) === TRUE) {
$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];
	$id_editar_ubicacion=$_POST['id_editar_ubicacion'];
	$direccion=$_POST['direccion'];
	$concultaUbicacion2="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
	$result2 = $conexion->query($concultaUbicacion2);
	$numero2=mysqli_num_rows($result2);
	if($numero2==0){
	$query = "INSERT INTO UBICACION (ID_Usuario, LAT, LONGI, DIR)
	VALUES('$_SESSION[ID]', '$latitud', '$longitud', '$direccion')";
if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
	}else{
	$query = "UPDATE UBICACION SET  LAT='$latitud', LONGI='$longitud', DIR='$direccion' WHERE ID_Usuario='$_SESSION[ID]'";
if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}
	}	
		
	
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}
			}else{
			$query = "UPDATE DESCRIPCION SET DESCRIPCION='$descripcion', TagPrincipal='$tagprincipal', TagSecundario='$textTagSecundario' 
			WHERE ID_Usuario='$_SESSION[ID]'";
if ($conexion->query($query) === TRUE) {
	$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];
	$id_editar_ubicacion=$_POST['id_editar_ubicacion'];
	$direccion=$_POST['direccion'];
	$concultaUbicacion2="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
	$result2 = $conexion->query($concultaUbicacion2);
	$numero2=mysqli_num_rows($result2);
	if($numero2==0){
	$query = "INSERT INTO UBICACION (ID_Usuario, LAT, LONGI, DIR)
	VALUES('$_SESSION[ID]', '$latitud', '$longitud', '$direccion')";
if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
	}else{
	$query = "UPDATE UBICACION SET  LAT='$latitud', LONGI='$longitud', DIR='$direccion' WHERE ID_Usuario='$_SESSION[ID]'";
if ($conexion->query($query) === TRUE) {
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha actualizado su Información.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}
	}
}else{

	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al actualizar su Información.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
			}
	}
	/*------Fin Descripcion Particular----------*/
	/*------Productos--------------------*/
	if(isset($_POST['subir_nuevo_producto_E']) && $_POST['subir_nuevo_producto_E']=='Subir'){
	$tilulo=$_POST['titulo'];
	$descripcion=$_POST['descripcion'];
	$precio=$_POST['precio'];
	$tag_principal=$_POST['tag_principal'];
	$subtag=$_POST['subtag'];
	$IdUsuario=$_SESSION['ID'];
	$productos_img=$_FILES['productos_img'];
	$textTagSecundario="";
	for($i=0; $i<count($subtag);$i++){
			$textTagSecundario.="#$subtag[$i];";
		}
/*Verificamos y creamos carpeta*/
$carpeta = "ImagenProducto/$_SESSION[ID]";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
$idProd="SELECT * FROM PRODUCTOS 
WHERE ID_Usuario='$_SESSION[ID]' AND TagPrincipal='$tag_principal' AND TagSecundario='$textTagSecundario' AND Titulo='$tilulo' AND Descripcion='$descripcion' AND Precio='$precio'";
$resulttt = $conexion->query($idProd);
$numeroProd=mysqli_num_rows($resulttt);
if($numeroProd==0){
if (file_exists($carpeta)) {	
	$query = "INSERT INTO PRODUCTOS (ID_Usuario, TagPrincipal, TagSecundario, Titulo, Descripcion, 	Precio)
	VALUES('$_SESSION[ID]', '$tag_principal', '$textTagSecundario', '$tilulo', '$descripcion', '$precio')";
if ($conexion->query($query) === TRUE) {

/*Subimos imagenes*/
$carpetaDestino="ImagenProducto/$_SESSION[ID]/";
$idProdu="SELECT * FROM PRODUCTOS 
WHERE ID_Usuario='$_SESSION[ID]' AND TagPrincipal='$tag_principal' AND TagSecundario='$textTagSecundario' AND Titulo='$tilulo' AND Descripcion='$descripcion' AND Precio='$precio'";
$resultt = $conexion->query($idProdu);
$rowprod = $resultt->fetch_array(MYSQLI_ASSOC);
$IdProducto=$rowprod['ID'];
for($i=0; $i<count($_FILES['productos_img']);$i++){
		$extension = end(explode(".", $_FILES['productos_img']['name'][$i]));
		$nombrearchivo=$IdProducto."Producto".$i.".".$extension;
		if($_FILES['productos_img']["type"][$i]=="image/jpeg" || $_FILES['productos_img']["type"][$i]=="image/pjpeg" || $_FILES['productos_img']["type"][$i]=="image/gif" || $_FILES['productos_img']["type"][$i]=="image/png")
            {
				 $origen=$_FILES['productos_img']["tmp_name"][$i];
				 $destino=$carpetaDestino.$nombrearchivo;
				  # movemos el archivo
                    if(@move_uploaded_file($origen, $destino))
                    {
						$link="Login/$destino";
						//$nombrearchivo=$_FILES["archivo"]["name"][$i];
						$tipoarchivo=$_FILES['productos_img']["type"][$i];
						
							$query = "INSERT INTO FotoProductos (ID_Usuario, ID_Producto, Link)
						VALUES ('$_SESSION[ID]', '$IdProducto', '$link')";
						
			    if ($conexion->query($query) === TRUE) {
                 ## CONFIGURACION ############################# 

    # ruta de la imagen a redimensionar 
    $imagen="$destino"; 
    # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe 
    $imagen_final="$destino"; 
    $ancho_nuevo=800; 
    $alto_nuevo=800; 

## FIN CONFIGURACION ############################# 


//REVISAR FUNCION-->
 if(redim ($imagen,$imagen_final,$ancho_nuevo,$alto_nuevo)=== TRUE){
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Se ha Subido su Producto.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
 }				
				}
                    }
			}	
/*-----------------*/
	
}}else{
	echo '<div id="popUpError">
	<div id="alert">
	<p>Informacion</p>
	<h3>Error al subir el producto.<br/>Inténtelo más tarde.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
}	
	}else{
echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Error Crear Carpeta</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
	
}}else{
echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Ya existe un producto suyo con los mismos datos.</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
	
}}
	/*-----Fin Productos----------------*/
	}else{
		header("Location: ../Login/");
	}
?>
<?php
echo "
<script>
function menu(div){
	$('#subirFotoUsuario').fadeOut(300);
	$('#configurar_usuario').fadeOut(300);
	/*document.getElementById('subirFotoUsuario').style.display='none';
	document.getElementById('configurar_usuario').style.display='none';*/";
	if($_SESSION['Nivel']==1){
		echo "
		$('#creacionAdminEtiquetas').fadeOut(300);
		$('#creacionPrinEtiquetas').fadeOut(300);
		$('#creacionAdminEtiquetasC').fadeOut(300);
		$('#creacionPrinEtiquetasC').fadeOut(300);
		/*
	document.getElementById('creacionAdminEtiquetas').style.display='none';
	document.getElementById('creacionPrinEtiquetas').style.display='none';*/
	";
	}
	if($_SESSION['Nivel']==2){
		echo "
		$('#ubicacion_empresas').fadeOut(300);
		$('#descripcion_empresas').fadeOut(300);
		$('#productos_empresas').fadeOut(300);
		$('#contratacion_empresas').fadeOut(300);
	/*document.getElementById('ubicacion_empresas').style.display='none';
	document.getElementById('descripcion_empresas').style.display='none';
	document.getElementById('productos_empresas').style.display='none';
	document.getElementById('contratacion_empresas').style.display='none';*/";
	
	}
	if($_SESSION['Nivel']==3){
		echo "
		 $('#descripcion_particular').fadeOut(300);
		 $('#productos_empresas').fadeOut(300);
		 $('#contratacion_empresas').fadeOut(300);
		 $('#contratacion_particular').fadeOut(300);
		/*document.getElementById('descripcion_particular').style.display='none';
		document.getElementById('productos_empresas').style.display='none';*/";
	}
	echo "
	setTimeout(function(){
	$('#' + div).fadeIn(300);
	}, 305);
	/*document.getElementById(div).style.display='block';*/
}
</script>";
?>
<body onLoad="<?php 
if($_SESSION['Nivel']==2 || $_SESSION['Nivel']==3){
	echo "tagSelect(); showSlides();";
	}else{ echo "imaPrincipalimg();";
	}?>">
    <div id="container">
        <div id="cabecera">
            <?php
                include_once "../archivosbase/php/cabeza.php";
            ?>
        </div>
		<div id='contenido'>
		<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	if($_SESSION['Nivel']==1 || $_SESSION['Nivel']==2 || $_SESSION['Nivel']==3){
		$sql = "SELECT * FROM FotoUsuario WHERE ID_Usuario='$_SESSION[ID]'";
		$result = $conexion->query($sql);
		if ($result->num_rows == 1) {  
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$imgUsuario=" src='../$row[Link]' ";
		}else{
			$imgUsuario='';
		}
		echo "
		<div id='admin_usuarios'>
		<div id='admin_usuarios_menu_izquierda'>
		<div id='admin_usuarios_imagen' onclick='menu(\"subirFotoUsuario\")'>
		<a onclick='menu(\"subirFotoUsuario\")'><img $imgUsuario/></a>
		</div>
		<div id='admin_usuarios_menu_izquierda_text'>
		<ul>
			<li class='level1'><a>Configuraci&oacute;n&nbsp;&nbsp;&#9658;</a>
				<ul>
					<li class='level2'  onclick='menu(\"configurar_usuario\")'><a>Configurar mi Usuario</a></li>
				</ul>
			</li>";
		if($_SESSION['Nivel']==1){
		echo "
		<li class='level1'><a>Configurar Usuario&nbsp;&nbsp;&#9658;</a>
			<!--<ul>
				<li class='level2'>Crear Usuario Administrador</li>
				<li class='level2'>Borrar/Banear Usuario Empresa</li>
				<li class='level2'>Borrar/Banear Usuario Particular</li>
			</ul>-->
		</li>
		<li class='level1'><a >Crear Categor&iacute;as Empresas y Productos&nbsp;&nbsp;&#9658;</a>
				<ul>
				<li class='level2' onclick='menu(\"creacionPrinEtiquetas\")'><a>Crear Categor&iacute;a</a></li>
				</ul>
				<ul>
				<li class='level2' onclick='menu(\"creacionAdminEtiquetas\")'><a>Crear Subcategor&iacute;a</a></li>
				</ul>
		</li>
		<li class='level1'><a >Crear Categor&iacute;as Contrataci&oacute;n y Servicios&nbsp;&nbsp;&#9658;</a>
				<ul>
				<li class='level2' onclick='menu(\"creacionPrinEtiquetasC\")'><a>Crear Categor&iacute;a</a></li>
				</ul>
				<ul>
				<li class='level2' onclick='menu(\"creacionAdminEtiquetasC\")'><a>Crear Subcategor&iacute;a</a></li>
				</ul>
		</li>
		";	
		}
		if($_SESSION['Nivel']==2){
		echo "
		<li class='level1'><a>Configurar mi Empresa&nbsp;&nbsp;&#9658;</a>
			<ul>
				<li class='level2' onclick='menu(\"ubicacion_empresas\")'><a>Ubicaci&oacute;n</a></li>
				<li class='level2' onclick='menu(\"descripcion_empresas\")'><a>Descripci&oacute;n</a></li>
				<li class='level2' onclick='menu(\"productos_empresas\")'><a>Productos</a></li>
			</ul>
		</li>";
		echo "
		<li class='level1'><a>Sistema de contrataci&oacute;n&nbsp;&nbsp;&#9658;</a>
			<ul>
				<li class='level2' onclick='menu(\"contratacion_empresas\")'><a>Mis Ofertas</a></li>
			</ul>
		</li>";
		}

		if($_SESSION['Nivel']==3){
		echo "<li class='level1'><a>Configurar mis Servicios&nbsp;&nbsp;&#9658;</a>
			<ul>
				<li class='level2' onclick='menu(\"descripcion_particular\")'>Servicio</li>
				<li class='level2' onclick='menu(\"productos_empresas\")'>Productos</li>
			</ul>
		</li>";
		echo "
		<li class='level1'><a>Sistema de contratación&nbsp;&nbsp;&#9658;</a>
			<ul>
				<li class='level2' onclick='menu(\"contratacion_empresas\")'><a>Mis Ofertas</a></li>
				<li class='level2' onclick='menu(\"contratacion_particular\")'><a>Mis Servicios</a></li>
			</ul>
		</li>";
		}
		echo "
		</ul>
		</div>
		</div>";
		/*-----------Editar Usuarios------------------*/
		echo "
		<script>
		function configuauario(id){
	document.getElementById('configuauario_nombre').style.display='none';
	document.getElementById('configuauario_mail').style.display='none';
	document.getElementById('configuauario_direccion').style.display='none';
	document.getElementById('configuauario_contrasena').style.display='none';
	document.getElementById('configuauario_telefono').style.display='none';
	document.getElementById(id).style.display='block';
		}
		function cancelarconfiguauario(id){
	document.getElementById(id).style.display='none';
		}
		</script>
		<div id='admin_usuarios_contenido'>
			<div id='configurar_usuario' class='oculto'>
				<div class='loginEdit'><button type='button' onclick='configuauario(\"configuauario_nombre\")'>Editar Nombre</button></br>
				<form action='$_SERVER[PHP_SELF]' method='post' id='configuauario_nombre' class='oculto'>
				<input type='text' name='nombre'  required placeholder='Nombre' value='$_SESSION[Nombre]'>
				<button type='submit' name='editar_nombre' class='editSubmit' value='Editar'></button><button type='button' onclick='cancelarconfiguauario(\"configuauario_nombre\")' class='cancelar_edit'></button></form>
				</div>
				<div class='loginEdit'><button type='button' onclick='configuauario(\"configuauario_mail\")'>Editar Mail</button></br>
				<form action='$_SERVER[PHP_SELF]' method='post' class='oculto' id='configuauario_mail'>
				<input type='text' name='mail'  required placeholder='Correo Electr&oacute;nico*' value='$_SESSION[Mail]'>
				<button type='submit' name='editar_mail' class='editSubmit' value='Editar'></button><button type='button' onclick='cancelarconfiguauario(\"configuauario_mail\")' class='cancelar_edit'></button></form>
				</div>
				<div class='loginEdit'><button type='button' onclick='configuauario(\"configuauario_direccion\")'>Editar Direcci&oacute;n</button></br>
				<form action='$_SERVER[PHP_SELF]' method='post' class='oculto' id='configuauario_direccion'>
				<input type='text' name='direccion' required placeholder='Direcci&oacute;n' value='$_SESSION[Direccion]'>
				<button type='submit' class='editSubmit' name='editar_direccion' value='Editar'></button><button type='button' onclick='cancelarconfiguauario(\"configuauario_direccion\")' class='cancelar_edit'></button></form>
				</div>
				<div class='loginEdit'><button type='button' onclick='configuauario(\"configuauario_telefono\")'>Editar Teléfono</button></br>
				<form action='$_SERVER[PHP_SELF]' method='post' class='oculto' id='configuauario_telefono'>
				<input type='text' name='telefono' required placeholder='Teléfono' value='$_SESSION[Telefono]'>
				<button type='submit' class='editSubmit' name='editar_telefono' value='Editar'></button><button type='button' onclick='cancelarconfiguauario(\"configuauario_telefono\")' class='cancelar_edit'></button></form>
				</div>
				<div class='loginEdit'><button type='button' onclick='configuauario(\"configuauario_contrasena\")'>Editar Contrase&ntilde;a</button></br>
				<form action='$_SERVER[PHP_SELF]' method='post' class='oculto' id='configuauario_contrasena'>
				<input type='password' name='password' id='userPwd' required placeholder='Contrase&ntilde;a'></br>
				<input type='password' name='passwordOtra'  required placeholder='Volver a escribir la Contrase&ntilde;a*'>
				<button type='submit' class='editSubmit' name='editar_contra' value='Editar'></button><button type='button' onclick='cancelarconfiguauario(\"configuauario_contrasena\")' class='cancelar_edit'></button></form>
				</div>
			</div>";
		/*----------SOLO ADMIN--------------*/	
		if($_SESSION['Nivel']==1){
		/*----------ETIQUETAS--------------*/
		/*Prin Categoria*/
		$concultaTag="SELECT * FROM TagPrincipal";
			$result = $conexion->query($concultaTag);
			$numero=mysqli_num_rows($result);
		echo "
		<script>
		var conttags=$numero;
		function tag_principal_nuevo(){
		var div=document.getElementById('tag_principal_div');
		var indiv = document.createElement('div');
		indiv.id='tag_principal_div_' + conttags;
		var texto='<label> Nombre de la Categor&iacute;a: <input type=\"text\" name=\"tag_principal[]\" required /></label>';
		 texto= texto + '<label> Imgen: <input type=\"text\"  name=\"link[]\" readonly required class=\"oculto\"/><img />';
		 texto= texto + '<div class=\"imagenTagsPrincipal oculto\"></div></label><button type=\"button\" onclick=\"tagimgescojerimg(this)\">Escoger imagen</button>';
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"eliminar_div_tagprinci(\'tag_principal_div_' + conttags +'\')\"></button><br/>';
		div.appendChild(indiv);
		document.getElementById('tag_principal_div_' + conttags).innerHTML=texto;
		imaPrincipalimg();
		conttags=conttags+1;
		}
		function eliminar_div_tagprinci(div1){
			var div = document.getElementById(div1);
    if(div !== null){
        while (div.hasChildNodes()){
            div.removeChild(div.lastChild);
        }
    }else{
        alert (\"No existe esta foto??\");
    }
		}
		function imaPrincipalimg(){
		$(\".imagenTagsPrincipal\").load(\"consultasphp/tagPrincipal.php\");
	}
	function linkimgtags(e){
		var link=e.src;
		var LocationActual='https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';

		LocationActual=LocationActual.replace('Login/administrar.php','');
	
		link=link.replace(LocationActual, '');
		
		var label=e.parentNode.parentNode;
		label.children[0].value=link;
		label.children[1].src='../' + link;
		label.children[1].className='previewimgTag';
		e.parentNode.style.display='none';
	}
 $(function(){
        $(\"#formuploadajaxTag\").on(\"submit\", function(e){
			
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById(\"formuploadajaxTag\"));
            //formData.append(f.attr(\"name\"), $(this)[0].files[0]);
			document.getElementById('ajax-loader').style.display='block';
            $.ajax({
                url: \"tagPrincipal.php\",
                type: \"post\",
                dataType: \"html\",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    $(\"#cargaerrorTagimg\").html(\"Respuesta: \" + res);
					document.getElementById('imagenesTag').value='';
					document.getElementById('ajax-loader').style.display='none';	
					imaPrincipalimg();
                });
        });
		
    });
	function tagimgescojerimg(e){
		e.parentNode.children[1].children[2].style.display='block';
	}
	function eliminarTagPrin(ID){
		document.getElementById('mensaje_javascript').style.display='block';
		$.get('../archivosbase/php/administrarJq/borrartags.php?IDmen=' + ID, function(texto){
			
			document.getElementById('mensaje_javascript').childNodes[0].innerHTML=texto;
		});
		
	}
		</script>";
		echo"
		<div id='creacionPrinEtiquetas' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<div id='tag_principal_div'>";
		$k=0;
		
		while ($fila = $result->fetch_row()){
			echo"
			<div id='tag_principal_div_$k'>
			<label> Nombre de la Categor&iacute;a: <input type='text' name='tag_principal[]' value='$fila[1]' required /></label>
			<label> Imagen: <input type='text' value='$fila[2]' name='link[]' readonly required class='oculto'/><img class='previewimgTag' src='../$fila[2]'/>
			<div class='imagenTagsPrincipal oculto'></div></label><button type='button' onclick='tagimgescojerimg(this)'>Escoger imagen</button>
			<button type='button' onclick='eliminarTagPrin($fila[0]);' class='cancelar_edit'></button>
			<br/>
			</div>
			<input type='text' required readonly class='oculto' value='$fila[0]' name='id[]' />
			";
			$k=$k+1;
		}
		echo "
		</div>
		<button type='button' onclick='tag_principal_nuevo();'>Nuevo</button>
		<button type='submit' value='Subir' name='subir_tag_principal'>Subir</button>
		</form>
		<form enctype=\"multipart/form-data\" id=\"formuploadajaxTag\" method=\"post\">
		<label>Subir nueva imagen: <input type='file' name='nombre_foto_in' id='imagenesTag' required/><button type='submit' >Subir</button></label>
		<div id='cargaerrorTagimg'>
		</div>
		</form>
		</div>";
		/*Sub categoria*/
		echo "
		<div id='creacionAdminEtiquetas' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<label> Nombre de la Etiqueta Principal:
		<div class='caja'>
		<select onchange='CreacionSubTags(this)' id='tag_principal' name='tag_principal' required >
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}
		
		echo "
		</select></div></label>
		</br>";
		echo "
		<script>
		function CreacionSubTags(e){
			var div=document.getElementById('CreacionSubTagsProductos');
			var id=e.value;	
			var texto='';";
				$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		
		while ($fila = $result->fetch_row()){
echo "
		if(id==$fila[0]){			
		";
		$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		texto=texto +'<label> Nombre de la Etiqueta:';
		 texto= texto + '<input type=\"text\" value=\"$fila2[2]\" /></label></br>';
		 texto= texto + '<button type=\"button\" name=\"editar_nombre\" onclick=\"editar_Tag_secundario_Productos(\'$fila2[0]\', \'$fila2[2]\')\" class=\"editSubmit\" ></button>'
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"eliminar_Tag_secundario_Productos(\'$fila2[0]\', \'$fila2[2]\')\"></button><br/>';
		
		";}
		echo "}";
		}
		echo "
		div.innerHTML=texto;

		}
		</script>
		<label> Nombre de la Etiqueta:
		<input type='text' name='nombre_tag_secundario' required/></label></br>
		<button type='submit' value='Subir' name='subir_tag_secundario'>Subir</button>
		</form>
		<div id='CreacionSubTagsProductos'></div>
		</div>";
		/*--------------------------------*/
		/*----------ETIQUETAS 2--------------*/
		/*Prin Categoria*/
		$concultaTag="SELECT * FROM TagPrincipalContra";
			$result = $conexion->query($concultaTag);
			$numero=mysqli_num_rows($result);
		echo "
		<script>
		var conttags_contra=$numero;
		function tag_principal_nuevo_contra(){
		var div=document.getElementById('tag_principal_div_contra');
		var indiv = document.createElement('div');
		indiv.id='tag_principal_div_contra_' + conttags_contra;
		var texto='<label> Nombre de la Categor&iacute;a: <input type=\"text\" name=\"tag_principal[]\" required /></label>';
		 texto= texto + '<label> Imgen: <input type=\"text\"  name=\"link[]\" readonly required class=\"oculto\"/><img />';
		 texto= texto + '<div class=\"imagenTagsPrincipal_contra oculto\"></div></label><button type=\"button\" onclick=\"tagimgescojerimg_contra(this)\">Escoger imagen</button>';
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"eliminar_div_tagprinci(\'tag_principal_div_contra_' + conttags_contra +'\')\"></button><br/>';
		div.appendChild(indiv);
		document.getElementById('tag_principal_div_contra_' + conttags_contra).innerHTML=texto;
		imaPrincipalimgl_contra();
		conttags_contra=conttags_contra+1;
		}
		function imaPrincipalimgl_contra(){
		$(\".imagenTagsPrincipal_contra\").load(\"consultasphp/tagPrincipal.php\");
	}
	function linkimgtags(e){
		var link=e.src;
		var LocationActual='https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';

		LocationActual=LocationActual.replace('Login/administrar.php','');
	
		link=link.replace(LocationActual, '');
		
		var label=e.parentNode.parentNode;
		label.children[0].value=link;
		label.children[1].src='../' + link;
		label.children[1].className='previewimgTag';
		e.parentNode.style.display='none';
	}
 $(function(){
        $(\"#formuploadajaxTag_contra\").on(\"submit\", function(e){
			
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById(\"formuploadajaxTag_contra\"));
            //formData.append(f.attr(\"name\"), $(this)[0].files[0]);
			document.getElementById('ajax-loader').style.display='block';
            $.ajax({
                url: \"tagPrincipal.php\",
                type: \"post\",
                dataType: \"html\",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    $(\"#cargaerrorTagimg_contra\").html(\"Respuesta: \" + res);
					document.getElementById('imagenesTag_contra').value='';
					document.getElementById('ajax-loader').style.display='none';	
					imaPrincipalimgl_contra();
                });
        });
		
    });
	function tagimgescojerimg_contra(e){
		e.parentNode.children[1].children[2].style.display='block';
	}
	function eliminarTagPrin_contra(ID){
		document.getElementById('mensaje_javascript').style.display='block';
		$.get('../archivosbase/php/administrarJq/borrartags_contra.php?IDmen=' + ID, function(texto){
			
			document.getElementById('mensaje_javascript').childNodes[0].innerHTML=texto;
		});
		
	}
		</script>";
		echo"
		<div id='creacionPrinEtiquetasC' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<div id='tag_principal_div_contra'>";
		$k=0;
		
		while ($fila = $result->fetch_row()){
			echo"
			<div id='tag_principal_div_contra_$k'>
			<label> Nombre de la Categor&iacute;a: <input type='text' name='tag_principal[]' value='$fila[1]' required /></label>
			<label> Imagen: <input type='text' value='$fila[2]' name='link[]' readonly required class='oculto'/><img class='previewimgTag' src='../$fila[2]'/>
			<div class='imagenTagsPrincipal_contra oculto'></div></label><button type='button' onclick='tagimgescojerimg_contra(this)'>Escoger imagen</button>
			<button type='button' onclick='eliminarTagPrin_contra($fila[0]);' class='cancelar_edit'></button>
			<br/>
			</div>
			<input type='text' required readonly class='oculto' value='$fila[0]' name='id[]' />
			";
			$k=$k+1;
		}
		echo "
		</div>
		<button type='button' onclick='tag_principal_nuevo_contra();'>Nuevo</button>
		<button type='submit' value='Subir' name='subir_tag_principal_contra'>Subir</button>
		</form>
		<form enctype=\"multipart/form-data\" id=\"formuploadajaxTag_contra\" method=\"post\">
		<label>Subir nueva imagen: <input type='file' name='nombre_foto_in' id='imagenesTag_contra' required/><button type='submit' >Subir</button></label>
		<div id='cargaerrorTagimg_contra'>
		</div>
		</form>
		</div>";
		/*Sub categoria*/
		echo "
		<div id='creacionAdminEtiquetasC' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<label> Nombre de la Etiqueta Principal:
		<div class='caja'>
		<select id='tag_principal_subetiqueta_contra' name='tag_principal' required >
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}
		echo "
		</select></div></label>
		</br>
		<label> Nombre de la Etiqueta:
		<input type='text' name='nombre_tag_secundario' required/></label></br>
		<button type='submit' value='Subir' name='subir_tag_secundario_contra'>Subir</button>
		</form>
		</div>";
		/*--------------------------------*/
		}
		/*-------------------------------*/
		/*----------Ubucacion de la empresa y sucursales--------------*/
		if($_SESSION['Nivel']==2){
			$concultaUbicacion="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
			$result = $conexion->query($concultaUbicacion);
			if ($result->num_rows == 0) {
				echo "
			<script type='text/javascript'> 
				function getCoords(marker, inoutLat, inputLon)
					{ 
				document.getElementById(inoutLat).value=marker.getPosition().lat(); 
				document.getElementById(inputLon).value=marker.getPosition().lng(); 
					} 
				var contadorubicaciones=1;
				function initialize(lat,lon, inoutLat, inputLon) {	
				var myLatlng = new google.maps.LatLng(lat,lon); 
				var myOptions = { 
				zoom: 16, 
        center: myLatlng, 
        mapTypeId: google.maps.MapTypeId.ROADMAP, 
    } 
    var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions); 
   marker = new google.maps.Marker({ 
          position: myLatlng, 
          draggable: true, 
          title:'Donde?' 
    });
	
    google.maps.event.addListener(marker, 'dragend', function() { 
                    getCoords(marker, inoutLat, inputLon); 
    }); 
     
      marker.setMap(map); 
    getCoords(marker, inoutLat, inputLon); 
  } 
 
 function nuevaubicacion(){
	 var texto=document.getElementById('ubicaciones').innerHTML;
	 contadorubicaciones=contadorubicaciones+1;
	 texto=texto + \"<label> Latitud: <input type='text' class='coordEdit' name='latitud[]'  id='latitud_mapa_\" + contadorubicaciones + \"' required readonly></label>\";
	 texto=texto + \"<label> Longitud: <input type='text' class='coordEdit' id='longitud_mapa_\" + contadorubicaciones + \"' name='longitud[]' required readonly></label>\";
	 texto=texto + \"<label> Direcci&oacute;n: <input type='text' class='coordEdit' name='direccion[]' required></label>\";
	 texto=texto + \"<button type='button' onclick=\\\"initialize(-0.1574824, -78.4682946,'latitud_mapa_\" + contadorubicaciones + \"','longitud_mapa_\" + contadorubicaciones + \"')\\\" style='margin-left: 2%;'>Ubicar</button><br/>\";
	 document.getElementById('ubicaciones').innerHTML=texto;
 }
  </script>";
		echo "
		<div id='ubicacion_empresas' class='oculto'>
			<form action='$_SERVER[PHP_SELF]' method='post' >
				<div id='ubicaciones'>
				<label> Latitud: <input type='text' class='coordEdit' name='latitud[]' id='latitud_mapa_1' required readonly ></label><label> Longitud: <input type='text'class='coordEdit' id='longitud_mapa_1' name='longitud[]' required readonly style='width: 140px;'></label>
				<label> Direcci&oacute;n: <input type='text' class='coordEdit' name='direccion[]' required></label><button type='button' onclick='initialize(-0.1574824, -78.4682946,\"latitud_mapa_1\",\"longitud_mapa_1\")' style='margin-left: 2%;'>Ubicar</button><br/>
				</div>
		<button type='submit' name='ubicacion_empresa_nuevo' value='Enviar'>Enviar</button><button type='button' onclick='nuevaubicacion()' style='margin-left: 2%;'>Nueva</button>
			</form>
				<div id='mapas_de_google' >
					<div id='map_canvas' style='width:400px; height:400px;' ></div><br> 
				</div>
				<div id='mapa_empresa_ubicacion'>
				</div>
		</div>";
		}else{
			$concultaUbicacion="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
			$result = $conexion->query($concultaUbicacion);
			$numero=mysqli_num_rows($result);
			echo "<script type='text/javascript'> 
function getCoords(marker, inoutLat, inputLon){ 
    document.getElementById(inoutLat).value=marker.getPosition().lat(); 
      document.getElementById(inputLon).value=marker.getPosition().lng(); 

} 
 var contadorubicaciones=$numero;
function initialize(lat,lon, inoutLat, inputLon) {	
    var myLatlng = new google.maps.LatLng(lat,lon); 
    var myOptions = { 
        zoom: 15, 
        center: myLatlng, 
        mapTypeId: google.maps.MapTypeId.ROADMAP, 
    } 
    var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions); 
    for(var i=0; i<contadorubicaciones; i++){ 
   marker = new google.maps.Marker({ 
          position: myLatlng, 
          draggable: true, 
          title:'Donde?' 
    });
	}	
    google.maps.event.addListener(marker, 'dragend', function() { 
                    getCoords(marker, inoutLat, inputLon); 
    }); 
     
      marker.setMap(map); 
    getCoords(marker, inoutLat, inputLon); 
  } 
 
 function nuevaubicacion(){
	 var texto=document.getElementById('ubicaciones').innerHTML;
	 contadorubicaciones=contadorubicaciones+1;
	 texto=texto + \"<label> Latitud: <input type='text' class='coordEdit' name='latitud[]' id='latitud_mapa_\" + contadorubicaciones + \"' required readonly></label>\";
	 texto=texto + \"<label> Longitud: <input type='text' class='coordEdit' id='longitud_mapa_\" + contadorubicaciones + \"' name='longitud[]' required readonly></label>\";
	 texto=texto + \"<label> Direcci&oacute;n: <input type='text' class='coordEdit' name='direccion[]' required></label>\";
	 texto=texto + \"<button type='button' onclick=\\\"initialize(-0.1574824, -78.4682946,'latitud_mapa_\" + contadorubicaciones + \"','longitud_mapa_\" + contadorubicaciones + \"')\\\" style='margin-left: 2%;'>Ubicar</button><br/>\";
	 document.getElementById('ubicaciones').innerHTML=texto;
 }
  </script>";
		echo "
		<div id='ubicacion_empresas' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post' >
		<div id='ubicaciones'>";
		$i=1;
		while ($fila = $result->fetch_row()){
echo "<label> Latitud: <input type='text' class='coordEdit' name='latitud[]' value='$fila[2]' id='latitud_mapa_$i' required readonly></label><label> Longitud: <input type='text' class='coordEdit' value='$fila[3]' id='longitud_mapa_$i' name='longitud[]' required readonly></label>
<label> Direcci&oacute;n: <input type='text'class='coordEdit' name='direccion[]' value='$fila[4]' required></label>
<input type='text' required readonly name='id_editar_ubicacion[]' value='$fila[0]' style='display:none;' /><button type='button' onclick='initialize($fila[2], $fila[3],\"latitud_mapa_$i\",\"longitud_mapa_$i\")' style='margin-left: 2%;'>Ubicar</button><br/>";
		$i=$i+1;}
		echo "</div>
		<button type='submit' name='ubicacion_empresa_nuevo' value='Enviar'>Enviar</button><button type='button' onclick='nuevaubicacion()' style='margin-left: 2%;'>Nueva</button>
		</form>
<div id='mapas_de_google' >
<div id='map_canvas' style='width:400px; height:400px;' ></div><br> 
</div>
		<div id='mapa_empresa_ubicacion'>
		</div>
		</div>";	
		}
	/*----------Descripcion Empresa-----------*/
	$buscd="SELECT * FROM DESCRIPCION WHERE ID_Usuario='$_SESSION[ID]' ";
		$result1 = $conexion->query($buscd);
			$numerodes=mysqli_num_rows($result1);
			$row = $result1->fetch_array(MYSQLI_ASSOC);
		echo "
		<div id='descripcion_empresas' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<label>Ingrese una descripci&oacute;n sobre su empresa <br/>";
		if($numerodes==0){
		echo "
		<textarea name='descripcion' required></textarea></label><br/>
		";
		}else{
		echo "
		<textarea name='descripcion' required>$row[DESCRIPCION]</textarea></label><br/>
		";	
		}
		echo "
		<div class='caja'>
		<select id='tag_principal' name='tag_principal' required onchange='tagSelect()'>
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		if($numerodes==0){	
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}else{
			if($fila[0]==$row['TagPrincipal']){
			echo "
		<option value='$fila[0]' selected>$fila[1]</option>";
			}else{
				echo "
		<option value='$fila[0]'>$fila[1]</option>";
			}
		}
		}
		echo "
		</select></div>
		<script>
		function tagSelect(){
			var tagprincipal=document.getElementById('tag_principal').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubTag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubTag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubTag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}
		
		</script>
		";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		<div class='SubTag oculto' id='SubTag$fila[0]'>";
		$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		if($numerodes==0){	
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
		}else{
$cadena_de_texto = $row['TagSecundario'];
$cadena_buscada   = "#$fila2[0];";
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
			if($posicion_coincidencia === false){
			
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
			}else{
				echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' checked value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
			}
		}
		
		}
		
		echo "
		</div>
		";}
			echo "
		<br/><button type='submit' name='descripcion_empresa' value='Enviar'>Enviar</button>
		</form>
		</div>";
		/*----FIN DESCRIPCION Empresa------*/
		
		}
		if($_SESSION['Nivel']==2 || $_SESSION['Nivel']==3){
		/*-----------Contratacion Empresa-----------*/
		echo "<div id='contratacion_empresas' class='oculto'>
		
			<div id='contratacion_empresas_misOfertas'>";
	
				/*Imagenes Base de Datos -> verificar si hay existencia*/
				$buscarproducto="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$_SESSION[ID]' AND TIPO='1'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
				echo "
				<div class='OfertaContra' >
				<div class='titulo_oferta'>
				<p>$fila[6]</p>
				</div>
				<div class='discripcion_oferta'>
				<p>$fila[2]</p>
				</div>
				<div class='puestos_Oferta'>
				$fila[3]
				</div>
				<div class='botones_oferta'>
				<button onclick='nuevo_ofertaE(\"contratacion_empresas_editar\"); editar_ofertaE(\"$fila[0]\");'>Editar</button><button>Eliminar</button>
				</div>
				</div>
				<div class='limpiador'></div>";}
				
			echo "
			<div id='contratacion_empresas_botones_nuevo'><button onclick='nuevo_ofertaE(\"contratacion_empresas_nuevo\")'>Nuevo</button></div>
			</div>
			<div id='contratacion_empresas_nuevo' class='oculto'>
			<div id='contratacion_empresas_botones_regresar'><button onclick='nuevo_ofertaE(\"contratacion_empresas_misOfertas\")'>Regresar</button></div>
			<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
			<label>Titulo: <input type='text' required name='titulo'></label><br/>
			<label>Descripci&oacute;n: <textarea required name='descripcion'></textarea></label><br/>
			<label>Puestos: <input type='number' step='any' required name='puestos'></label><br/>
		<div class='caja'>
		<select id='tag_principal_oferta' name='tag_principal' required onchange='tagSelect3()'>
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}
		echo "
		</select></div>
		<script>
		function nuevo_ofertaE(div){
			$('#contratacion_empresas_misOfertas').fadeOut(250);
			$('#contratacion_empresas_nuevo').fadeOut(250);
			$('#contratacion_empresas_editar').fadeOut(250);
			setTimeout(function(){
			$('#' + div).fadeIn(250);},255);
			
			/*document.getElementById('contratacion_empresas_misOfertas').style.display='none';
			document.getElementById('contratacion_empresas_nuevo').style.display='block';*/
		}

		function tagSelect3(){
			var tagprincipal=document.getElementById('tag_principal_oferta').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubCETag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubCETag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubCETag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}
		</script>
		";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		<div class='SubTag oculto' id='SubCETag$fila[0]'>";
		$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubCETag$fila[0]'/></label>";
		}
		echo "
		</div>";}
		echo "
		<button type='submit' name='subir_nuevo_oferta_E' value='Subir'>Subir</button>
			</form>
			</div>";
			/*contratacion Empresa Editar*/
			echo "
			<div id='contratacion_empresas_editar' class='oculto'>
			<script>
			function editar_ofertaE(ID){
				var TagSecundario='';
				var div=document.getElementById('contratacion_empresas_editar_div');
				div.innerHTML='';
				var texto='';
				";
				$buscarproducto="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$_SESSION[ID]' AND TIPO='1'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
				echo "
				if(ID=='$fila[0]'){
					texto=texto + \"<label>Titulo: <input type='text' required name='titulo' value='$fila[6]'></label><br/>\";
				texto=texto + \"<label>Descripci&oacute;n: <textarea required name='descripcion'>$fila[2]</textarea></label><br/>\";	
			texto=texto + \"<label>Puestos: <input type='number' step='any' required name='puestos' value='$fila[3]'></label><br/>\";
			texto=texto + \"<div class='caja'>\";
			texto=texto + \"<select id='tag_principal_oferta_editar' name='tag_principal' required onchange='tagSelect4()'>\";
			texto=texto + \"<option value=''>Seleccione una opci&oacute;n</option>\";
		";
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila2 = $result->fetch_row()){
			if($fila2[0]==$fila[4]){
		echo "
		texto=texto + \"<option value='$fila2[0]' selected>$fila2[1]</option>\";
		";
			}else{
				echo "
		texto=texto + \"<option value='$fila2[0]'>$fila2[1]</option>\";
		";
			}
		}
		echo "
		texto=texto + \"</select></div>\";
		";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila3 = $result->fetch_row()){
			echo "
		texto=texto + \"<div class='SubTag oculto' id='SubCEETag$fila3[0]'>\";
		";
		$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila3[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		texto=texto + \"<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubCEETag$fila3[0]'/></label>\";
		";
		}
		echo "
		texto=texto + \"</div>\";
		";}
		echo "
		texto=texto + \"<input type='text' name='ID' value='$fila[0]' required readonly  style='display:none'/>\";	
		texto=texto + \"<button type='submit' name='subir_editar_oferta_E' value='Subir'>Subir</button>\";
		TagSecundario='$fila[5]';		
				}
				";
				}					
			
			echo "
			div.innerHTML=texto;
			tagSelect4();";
			
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		if(TagSecundario.indexOf('#$fila2[0];')!=-1){
			var x = document.getElementsByClassName('CSubCEETag$fila[0]');
			var Y;
			for (Y = 0; Y < x.length; y++) {
					if(x[Y].value==$fila2[0]){
						x[Y].checked=true;
					}
				}}";
		}}
		echo "	
			}
		function tagSelect4(){
			var tagprincipal=document.getElementById('tag_principal_oferta_editar').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubCEETag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubCEETag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubCEETag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}	
			
			</script>
			<div id='contratacion_empresas_editar_botones_regresar'><button onclick='nuevo_ofertaE(\"contratacion_empresas_misOfertas\")'>Regresar</button></div>
			<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
			<div id='contratacion_empresas_editar_div'>
			
			</div>
			</form>
			</div>
			";
		
		echo "
		</div>";
	   /*------FIN Contratacion Empresa------------*/	
			/*----Productos Empresa------*/
		echo "
		<div id='productos_empresas' class='oculto'>
			<div id='productos_empresas_misProductos'>";
			echo "<script>
				function showSlides(){
					";
					$buscarproducto="SELECT * FROM PRODUCTOS WHERE ID_Usuario='$_SESSION[ID]'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
					echo "showSlides$fila[0]();";
				}
					echo "
				}
				
				function slidesinnumero(e){
					/*var id=e.id;
					var padre=e.parentNode;
					var hijos=padre.children;
					var contIMGSLIDEsin=0;
						$('#' + id).fadeToggle(500);
					setTimeout(function(){
				for(var i=0; i<hijos.length; i++){
						if(hijos[i].style.display=='none'){
							contIMGSLIDEsin=contIMGSLIDEsin+1;
						
						}
					}
					if(contIMGSLIDEsin==(hijos.length - 1)){
						contIMGSLIDEsin=0;
						for(var i=0; i<hijos.length; i++){
						var idi=hijos[i].id;
						$('#' + idi).fadeToggle('slow');
						}
					}		},510);			*/
				}
			</script>";	
				/*Imagenes Base de Datos -> verificar si hay existencia*/
				$buscarproducto="SELECT * FROM PRODUCTOS WHERE ID_Usuario='$_SESSION[ID]'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
			echo "<script>
					var slideIndex$fila[0] = 0;
function showSlides$fila[0]() {
    var i;
    var slides = document.getElementsByClassName('mySlides$fila[0]');
    for (i = 0; i < slides.length; i++) {
       /* slides[i].style.display = 'none'; */
	   var id=slides[i].id;
		$('#' + id).fadeOut();
    }
    slideIndex$fila[0]++;
    if (slideIndex$fila[0] > slides.length) {slideIndex$fila[0] = 1} 
    /*slides[slideIndex$fila[0]-1].style.display = 'block'; */
	var ido=slides[slideIndex$fila[0]-1].id;
	$('#' + ido).fadeIn();
   // setTimeout(showSlides$fila[0], 2500); 
}
						
					
					";
				
				echo "
				</script>";
				echo "
				<div class='producto' >
				<div class='img_producto' >";
				$buscarproductoI="SELECT * FROM FotoProductos WHERE ID_Usuario='$_SESSION[ID]' AND ID_Producto='$fila[0]'";
				$resultprI = $conexion->query($buscarproductoI);
				$numeroimgprod=mysqli_num_rows($resultprI);
				if($numeroimgprod==0){
					echo "<img src='imagen no imagen'  class='mySlides$fila[0]'/>";
				}else{
				while ($fila2 = $resultprI->fetch_row()){
					echo "<img src='https://nirjob.com/$fila2[3]' onclick='showSlides$fila[0]()' id='imagen_slide_product_$fila2[0]' class='mySlides$fila[0]'/>";
				}}
				echo "
				</div>
				<div class='discripcion_producto'>
				<h4>$fila[4]</h4>
				<p>$fila[5]</p>
				</div>
				<div class='precio_producto'>
				\$$fila[6]
				</div>
				<div class='botones_producto'>
				<button onclick='editarProductosPrin(\"$fila[0]\")'>Editar</button><button>Vendido</button><br/>
				<button>Ver</button><button>Eliminar</button>
				</div>
				</div>
				<div class='limpiador'></div>";}
				
			echo "
			<div id='productos_empresas_botones_nuevo'><button onclick='nuevo_productoE(\"productos_empresas_nuevo\")'>Nuevo</button></div>
			</div>
			<div id='productos_empresas_nuevo' class='oculto'>
			<button type='button' onclick='nuevo_productoE(\"productos_empresas_misProductos\")'>Regresar</button>
			<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
			<label>Titulo: <input type='text' required name='titulo'></label><br/>
			<label>Descripci&oacute;n: <textarea required name='descripcion'></textarea></label><br/>
			<label>Precio: $<input type='number' step='any' required name='precio'></label><br/>
		<div class='caja'>
		<select id='tag_principal_producto' name='tag_principal' required onchange=\"tagSelect2('tag_principal_producto', 'SubPTag', 'CSubPTag')\">
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}
		echo "
		</select></div>
		<script>
		function nuevo_productoE(ID){
			$('#productos_empresas_misProductos').fadeOut(250);
			$('#productos_empresas_nuevo').fadeOut(250);
			$('#productos_empresas_editar').fadeOut(250);
			setTimeout(function(){
			$('#' + ID).fadeIn(250);},255);
		}
		var contProductosImg=0;
		function productos_empresas_nuevo_imagenes(ID){
		var div=document.getElementById(ID);
		var indiv = document.createElement('div');
		indiv.id='img_producto_input_div' + contProductosImg;
		var texto='<input type=\"file\" name=\"productos_img[]\" id=\"img_producto_input' + contProductosImg + '\" onChange=\'ver_fotos(\"img_producto_input' + contProductosImg + '\",\"img_producto_out' + contProductosImg + '\", \"Subir_producto_Nuevo\")\' required accept=\"image/*\" /><output id=\"img_producto_out' + contProductosImg + '\" ></output>';
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"eliminar_div_productos(\'img_producto_input_div' + contProductosImg +'\')\"></button><br/>';
		div.appendChild(indiv);
		document.getElementById('img_producto_input_div' + contProductosImg).innerHTML=texto;
		/*div.innerHTML=div.innerHTML + texto;*/
		
		contProductosImg=contProductosImg+1;
		}
		function eliminar_div_productos(div1){
			var div = document.getElementById(div1);
    if(div !== null){
        while (div.hasChildNodes()){
            div.removeChild(div.lastChild);
        }
    }else{
        alert (\"No existe esta foto??\");
    }
		}
		function tagSelect2(ID, SUB, CSUB){
			var tagprincipal=document.getElementById(ID).value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById(SUB + '$fila[0]').style.display='block';
			}else{
				document.getElementById(SUB + '$fila[0]').style.display='none';
				var x = document.getElementsByClassName(CSUB + '$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}
		</script>
		";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		<div class='SubTag oculto' id='SubPTag$fila[0]'>";
		$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubPTag$fila[0]'/></label>";
		}
		echo "
		</div>";}
		echo "
		<div id='productos_empresas_nuevo_imagenes'>
		<div id='productos_empresas_nuevo_imagenes_div'>
		</div>
		<button type='button' onclick='productos_empresas_nuevo_imagenes(\"productos_empresas_nuevo_imagenes_div\")'>Nueva Imagen</button>
		</div>
		<button type='submit'  id='Subir_producto_Nuevo' name='subir_nuevo_producto_E' value='Subir'>Subir</button>
			</form>
			</div>";
			/*Editar Productos*/
			$comilla='"';
			echo "
			<div id='productos_empresas_editar' class='oculto'>
			<button type='button' onclick='nuevo_productoE(\"productos_empresas_misProductos\")'>Regresar</button>
			<script>
			function editarProductosPrin(ID){
				$('#ajax-loader').fadeIn(250);
				$('#productos_empresas_misProductos').fadeOut(250);
				setTimeout(function(){
				$('#productos_empresas_editar').fadeIn(250);	
				document.getElementById('productos_empresas_editar_div').innerHTML='';
				var divIngr=document.getElementById('productos_empresas_editar_div');	
				$.getJSON('consultasphp/imgenasEditar.php?Usuario=$_SESSION[ID]&ID=' + ID, function(data) {				
		var tamanio=data.length;
		var texto='';
			for(var i=0; i<tamanio; i++){
				var Precio=parseFloat(data[i].Precio);
				var Titulo=data[i].Titulo;
				var ID_Usuario=data[i].ID_Usuario;
				var Descri=data[i].Descri;
				var ID=data[i].ID;
				var Tagprincipal=data[i].Tagprincipal;
				var TagSecundario=data[i].TagSecundario;
				var Imagen=data[i].Imagen;
				var tamanioImagen=Imagen.length;
			texto=texto + \"<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>\";
			texto=texto + \"<label>Titulo: <input type='text' required name='titulo' value='\"+ Titulo +\"'></label><br/>\";
			texto=texto + \"<label>Descripci&oacute;n: <textarea required name='descripcion'>\"+ Descri +\"</textarea></label><br/>\";
		texto=texto + \"	<label>Precio: $<input type='number' step='any' required name='precio' value='\"+ Precio +\"'></label><br/>\";
		texto=texto + \"<div class='caja'>\";
		texto=texto + '<select id=\'tag_principal_producto_editar\' name=\'tag_principal\' required onchange=\'tagSelect2(\"tag_principal_producto_editar\", \"SubPTag_Edit\", \"CSubPTag_Edit\")\'>';
		texto=texto + \"<option value=''>Seleccione una opci&oacute;n</option>\";
		";
		$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		if(Tagprincipal==$fila[0]){
			texto=texto + \"<option selected value='$fila[0]'>$fila[1]</option>\";
			
		}else{
		texto=texto + \"<option value='$fila[0]'>$fila[1]</option>\";
		}
		";
		}
		echo "
		
	texto=texto + \"	</select></div>\";
	";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		texto=texto + \"<div class='SubTag oculto' id='SubPTag_Edit$fila[0]'>\";
		";
		$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		if(TagSecundario.indexOf('#$fila2[0];')!=-1){
		texto=texto + \"<label>$fila2[2] <input type='checkbox' checked name='subtag[]' value='$fila2[0]' class='CSubPTag_Edit$fila[0]'/></label>\";	
		}else{
		texto=texto + \"<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubPTag_Edit$fila[0]'/></label>\";
		}";
		}
		echo "
		texto=texto + \"</div>\";
		";}
		echo "
		texto=texto + \"<div id='productos_empresas_nuevo_imagenes_Edit'>\";
		texto=texto + \"<div id='productos_empresas_nuevo_imagenes_Edit_div'>\";
		for(var j=0; j<tamanioImagen; j++){
	texto=texto+ '<output id=\"img_producto_edit_out' + j + '\" ><img src=\"../' + Imagen[j] + '\"></output>';
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"borrarIMG_div_productos(\'' + Imagen[j] + '\')\"></button><br/>';
				}
		contProductosImgEditImg=j;		
		texto=texto + \"</div>\";
		texto=texto + '<button type=\"button\" onclick=\'productos_empresas_edit_imagenes(\"productos_empresas_nuevo_imagenes_Edit_div\")\'>Nueva Imagen</button>';
		texto=texto + \"</div>\";
		texto=texto + \"<button type='submit' id='Subir_producto_Editar' name='subir_nuevo_producto_Edit' value='Editar'>Editar</button>\";
		texto=texto + \"	</form>\";
				
			}
divIngr.innerHTML=texto; 
tagSelect2('tag_principal_producto_editar', 'SubPTag_Edit', 'CSubPTag_Edit');
";
$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		if(TagSecundario.indexOf('#$fila2[0];')!=-1){
			var x = document.getElementsByClassName('CSubPTag_Edit$fila[0]');
			var Y;
			for (Y = 0; Y < x.length; y++) {
					if(x[Y].value==$fila2[0]){
						x[Y].checked=true;
					}
				}}";
		}}
		echo "	
		});		
		$('#ajax-loader').fadeOut(250);		},255);
			}
var contProductosImgEditImg=0;
		function productos_empresas_edit_imagenes(ID){
			
		var div=document.getElementById(ID);
		var indiv = document.createElement('div');
		indiv.id='img_producto_input_edit_div' + contProductosImgEditImg;
		
		var texto='<input type=\"file\" name=\"productos_img[]\" id=\"img_producto_edit_input' + contProductosImgEditImg + '\" onChange=\'ver_fotos(\"img_producto_edit_input' + contProductosImgEditImg + '\",\"img_producto_edit_out' + contProductosImgEditImg + '\", \"Subir_producto_Editar\")\' required accept=\"image/*\" /><output id=\"img_producto_edit_out' + contProductosImgEditImg + '\" ></output>';
		
		texto=texto+ '<button type=\"button\" class=\"cancelar_edit\" onclick=\"eliminar_div_productos(\'img_producto_input_edit_div' + contProductosImgEditImg +'\')\"></button><br/>';
		
		div.appendChild(indiv);
		document.getElementById('img_producto_input_edit_div' + contProductosImgEditImg).innerHTML=texto;
		/*div.innerHTML=div.innerHTML + texto;*/
		
		contProductosImgEditImg=contProductosImgEditImg+1;
		}			
			</script>
			<div id='productos_empresas_editar_div'>
			
			</div>
			</div>
			";
			echo "
		</div>
		";
		/*----FIN Productos Empresa------*/
		}
		/*---SERVICIO PARTICULAR--------*/
		if( $_SESSION['Nivel']==3){
		/*-----------Contratacion Empresa-----------*/
		echo "<div id='contratacion_particular' class='oculto'>";
		
			echo "
			<div id='contratacion_particular_misOfertas'>";
				$buscarproducto="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$_SESSION[ID]' AND TIPO='2'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
				echo "
				<div class='OfertaContra' >
				<div class='titulo_oferta'>
				<p>$fila[6]</p>
				</div>
				<div class='discripcion_oferta'>
				<p>$fila[2]</p>
				</div>
				<div class='puestos_Oferta'>
				$fila[3]
				</div>
				<div class='botones_oferta'>
				<button onclick='nuevo_ofertaP(\"contratacion_particular_editar\"); editar_ofertaP(\"$fila[0]\");'>Editar</button><button>Eliminar</button>
				</div>
				</div>
				<div class='limpiador'></div>";}
				
			echo "
			<div id='contratacion_particular_botones_nuevo'><button onclick='nuevo_ofertaP(\"contratacion_particular_nuevo\")'>Nuevo</button></div>
			</div>
			<div id='contratacion_particular_nuevo' class='oculto'>
			<div id='contratacion_particular_botones_regresar'><button onclick='nuevo_ofertaP(\"contratacion_particular_misOfertas\")'>Regresar</button></div>
			<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
			<label>Titulo: <input type='text' required name='titulo'></label><br/>
			<label>Descripci&oacute;n: <textarea required name='descripcion'></textarea></label><br/>
			<label>Puestos: <input type='number' step='any' required name='puestos'></label><br/>
		<div class='caja'>
		<select id='tag_principal_oferta_p' name='tag_principal' required onchange='tagSelect5()'>
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}
		echo "
		</select></div>
		<script>
		function nuevo_ofertaP(div){
			$('#contratacion_particular_misOfertas').fadeOut(250);
			$('#contratacion_particular_nuevo').fadeOut(250);
			$('#contratacion_particular_editar').fadeOut(250);
			setTimeout(function(){
			$('#' + div).fadeIn(250);},255);
			
			
		}

		function tagSelect5(){
			var tagprincipal=document.getElementById('tag_principal_oferta_p').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubCPTag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubCPTag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubCPTag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}
		</script>
		";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		<div class='SubTag oculto' id='SubCPTag$fila[0]'>";
		$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubCPTag$fila[0]'/></label>";
		}
		echo "
		</div>";}
		echo "
		<button type='submit' name='subir_nuevo_oferta_P' value='Subir'>Subir</button>
			</form>
			</div>";
			/*contratacion principal Editar*/
			echo "
			<div id='contratacion_particular_editar' class='oculto'>
			<script>
			function editar_ofertaP(ID){
				var TagSecundario='';
				var div=document.getElementById('contratacion_particular_editar_div');
				div.innerHTML='';
				var texto='';
				";
				$buscarproducto="SELECT * FROM CONTRATACIONE WHERE ID_Usuario='$_SESSION[ID]' AND TIPO='2'";
				$resultpr = $conexion->query($buscarproducto);
				while ($fila = $resultpr->fetch_row()){
				echo "
				if(ID=='$fila[0]'){
					texto=texto + \"<label>Titulo: <input type='text' required name='titulo' value='$fila[6]'></label><br/>\";
				texto=texto + \"<label>Descripci&oacute;n: <textarea required name='descripcion'>$fila[2]</textarea></label><br/>\";	
			texto=texto + \"<label>Puestos: <input type='number' step='any' required name='puestos' value='$fila[3]'></label><br/>\";
			texto=texto + \"<div class='caja'>\";
			texto=texto + \"<select id='tag_principal_oferta_p_editar' name='tag_principal' required onchange='tagSelect6()'>\";
			texto=texto + \"<option value=''>Seleccione una opci&oacute;n</option>\";
		";
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila2 = $result->fetch_row()){
			if($fila2[0]==$fila[4]){
		echo "
		texto=texto + \"<option value='$fila2[0]' selected>$fila2[1]</option>\";
		";
			}else{
				echo "
		texto=texto + \"<option value='$fila2[0]'>$fila2[1]</option>\";
		";
			}
		}
		echo "
		texto=texto + \"</select></div>\";
		";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila3 = $result->fetch_row()){
			echo "
		texto=texto + \"<div class='SubTag oculto' id='SubCPETag$fila3[0]'>\";
		";
		$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila3[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		texto=texto + \"<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubCPETag$fila3[0]'/></label>\";
		";
		}
		echo "
		texto=texto + \"</div>\";
		";}
		echo "
		texto=texto + \"<input type='text' name='ID' value='$fila[0]' required readonly  style='display:none'/>\";	
		texto=texto + \"<button type='submit' name='subir_editar_oferta_p_E' value='Subir'>Subir</button>\";
		TagSecundario='$fila[5]';		
				}
				";
				}					
			
			echo "
			div.innerHTML=texto;
			tagSelect6();";
			
		$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
$TagSecundario="SELECT * FROM TagSecundarioContra WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		echo "
		if(TagSecundario.indexOf('#$fila2[0];')!=-1){
			var x = document.getElementsByClassName('CSubCPETag$fila[0]');
			var Y;
			for (Y = 0; Y < x.length; y++) {
					if(x[Y].value==$fila2[0]){
						x[Y].checked=true;
					}
				}}";
		}}
		echo "	
			}
		function tagSelect6(){
			var tagprincipal=document.getElementById('tag_principal_oferta_p_editar').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipalContra";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubCPETag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubCPETag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubCPETag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}	
			
			</script>
			<div id='contratacion_particular_editar_botones_regresar'><button onclick='nuevo_ofertaP(\"contratacion_particular_misOfertas\")'>Regresar</button></div>
			<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
			<div id='contratacion_particular_editar_div'>
			
			</div>
			</form>
			</div>
			";
		
		echo "
		</div>";
	   /*------FIN Contratacion Particular------------*/		
				$buscd="SELECT * FROM DESCRIPCION WHERE ID_Usuario='$_SESSION[ID]' ";
		$result1 = $conexion->query($buscd);
			$numerodes=mysqli_num_rows($result1);
			$row = $result1->fetch_array(MYSQLI_ASSOC);
		echo "
		<div id='descripcion_particular' class='oculto'>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<label>Ingrese una descripci&oacute;n sobre su Servicio <br/>";
		if($numerodes==0){
		echo "
		<textarea name='descripcion' required></textarea></label><br/>
		";
		}else{
		echo "
		<textarea name='descripcion' required>$row[DESCRIPCION]</textarea></label><br/>
		";	
		}
		echo "
		<div class='caja'>
		<select id='tag_principal' name='tag_principal' required onchange='tagSelect()'>
		<option value=''>Seleccione una opci&oacute;n</option>
		";
		$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
		if($numerodes==0){	
		echo "
		<option value='$fila[0]'>$fila[1]</option>";
		}else{
			if($fila[0]==$row['TagPrincipal']){
			echo "
		<option value='$fila[0]' selected>$fila[1]</option>";
			}else{
				echo "
		<option value='$fila[0]'>$fila[1]</option>";
			}
		}
		}
		echo "
		</select></div>
		<script>
		function tagSelect(){
			var tagprincipal=document.getElementById('tag_principal').value;
			";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
			if(tagprincipal=='$fila[0]'){
				document.getElementById('SubTag$fila[0]').style.display='block';
			}else{
				document.getElementById('SubTag$fila[0]').style.display='none';
				var x = document.getElementsByClassName('CSubTag$fila[0]');
				var i;
				for (i = 0; i < x.length; i++) {
				x[i].checked = false;
					}
			}
		";}
			echo "
		}
		</script>
		";
			$TagPrincipal="SELECT * FROM TagPrincipal";
		$result = $conexion->query($TagPrincipal);
		while ($fila = $result->fetch_row()){
			echo "
		<div class='SubTag oculto' id='SubTag$fila[0]'>";
		$TagSecundario="SELECT * FROM TagSecundario WHERE ID_TagPrincipal='$fila[0]'";
		$result2 = $conexion->query($TagSecundario);
		while ($fila2 = $result2->fetch_row()){
		if($numerodes==0){	
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
		}else{
$cadena_de_texto = $row['TagSecundario'];
$cadena_buscada   = "#$fila2[0];";
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
			if($posicion_coincidencia === false){
			
		echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
			}else{
				echo "<label>$fila2[2] <input type='checkbox' name='subtag[]' checked value='$fila2[0]' class='CSubTag$fila[0]'/></label>";
			}
		}
		
		}
		
		echo "
		</div>
		";}
		/*-------Ubicacion del servicio-----*/
		echo "
			<script type='text/javascript'> 
				function getCoords(marker, inoutLat, inputLon)
					{ 
				document.getElementById(inoutLat).value=marker.getPosition().lat(); 
				document.getElementById(inputLon).value=marker.getPosition().lng(); 
					} 
				var contadorubicaciones=1;
				function initialize(lat,lon, inoutLat, inputLon) {	
				var myLatlng = new google.maps.LatLng(lat,lon); 
				var myOptions = { 
				zoom: 16, 
        center: myLatlng, 
        mapTypeId: google.maps.MapTypeId.ROADMAP, 
    } 
    var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions); 
   marker = new google.maps.Marker({ 
          position: myLatlng, 
          draggable: true, 
          title:'Donde?' 
    });
	
    google.maps.event.addListener(marker, 'dragend', function() { 
                    getCoords(marker, inoutLat, inputLon); 
    }); 
     
      marker.setMap(map); 
    getCoords(marker, inoutLat, inputLon); 
  } 
function cargarmap(){
navigator.geolocation.getCurrentPosition(showPosition,showError);
if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(mostrarUbicacion);
	} else {alert('¡Error! Este navegador no soporta la Geolocalización.');}	
function showPosition(position)
  {
  lat=position.coords.latitude;
  lon=position.coords.longitude;
  initialize(lat,lon,\"latitud_mapa_1\",\"longitud_mapa_1\");
  }
function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML='Denegada la peticion de Geolocalización en el navegador.'
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML='La información de la localización no esta disponible.'
      break;
    case error.TIMEOUT:
      x.innerHTML='El tiempo de petición ha expirado.'
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML='Ha ocurrido un error desconocido.'
      break;
    }
  }}
  </script>";
  $concultaUbicacion="SELECT * FROM UBICACION WHERE ID_Usuario='$_SESSION[ID]'";
			$result = $conexion->query($concultaUbicacion);
			
			if ($result->num_rows == 0) {
		echo "
		<div id='ubicacion_producto' >
				<div id='ubicaciones'>
				<label> Latitud: <input type='text' class='coordEdit' name='latitud' id='latitud_mapa_1' required readonly ></label><label> Longitud: <input type='text'class='coordEdit' id='longitud_mapa_1' name='longitud' required readonly style='width: 140px;'></label>
				<label> Direcci&oacute;n: <input type='text' class='coordEdit' name='direccion' value='NF' required></label><button type='button' onclick='cargarmap()' style='margin-left: 2%;'>Ubicación Actual<br/>(GPS)</button>
				<button type='button' onclick='initialize(-0.1574824, -78.4682946,\"latitud_mapa_1\",\"longitud_mapa_1\")' style='margin-left: 2%;'>Ubicación sin GPS<br/>(GPS)</button><br/>
				</div>
				<div id='politicaDeUsoTR'>
				<p>AQUI POLITICA DE USO PARA LA APP EN TIEMPO REAL</p>
				<label>SI:<input type='radio' value='1' name='politicadeuso' required/></label>
				<label>NO:<input type='radio' value='0' name='politicadeuso' required/></label></div>
				<div id='mapas_de_google' >
					<div id='map_canvas' style='width:400px; height:400px;' ></div><br> 
				</div>
		</div>";
			}else{
				$row = $result->fetch_array(MYSQLI_ASSOC);
				echo "
		<div id='ubicacion_producto' >
				<div id='ubicaciones'>
				<label> Latitud: <input type='text' class='coordEdit' value='$row[LAT]' name='latitud' id='latitud_mapa_1' required readonly ></label><label> Longitud: <input type='text'class='coordEdit' value='$row[LONGI]' id='longitud_mapa_1' name='longitud' required readonly style='width: 140px;'></label>
				<label> Direcci&oacute;n: <input type='text' value='$row[DIR]' class='coordEdit' name='direccion' value='NF' required></label><button type='button' onclick='cargarmap()' style='margin-left: 2%;'>Ubicación Actual<br/>(GPS)</button>
				<button type='button' onclick='initialize($row[LAT], $row[LONGI],\"latitud_mapa_1\",\"longitud_mapa_1\")' style='margin-left: 2%;'>Ubicación sin GPS<br/>(GPS)</button><br/>
				</div>
				<div id='politicaDeUsoTR'>
				<p>AQUI POLITICA DE USO PARA LA APP EN TIEMPO REAL</p>
				<label>SI:<input type='radio' value='1' name='politicadeuso' required/></label>
				<label>NO:<input type='radio' value='0' name='politicadeuso' required/></label></div>
				<div id='mapas_de_google' >
					<div id='map_canvas' style='width:400px; height:400px;' ></div><br> 
				</div>
		</div>";		
			}
			echo "
		<br/><button type='submit' name='descripcion_particular' value='Enviar'>Enviar</button>
		</form>
		</div>";
		}
		/*------FIN Servicio Particular---------*/
		echo "
		
		<div class='limpiador'></div>
		</div>";
		/*-------------imagen Usuario---------------*/
		echo "
		<div class='ventana_flotante oculto' id='subirFotoUsuario'>
<form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
<input class='ingresofoto' id='nombre_foto_in' accept='image/*' name='nombre_foto_in' type='file' required onChange='ver_fotos(\"nombre_foto_in\",\"nombre_foto_out\",\"subir_imagen_Usuario\")' />
<output id='nombre_foto_out' class='usuario'></output>
</br>
<span id='subir_imagen_Usuario_mensaje'></span></br>
<input type='submit' id='subir_imagen_Usuario' name='subir_imagen_Usuario' value='Subir'/>
</form>
</div>
		";
		if($contadorimagenes==1){
			echo '<div id="popUpError"><div id="alert"><p>Informacion</p><h3>Imagen ingresada con &eacute;xito</h3><button type="button" onclick="cancelarconfiguauario(\'popUpError\')">Aceptar</button></div></div>';
			
		}
	}else{
		header("Location: ../Login/");
	}
}else{
	header("Location: ../Login/");
}
?>
<div class='ventana_flotante' id='subirFotoUsuario'></div>
		<div id='footer'>
		 <?php
                include_once "../archivosbase/php/cabeza.php";
            ?>
		</div>
	<div id='ajax-loader'>
	<img src='../archivosbase/img/ajax-loader.gif'/>
	</div>
	<div id='mensaje_javascript'><div></div></div>
    </div>
	<script>
             function ver_fotos(idin,idout,boton) {
				
                  var files = document.getElementById(idin).files; // FileList object
				var size=files[0].size;
				if(size<2000000){
					document.getElementById(idout).innerHTML = '';
					document.getElementById(boton).disabled = false;
                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
             
                    var reader = new FileReader();
             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById(idout).innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
				}else{
					document.getElementById(idout).innerHTML = '<p>Peso máximo del archivo permitido 2Mb.</p>';
					//document.getElementById('subir_imagen_Usuario_mensaje').innerHTML = 'Peso máximo del archivo permitido 2Mb.';
					document.getElementById(boton).disabled = true;
				}
              }
            
</script>
</body>
<?php
mysqli_close($conexion);
?>
</html>

