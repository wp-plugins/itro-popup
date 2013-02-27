<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/

// Administration menu
function itro_plugin_menu() {
	add_options_page( 'Popup Plugin Options', 'ITRO Popup', 'manage_options', 'itro-plugin-menu', 'itro_plugin_options' );
}

function itro_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	// variables for the field and option names
	if( !isset($submitted_form )) 
	{
		$opt_name=array(
		/*opt 0*/'popup_time',
		/*opt 1*/ '', //emply slot... :)
		/*opt 2*/'cookie_time_exp',
		/*opt 3*/'popup_width',
		/*opt 4*/'popup_background',
		/*opt 5*/'popup_border_color',
		/*opt 6*/'age_restriction',
		/*opt 7*/'enter_button_text',
		/*opt 8*/'leave_button_text',
		/*opt 9*/'leave_button_url',
		/*opt 10*/'enter_button_bg_color',
		/*opt 11*/'enter_button_border_color',
		/*opt 12*/'leave_button_bg_color',
		/*opt 13*/'leave_button_border_color',
		/*opt 14*/'enter_button_font_color',
		/*opt 15*/'leave_button_font_color',
		/*opt 16*/'popup_position',
		/*opt 17*/'popup_height',
		/*opt 18*/'page_selection',
		);
		$field_name=array(
		/*fld 1*/'custom_html',
		);
		$submitted_form = 'mt_submit_hidden';
	}
	//unsorted option and field
	if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y')
	{
		if( isset($_POST['selected_page_id']) ) 
		{
			$selected_page_id=json_encode($_POST['selected_page_id']);
			itro_update_option('selected_page_id',$selected_page_id);
		}
	}
	//ordered options
	for($i=0;$i<count($opt_name); $i++)
	{
		// Read in existing option value from database
		$opt_val[$i] = itro_get_option( $opt_name[$i] );

		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y')
		{
			// Read their posted value
			if(isset($_POST[$opt_name[$i]])){$opt_val[$i] = $_POST[ $opt_name[$i] ];}
			else{$opt_val[$i] = NULL;}
			
			// Save the posted value in the database
			itro_update_option( $opt_name[$i], $opt_val[$i] );
		}
	}
	
	//ordered field
	for($i=0;$i<count($field_name); $i++)
	{
		// Read in existing option value from database
		$field_value[$i] = itro_get_field( $field_name[$i] );

		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y' ) 
		{
			// Read their posted value
			if(isset($_POST[$field_name[$i]])){$field_value[$i] = $_POST[ $field_name[$i] ];}
			else{$field_value[$i] = NULL;}
			
			// Save the posted value in the database
			itro_update_field( $field_name[$i], $field_value[$i] );
		}
	}
	
	// Put an settings updated message on the screen
	if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y' ) {
		?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'itro-plugin' ); ?></strong></p></div>
		<?php
	}
	?>
	<script>
		function itroShow(x) {document.getElementById(x).style.height='auto';}
		function itroHide(x) {document.getElementById(x).style.height='0px';}
	</script>
	
	<img style="position:relative; float:right;" src="">
	<h1><?php _e( 'I.T.RO. Popup Plugin - Settings', 'itro-plugin');?></h1>
	
