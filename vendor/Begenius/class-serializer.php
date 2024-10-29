<?php

namespace Begenius;

abstract class Serializer
{
  public static abstract function serialize($object);
      
  public static abstract function unserialize($string);
}