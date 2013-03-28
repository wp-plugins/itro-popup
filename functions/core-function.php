<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/


//------------------ADD MENU PAGE
function itro_plugin_menu() {
	add_options_page( 'Popup Plugin Options', 'ITRO Popup', 'manage_options', 'itro-popup/admin/popup-admin.php', '' );
}

//-------------- INITIALIZATION

function itro_init()
{
	//--------- initialize database
	itro_db_init();
	
	//-------- check version
	if( $GLOBALS['ITRO_VER'] != get_option('itro_curr_ver') )
	{
		$ver = get_option('itro_curr_ver');
		update_option('itro_prev_ver',$ver);
		update_option('itro_curr_ver', $GLOBALS['ITRO_VER']);
	}
	
	//---------------create preview page
	if ( get_bloginfo('language') == 'en-US') { $preview_text = 'ITRO - Preview page. This page is used to rightly diplay preview of your popup with site theme.'; }
	if ( get_bloginfo('language') == 'it_IT') { $preview_text = 'ITRO - Pagina di anteprima. Questa pagina è utilizzata per visualizzare correttamente il popup, integrato con lo stile del tema.'; }
	else {$preview_text = 'ITRO - Preview page. This page is used to rightly diplay preview of your popup with site theme.'; }
	
	if ( itro_get_option('preview_id') == NULL )
	{
		// Create post object
		$preview_post = array(
		  'post_title'    => 'ITRO - Preview',
		  'post_name'    => 'itro-preview',
		  'post_content'  => $preview_text,
		  'post_status'   => 'private',
		  'post_author'   => 1,
		  'post_type'   => 'page',
		);
		// Insert the post into the database
		$preview_id = wp_insert_post( $preview_post );
		itro_update_option('preview_id',$preview_id);
	}
	
}



//---------------------- SEND HEADER
function itro_send_header() 
{
	//set the cookie for one-time visualization
	$expiration_time = itro_get_option('cookie_time_exp') ;
	if (!isset($_COOKIE['popup_cookie'])) {
	setcookie("popup_cookie" , "one_time_popup" , time() + $expiration_time * 3600) ; }
	
	//add meta tag for IE compability
	if ( itro_get_option('ie_compability') == 'yes' )
	{ echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>'; }
}

//--------------------------DISPLAY THE POPUP
function itro_display_popup()
{
	//this condition, control if the popup must or not by displayed in a specified page
	$selected_page_id = json_decode(itro_get_option('selected_page_id'));
	$id_match = NULL;
	if( isset($selected_page_id) ) 
	{
		foreach ($selected_page_id as $single_id)
		{if ($single_id==get_the_id()) $id_match++; }
	}
	if ( is_home() && itro_get_option('blog_home') == 'yes' || itro_get_option('preview_id') == get_the_id() ) { $id_match++; }
	if( ( itro_get_option('page_selection')!='any' && !isset($_COOKIE['popup_cookie']) ) || itro_get_option('preview_id') == get_the_id())
	if( ($id_match != NULL) || (itro_get_option('page_selection')=='all') )
	{
		echo itro_popup_js();
		include( 'wp-content/plugins/itro-popup/templates/itro-popup-template.php' );
	}
}

//------------------------- SELECT PAGES FUNCTIONS
function itro_check_selected_id($id_to_check)
{
	if(itro_get_option('selected_page_id') != NULL)
	{
		$selected_page_id = json_decode(itro_get_option('selected_page_id'));
		$id_match = NULL;
		if( isset($selected_page_id) ) 
		{
			foreach ($selected_page_id as $single_id)
			{if ($single_id == $id_to_check) return (true); }
		}
	}
}

function itro_list_pages()
{?>				
	<select name="selected_page_id[]" multiple> 
	 <?php 
	  $pages = get_pages(); 
	  foreach ( $pages as $page ) 
	  {
		$option = '<option value="'. $page->ID .'"';
		if(itro_check_selected_id($page->ID)){$option .='selected="select"';} 
		$option .= '>';
		$option .= $page->post_title;
		$option .= '</option>';
		echo $option;
	  }
	 ?>
	</select>
<?php
}

//---------------REVERSE WPAUTOP
function reverse_wpautop($s)
{
    //remove any new lines already in there
    $s = str_replace("\n", "", $s);

    //remove all <p>
    $s = str_replace("<p>", "", $s);

    //replace <br /> with \n
    $s = str_replace(array("<br />", "<br>", "<br/>"), "\n", $s);

    //replace </p> with \n\n
    $s = str_replace("</p>", "\n\n", $s);       

    return $s;      
} ?>