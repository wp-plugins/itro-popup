<?php 
function itro_popup_template()
{ ?>
	<div id="itro_popup" style="visibility:hidden">
		<div id="popup_content"><?php
			$custom_field = stripslashes(itro_get_field('custom_html')); //insert custom html code 
			echo str_replace("\r\n",'',$custom_field); //return the string whitout new line
			if ( itro_get_option('age_restriction') == 'yes' ) 
			{?>
				<p id="age_button_area" align="center">
				<input type="button" id="ageEnterButton" onClick="itro_set_cookie('popup_cookie','one_time_popup',<?php echo itro_get_option('cookie_time_exp'); ?>); jQuery('#itro_popup').fadeOut(function(){itro_opaco.style.visibility='hidden';})" value="<?php echo itro_get_option('enter_button_text');?>">
				<input type="button" id="ageLeaveButton" onClick="javascript:window.open('<?php echo itro_get_option('leave_button_url')?>','_self');" value="<?php echo itro_get_option('leave_button_text');?>">
				</p><?php
			}
			?>
		</div> <?php
		if ( itro_get_option('age_restriction') == NULL ) 
			{?>
				<img id="close_cross" src="<?php echo itroPath . 'images/close-icon.png'; ?>" title="<?php _e('CLOSE','itro-plugin'); ?>" onclick="jQuery('#itro_popup').fadeOut(function(){itro_opaco.style.visibility='hidden';})">
				<div id="popup_countdown" align="center"><?php _e('This popup will be closed in: ','itro-plugin'); ?> <b id="timer"></b></div>
				<?php
			} ?>
	</div>
	<div id="itro_opaco" style="visibility:hidden"></div>
<?php
}
?>