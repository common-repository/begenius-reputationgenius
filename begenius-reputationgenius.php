<?php
/*
  Plugin Name: Begenius Reputationgenius
  Plugin URI: http://admin.reputationgenius.it
  Description: This plugin seamlessly integrates your customer reviews into your WordPress site.
  Author: Begenius
  Version: 1.1.3
  Author URI: http://www.begenius.it
  Text Domain: bgrg
  Domain Path: /languages
  Licence : GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
  Copyright : Copyright (C) 2017 Begenius s.r.l. (http://www.begenius.it). All rights reserved.
 */
// Prohibit direct script loading
defined('ABSPATH') || die('No direct script access allowed!');

use Begenius\PluginFactory;

register_activation_hook(__FILE__, 'bgrg_reputationgenius_install');
register_uninstall_hook( __FILE__, 'bgrg_reputationgenius_uninstall' );

add_action('admin_menu', 'bgrg_reputationgenius_menu');
add_shortcode('rg_comments', 'bgrg_comments');
add_action('init', 'bgrg_reputationgenius_load_textdomain');



function bgrg_reputationgenius_load_textdomain() { 
  $plugin_dir = plugin_dir_path( __FILE__ );  
  require_once($plugin_dir . DIRECTORY_SEPARATOR . 'init' . DIRECTORY_SEPARATOR . 'init.php');  
  
  remove_all_filters('override_load_textdomain');
  load_plugin_textdomain( 'bgrg', false, basename( dirname( __FILE__ ) ) . '/languages/' );  
  add_filter('override_load_textdomain', function(){
    return true;
  });
}



function bgrg_comments() {

  $plugin = bgrg_plugin_factory('Reputationgenius', 'Reputationgenius');

  $tracking_url = $plugin->config('tracking_url');

  $plugin->options('rss_feed_url')->load();
  $rss_feed_url = $plugin->options('rss_feed_url')->value;
 
  $uri_parts = explode('/', $rss_feed_url);
  $slug = $uri_parts[count($uri_parts) - 1];
  $tracking_url = str_replace('{slug}', $slug, $tracking_url);
  $tracking_check_url = str_replace('{slug}', $slug, $plugin->config('tracking_check_url'));

  // Il tracking usa lo script distribuito
  // e dal reputationgenius e il medesimo endpoint
  wp_enqueue_script('bg-tracking', $tracking_url);
  wp_enqueue_script('bg-tracking-script', $plugin->config('tracking_script_url'));
  wp_localize_script('bg-tracking-script', 'bg_rg_config', [
    'tracking_url' => $tracking_url,
    'tracking_check_url' => $tracking_check_url,
    'wp_lang' => substr(get_locale(), 0, 2),
    'rev_btn_selector' => $plugin->config('rev_btn_selector'),
    'client_uuid' => wp_generate_uuid4(),
  ]);

  $plugin->render_comments();
}

function bgrg_plugin_factory($name, $namespace) {  
  $plugin_url = plugin_dir_url( __FILE__ ) .  DIRECTORY_SEPARATOR;
  $plugin_dir = plugin_dir_path( __FILE__ )  . DIRECTORY_SEPARATOR;
  require_once($plugin_dir . DIRECTORY_SEPARATOR . 'init' . DIRECTORY_SEPARATOR . 'init.php');
  return PluginFactory::create($name, $namespace, $plugin_dir, $plugin_url);
}

function bgrg_reputationgenius_menu() { 
  bgrg_plugin_factory('Reputationgenius', 'Reputationgenius');
}


function bgrg_reputationgenius_install () {    
  $plugin = bgrg_plugin_factory('Reputationgenius', 'Reputationgenius');
  
  foreach ($plugin->options() as $option) {
    $option->create();
  }
}

function bgrg_reputationgenius_uninstall() {
  
  $plugin = bgrg_plugin_factory('Reputationgenius', 'Reputationgenius');
  
  foreach ($plugin->options() as $option) {
    $option->delete();
  }
}
