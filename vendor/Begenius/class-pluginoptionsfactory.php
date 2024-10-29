<?php

namespace Begenius;

use Begenius\TextOption;
use Begenius\DropdownOption;
use Begenius\MultipleOptions;
use Begenius\LongTextOption;
use Begenius\ColorOption;

class PluginOptionsFactory
{
  const TEXT='text';
  const LONGTEXT='longtext';
  const DROPDOWN='dropdown';
  const MULTIPLE='multiple';
  const COLOR='color';
  
  public static function create($name, $configuration)
  {
    $type = $configuration['type'];
      
    switch($type) {
      case self::TEXT:       
        return new TextOption($name, $configuration);       
      case self::LONGTEXT:
        return new LongTextOption($name, $configuration);     
      case self::DROPDOWN:
        return new DropdownOption($name, $configuration);      
      case self::MULTIPLE:
        return new MultipleOptions($name, $configuration); 
      case self::COLOR:
        return new ColorOption($name, $configuration);
    }
  }
}