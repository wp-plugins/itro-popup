<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.

Plugin Name: ITRO Popup Plugin
Plugin URI: http://www.itro.eu/index.php/sezione-informatica/sviluppo-software/
Description: EN - Show a perfecly centered customizable popup and a popup-system for age-restricted site and allow to insert own HTML code. IT - Visualizza un popup perfettamente centrato e personalizzabile con possibile blocco per i siti con restrizioni di eta' e permette di inserire il proprio codice HTML.
Author: I.T.RO.(c) Sez. Informatica
E-mail: support.itro@live.com
Version: 3.6.3
Author URI: http://www.itro.eu/
*/

global $ITRO_VER;
$ITRO_VER = 3.62;
define('itroLocalPath', __DIR__);
define('itroPath', plugins_url() . '/itro-popup/');
define('itroImages', plugins_url() . '/itro-popup/images/');
$updir = wp_upload_dir();
define ('itroUploadUrl', $updir['baseurl'] . '/itro-upload');

include_once ('functions/core-function.php');
include_once ('functions/database-function.php');
include_once ('functions/js-function.php');
include_once ('templates/itro-popup-template.php');
include_once ('css/itro-style.php');
load_plugin_textdomain('itro-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );

register_activation_hook( __FILE__, 'itro_init' );

function itro_admin_scripts()
{
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
}

function itro_admin_styles() 
{
	wp_enqueue_style('thickbox');
}

add_action( 'init','itro_send_header' );

add_action( 'get_header','itro_style' );
add_action( 'get_header','itro_display_popup' );

add_action('admin_head', 'itro_admin_js');
add_action('admin_print_scripts', 'itro_admin_scripts');
add_action('admin_print_styles', 'itro_admin_styles');
add_action( 'admin_menu', 'itro_plugin_menu' );

?>