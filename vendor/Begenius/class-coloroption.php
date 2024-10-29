<?php

namespace Begenius;

use Begenius\PluginOption;

class ColorOption extends PluginOption
{
  public function __construct($name, $configuration) 
  {
    wp_enqueue_script('begenius-pitpik-colorpicker', plugin_dir_url( __DIR__ ) . 'PitPik' . DIRECTORY_SEPARATOR . 'jqColorPicker.min.js');    
    return parent::__construct($name, $configuration);
  }
  
  public function render()
  {    
    return <<<EOT
      <input type="text" id="$this->name" name="$this->name" value="$this->value" />
      <script>
        jQuery( document ).ready( function(){
           jQuery("#{$this->name}").colorPicker({
             });
        });
      </script>
EOT;
  }
}