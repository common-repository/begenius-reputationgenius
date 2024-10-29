<?php

if (!function_exists('bgrg_reputationgenius_autoloader')) {
  function bgrg_reputationgenius_autoloader( $class_name ) {

    $class_name_parts = explode('\\', $class_name);
    
    if (isset($class_name_parts[0])) {    
    
      switch ($class_name_parts[0]) {
        case 'Begenius':          
          $name = substr(strrchr($class_name, '\\'), 1);
          $class_file = 'class-' . strtolower(str_replace( '_', '-', $name )) . '.php';
          $class_namespace = str_replace('\\', '/', str_replace($name, $class_file, $class_name));
          $classes_dir = realpath( plugin_dir_path( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR;
          if (file_exists($classes_dir . $class_namespace)) {
            require_once $classes_dir . $class_namespace;
          }
          break;
        case 'Reputationgenius':        
          $name = substr(strrchr($class_name, '\\'), 1);
          $class_path = str_replace('\\', '/', substr($class_name, 0, -strlen($name)));

          $class_file = 'class-' . strtolower(str_replace( '_', '-', $name )) . '.php';
          $class_location = $class_path . $class_file;                
          $classes_dir = realpath( plugin_dir_path( __DIR__ ) ) . DIRECTORY_SEPARATOR;
        
          require_once $classes_dir . $class_location;
          break;
      }    
    }  
  }
}

spl_autoload_register( 'bgrg_reputationgenius_autoloader' );