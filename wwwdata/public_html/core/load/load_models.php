<?php

$handle = opendir(PATH_CORE_MODEL); 
while (false !== ($file = readdir($handle))){ 
  $extension = strtolower(substr(strrchr($file, '.'), 1)); 
  if($extension == 'php' && $file != 'core_model.php'){ 
      require_once PATH_CORE_MODEL.$file; 
  } 
}  

?>
