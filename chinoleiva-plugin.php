<?php
/*
Plugin Name: Chino Leiva Plugin
Plugin URI: http://imgdigital.com.ar/portfolio/projects/chinoleiva/
Description: Este es un Plug-in para el sitio de Chino Leiva
Version: 0.1.2
Author: Federico Reinoso
Author URI: http://imgdigital.com.ar
Text Domain: imgd
Domain Path: languages/
Plugin Type: Piklist
License: GPL2
*/

define( 'IMGD_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );

//echo IMGD_PLUGIN_PATH;
/**
 * Check if Piklist is activated and installed
 */
add_action('init', 'imgd_init_function');
function imgd_init_function()
{
    if(is_admin())
    {
        include_once(plugin_dir_path(__FILE__).'class-piklist-checker.php');

        if (!piklist_checker::check(__FILE__))
        {
            return;
        }
    }
}

/**
 * Loading Translation
 */
function imgd_plugin_init() {
    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    //echo '<h1>'.$plugin_dir.'</h1>';
    load_plugin_textdomain( 'imgd', false, $plugin_dir );
}
add_action('plugins_loaded', 'imgd_plugin_init');




function imgd_setting_pages($pages)
{
    $pages[] = array(
        'page_title' => __('Chino Leiva Page Settings','imgd')
    ,'menu_title' => __('Chino Leiva Page', 'imgd')
    ,'capability' => 'manage_options'
    ,'menu_slug' => 'chinoleiva_settings'
    ,'setting' => 'chinoleiva_settings'
    ,'menu_icon' => 'dashicons-camera'
    ,'page_icon' => 'dashicons-camera'
        ,'position'=> '59'
    ,'default_tab' => 'Home'

    ,'save_text' => __('Save Settings','imgd')
    );

    return $pages;
}

add_filter('piklist_admin_pages', 'imgd_setting_pages');
/**
 * Load IMGD Framework compatibility file.
 */
require plugin_dir_path(__FILE__).'/inc/imgd_functions.php';

//imgd_setting_css();

/**
 * Load IMGD Framework compatibility file.
 */
//require plugin_dir_path(__FILE__).'/inc/imgd_slider.php';


/**
 * Load IMGD Framework compatibility file.
 */
//require plugin_dir_path(__FILE__).'/inc/imgd_sort_columns.php';