<?php

namespace Begenius;

use Begenius\PluginOptionsFactory;
use Begenius\PluginOption;

abstract class Plugin
{
  protected $_plugin_dir;
  protected $_plugin_url;
  protected $_name;
  protected $_options;
  protected $_config;

  public function __construct($config, $plugin_url, $plugin_dir)
  {        
    $this->_plugin_url = $plugin_url;
    $this->_plugin_dir = $plugin_dir;
    
    $this->_name = $config['plugin_name'];
    
    if (isset($config['config'])) {
      $this->_config = $config['config'];
    }

    if (isset($config['menu_page'])) {     
      $this->add_menu_page(
        $config['menu_page']['page_title'],
        $config['menu_page']['menu_title'],
        $config['menu_page']['capability'],
        $config['menu_page']['menu_slug'],
        $config['menu_page']['icon'],        
        $config['menu_page']['position']
      );
    }
    
    if (isset($config['options'])) {
      foreach ($config['options'] as $name => $option_config) {     
        $this->_options[$name] = PluginOptionsFactory::create($name, $option_config);
      }
      
    }    
  }
  
  abstract function options_page();
  
  public function dir()
  {
    return $this->_plugin_dir;
  }
  
  public function url()
  {
    return $this->_plugin_url;
  }
  
  public function config($key='')
  {
    if (strlen($key) === 0) {
      return $this->_config;
    }

    return $this->_config[$key];
  }

  public function name()
  {    
    return $this->_name;
  }
  
  public function unset_option($option_name='')
  {
    unset($this->_options[$option_name]);
  }
  
  public function options($option_name='')
  {
    if (strlen($option_name) > 0) {    
      return $this->_options[$option_name];
    }
    return $this->_options;
  }
  
  public function add_option(PluginOption $option)
  {
    $this->_options[$option->name] = $option;   
  }    
  
  public function add_menu_page($page_title, $menu_title, $capability, $menu_slug, $icon, $function='', $position=null)
  {   
    if (isset($icon['type'])) {
      if ($icon['type'] === 'icon') {
        $icon_url = $icon['name'];
      } elseif($icon['type'] === 'url') {
        $icon_url = $this->_plugin_dir  . DIRECTORY_SEPARATOR . $icon_url;
      }    
    } else {
      $icon_url = '';
    }
    
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, [$this, 'options_page'], $icon_url, $position);    
  }      
}