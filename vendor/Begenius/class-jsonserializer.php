<?php

namespace Begenius;

class JsonSerializer
{
  public static function serialize($object)
  {
    return json_encode($object);
  }
  
  public static function unserialize($serialized)
  {      
    return json_decode($serialized);
  }
}