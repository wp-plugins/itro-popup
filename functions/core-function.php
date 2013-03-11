<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/

//---------------------- SEND HEADER
function itro_send_header() 
{
	//set the cookie for one-time visualization
	$expiration_time = itro_get_option('cookie_time_exp') ;
	setcookie("popup_cookie" , "one_time_popup" , time() + $expiration_time * 3600) ;
	
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
	if(itro_get_option('page_selection')!='any' && !isset($_COOKIE['popup_cookie']) )
	if( ($id_match != NULL) || (itro_get_option('page_selection')=='all') )
	{ 
		echo include( 'wp-content/plugins/itro-popup/templates/itro-popup-template.php' );
	} 
}

//--------------------------------FILE UPLOADER FOR POPUP IMAGE
function itro_image_uploader() 
{
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["size"] > 2048000){echo'<script>alert("'; _e('Warning file is too big, this may cause problems!','itro-plugin'); echo'");</script>';}
		if ($_FILES["file"]["error"] > 0){ echo "Error Code: " . $_FILES["file"]["error"] . "<br>"; }
		else
		{
			if(!isset($_POST['overwrite'])){$_POST['overwrite']='no';}
			if (file_exists(mainLocalPath . "/uploaded-images/" . $_FILES["file"]["name"]) && $_POST['overwrite']!='yes')
			{ echo '<b style="color: red;">"' . $_FILES["file"]["name"] ; _e('" already exists. Please check the overwrite option','itro-prugin'); echo '</b><br><br>'; }
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				mainLocalPath . "/uploaded-images/" . $_FILES["file"]["name"]);
				$img_source = itroPath . "uploaded-images/" . $_FILES["file"]["name"];
				echo '<b style="color: green;">"' . $_FILES["file"]["name"]; _e('" successfully uploaded'); echo '"</b><br>Image link: ' . $img_source . '<br><br>' ;
				itro_update_option('img_source',$img_source);
				itro_update_option('selected_image',$_FILES["file"]["name"]);
			}
		}
	}
	else
	{
		echo "Invalid file";
	}
}

//------------------- IMAGES MANAGER
//image listing
function itro_image_list($img)
{	
	if($handle = opendir(mainLocalPath . '/uploaded-images'))
	{
		if ($img == 'ins') 
		{$selected_img = itro_get_option('selected_image');} 
		else 
		{$selected_img = itro_get_option('bg_selected_image');}
		
		echo '<option></option>';
		while (false !== ($entry = readdir($handle))) 
		{
			if ($entry != "." && $entry != "..")
			{
				if($entry === $selected_img){echo '<option selected="select">' . $entry . '</option>';}
				else { echo '<option>' . $entry . '</option>'; }
			}
		}
	}
	closedir($handle);
}

function itro_image_manager()
{
	//----select inserted image
	if( empty($_POST['selected_image']) && !isset($_POST[ 'img_url_check']) )
	{
		itro_update_option('img_source' , NULL);
		itro_update_option('selected_image' , NULL);
		echo '<b style="color:red;">';
		_e('Any image selected','itro-plugin'); 
		echo '</b><br>';
		
	} 
	else 
	{
		if ( !empty($_POST['selected_image']) )
		{
			itro_update_option('img_source', itroPath . "uploaded-images/" . $_POST['selected_image']);
			itro_update_option('selected_image',$_POST['selected_image']);
			echo '<b style="color:green;">"';
			echo $_POST['selected_image'] . '"'; _e(' added in popup','itro-plugin');
			echo '</b><br>';
		}
	}
	//--select background image
	if( empty($_POST['bg_selected_image']) && !isset($_POST[ 'bg_url_check']) )
	{
		itro_update_option('background_source' , NULL);
		itro_update_option('bg_selected_image' , NULL);
		echo '<b style="color:red;">';
		_e('Any background image used','itro-plugin');
		echo '</b><br>';
	} 
	else 
	{
		if ( !empty($_POST['bg_selected_image']) )
		{
			itro_update_option('background_source', itroPath . "uploaded-images/" . $_POST['bg_selected_image']);
			itro_update_option('bg_selected_image',$_POST['bg_selected_image']);
			echo '<b style="color:green;">"';
			echo $_POST['bg_selected_image'] . '"'; _e(' selected as background','itro-plugin');
			echo '</b><br>';
		}
	}
}
	//delete image
function itro_delete_image()
{
	if(empty($_POST['deleted_image']))
	{
		echo '<b style="color:red;">';
		_e('Any image selected. Please select one.','itro-plugin');
		echo '</b><br><br>';
	}
	else
	{
		if ( unlink(mainLocalPath . "/uploaded-images/" . $_POST['deleted_image']) )
		{
			if (itro_get_option('deleted_image') == $_POST['deleted_image']) {itro_update_option('background_source' , NULL); }
			echo '<b style="color:green;">"';
			echo $_POST['deleted_image'] ; _e('" successfully deleted','itro-plugin');
			echo '</b><br><br>';
		}
		else {echo '<b style="color:red;">"'; _e('Error, can\'t delete image.','itro-plugin');echo '"</b><br><br>';}
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