<div id="rightColumn">
	<!-- Donation form - please don't change or remove!!! thanks !-->
	<div id="donateForm">
		<h3><?php _e("HELP US TO CONTINUE OUR DEVELOPING WORK. PLEASE DONATE!")?></h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="L2QKQKSPMY3RU">
			<table style="float:right;">
				<tr><td><input type="hidden" name="on0" value="Make your donation">Make your donation</td></tr><tr><td><select name="os0">
				<option value="thiny donation">thiny donation &#8364;1,00 EUR</option>
				<option value="little donation">little donation &#8364;2,00 EUR</option>
				<option value="right donation">right donation &#8364;5,00 EUR</option>
				<option value="normal donation">normal donation &#8364;10,00 EUR</option>
				<option value="good donation">good donation &#8364;20,00 EUR</option>
				<option value="great donation">great donation &#8364;50,00 EUR</option>
				</select> </td></tr>
			</table>
			<input type="hidden" name="currency_code" value="EUR">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	
	<!-- Color Table !-->
	<object>
		<param name="movie" value="file.swf">
		<embed id="colorTable" src="<?php echo itroPath . 'other/color.swf'?>" width="100" height="100">
		</embed>
	</object>
	<?php
		//---Image manager form for the popup image
		
		echo itro_onOff('imgManagerForm');//the hide-show function?>
		<p class="wpstyle" onClick="onOff_imgManagerForm();"><?php _e("Popup image settings:", 'itro-plugin' ); ?> </p>
		<?php 
		if(!empty($_REQUEST['submitUpload'])) {itro_image_uploader(); itro_update_option('img_url_check',NULL);}//if use has uploaded an image
		if(!empty($_REQUEST['submitDelete']) || !empty($_REQUEST['submitSelect'])) {itro_image_manager(); itro_update_option('img_url_check',NULL);}//if use has managed images
		if( isset($_POST[ 'img_url_check' ]) && $_POST[ 'image_manager' ] == 'Y' ) //if user has selcted the direct url
		{
			itro_update_option('img_url_check',$_POST['img_url_check']);
			itro_update_option('img_source',$_POST['img_source']);
			itro_update_option('img_direct_url',$_POST['img_source']);
		}
		?>
		<form id="imgManagerForm" action="#imgManagerForm" method="post" enctype="multipart/form-data">
			<input type="hidden" name="image_manager" value="Y">
			<?php echo itro_onOff_checkbox('imgUrlCheck','imgUploader','true');?>
			<p><?php _e("Use direck url:", 'itro-plugin' ); ?>
				<input id="imgUrlCheck" type="checkbox" onClick="imgUrlCheck_checkbox_imgUploader()" name="img_url_check" value="yes" <?php if(itro_get_option('img_url_check')=='yes' ){echo 'checked="checked"';} ?> />
				<input type="text" name="<?php echo 'img_source'; ?>" value="<?php echo itro_get_option('img_direct_url'); ?>" size="50">
				<input class="button-primary" type="submit" name="submitImgUrl" value="<?php _e("Save", 'itro-plugin')?>">
			</p>
			<div id="imgUploader" style="height:<?php if(itro_get_option('img_url_check')=='yes'){echo '0px;';}?>">
				<p><?php _e('Current image link:','itro-plugin')?><a href="<?php echo itro_get_option('img_source');?>"><?php echo itro_get_option('img_source');?></a></p>
				<select name="selected_image" style="min-width:100px;">
					<?php itro_image_list(); ?>
				</select>
				<input class="button-primary" type="submit" name="submitSelect" value="<?php _e("Select", 'itro-plugin')?>">
				<input class="button-primary" type="submit" name="submitDelete" value="<?php _e("Delete", 'itro-plugin')?>">
				<p>
					<label for="file"><?php _e("Select the image", 'itro-plugin')?></label>
					<input type="file" name="file" id="file"><br>
					<input class="button-primary" type="submit" name="submitUpload" value="<?php _e("Upload", 'itro-plugin')?>">
					<input type="checkbox" name="overwrite" value="yes"><?php _e("Overwrite", 'itro-plugin')?>
				</p>
			</div>
		</form>
</div>

