<?php

namespace Reputationgenius;

use Begenius\Plugin;
use Begenius\Request;
use Begenius\JsonSerializer;
use Begenius\XmlSerializer;
use Reputationgenius\Comment;

class Reputationgenius extends Plugin
{ 
  public function options_page()
  {  
    $plugin = $this; 
    
    $request = Request::from_server();
    
    $errors = [];

    if ($request->is_post()) {
      
      $request->validate([
          'rss_feed_url' => 'required|url',
          'comments_cache_expiration' => 'required|integer:positive',          
      ]);            
      
      $this->options('rss_feed_url')->value = $request->get('rss_feed_url');
      $this->options('comments_cache_expiration')->value = $request->get('comments_cache_expiration');
      $this->options('feed_type')->value = $request->get('feed_type');
      $this->options('comments_template')->value = $request->get('comments_template');
      
      $this->options('paper_color')->value = $request->get('paper_color');
      $this->options('stars_color')->value = $request->get('stars_color');
      $this->options('stars_hidden_color')->value = $request->get('stars_hidden_color');
      $this->options('text_color')->value = $request->get('text_color');
      $this->options('paper_border_color')->value = $request->get('paper_border_color');
      $this->options('landing_page_url')->value = $request->get('landing_page_url');
     
      if ($request->has_errors()) {         
        $errors = $request->errors();
      } else {
        
        foreach ($this->options() as $option) {           
          $option->save();         
        }
        
        $this->download_and_save_comments();
      }     
    } else {
            
      $this->options('rss_feed_url')->load();
      $this->options('comments_cache_expiration')->load();
      $this->options('feed_type')->load();
      
      $this->options('latest_comments_download')->load();      
      $this->options('text_color')->load();
      $this->options('stars_color')->load();
      $this->options('stars_hidden_color')->load();
      $this->options('paper_color')->load();
      $this->options('paper_border_color')->load();
      $this->options('landing_page_url')->load();
    }
           
    $comments = $this->fill_comments(
      $this->download_and_save_comments()
    );
    
    require_once($this->_plugin_dir . 'views' . DIRECTORY_SEPARATOR . 'options_page.php');         
  }
  
  protected function unserialize_comments($serialized_comments)
  {
     
    if ($this->options('feed_type')->value === 'xml') {      
      $comments = XmlSerializer::unserialize($serialized_comments);      
    } else {
      $comments = JsonSerializer::unserialize($serialized_comments);      
    }
    
    return $comments;
  }
  
  protected function fill_comments($raw_data)
  {
    $comments = [];
 
    foreach ($raw_data->reviews as $reviews) {

      foreach ($reviews as $review) {       
        $comments[] = new Comment($review);
      }
    }
    return $comments;
  }

  protected function download_and_save_comments()
  {
    $lang = substr(get_locale(), 0, 2);
    $this->options('rss_feed_url')->load();
    
    $comments =  file_get_contents($this->options('rss_feed_url')->value . DIRECTORY_SEPARATOR . $lang);
    if ($comments === false) {
      $error = error_get_last();
      echo 'Error while connecting to: ' . $this->options('rss_feed_url')->value;
      echo PHP_EOL;
      echo $error['message'];
      
    }
    $this->options('latest_comments_download')->value = date('Y-m-d H:i:s');
    $this->options('latest_comments_download')->save();
    set_transient('reputationgenius_comments_' . $lang, $comments, $this->options('comments_cache_expiration')->value);
    
    $comments_generic =  file_get_contents($this->options('rss_feed_url')->value);      
    set_transient('reputationgenius_comments_generic', $comments, $this->options('comments_cache_expiration')->value);
   
    if (strlen($comments) === 0) {                   
      return $this->unserialize_comments($comments_generic);
    }
    return $this->unserialize_comments($comments);
  }
  
  public function render_comments()
  { 
    $this->options('feed_type')->load();
    
    $plugin = $this;
    
    $lang = substr(get_locale(), 0, 2);
   
    $serialized_comments = get_transient('reputationgenius_comments_'.$lang);
      
    if (strlen($serialized_comments) === 0) {
      $raw_comments =  $this->download_and_save_comments();
    } else {    
      $raw_comments = $this->unserialize_comments($serialized_comments);
    }
    
    $comments = $this->fill_comments($raw_comments);

    $this->options('text_color')->load();
    $this->options('stars_color')->load();
    
    $this->options('stars_hidden_color')->load();
    $this->options('paper_color')->load();
    $this->options('paper_border_color')->load();
    $this->options('landing_page_url')->load();
    $this->options('comments_template')->load();
    
    $template_name = $this->options('comments_template')->value;  
    require_once($this->_plugin_dir . 'views' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template_name . '.php');         
  }
 
}