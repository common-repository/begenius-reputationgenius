<?php

namespace Begenius;

use Begenius\PluginOption;

class TextOption extends PluginOption
{
  public function render()
  {
    return <<<EOT
      <input type="text" id="$this->name" name="$this->name" value="$this->value" />
EOT;
  }
}