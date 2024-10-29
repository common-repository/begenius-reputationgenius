<?php

namespace Begenius;

use Begenius\BG_PluginOption;

class DropdownOption extends PluginOption
{
  public $values;
  
  public function __construct($name, $configuration)
  {
    if (isset($configuration['values'])) {
      $this->values = $configuration['values'];
    }
    
    return parent::__construct($name, $configuration);
    
  }
  public function render()
  {
    $options = '';
    foreach ($this->values as $value => $text) {
      $selected = $this->value == $value ? 'selected="selected"' : '';      
      $options .= '<option value="'.$value.'" '.$selected.'>'.__($text).'</option>';
    }
    
    return <<<EOT
      <select name="$this->name" id="$this->name" >
        $options
      </select>
EOT;
  }
}