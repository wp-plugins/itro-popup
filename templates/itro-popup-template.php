<div id="opaco" <?php if( itro_get_option('popup_delay') != NULL ) { echo ' style="visibility:hidden;" '; } ?>></div>
<div id="popup" <?php if( itro_get_option('popup_delay') != NULL ) { echo ' style="visibility:hidden;" '; } ?> >
	<div id="popup_content"><?php 
		$custom_field = stripslashes(itro_get_field('custom_html')); //insert custom html code 
		echo str_replace("\r\n",'',$custom_field); //return the string whitout new line
		if ( itro_get_option('age_restriction') == 'yes' ) 
		{?>
			<p id="age_button_area" align="center">
			<input type="button" id="ageEnterButton" onClick="popup.style.visibility='Hidden',opaco.style.visibility='Hidden'" value="<?php echo itro_get_option('enter_button_text');?>">
			<input type="button" id="ageLeaveButton" onClick="javascript:window.open('<?php echo itro_get_option('leave_button_url')?>','_self');" value="<?php echo itro_get_option('leave_button_text');?>">
			</p><?php
		} ?>
	</div> <?php
	if ( itro_get_option('age_restriction') == NULL ) 
		{?>
			<img id="close_cross" src="<?php echo itroPath . 'images/close-icon.png'; ?>" title="<?php _e('CLOSE','itro-plugin'); ?>" onclick="popup.style.visibility='Hidden',opaco.style.visibility='Hidden'">
			<div id="popup_countdown" align="center"><?php _e('This popup will be closed in: ','itro-plugin'); ?> <b id="timer"></b></div>
			<?php
		} ?>
</div>