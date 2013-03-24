<?php
/*
Copyright 2013  I.T.RO.� (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/

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
	/*opt 19*/'blog_home',
	/*opt 20*/'wpautop_select',
	/*opt 21*/'count_font_color',
	/*opt 22*/'background_select',
	/*opt 23*/'popup_delay',
	/*opt 24*/'popup_unlockable',
	);
	$field_name=array(
	/*fld 0*/'custom_html',
	);
	$submitted_form = 'mt_submit_hidden';
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
		if(isset($_POST[$field_name[$i]])) {$field_value[$i] = $_POST[ $field_name[$i] ]; }
		else{$field_value[$i] = NULL;}
		
		// Save the posted value in the database
		itro_update_field( $field_name[$i], $field_value[$i] );
	}
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
	
	if( empty($_POST['background_source']) ) { $opt_val[22] = NULL; itro_update_option('background_source',NULL); }
	else { itro_update_option('background_source',$_POST['background_source']); }
}
itro_admin_style();
// Put an settings updated message on the screen
if( isset($_POST[ $submitted_form ]) && $_POST[ $submitted_form ] == 'Y' ) {
	?>
	<div class="updated"><p><strong><?php _e('settings saved.', 'itro-plugin' ); ?></strong></p></div>
	<?php
}

?>
<script type="text/javascript" src="<?php echo itroPath . 'scripts/'; ?>jscolor/jscolor.js"></script>

<div style="display:table; width:100%;">
	<h1 style="float:left;"><?php _e( 'I.T.RO. Popup Plugin - Settings', 'itro-plugin');?></h1>
	<h4 style="float:right;">VER <?php echo get_option('itro_curr_ver');	?></h4>
</div>

