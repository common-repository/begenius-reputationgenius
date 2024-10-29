<?php

namespace Begenius;

abstract class DynamicCss
{
  protected $id;
  protected $plugin;
  
  public function __construct($plugin)
  {
    $this->plugin = $plugin;
  }
  
  protected abstract function content();
  
  public function render()
  {   
    echo '<style id="'.$this->id.'" type="text/css">' . $this->content() . '</style>';
  }
    
 
}