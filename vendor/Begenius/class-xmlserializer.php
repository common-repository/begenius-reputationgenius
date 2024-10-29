<?php

namespace Begenius;

use Begenius\Serializer;

class XmlSerializer extends Serializer
{
  public static function serialize($object)
  {
    
  }
  
  public static function unserialize($string)
  {
    return simplexml_load_string($string);
  }            
}