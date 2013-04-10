<?php
//uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {exit ();}
else
{
	include_once ('functions/database-function.php');
	if( itro_get_option('delete_data') == 'yes' )
	{
		$preview_id = itro_get_option('preview_id'); //delete preview page
		wp_delete_post( $preview_id , true );
		
		delete_option('itro_curr_ver');
		delete_option('itro_prev_ver');
		delete_option('delete_data');
		
		$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
		if (!$con){die('Could not connect: ' . mysql_error());}
		mysql_select_db(DB_NAME);
		
		mysql_query('DROP TABLE wp_itro_plugin_option');
		mysql_query('DROP TABLE wp_itro_plugin_field');
	}
}
?>