<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
*/

//-------Create plugin tables
function itro_db_init()
{
	global $wpdb;
	
	//------------------Option table
	//$option_table_name = $wpdb->prefix . "itro_plugin_option";
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_option 
	(
	option_name varchar(255),
	PRIMARY KEY(option_name),
	option_val varchar(255)
	)";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	//--------------Custom field table
	//$field_table_name = $wpdb->prefix . "itro_plugin_field";
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_field
	(
	field_name varchar(50),
	PRIMARY KEY(field_name),
	field_value TEXT
	)";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	update_option('itro_db_init','true');	
}

//------------------ PLUGIN OPTION DB MANAGEMENT -------------- 
function itro_update_option($opt_name,$opt_val)
{
	global $wpdb;
	$data_to_send = array('option_val'=> $opt_val);
	$where_line = array('option_name' => $opt_name);
	if ( !$wpdb->update( 'wp_itro_plugin_option' , $data_to_send, $where_line ) )
	{
		$wpdb->insert( 'wp_itro_plugin_option' , $where_line);
		$wpdb->update( 'wp_itro_plugin_option' , $data_to_send, $where_line );
	}
}

function itro_get_option($opt_name)
{
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wp_itro_plugin_option WHERE option_name='$opt_name'");
	foreach($result as $pippo)
	{
		$opt_val = $pippo->option_val;
	}
	return $opt_val;
}

//------------------ CUSTOM FIELD CONTENT DB MANAGEMENT -------------- 
function itro_update_field($field_name,$field_value)
{
	global $wpdb;
	$data_to_send = array('field_value'=> $field_value);
	$where_line = array('field_name' => $field_name);
	if ( !$wpdb->update( 'wp_itro_plugin_field' , $data_to_send, $where_line ) )
	{
		$wpdb->insert( 'wp_itro_plugin_field' , $where_line);
		$wpdb->update( 'wp_itro_plugin_field' , $data_to_send, $where_line );
	}
}

function itro_get_field($field_name)
{
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wp_itro_plugin_field WHERE field_name='$field_name'");
	foreach($result as $pippo)
	{
		$field_value = $pippo->field_value;
	}
	return $field_value;
}
?>