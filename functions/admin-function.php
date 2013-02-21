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
		/*opt 1*/'only_home',
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
		);
		$field_name=array(
		/*fld 1*/'custom_html',
		);
		$submitted_form = 'mt_submit_hidden';
	}
	
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
	<img style="position:absolute" src="http://www.gnu.org/graphics/gplv3-88x31.png">
<h1 style="text-align:center"><?php _e( 'I.T.RO. Popup Plugin', 'itro-plugin') ?></h1>
<h2 style="text-align:center"><?php _e( 'Settings', 'itro-plugin') ?></h2>
<div id="rightColumn">

	<!-- Donation form - please don't change or remove!!! thanks !-->
	<div id="donateForm">
		<h3><?php _e("HELP US TO CONTINUE OUR DEVELOPING WORK. PLEASE DONATE!")?></h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="L2QKQKSPMY3RU">
			<table style="float:right;">
				<tr><td><input type="hidden" name="on0" value="Make your donation">Make your donation</td></tr><tr><td><select name="os0">
				<option value="little donation">thiny donation &#8364;1,00 EUR</option>
				<option value="not much litle donation">little donation &#8364;5,00 EUR</option>
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
				<p><?php _e("Popup seconds:", 'itro-plugin' ); ?> 
					<input type="text" name="<?php echo $opt_name[0]; ?>" value="<?php echo $opt_val[0]; ?>" size="10">
				</p>
				<p><?php _e("Cookie Time Expiration (hours):", 'itro-plugin' ); ?> 
					<input type="text" name="<?php echo $opt_name[2]; ?>" value="<?php echo $opt_val[2]; ?>" size="10">
				</p>
				<p><?php _e("Popup width (%):", 'itro-plugin' ); ?> 
					<input type="text" name="<?php echo $opt_name[3]; ?>" value="<?php echo $opt_val[3]; ?>" size="10">
				</p>
				<p><?php _e("Popup background color", 'itro-plugin' ); ?> 
					<input type="text" name="<?php echo $opt_name[4]; ?>" value="<?php echo $opt_val[4]; ?>" size="10">
				</p>
				<p><?php _e("Popup border color:", 'itro-plugin' ); ?> 
					<input type="text" name="<?php echo $opt_name[5]; ?>" value="<?php echo $opt_val[5]; ?>" size="10">
				</p>
				<p><?php _e("Only in home page:", 'itro-plugin' ); ?> 
					<input type="checkbox" name="<?php echo $opt_name[1]; ?>" value="yes" <?php if($opt_val[1]=='yes' ){echo 'checked="checked"';} ?> />
				</p>
			</div>
			
			<!------- Custom html field -------->
			<?php echo itro_onOff('customHtmlForm');?>
			<p class="wpstyle" onClick="onOff_customHtmlForm();"><?php _e("Custom HTML code:", 'itro-plugin' ); ?> </p>
			<p id="customHtmlForm">
				<textarea rows="10" cols="70" name="<?php echo $field_name[0]; ?>"><?php echo $field_value[0]; ?></textarea>
			</p>

			<!------------ Age restriction option  ---------->
			<?php echo itro_onOff('ageRestSettings');?>
			<p class="wpstyle" onClick="onOff_ageRestSettings();"><?php _e("Age restriction settings:", 'itro-plugin' ); ?> </p>
			<div id="ageRestSettings">
				<?php echo itro_onOff_checkbox('ageCheck','ageRest');?>
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
		
		<?php
		//---Image manager form for the popup image
		echo itro_onOff('imgManagerForm');?>
		<p class="wpstyle" onClick="onOff_imgManagerForm();"><?php _e("Popup image settings:", 'itro-plugin' ); ?> </p>
		<?php 
		if(!empty($_REQUEST['submitUpload'])) {itro_image_uploader();}
		if(!empty($_REQUEST['submitDelete']) || !empty($_REQUEST['submitSelect']) ) {itro_image_manager();}
		?>
		<form id="imgManagerForm" action="#imgManagerForm" method="post" enctype="multipart/form-data">
			<input type="hidden" name="image_manager" value="Y">
			<select name="selected_image" style="min-width:100px;">
				<?php itro_image_list(); ?>
			</select>
			<input class="button-primary" type="submit" name="submitSelect" value="<?php _e("Select", 'itro-plugin')?>">
			<input class="button-primary" type="submit" name="submitDelete" value="<?php _e("Delete", 'itro-plugin')?>">
			<p><?php _e('Current image link:','itro-plugin')?><a href="<?php echo itro_get_option('img_source');?>"><?php echo itro_get_option('img_source');?></a></p>
			<label for="file"><?php _e("Select the image", 'itro-plugin')?></label>
			<input type="file" name="file" id="file"><br>
			<input class="button-primary" type="submit" name="submitUpload" value="<?php _e("Upload", 'itro-plugin')?>">
			<input type="checkbox" name="overwrite" value="yes"><?php _e("Overwrite", 'itro-plugin')?>
		</form>
	</div>	
</div>
<?php } ?>