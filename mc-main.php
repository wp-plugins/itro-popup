<?php
/*
Copyright 2013  I.T.RO.� (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.

Plugin Name: ITRO Popup Plugin
Plugin URI: http://www.itro.eu/index.php/sezione-informatica/sviluppo-software/
Description: EN - Show a perfecly centered customizable popup and a popup-system for age-restricted site and allow to insert own HTML code. IT- Visualizza un popup perfettamente centrato e personalizzabile con possibile blocco per i siti con restrizioni di et� e permette di inserire il proprio codice HTML.
Author: I.T.RO.(c) Sez. Informatica
E-mail: support.itro@live.com
Version: 3.1
Author URI: http://www.itro.eu/
*/

define('mainLocalPath', __DIR__);
define('itroPath', plugins_url() . '/itro-popup/');
include_once ('functions/admin-function.php');
include_once ('functions/core-function.php');
include_once ('functions/database-function.php');
include_once ('functions/js-function.php');
include_once ('css/itro-style.php');
load_plugin_textdomain('itro-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );

//Function which load all the scripts and the style-sheet files

register_activation_hook( __FILE__, 'itro_db_init' );
add_action('init','itro_send_header');
add_action('init','itro_db_init');

add_action('get_header','itro_style');
add_action('get_header','itro_display_popup');
add_action( 'get_header', 'itro_popup_js' );

add_action( 'admin_head', 'itro_admin_style' );
add_action( 'admin_menu', 'itro_plugin_menu' );