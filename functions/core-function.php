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
	switch(WPLANG)
	{
		case 'en_US':
			$preview_text = 'ITRO - Preview page. This page is used to rightly display preview of your popup with site theme.';
			break;
		case 'it_IT':
			$preview_text = 'ITRO - Pagina di anteprima. Questa pagina &egrave; utilizzata per visualizzare correttamente il popup, integrato con lo stile del tema.';
			break;
		default:
			$preview_text = 'ITRO - Preview page. This page is used to rightly diplay preview of your popup with site theme.';
	}
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
	
	//-----load sample popup settings
	if( get_option("itro_curr_ver") == NULL )
	{
		itro_update_option('popup_time',20);
		itro_update_option('cookie_time_exp',6);
		itro_update_option('popup_background','#FFFFFF');
		itro_update_option('popup_border_color','#F7FF00');
		itro_update_option('px_popup_width',300);
		itro_update_option('px_popup_height',0);
		itro_update_option('show_countdown','yes');
		itro_update_option('auto_margin_check','yes');
		itro_update_option('select_popup_width','px');
		itro_update_option('select_popup_height','auto');
		itro_update_option('popup_bg_opacity',0.4);
		itro_update_option('opaco_bg_color','#8A8A8A');
		itro_update_option('popup_position','fixed');
		
		switch(WPLANG)
		{
			case 'en_US':
			$welcome_text = '<h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">Hello, this is a pop-up sample.</span></h1><h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">The basic stetting to get started are: Popup height, Popup time, Next visualization, Popup border color, Popup background.</span></h1><h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">Write watever you want in the Custom text editor and enjoy our plugin!</span></h1><p>&nbsp;</p>';
				break;
			case 'it_IT':
			$welcome_text = '<p style="text-align: center;"><span style="color: #000000; font-size: 20;">Salve, questo &egrave; un esempio di popup.</span></p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;"><span style="color: #000000; font-size: 20;">Le impostazioni base per iniziare sono: Altezza popup, Tempo popup, Prossima visualizzazione, Colore bordo, Colore sfondo.</span></p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;"><span style="color: #000000; font-size: 20;">Scrivi qualunque cosa vuoi nell&#39;editor di testo di wordpress e buon lavoro!</span></p><p style="text-align: center;">&nbsp;</p>';
				break;
			default:
				$welcome_text = '<h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">Hello, this is a pop-up sample.</span></h1><h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">The basic stetting to get started are: Popup height, Popup time, Next visualization, Popup border color, Popup background.</span></h1><h1 style="text-align: center;"><span style="color: #000000; font-size: 20;">Write watever you want in the Custom text editor and enjoy our plugin!</span></h1><p>&nbsp;</p>';
		}
		itro_update_field('custom_html',$welcome_text);
		
		itro_update_option('sample_popup','done');
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
		echo itro_popup_template();
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
}?>