<?php

//echo '<pre>' . var_export($_FILES, true) . '</pre>';
//echo '<pre>' . var_export($_POST, true) . '</pre>';

require('clases/upload.php');
var_export($_FILES['file']['name'][0]);
echo '<br>';
$archivo = new Upload($_FILES['file']);
//$archivo->setPolicy(Upload::POLICY_RENAME);
//$r = $archivo->upload();
//echo '<pre>' . var_export($r, true) . '</pre>';


