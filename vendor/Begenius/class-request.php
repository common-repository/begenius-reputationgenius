<?php

namespace Begenius;

class Request
{
  private static $_request;
  private $_request_fields = [];   
  private $_server;
  private $_has_errors = false;
  private $_errors;
  
  private function __construct($request_data)
  {
   
    foreach ($request_data as $key => $value) {
      $this->_request_fields[$key] = $value;
    }
    $this->_server = $_SERVER;        
  }
  
  public static function from_server()
  {   
    if (static::$_request === null) {
      static::$_request = new Request(array_merge(
        $_POST,
        $_GET,        
        $_FILES
      ));
    }
    return static::$_request;
  }
  
  public function get($field)
  {    
    return $this->_request_fields[$field];
  }
  
  public function is_post()
  {
    return $this->_server['REQUEST_METHOD'] === 'POST';
  }
  
  public function errors()
  {
    return $this->_errors;
  }
  
  public function has_errors()
  {
    return $this->_has_errors;
  }
  
  public function validate($rules=[])
  {    
    foreach ($rules as $field_name => $ruleset) {
      $set = explode('|', $ruleset);      
      foreach ($set as $rule) {
        $modifiers = explode(':', $rule);
        $validator = $modifiers[0];
        if (sizeof($modifiers) === 0) {
          $res = call_user_func([$this, "{$validator}_validator"], $field_name);
        } else {
          unset($modifiers[0]);                    
          $validator_method = "{$validator}_validator";        
          $param_arr = array_values(array_merge([$field_name], $modifiers));          
          $res = call_user_func_array([$this, $validator_method], $param_arr);
        }
        
        if (!$res) {
          continue;
        }
      }
    }
    
    if (count($this->_errors) > 0) {
      $this->_has_errors = true;
    }
  }
  
  protected function required_validator($field)
  {
    if (strlen($this->get($field)) === 0) {
      $this->_errors[$field][] = (object)[         
        'type' => 'required',
        'message' => __('field is required'),
      ];
      return false;
    }   
    return true;
  }
  
  protected function url_validator($field)
  {
    return esc_url($url);
  }
  
  protected function integer_validator($field, $modifier)
  {
    $field_value = $this->get($field);
    if (is_numeric($field_value)) {
      
      return true;
    }    
    $this->_errors[$field][] = (object)[
        'type' => 'integer',
        'message' => __('value is not a number'),
    ];
    
    return false;
  }
}