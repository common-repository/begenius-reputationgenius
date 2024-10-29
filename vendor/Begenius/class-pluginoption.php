<?php

namespace Begenius;

abstract class PluginOption
{
  public $name;
  public $value;  
  public $title;
  public $type;
  public $required;
  public $hidden;
   
  
  public function __construct($name, $configuration)
  {     
    $this->name = $name;    
    foreach ($configuration as $key => $value) {
      $this->$key = $value;      
    }
    if (isset($configuration['value'])) {
      $this->value = $configuration['value'];
    }
    
    if (!isset($configuration['hidden'])) {
      $this->hidden = false;
    }
  }
  
  public function create()
  {            
    add_option($this->name, $this->value);    
  }
  
  public function save()
  {      
    update_option($this->name, $this->value);
  }
  
  public function load()
  {
    $this->value = get_option($this->name);
    return $this;
  }
  
  public function delete()
  {
    delete_option($this->name);
  }
  
  abstract public function render();
}