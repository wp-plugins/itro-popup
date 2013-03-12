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

function itro_plugin_options() 
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	// variables for the field and option names
	if( !isset($submitted_form )) 
	{
		$opt_name=array(
		/*opt 0*/'popup_time',
		/*opt 1*/'popup_top_margin',
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
		/*opt 19*/'text_bg_color',
		/*opt 20*/'text_border_color',
		/*opt 21*/'count_font_color',
		);
		$field_name=array(
		/*fld 0*/'custom_html',
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
		if( isset($_POST['auto_margin_check']) ) { itro_update_option('auto_margin_check',$_POST['auto_margin_check']); }
		else { itro_update_option('auto_margin_check',NULL); }
		
		if( isset($_POST['ie_compability']) ) { itro_update_option('ie_compability',$_POST['ie_compability']); }
		else { itro_update_option('ie_compability',NULL); }
		
		if( isset($_POST['show_countdown']) ) { itro_update_option('show_countdown',$_POST['show_countdown']); }
		else { itro_update_option('show_countdown',NULL); }
	}
	
	//ordered options
	for($i=0;$i<count($opt_name); $i++)
	{
		// Read in existing option value from database
		$opt_val[$i] = itro_get_option( $opt_name[$i] );

		// See if the user has posted us some information 
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y' )
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
	<script type="text/javascript" src="<?php echo itroPath . 'scripts/'; ?>jscolor/jscolor.js"></script>
	<script type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce.js"></script>
	<script>
		function itroShow(x) {document.getElementById(x).style.height='auto';}
		function itroHide(x) {document.getElementById(x).style.height='0px';}
	</script>
	<!-- <img style="position:relative; float:right;" src=""> !-->
	<h1><?php _e( 'I.T.RO. Popup Plugin - Settings', 'itro-plugin');?></h1>
	
	<form id="optionForm" method="post">
		
		<div id="leftColumn">
			<!-- Settings form !-->
			<div id="formContainer">
				
				<!--------- General options --------->
				<?php echo itro_onOff('genOption');?>
				<p class="wpstyle" onClick="onOff_genOption();"><?php _e("General Popup Option:", 'itro-plugin' ); ?> </p>
				<div id="genOption">
					<input type="hidden" name="<?php echo $submitted_form; ?>" value="Y">
					<p><?php _e("Enable IE compability:", 'itro-plugin' ); ?><sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e('If your site is has visualization issues in Internet Explorer, check this box to solve the compatibility problem.','itro-plugin');?>" >?</sup>
						<input type="checkbox" name="ie_compability" value="yes" <?php if(itro_get_option('ie_compability')=='yes' ){echo 'checked="checked"';} ?> />
					</p>
					<p><?php _e("Popup seconds:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Set seconds until the popup automatically close",'itro-plugin');?>" >?</sup>
						<input type="text" name="<?php echo $opt_name[0]; ?>" value="<?php echo $opt_val[0]; ?>" size="10">
					</p>
					<p><?php _e("Show countdown:", 'itro-plugin' ); ?><sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e('Show the countdown at the bottom of the popup which dispay the time before popup will close','itro-plugin');?>" >?</sup>
						<input type="checkbox" name="show_countdown" value="yes" <?php if(itro_get_option('show_countdown')=='yes' ){echo 'checked="checked"';} ?> />&nbsp;&nbsp;&nbsp;&nbsp;
						<?php _e("Countdown font color:", 'itro-plugin' ); ?>
						<input type="text" class="color" name="<?php echo $opt_name[21]; ?>" value="<?php echo $opt_val[21]; ?>" size="10">
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
					<?php echo itro_onOff_checkbox('autoMarginCheck','marginDiv','true');?>
					<p><?php _e("Use automatic top margin:", 'itro-plugin' ); ?><sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("The system will try to auto center the popup, in case of problem deselect this option",'itro-plugin');?>" >?</sup>
						<input id="autoMarginCheck" type="checkbox" onClick="autoMarginCheck_checkbox_marginDiv()" name="auto_margin_check" value="yes" <?php if(itro_get_option('auto_margin_check')=='yes' ){echo 'checked="checked"';} ?> />
					</p>
					<div id="marginDiv" style="height:<?php if(itro_get_option('auto_margin_check')=='yes'){echo '0px;';}?>">
					<p><?php _e("Popup top margin:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Select manually the top margin to vertical align the popup i.e.: 20px or 10%",'itro-plugin');?>" >?</sup>
						<input type="text" name="<?php echo $opt_name[1]; ?>" value="<?php echo $opt_val[1]; ?>" size="10">
					</p>
					</div>
					<p><?php _e("Popup width:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Use the % to change width dinamically with the browser window i.e: 30%",'itro-plugin');?>" >?</sup>
						<input type="text" name="<?php echo $opt_name[3]; ?>" value="<?php echo $opt_val[3]; ?>" size="10">&nbsp;&nbsp;&nbsp;&nbsp;
						<?php _e("Popup height:", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Leave it blank to maintain the aspect ratio",'itro-plugin');?>" >?</sup>
						<input type="text" name="<?php echo $opt_name[17]; ?>" value="<?php echo $opt_val[17]; ?>" size="10">
					</p>
					<p><?php _e("Popup background color", 'itro-plugin' ); ?>
						<input type="text" class="color" name="<?php echo $opt_name[4]; ?>" value="<?php echo $opt_val[4]; ?>" size="10">&nbsp;&nbsp;&nbsp;&nbsp;
						<?php _e("Popup border color:", 'itro-plugin' ); ?>
						<input type="text" class="color" name="<?php echo $opt_name[5]; ?>" value="<?php echo $opt_val[5]; ?>" size="10">
					</p>
					<p>
						<h4><?php _e("DECIDE WHERE POPUP WILL BE DISPLAYED","itro-plugin")?></h4>
						<fieldset>
							<?php _e("Only selected pages", 'itro-plugin' ); ?><sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Multiple choise with CTRL+Click or SHIFT+Arrow up or down",'itro-plugin');?>">?</sup><input type="radio" name="<?php echo $opt_name[18];?>" value="some"<?php if($opt_val[18]=='some'){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
							<?php _e("All pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="all" <?php if($opt_val[18]=='all' ){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
							<?php _e("Any pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="any" <?php if($opt_val[18]=='any' ){echo 'checked="checked"';} ?>/>
						</fieldset><br>
						<?php
						itro_list_pages();
						?>
					</p>																			
				</div>
				
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
							<input type="text" name="<?php echo $opt_name[7]; ?>" value="<?php echo $opt_val[7]; ?>" placeholder="<?php _e("i.e.: I AM OVER 18 - ENTER", 'itro-plugin' ); ?>"  size="40">
						</p>
						<p><?php _e("Enter button background color:", 'itro-plugin' ); ?> 
							<input type="text" class="color" name="<?php echo $opt_name[10]; ?>" value="<?php echo $opt_val[10]; ?>" size="10">
						</p>
						<p><?php _e("Enter button border color:", 'itro-plugin' ); ?> 
							<input type="text" class="color" name="<?php echo $opt_name[11]; ?>" value="<?php echo $opt_val[11]; ?>" size="10">
						</p>
						<p><?php _e("Enter button font color:", 'itro-plugin' ); ?> 
							<input type="text" class="color" name="<?php echo $opt_name[14]; ?>" value="<?php echo $opt_val[14]; ?>" size="10">
						</p>
						<p><?php _e("Leave button text:", 'itro-plugin' ); ?> 
							<input type="text" name="<?php echo $opt_name[8]; ?>" value="<?php echo $opt_val[8] ?>" placeholder="<?php _e("i.e.: I AM UNDER 18 - LEAVE", 'itro-plugin' ); ?>" size="40">
						</p>
						<p><?php _e("Leave button url:", 'itro-plugin' ); ?> 
							<input type="text" name="<?php echo $opt_name[9]; ?>" value="<?php if(!isset($opt_val[9])){_e("i.e.: http://www.mysite.com/leave.html", 'itro-plugin' );} else{echo $opt_val[9];} ?>" size="40">
						</p>
						<p><?php _e("Leave button background color:", 'itro-plugin' ); ?> 
							<input type="text" name="<?php echo $opt_name[12]; ?>" value="<?php echo $opt_val[12]; ?>" size="10">
						</p>
						<p><?php _e("Leave button border color:", 'itro-plugin' ); ?> 
							<input type="text" class="color" name="<?php echo $opt_name[13]; ?>" value="<?php echo $opt_val[13]; ?>" size="10">
						</p>
						<p><?php _e("Leave button font color:", 'itro-plugin' ); ?> 
							<input type="text" class="color" name="<?php echo $opt_name[15]; ?>" value="<?php echo $opt_val[15]; ?>" size="10">
						</p>					
					</div>
				</div>
			</div>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" target="_blank" class="button-primary" onClick="window.open('/?page_id=<?php echo itro_get_option('preview_id') ?>')" value="<?php echo _e('Preview page','itro-plugin' )?>">
			</p>
		</div>

		<div id="rightColumn">
			<input type="hidden" name="<?php echo $submitted_form; ?>" value="Y">
			<!------- Custom html field -------->
				<?php echo itro_onOff('customHtmlForm'); ?>
				<p class="wpstyle" onClick="onOff_customHtmlForm();"><?php _e("Your text (or HTML code:)", 'itro-plugin' ); ?> </p>
				<div id="customHtmlForm">
					<?php
					$content = stripslashes($field_value[0]);
					wp_editor( $content, 'editorid', array('textarea_name'=> 'custom_html','teeny'=>false, 'media_buttons'=>false) );
					?>
					<p><?php _e("Text background color", 'itro-plugin' ); ?>
						<input type="text" class="color" name="<?php echo $opt_name[19]; ?>" value="<?php echo $opt_val[19]; ?>" size="10">
					</p>
					<p><?php _e("Text border color:", 'itro-plugin' ); ?>
						<input type="text" class="color" name="<?php echo $opt_name[20]; ?>" value="<?php echo $opt_val[20]; ?>" size="10">
					</p>
				</div>
				
			<?php
			//---Image manager for popup images
			echo itro_onOff('imgManagerDiv');//the hide-show function?>
			<p id="imgSettings" class="wpstyle" onClick="onOff_imgManagerDiv();"><?php _e("Popup image settings:", 'itro-plugin' ); ?> </p>
			<?php 		
			if( isset($_POST[ 'image_manager']) && $_POST[ 'image_manager' ] == 'Y' )
			{
				//if not use direct link
				itro_update_option('image_width',$_POST['image_width']);
				if( !isset($_POST['img_url_check']) ) { itro_update_option('img_url_check',NULL); }
				if( !isset($_POST['bg_url_check']) ) { itro_update_option('bg_url_check',NULL); }
				if( !isset($_POST['img_url_check']) || !isset($_POST['bg_url_check']) ) { itro_image_manager(); }
				
				//if user has selcted the direct url
				if( isset($_POST[ 'img_url_check' ]) )
				{
					itro_update_option('img_url_check',$_POST['img_url_check']);
					itro_update_option('img_source',$_POST['img_source']);
					itro_update_option('img_direct_url',$_POST['img_source']);
					echo '<b style="color:green">'; _e('Added image from direct url','itro-plugin'); echo '</b>';
				}
				if( isset($_POST[ 'bg_url_check']) )
				{
					itro_update_option('bg_url_check',$_POST['bg_url_check']);
					itro_update_option('background_source',$_POST['background_source']);
					itro_update_option('background_direct_url',$_POST['background_source']);
					echo '<b style="color:green">'; _e('Added background from direct url','itro-plugin'); echo '</b>';
				}
			}
			if ( isset($_POST['delete_image']) && $_POST[ 'delete_image' ] == 'Y' ) { itro_delete_image(); }
			if( isset($_POST['image_uploader']) ) {itro_image_uploader();}//if user has uploaded an image 
			?>
			<div id="imgManagerDiv">
				<input type="hidden" name="image_manager" value="Y">
				
				<!-------- inserted image manager !--------->
				<h4><?php _e("INSERTED IMAGE",'itro-plugin');?></h4>
				
				<?php echo itro_onOff_checkbox('imgUrlCheck','imgManager','true');?>
				
				<p><?php _e("Image size (%):", 'itro-plugin' ); ?> <sup style="text-decoration:underline; color:blue; cursor:help;" title="<?php _e("Insert pure number whithout %",'itro-plugin');?>" >?</sup>
					<input type="text" name="image_width" value="<?php echo itro_get_option('image_width'); ?>" size="10">
				</p>
				<p><?php _e("Use direck url:", 'itro-plugin' ); ?>
					<input id="imgUrlCheck" type="checkbox" onClick="imgUrlCheck_checkbox_imgManager()" name="img_url_check" value="yes" <?php if(itro_get_option('img_url_check')=='yes' ){echo 'checked="checked"';} ?> />
					<input type="text" name="img_source" value="<?php echo itro_get_option('img_direct_url'); ?>" size="50">
				</p>
				<div id="imgManager" style="height:<?php if(itro_get_option('img_url_check')=='yes'){echo '0px;';}?>">
					<p>
						<a href="<?php if ( itro_get_option('img_source') == NULL ) {echo '#';} else { echo itro_get_option('img_source'); }?>"><?php _e('Current image link:','itro-plugin')?></a>
						<input type="text" readonly onClick="select();" value="<?php echo itro_get_option('img_source'); ?>" size="50">
					</p>
					<select name="selected_image" style="min-width:100px;">
						<?php itro_image_list('ins');//list uploaded images and diplay the inserted one selected ?>
					</select>
				</div>
				
				<!----- background image manager !---------->
				<h4><?php _e("BACKGROUND IMAGE",'itro-plugin');?></h4>
				
				<?php echo itro_onOff_checkbox('bgUrlCheck','bgManager','true');?>
				
				<p><?php _e("Use direck url:", 'itro-plugin' ); ?>
					<input id="bgUrlCheck" type="checkbox" onClick="bgUrlCheck_checkbox_bgManager()" name="bg_url_check" value="yes" <?php if(itro_get_option('bg_url_check')=='yes' ){echo 'checked="checked"';} ?> />
					<input type="text" name="background_source" value="<?php echo itro_get_option('background_direct_url'); ?>" size="50">
				</p>
				<div id="bgManager" style="height:<?php if(itro_get_option('bg_url_check')=='yes'){echo '0px;';}?>">
					<p>
					<a href="<?php if ( itro_get_option('background_source') == NULL ) {echo '#';} else { echo itro_get_option('img_source'); }?>"><?php _e('Current image link:','itro-plugin')?></a>
					<input type="text" readonly onClick="select();" value="<?php echo itro_get_option('background_source'); ?>" size="50">
					</p>
					<select name="bg_selected_image" style="min-width:100px;">
						<?php itro_image_list('bg'); //list uploaded images and diplay the background one selected?>
					</select>
				</div>
			</div>
			<hr>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
		</div>
	</form>
	<div id="rightColumn2">
		<?php
		//---Image manager2 for popup images
		echo itro_onOff('imgManagerDiv2');//the hide-show function?>
		<p class="wpstyle" onClick="onOff_imgManagerDiv2();"><?php _e("Upload and delete images",'itro-plugin'); ?> </p>
		
		<div id="imgManagerDiv2">
			<!--------- image deleteing !--------->
			<?php
			?>
			<form id="deleteImgForm" action="#imgSettings" method="post">
				<input type="hidden" name="delete_image" value="Y">
				<select name="deleted_image" style="min-width:100px;">
					<?php itro_image_list('no_select'); ?>
				</select>
				<input class="button-primary" type="submit" name="submitImgDelete" value="<?php _e("Delete", 'itro-plugin')?>">
			</form>
			
			<!--------- image uploading !---------->
			<form id="imgUploaderForm" action="#imgSettings" method="post" enctype="multipart/form-data">
				<input type="hidden" name="image_uploader" value="Y">
				<p>
					<label for="file"><?php _e("Select the image", 'itro-plugin')?></label>
					<input type="file" name="file" id="file"><br>
					<input class="button-primary" type="submit" name="submitUpload" value="<?php _e("Upload", 'itro-plugin')?>">
					<input type="checkbox" name="overwrite" value="yes"><?php _e("Overwrite", 'itro-plugin')?>
				</p>
			</form>
		</div>
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
	</div>
	<?php 
} ?>