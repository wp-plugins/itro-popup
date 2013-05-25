<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
*/

//-------Create plugin tables
function itro_db_init()
{
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	
	//------------------Option table
	//$option_table_name = $wpdb->prefix . "itro_plugin_option";
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_option 
	(
	option_name varchar(255),
	PRIMARY KEY(option_name),
	option_val varchar(255)
	)";
	mysqli_query($con, $sql);
	
	//--------------Custom field table
	//$field_table_name = $wpdb->prefix . "itro_plugin_field";
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_field
	(
	field_name varchar(50),
	PRIMARY KEY(field_name),
	field_value TEXT
	)";
	mysqli_query($con, $sql);
	
	update_option('itro_db_init','true');	
}

//------------------ PLUGIN OPTION DB MANAGEMENT -------------- 
function itro_update_option($opt_name,$opt_value)
{
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "DELETE FROM wp_itro_plugin_option WHERE option_name='$opt_name'";
	mysqli_query($con, $sql);
	$sql = "INSERT INTO wp_itro_plugin_option (option_name, option_val) VALUES ('$opt_name', '$opt_value')";
	mysqli_query($con, $sql);
}

function itro_get_option($opt_name)
{
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "SELECT * FROM wp_itro_plugin_option WHERE option_name='$opt_name'";
	$result = mysqli_query($con, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return ($row['option_val']);
	}
	else return(NULL);
}

//------------------ CUSTOM FIELD CONTENT DB MANAGEMENT -------------- 
function itro_update_field($field_name,$field_value)
{
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "DELETE FROM wp_itro_plugin_field WHERE field_name='$field_name'";
	mysqli_query($con, $sql);
	$sql = "INSERT INTO wp_itro_plugin_field (field_name, field_value) VALUES ('$field_name', '$field_value')";
	mysqli_query($con, $sql);
}

function itro_get_field($field_name)
{
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "SELECT * FROM wp_itro_plugin_field WHERE field_name='$field_name'";
	$result = mysqli_query($con, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return ($row['field_value']);
	}
	else return(NULL);
}
?>