<div id="leftColumn">
	<!-- Settings form !-->
	<div id="formContainer">
		<form id="settingsForm" method="post" action="#settingsForm">
		
			<!--------- General options --------->
			<?php echo itro_onOff('genOption');?>
			<p class="wpstyle" onClick="onOff_genOption();"><?php _e("General Popup Option:", 'itro-plugin' ); ?> </p>
			<div id="genOption">
				<input type="hidden" name="<?php echo $submitted_form; ?>" value="Y">
				<p><?php _e("Popup seconds:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Set seconds until the popup automatically close",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[0]; ?>" value="<?php echo $opt_val[0]; ?>" size="10">
				</p>
				<p><?php _e("Next time visualization (hours):", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Set hours until the popup will appear again",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[2]; ?>" value="<?php echo $opt_val[2]; ?>" size="10">
				</p>
				<p><?php _e("Popup position:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Setting ABSOLUTE the popup will be static on the page. Setting FIXED it will scroll with the page.",'itro-plugin');?>" >?</sup>
					<select name="<?php echo $opt_name[16]; ?>"  style="min-width:100px;">
						<option value="absolute" <?php if(itro_get_option($opt_name[16])=='absolute') {echo 'selected="select"';} ?> >Absolute</option>
						<option value="fixed" <?php if(itro_get_option($opt_name[16])=='fixed') {echo 'selected="select"';} ?> >Fixed</option>
					</select>
				</p>
				<p><?php _e("Popup width:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Use the % to change width dinamically with the browser window i.e: 30%",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[3]; ?>" value="<?php echo $opt_val[3]; ?>" size="10">
				</p>
				<p><?php _e("Popup height:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Leave it blank to maintain the aspect ratio",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[17]; ?>" value="<?php echo $opt_val[17]; ?>" size="10">
				</p>
				<p><?php _e("Popup background color", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("RGB code i.e.: rgb(255,0,0) HEX code i.e.: #FF0000",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[4]; ?>" value="<?php echo $opt_val[4]; ?>" size="10">
				</p>
				<p><?php _e("Popup border color:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("RGB code i.e.: rgb(255,0,0) HEX code i.e.: #FF0000",'itro-plugin');?>" >?</sup>
					<input type="text" name="<?php echo $opt_name[5]; ?>" value="<?php echo $opt_val[5]; ?>" size="10">
				</p>
				<p>
					<fieldset>
						<legend><?php _e("Decide where the popup will be displayed","itro-plugin")?></legend>
						<?php _e("Only selected pages", 'itro-plugin' ); ?><sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Multiple choise with CTRL+Click or SHIFT+Arrow up or down",'itro-plugin');?>">?</sup><input type="radio" name="<?php echo $opt_name[18];?>" value="some"<?php if($opt_val[18]=='some'){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
						<?php _e("All pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="all" <?php if($opt_val[18]=='all' ){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
						<?php _e("Any pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="any" <?php if($opt_val[18]=='any' ){echo 'checked="checked"';} ?>/>
					</fieldset>
					<?php
					itro_list_pages();
					?>
				</p>
				<!---<input type="button" class="button-primary" onClick="popup.style.visibility=''; opaco.style.visibility='';" value="<?php echo _e("Preview")?>"> ----!>
				 														
			</div>
			
			<!------- Custom html field -------->
			<?php echo itro_onOff('customHtmlForm'); ?>
			<p class="wpstyle" onClick="onOff_customHtmlForm();"><?php _e("Custom HTML code:", 'itro-plugin' ); ?> </p>
			<p id="customHtmlForm">
				<textarea rows="9" cols="70" name="<?php echo $field_name[0]; ?>"><?php echo stripslashes($field_value[0]); ?></textarea>
			</p>
			
			<!------------ Age restriction option  ---------->
			<?php echo itro_onOff('ageRestSettings');?>
			<p class="wpstyle" onClick="onOff_ageRestSettings();"><?php _e("Age restriction settings:", 'itro-plugin' ); ?> </p>
			<div id="ageRestSettings">
				<?php echo itro_onOff_checkbox('ageCheck','ageRest','false');?>
				<p><?php _e("Age restricted page:", 'itro-plugin' ); ?>
				<input id="ageCheck" type="checkbox" onClick="ageCheck_checkbox_ageRest()" name="<?php echo $opt_name[6]; ?>" value="yes" <?php if($opt_val[6]=='yes' ){echo 'checked="checked"';} ?> />
				</p>
				<div id="ageRest" style="height:<?php if($opt_val[6]!='yes' ){echo '0px;';}?>">
					<p><?php _e("Enter button text:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[7]; ?>" value="<?php if($opt_val[7]==NULL){_e("i.e.: I AM OVER 18 - ENTER", 'itro-plugin' );} else{echo $opt_val[7];} ?>" size="40">
					</p>
					<p><?php _e("Enter button background color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[10]; ?>" value="<?php echo $opt_val[10]; ?>" size="10">
					</p>
					<p><?php _e("Enter button border color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[11]; ?>" value="<?php echo $opt_val[11]; ?>" size="10">
					</p>
					<p><?php _e("Enter button font color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[14]; ?>" value="<?php echo $opt_val[14]; ?>" size="10">
					</p>
					<p><?php _e("Leave button text:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[8]; ?>" value="<?php if(!isset($opt_val[8])){_e("i.e.: I AM UNDER 18 - LEAVE", 'itro-plugin' );} else{echo $opt_val[8];} ?>" size="40">
					</p>
					<p><?php _e("Leave button url:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[9]; ?>" value="<?php if(!isset($opt_val[9])){_e("i.e.: http://www.mysite.com/leave.html", 'itro-plugin' );} else{echo $opt_val[9];} ?>" size="40">
					</p>
					<p><?php _e("Leave button background color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[12]; ?>" value="<?php echo $opt_val[12]; ?>" size="10">
					</p>
					<p><?php _e("Leave button border color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[13]; ?>" value="<?php echo $opt_val[13]; ?>" size="10">
					</p>
					<p><?php _e("Leave button font color:", 'itro-plugin' ); ?> 
						<input type="text" name="<?php echo $opt_name[15]; ?>" value="<?php echo $opt_val[15]; ?>" size="10">
					</p>					
				</div>
			</div>
			
			<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
		</form>
	</div>	
</div>

<!-----------------------------------------------------------start popoup div and js preview--------------------------------------------------->	
<div id="opaco" style="visibility:hidden;"></div>
<div id="popup" style="visibility:hidden;">
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

	setInterval(function(){marginRefresh()},100); //refresh every 0.1 second the popup top margin (needed for browser window resizeing)
	function marginRefresh()
	{
		//assign to x the window width and to y the window height
		var w = window, d = document, e = d.documentElement, g = d.getElementsByTagName('body')[0], x = w.innerWidth||e.clientWidth||g.clientWidth ;
		var y = w.innerHeight||e.clientHeight||g.clientHeight ;
		var popupHeight = document.getElementById('popup').offsetHeight ; 		//display the actual px size of popup div
		poupTopMargin = (y - popupHeight - 600)/8; 									//calculate the top margin 
		document.getElementById('popup').style.marginTop = poupTopMargin ; 		//update the top margin of popup
	}
</script>
<!--------------------------------------------------------------end popoup div and js---------------------------------------------------->
<?php } ?>