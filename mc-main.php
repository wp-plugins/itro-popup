<?php
/*
Copyright 2013  I.T.RO.® Corp  (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.

    ITRO Popup Plugin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    ITRO Popup Plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ITRO Popup Plugin.  If not, see <http://www.gnu.org/licenses/>.

Plugin Name: ITRO Popup Plugin
Plugin URI: http://www.itro.eu/index.php/sezione-informatica/sviluppo-software/
Description: Show a customizable popup and a popup-system for age-restricted site
Author: I.T.RO.(c) Sez. Informatica
E-mail: support.itro@live.com
Version: 1.0
Author URI: http://www.itro.eu/
*/

define('mainLocalPath', __DIR__);
define('itroPath', plugins_url() . '/itro-plugin/');
include_once ('functions/admin-function.php');
include_once ('functions/core-function.php');
include_once ('functions/database-function.php');
include_once ('functions/js-function.php');
include_once ('css/itro-style.php');
load_plugin_textdomain('itro-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );

//Function that load all the scripts and the style-sheet files
function load_itro_scripts()
{
	if( !is_admin())
	{
	//wp_enqueue_style('mc-style',  itroPath.'/css/mc-style.css');
	}
}
register_activation_hook( __FILE__, 'itro_db_init' );
add_action( 'init', 'load_itro_scripts' ); //Load All Scripts
add_action( 'init', 'set_popup_cookie');
add_action('init','get_itro_style');
add_action('init','itro_db_init');
add_action('get_header','display_popup');
add_action( 'admin_menu', 'itro_plugin_menu' );