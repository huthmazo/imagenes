  <?php

    require('clases/upload.php');
    ?>
<!DOCTYPE html>
<html>
  
<head>
	<title></title>
</head>
<body>
	<form enctype="multipart/form-data" method="post" action="upload.php">
		    <input type="file" name="file[]" multiple>
            <input type="submit" name="submit">
	</form> 
	<table style="border:1px solid black">
	    <tr style="border:1px solid black">
	        
	        <?php
	            $ficheros=scandir('/home/ubuntu/imagenes/');
	            for($i=0;$i<count($ficheros);$i++){
	                
	                $tmp=explode('.',$ficheros[$i]);
	                $nombreAlumno='';
	                $extension=$tmp[count($tmp)-1];
	                for($a=0;$a<count($tmp)-1;$a++){
	                    $nombreAlumno=$nombreAlumno.$tmp[$a];
	                }
	                if($extension=="jpg" || $extension=="jpeg" || $extension=="png"){
	                    $imagenValida[$i]=$ficheros[$i];
	                    $base="/home/ubuntu/imagenes/";
	                    $ruta=$base.$ficheros[$i];
        	            $imgData=base64_encode(file_get_contents($ruta));
        	            $src='data: '.mime_content_type($ruta).';base64,'.$imgData;
        	            ?>
        	                <img src="<?= $src ?>" style="width: 30%; heigth:200px;">Alumno: <?= $nombreAlumno ?></img>
        	            <?php
	                }
	            }
	            
	            
	        ?>
	        
	    
	        
	    </tr>
	    <tr style="border:1px solid black">
	    </tr>
	</table>
 
</body>
</html>
