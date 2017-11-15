<?php
	include "../archivosbase/conexion.php";
	$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
	if ($conexion->connect_error) {
	 die("La conexion fall?: " . $conexion->connect_error);
	}
	$carpetaDestino='ImagenTag/';
		$extension = end(explode(".", $_FILES['nombre_foto_in']['name']));
		$nombrearchivo=$_FILES['nombre_foto_in']['name'];
		if($_FILES["nombre_foto_in"]["type"]=="image/jpeg" || $_FILES["nombre_foto_in"]["type"]=="image/pjpeg" || $_FILES["nombre_foto_in"]["type"]=="image/gif" || $_FILES["nombre_foto_in"]["type"]=="image/png")
        {
                $origen=$_FILES["nombre_foto_in"]["tmp_name"];
                $destino=$carpetaDestino.$nombrearchivo;
                # movemos el archivo
                if(@move_uploaded_file($origen, $destino))
                {
                    $link="Login/$destino";
                    
                    $tipoarchivo=$_FILES["nombre_foto_in"]["type"];
                        $query = "INSERT INTO ImgTagPrincipal ( Link ) VALUES ('$link')";
                    if ($conexion->query($query) === TRUE) 
                    {
           
                        $extension2='.png';
                        $red='red.png';
                        $strRed='_red.png';
                    
                        $nombreArchivo=explode(".",$_FILES['nombre_foto_in']['name']);
                        
                        $image_1=imagecreatefrompng($carpetaDestino.$red);
                        $image_2=imagecreatefrompng($destino);                        
                        imagealphablending($image_1,true);
                        imagesavealpha($image_1,true);
                        imagecopy($image_1,$image_2,0,0,0,0,286,328);
                        $des=$carpetaDestino.$nombreArchivo[0].$strRed;
                        imagepng($image_1,$des);


                        
                        $green='green.png';
                        $strGreen='_green.png';
                    
                        
                        $image_3=imagecreatefrompng($carpetaDestino.$green);
                        $image_4=imagecreatefrompng($destino);                        
                        imagealphablending($image_3,true);
                        imagesavealpha($image_3,true);
                        imagecopy($image_3,$image_4,0,0,0,0,286,328);
                        $des=$carpetaDestino.$nombreArchivo[0].$strGreen;
                        imagepng($image_3,$des);



                        echo "Imagen Cargada con Exito";
                    }
                    else
                    {
                        echo 'Error al subir la imagen';
                    }
                }
                else
                {
                    echo 'Error al mover la imagen';
                }
        }else
        {
	        echo 'La imagen no es del tipo aceptado';
        }
?>