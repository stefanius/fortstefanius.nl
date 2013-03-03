<?php

$handle = opendir(PATH_CORE_CONTROLLER); 
while (false !== ($file = readdir($handle))){ 
  $extension = strtolower(substr(strrchr($file, '.'), 1)); 
  if($extension == 'php' && $file != 'core_controller.php'){ 
      require_once PATH_CORE_CONTROLLER.$file; 
  } 
}  
?>
