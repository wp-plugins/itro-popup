<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
function itro_style() { ?>
	<style>
		#age_button_area
		{
			padding-top:10px;
			position: relative;
			width: 100%;
			bottom: 5px;
			padding-top:5px;
		}
		
		#ageEnterButton
		{
			border-color:<?php echo itro_get_option('enter_button_border_color')?>;
			background:<?php echo itro_get_option('enter_button_bg_color')?>;
			color: <?php echo itro_get_option('enter_button_font_color');?>;
		}

		#ageLeaveButton
		{
			border-color:<?php echo itro_get_option('leave_button_border_color')?>;
			background:<?php echo itro_get_option('leave_button_bg_color')?>;
			color: <?php echo itro_get_option('leave_button_font_color');?>;
		}
		
		#popup_content
		{
			<?php 
			if( itro_get_option('select_popup_height') == 'px' || itro_get_option('select_popup_height') == '%' ) 
			{echo 'overflow-y:auto;' ;} 
			else { echo 'overflow-y:hidden;' ;}
			?>
			overflow-x: auto;
			height: 100%;
			width:100%;
			
		}
		
		#itro_popup
		{
			color: <?php echo itro_get_option('text_color') ?>;
			position: <?php echo itro_get_option('popup_position');?>;
			background-image: <?php if (itro_get_option('background_select') != NULL ) { echo 'url("' . itro_get_option('background_source') . '");'; } ?>
			background-repeat: no-repeat;
			background-position: center center;
			margin: 0 auto;
			left:30px;
			right:30px;
			font-size: 10px;
			font-family: Verdana;
			z-index: 9999999;
			<?php if( itro_get_option('auto_margin_check') == NULL  ) {echo 'margin-top:' . itro_get_option('popup_top_margin') . 'px;' ;}
			if (itro_get_option('popup_border_color') != NULL ) {echo 'border: 4px solid' . itro_get_option('popup_border_color') . ';';}?>			
			border-radius: 8px 8px 8px 8px;
			width: <?php 
					if( itro_get_option('select_popup_width') == 'px') { echo itro_get_option('px_popup_width') . 'px'; }
					if( itro_get_option('select_popup_width') == 'perc') { echo itro_get_option('perc_popup_width') . '%'; }
					?>;
			height: <?php 
					if( itro_get_option('select_popup_height') == 'px') { echo itro_get_option('px_popup_height') . 'px'; }
					if( itro_get_option('select_popup_height') == 'perc') { echo itro_get_option('perc_popup_height') . '%'; }
					?>;
			background-color: <?php echo itro_get_option('popup_background'); ?>;
			<?php if( itro_get_option('show_countdown') != NULL ) { echo 'padding-bottom: 15px;'; } ?>
			<?php if( itro_get_option('popup_delay') != 0 ) { echo 'visibility:hidden;'; } ?>
		}
		
		#close_cross
		{
			cursor:pointer; 
			width:20px; 
			position:absolute; 
			top:-22px; 
			right:-22px;
		}

		#popup_image
		{
			width: <?php echo itro_get_option('image_width'); ?>%;
			margin: 0 auto;
			display:block;
		}

		#popup_countdown 
		{
			color: <?php echo itro_get_option('count_font_color') ?>;
			width: 100%;
			padding-top: <?php if( itro_get_option('show_countdown') != 'yes' ) { echo '0px'; } else {echo '1px';}?> ;
			padding-bottom:<?php if( itro_get_option('show_countdown') != 'yes' ) { echo '0px'; } else {echo '1px';}?> ;
			background-color: <?php echo itro_get_option('popup_border_color');?>;
			height: <?php if( itro_get_option('show_countdown') != 'yes' ) { echo '0px'; }?> ;
			overflow: hidden;
			position:absolute;
		}

		#itro_opaco{
			opacity:0.6;
			position:fixed;
			background-color:  <?php echo itro_get_option('opaco_bg_color'); ?>;
			font-size: 10px;
			font-family: Verdana;
			top: 100px;    
			width: 100%;
			height: 100%;
			z-index: 999999;
			left: 0px ;
			right: 0px;
			top: 0px;
			bottom: 0px;
			<?php if( itro_get_option('popup_delay') != 0 ) { echo 'visibility:hidden;'; } ?>
			opacity: <?php echo itro_get_option('popup_bg_opacity'); ?> ;
			filter:alpha(opacity = <?php echo ( itro_get_option('popup_bg_opacity') * 100); ?>); /* For IE8 and earlier */
		}

		@media screen and (max-width: 480px){
			 #popup_image2{width:80%;}
			 #popup_text2{width:100%;margin-top:80%;}
		}
	</style>
<?php 
}

function itro_admin_style ()
{ ?>
	<style>
		.wpstyle
		{
			background: linear-gradient(to top, rgb(236, 236, 236), rgb(249, 249, 249)) repeat scroll 0% 0% rgb(241, 241, 241);
			padding: 7px 10px;
			font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
			border-radius: 3px 3px 3px 3px;
			color: rgb(70, 70, 70);
			border-bottom-color: rgb(223, 223, 223);
			text-shadow: 0px 1px 0px rgb(255, 255, 255);
			box-shadow: 0px 1px 0px rgb(255, 255, 255);
			border-bottom-width: 1px;
			border-bottom-style: solid;
			-moz-user-select: none;
			cursor: pointer;
		}
		
		#wp-custom_html-editor-container #custom_html_ifr
		{ 
			width: 450px !important;
		}
		
		#leftColumn
		{
			float:left;
			width:450px;
		}

		#rightColumn
		{
			float:right;
			margin-right:10%;
			width:450px;
		}
		
		#rightColumn2
		{
			clear:right;
			float:right;
			margin-right:10%;
			width:450px;
		}
		
		#customHtmlForm
		{
			overflow: show;
		}

		#donateForm
		{
		}
	</style>
<?php
} ?>