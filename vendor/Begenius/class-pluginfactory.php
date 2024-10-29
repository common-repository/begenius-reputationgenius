<?php

namespace Begenius;

class PluginFactory
{
  public static function create($class_name, $namespace, $plugin_dir, $plugin_url) 
  {                 
    $class_full_name = $namespace . '\\' . $class_name;
    $config = require $plugin_dir . 'config' . DIRECTORY_SEPARATOR . 'plugin.php';      
    
    return new $class_full_name($config, $plugin_url, $plugin_dir);
  }   
}