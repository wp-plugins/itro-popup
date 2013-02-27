<?php
/*
Copyright 2013  I.T.RO.� (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/

//----------------------- ADD META TAG FOR IE COMPATIBILITY
function itro_ie_compatibility(){echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>';}

//----------------------SET THE COOKIE FOR THE ONE-TIME VISUALIZATION OF POPUP
function set_popup_cookie() 
{
	$expiration_time = itro_get_option('cookie_time_exp') ;
	setcookie("popup_cookie" , "one_time_popup" , time() + $expiration_time * 3600) ;
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
	if(itro_get_option('page_selection')!='any')
	if( ($id_match != NULL) || (itro_get_option('page_selection')=='all') )
	{ ?>
		<!--------------start popoup div and js--------------->	
		<div id="opaco"></div>
		<div id="popup">
				<?php 
				if (itro_get_option('img_source')!=NULL) 
				{?>
					<img id="popup_image" src="<?php echo itro_get_option('img_source');?>" style="padding-top:10px;">
				<?php 
				}
				if (itro_get_option('age_restriction')==NULL) {?>
				<p id="popup_text" align="center"><?php _e('This popup will be closed in: ','itro-plugin'); ?> <b id="timer"></b>&nbsp 
				<a class="popup" href="javascript:void(0)" onclick="popup.style.visibility='Hidden',opaco.style.visibility='Hidden'"><?php _e('CLOSE NOW','itro-plugin'); ?></a>
				</p>
				<?php } else {?>
				<p id="age_button_area" align="center" style="padding-top:10px;">
				<input type="button" id="ageEnterButton" onClick="popup.style.visibility='Hidden',opaco.style.visibility='Hidden'" value="<?php echo itro_get_option('enter_button_text');?>">
				<input type="button" id="ageLeaveButton" onClick="javascript:window.open('<?php echo itro_get_option('leave_button_url')?>','_self');" value="<?php echo itro_get_option('leave_button_text');?>">
				</p>
				<?php }?>
				<div id="customHtml"></div>
		</div>
		<!---------end popoup div and js--------->
<?php 
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
		if($_FILES["file"]["size"] > 2048000){echo'<script>alert("'; _e('Warning file is too big, this may cause problems!','itro-plugin'); echo'");</script>';}
		if ($_FILES["file"]["error"] > 0){ echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; }
		else
		{
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

			if(!isset($_POST['overwrite'])){$_POST['overwrite']='no';}
			if (file_exists(mainLocalPath . "\\images\\" . $_FILES["file"]["name"]) && $_POST['overwrite']!='yes')
			{ echo $_FILES["file"]["name"] ; _e('already exists. Please check the overwrite option','itro-prugin'); }
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				mainLocalPath . "\\images\\" . $_FILES["file"]["name"]);
				$img_source = itroPath . "images/" . $_FILES["file"]["name"];
				echo $img_source;
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

//------------------- SELECT AND DELETE UPLOADED IMAGES
function itro_image_list()
{
	if($handle = opendir(mainLocalPath . '\images'))
	{
		$selected_img = itro_get_option('selected_image');
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
	//delete image
	if(!empty($_REQUEST['submitDelete'])) 
	{ 
		if(empty($_POST['selected_image'])){_e('No image selected','itro-plugin');}
		else
		{
			unlink(mainLocalPath . "\\images\\" . $_POST['selected_image']);
			if (itro_get_option('selected_image') == $_POST['selected_image']) {itro_update_option('img_source' , NULL); }
			echo $_POST['selected_image'] ; _e(' successfully deleted','itro-plugin');
		}
	}
	//select image
	if(!empty($_REQUEST['submitSelect'])) 
	{
		if(empty($_POST['selected_image']))
		{
			itro_update_option('img_source' , NULL);
			itro_update_option('selected_image' , NULL);
			_e('No image used','itro-plugin');
		} 
		else 
		{
			itro_update_option('img_source', itroPath . "images/" . $_POST['selected_image']);
			itro_update_option('selected_image',$_POST['selected_image']);
			echo $_POST['selected_image'] ; _e(' selected','itro-plugin');
		}
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