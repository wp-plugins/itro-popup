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
				<script>
				function lastLoad() 
				{
					var customHtml = document.getElementById('customHtml');
					var html = '<?php echo stripslashes(itro_get_field('custom_html')); //insert custom html code?>';
					customHtml.innerHTML = html;
				}
				window.onload = lastLoad;
				</script>
				<div id="customHtml"></div>
		</div>
		<script>
			<?php 
			if (itro_get_option('age_restriction')==NULL) //if is not set age restriction option popup will be closed automatically
			{ ?>
				var popTime=<?php echo itro_get_option('popup_time'); ?>;

				setInterval(function(){popTimer()},1000); //the countdown 
				function popTimer()
				{
					if (popTime>0){
					document.getElementById("timer").innerHTML=popTime;
					popTime--;
					}
					else {popup.style.visibility='Hidden'; opaco.style.visibility='Hidden';
					}
				}
			<?php 
			}?>
			setInterval(function(){marginRefresh()},100); //refresh every 0.1 second the popup top margin (needed for browser window resizeing)
			function marginRefresh()
			{
				//assign to x the window width and to y the window height
				var w = window, d = document, e = d.documentElement, g = d.getElementsByTagName('body')[0], x = w.innerWidth||e.clientWidth||g.clientWidth ;
				var y = w.innerHeight||e.clientHeight||g.clientHeight ;
				var popupHeight = document.getElementById('popup').offsetHeight ; 		//display the actual px size of popup div
				poupTopMargin = (y - popupHeight)/8; 									//calculate the top margin 
				document.getElementById('popup').style.marginTop = poupTopMargin ; 		//update the top margin of popup
			}
		</script>
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