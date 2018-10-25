<?php

require('clases/upload.php');
echo '<hr>';
$archivo = new Upload($_FILES['file']);
header('location: imagenMain.php');
