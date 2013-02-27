<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
	
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {exit ();}

$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
if (!$con){die('Could not connect: ' . mysql_error());}

mysql_query("DROP TABLE IF EXIST wp_itro_plugin_option;");
mysql_query("DROP TABLE IF EXIST wp_itro_plugin_field;");

?>