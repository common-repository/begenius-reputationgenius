<?php

namespace Begenius;

use Begenius\PluginOption;
use Begenius\Request;

class MultipleOptions extends PluginOption
{
  
  public $values;
  
  public function __construct($name, $configuration)
  {    
    if (isset($configuration['values'])) {
      foreach ($configuration['values'] as $option_name => $config) {
        $this->values[] = PluginOptionsFactory::create($option_name, $config);
      }     
    }
    $this->name = $name;
  }    
  
  public function save()
  {
    update_option($this->name, serialize($this->values));
  }
  
  public function load()
  {    
    $values = unserialize(get_option($this->name));
     
    $new_options = [];
    
    $new_options = array_filter($this->values, function($option) use ($values, $new_options){
      foreach ($values as $value) {
        if ($option->name === $value->name) {
          return false;          
        }
      }
      return true;      
    });
    
   
    if ($values) {            
      $this->values = array_values( array_merge( $values, $new_options ) );
    }
    
   
    return $this;
  }
  
  public function get($by_name)
  {
    foreach ($this->values as $value) {
      if ($value->name === $by_name) {
        return $value;
      }
    }
    return null;
  }
  
  public function from_request(Request $request)
  {
    foreach ($this->values as $option) {
      $option->value = $request->get($option->name);
    }
  }
    
  
  public function create()
  {        
    add_option($this->name, serialize($this->values));
  }
  
  public function render()
  {    
    foreach ($this->values as $option) {
      return $option->render();
    }   
  }
}