<form id="optionForm" method="post">
	
	<div id="leftColumn">
		<!-- Settings form !-->
		<div id="formContainer">
			
			<!--------- General options --------->
			<?php echo itro_onOff('genOption','hidden');?>
			<p class="wpstyle" onClick="onOff_genOption();"><?php _e("General Popup Option:", 'itro-plugin' ); ?> </p>
			<div id="genOption">
				<input type="hidden" name="<?php echo $submitted_form; ?>" value="Y">
				<p>
					<input type="checkbox" id="ie_compability" name="ie_compability" value="yes" <?php if(itro_get_option('ie_compability')=='yes' ){echo 'checked="checked"';} ?> />
					<span onclick="itro_mutual_check('ie_compability','','')"><?php _e("Enable IE compability", 'itro-plugin' ); ?></span>
					<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>"title="<?php _e('If your site is has visualization issues in Internet Explorer, check this box to solve the compatibility problem.','itro-plugin');?>" >
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="<?php echo $opt_name[24]; ?>" name="<?php echo $opt_name[24]; ?>" value="yes" <?php if($opt_val[24] == 'yes' ){echo 'checked="checked"';} ?> />
					<span onclick="itro_mutual_check('<?php echo $opt_name[24]; ?>','','')"><?php _e("Disable ESC key", 'itro-plugin' ); ?></span>
					<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>"title="<?php _e('If you set this option popup can not be closed with ESC button of keyboard.','itro-plugin');?>" >
				</p>
				<p><?php _e("Popup seconds:", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Set seconds until the popup automatically close. Leave it blank to disable countdown.",'itro-plugin');?>" >
					<input type="text" name="<?php echo $opt_name[0]; ?>" value="<?php echo $opt_val[0]; ?>" size="10">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php _e("Popup delay:", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Set the delay before popup will be displayed",'itro-plugin');?>" >
					<input type="text" name="<?php echo $opt_name[23]; ?>" value="<?php echo $opt_val[23]; ?>" size="10">
				</p>
				<p>
					<input type="checkbox" name="show_countdown" id="show_countdown" value="yes" <?php if(itro_get_option('show_countdown')=='yes' ){echo 'checked="checked"';} ?> />&nbsp;&nbsp;
					<span onclick="itro_mutual_check('show_countdown','','')"><?php _e("Show countdown", 'itro-plugin' ); ?></span>
					<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e('Show the countdown at the bottom of the popup which dispay the time before popup will close. If is hidden, it run anyway.','itro-plugin');?>" >
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php _e("Countdown font color:", 'itro-plugin' ); ?>
					<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e('Select the countdown font color.','itro-plugin');?>" >
					<input type="text" class="color" name="<?php echo $opt_name[21]; ?>" value="<?php echo $opt_val[21]; ?>" size="10">
				</p>
				<p><?php _e("Next time visualization (hours):", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Set hours until the popup will appear again",'itro-plugin');?>" >
					<input type="text" name="<?php echo $opt_name[2]; ?>" value="<?php echo $opt_val[2]; ?>" size="10">
				</p>
				<p><?php _e("Popup position:", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Setting ABSOLUTE the popup will be static on the page. Setting FIXED it will scroll with the page.",'itro-plugin');?>" >
					<select name="<?php echo $opt_name[16]; ?>"  style="min-width:100px;">
						<option value="absolute" <?php if(itro_get_option($opt_name[16])=='absolute') {echo 'selected="select"';} ?> >Absolute</option>
						<option value="fixed" <?php if(itro_get_option($opt_name[16])=='fixed') {echo 'selected="select"';} ?> >Fixed</option>
					</select>
				</p>
				<p>
					<input id="autoMarginCheck" type="checkbox" name="auto_margin_check" value="yes" <?php if(itro_get_option('auto_margin_check')=='yes' ){echo 'checked="checked"';} ?> />
					<span onclick="itro_mutual_check('autoMarginCheck','','');"><?php _e("Automatic top margin:", 'itro-plugin' ); ?></span>
					<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("The system will try to auto center the popup, in case of problem deselect this option",'itro-plugin');?>" >
					&nbsp;&nbsp;&nbsp;
					<span id="marginDiv" style="height:<?php if(itro_get_option('auto_margin_check')=='yes'){echo '0px;';}?>">					
						<?php _e("Popup top margin:", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Select manually the top margin to vertical align the popup i.e.: 20px or 10%",'itro-plugin');?>" >
						<input type="text" name="<?php echo $opt_name[1]; ?>" value="<?php echo $opt_val[1]; ?>" size="10">
					</span>
				</p>					
				<p><?php _e("Popup width:", 'itro-plugin' ); ?> <img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Use the % to change width dinamically with the browser window , or px for fixed dimension i.e: 30% or 200px",'itro-plugin');?>" >
					<input type="text" name="<?php echo $opt_name[3]; ?>" value="<?php echo $opt_val[3]; ?>" size="10">&nbsp;&nbsp;&nbsp;&nbsp;
					<?php _e("Popup height:", 'itro-plugin' ); ?>
					<input type="text" name="<?php echo $opt_name[17]; ?>" value="<?php echo $opt_val[17]; ?>" size="10">
				</p>
				<p><?php _e("Popup background color", 'itro-plugin' ); ?>
					<input type="text" class="color" name="<?php echo $opt_name[4]; ?>" value="<?php echo $opt_val[4]; ?>" size="10">&nbsp;&nbsp;&nbsp;&nbsp;
					<?php _e("Popup border color:", 'itro-plugin' ); ?>
					<input type="text" class="color" name="<?php echo $opt_name[5]; ?>" value="<?php echo $opt_val[5]; ?>" size="10">
				</p>
				<p>
					<h4><?php _e("DECIDE WHERE POPUP WILL BE DISPLAYED","itro-plugin")?></h4>
					<p>
						<input type="checkbox" name="<?php echo $opt_name[19]; ?>" value="yes" <?php if($opt_val[19]=='yes' ){echo 'checked="checked"';} ?>>
						<?php _e("Blog homepage","itro-plugin")?><img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e('If in your Settings->Reading you have set \'Front page displays: Your latest posts\' and want to display the popup in the home, check this box.','itro-plugin');?>" />
					</p>
					<fieldset>
						<?php _e("Only selected pages", 'itro-plugin' ); ?><img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("Multiple choise with CTRL+Click or SHIFT+Arrow up or down",'itro-plugin');?>"><input type="radio" name="<?php echo $opt_name[18];?>" value="some"<?php if($opt_val[18]=='some'){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
						<?php _e("All pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="all" <?php if($opt_val[18]=='all' ){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;
						<?php _e("Any pages", 'itro-plugin' ); ?><input type="radio" name="<?php echo $opt_name[18];?>" value="any" <?php if($opt_val[18]=='any' || $opt_val[18]== NULL){echo 'checked="checked"';} ?>/>
					</fieldset><br>
					<?php
					itro_list_pages();
					?>
				</p>																			
			</div>
			
			<!------------ Age restriction option  ---------->
			<?php echo itro_onOff('ageRestSettings','hidden');?>
			<p class="wpstyle" onClick="onOff_ageRestSettings();"><?php _e("Age restriction settings:", 'itro-plugin' ); ?> </p>
			<div id="ageRestSettings">
				<?php echo itro_onOff_checkbox('ageCheck','ageRest','false');?>
				<p>
				<input id="ageCheck" type="checkbox" onClick="ageCheck_checkbox_ageRest()" name="<?php echo $opt_name[6]; ?>" value="yes" <?php if($opt_val[6]=='yes' ){echo 'checked="checked"';} ?> />
				<span onclick="itro_mutual_check('ageCheck','','');ageCheck_checkbox_ageRest();"><?php _e("Enable age validation", 'itro-plugin' ); ?></span>
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
						<input type="text" name="<?php echo $opt_name[9]; ?>" value="<?php echo $opt_val[9]; ?>" placeholder="<?php _e("i.e.: http://www.mysite.com/leave.html", 'itro-plugin' ); ?>" size="40">
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
			<input type="button" target="_blank" class="button" onClick="window.open('/?page_id=<?php echo itro_get_option('preview_id') ?>')" value="<?php echo _e('Preview page','itro-plugin' )?>">
		</p>
	</div>

	<div id="rightColumn">
		<input type="hidden" name="<?php echo $submitted_form; ?>" value="Y">
		<!------- Custom html field -------->
		<?php echo itro_onOff('customHtmlForm','hidden');?>
		<p class="wpstyle" onClick="onOff_customHtmlForm();"><?php _e("Your text (or HTML code:)", 'itro-plugin' ); ?> </p>
		<div id="customHtmlForm">
			<?php					
			$content = stripslashes($field_value[0]);
			wp_editor( $content, 'custom_html', array('textarea_name'=> 'custom_html','teeny'=>false, 'media_buttons'=>true, 'wpautop'=>false ) );
			?>
			<h4><?php _e("BACKGROUND IMAGE",'itro-plugin');?></h4>
			<a href="<?php if ( itro_get_option('background_source') == NULL ) {echo '#customHtmlForm';} else { echo itro_get_option('background_source'); }?>"><?php _e('Show image','itro-plugin')?></a>
			
			<?php //------------------- check version to retrieve old uploaded images 
			if ( get_option('itro_perv_ver') < 3.4 || get_option('itro_perv_ver') == NULL ) 
			{ ?>
				<span style="float: right;">
				<a href="<?php echo itroUploadUrl; ?>"><?php _e('Where are my old images?','itro-plugin'); ?></a>
				<img style="vertical-align:super; cursor:help" src="<?php echo itroImages . 'question_mark.png' ; ?>" title="<?php _e("If your plugin version is older than 3.4 here you can found your old uploaded images.",'itro-plugin');?>" >
				</span>
				<br><?php 
			} ?>
			
			<input type="radio" name="<?php echo $opt_name[22];?>" value="" <?php if($opt_val[22]== 'no' || $opt_val[22]== NULL ){echo 'checked="checked"';} ?>/>
			<?php _e("No background",'itro-plugin');?><br>
			<input type="radio" id="yes_bg" name="<?php echo $opt_name[22];?>" value="yes" <?php if( $opt_val[22]== 'yes' ){echo 'checked="checked"';} ?>/>
			<input class="upload" onClick="select(); document.getElementById('yes_bg').checked=true" type="text" name="background_source" size="50" value="<?php echo itro_get_option('background_source'); ?>" />
			<input class="button" id="upload_button" type="button" name="bg_upload_button" value="<?php _e('Upload Image','itro-plugin') ?>" />
			<hr>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" target="_blank" class="button" onClick="window.open('/?page_id=<?php echo itro_get_option('preview_id') ?>')" value="<?php echo _e('Preview page','itro-plugin' )?>">
			</p>
		</div>
	</div>
</form>
<div id="rightColumn2">
	<!-- Donation form - please don't change or remove!!! thanks !-->
	<div id="donateForm">
		<h3><?php _e("Like it? Offer us a coffee! ;-)","itro-plugin")?> <img width="35px" src="<?php echo itroImages . 'coffee.png';?>"></h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="L2QKQKSPMY3RU">
			<table style="float:right;">
				<tr><td><input type="hidden" name="on0" value="Make your donation"><?php _e('Make your donation','itro-plugin') ?></td></tr><tr><td><select name="os0">
				<option value="thiny donation"><?php _e('thiny donation','itro-plugin') ?>   &#8364;1,00 EUR</option>
				<option value="little donation"><?php _e('little donation','itro-plugin') ?> &#8364;2,00 EUR</option>
				<option value="right donation"><?php _e('thiny donation','itro-plugin') ?>   &#8364;5,00 EUR</option>
				<option value="normal donation"><?php _e('normal donation','itro-plugin') ?> &#8364;10,00 EUR</option>
				<option value="good donation"><?php _e('good donation','itro-plugin') ?>     &#8364;20,00 EUR</option>
				<option value="great donation"><?php _e('great donation','itro-plugin') ?>   &#8364;50,00 EUR</option>
				</select> </td></tr>
			</table>
			<input type="hidden" name="currency_code" value="EUR">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
</div>