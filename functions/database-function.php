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
*/
mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
function itro_db_init()
{
	$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	if (!$con){die('Could not connect: ' . mysql_error());}

//-------Create plugin tables
	mysql_select_db(DB_NAME, $con);
	
	//------------------Option table
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_option 
	(
	option_name varchar(255),
	PRIMARY KEY(option_name),
	option_val varchar(255)
	)";
	mysql_query($sql,$con);
	
	//--------------Custom field table
	$sql = "CREATE TABLE IF NOT EXISTS wp_itro_plugin_field
	(
	field_name varchar(50),
	PRIMARY KEY(field_name),
	field_value TEXT
	)";
	mysql_query($sql,$con);
	
	update_option('itro_db_init','true');	
}

//------------------ PLUGIN OPTION DB MANAGEMENT -------------- 
function itro_update_option($opt_name,$opt_value)
{
	mysql_query("DELETE FROM wp_itro_plugin_option WHERE option_name='$opt_name'");
	mysql_query("INSERT INTO wp_itro_plugin_option (option_name, option_val) VALUES ('$opt_name', '$opt_value')");
}

function itro_get_option($opt_name)
{
	$result=mysql_query("SELECT * FROM wp_itro_plugin_option WHERE option_name='$opt_name'");
	if($result)
	{
		$row = mysql_fetch_array($result);
		return ($row['option_val']);
	}
	else return(NULL);
}

//------------------ CUSTOM FIELD CONTENT DB MANAGEMENT -------------- 
function itro_update_field($field_name,$field_value)
{
	mysql_query("DELETE FROM wp_itro_plugin_field WHERE field_name='$field_name'");
	mysql_query("INSERT INTO wp_itro_plugin_field (field_name, field_value) VALUES ('$field_name', '$field_value')");
}

function itro_get_field($field_name)
{
	$result=mysql_query("SELECT * FROM wp_itro_plugin_field WHERE field_name='$field_name'");
	if($result)
	{
		$row = mysql_fetch_array($result);
		return ($row['field_value']);
	}
	else return(NULL);
}
?>