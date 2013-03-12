<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
function itro_style() { ?>
	<style>
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

		#popup
		{
			position: <?php echo itro_get_option('popup_position');?>;
			background-image: url('<?php echo itro_get_option('background_source');?>');
			background-repeat: no-repeat;
			background-position: center center;
			margin: 0 auto;
			left:30px;
			right:30px;
			font-size: 10px;
			font-family: Verdana;
			z-index: 999999;
			<?php if( itro_get_option('auto_margin_check') == NULL  ) {echo 'margin-top:' . itro_get_option('popup_top_margin') . ';' ;}?>
			border: 4px solid <?php echo itro_get_option('popup_border_color');?>;
			border-radius: 8px 8px 8px 8px;
			width: <?php echo itro_get_option('popup_width');?>;
			height: <?php echo itro_get_option('popup_height');?>;
			background-color: <?php echo itro_get_option('popup_background'); ?>;
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
			padding:2px;
		}

		#customHtml
		{
			position: relative;
			background-color: <?php echo itro_get_option('text_bg_color') ?>;
			<?php
			if (itro_get_option('text_border_color') != NULL )
			{
				echo 'border-top: 3px solid' . itro_get_option('text_border_color') . ';' ;
				echo 'border-bottom: 3px solid' . itro_get_option('text_border_color') . ';' ;
			} ?>
			color: <?php echo itro_get_option('text_color') ?>;
			padding-left:10px;
			padding-right: 10px;
		}

		#opaco{
			opacity:0.6;
			position:fixed;
			z-index:99997;
			background-color: #eeeeee;
			font-size: 10px;
			font-family: Verdana;
			top: 100px;    
			width: 100%;
			height: 100%;
			z-index: 99998;
			left: 0px ;
			right: 0px;
			top: 0px;
			bottom: 0px;
			
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

		#donateForm
		{
		}
	</style>
<?php
}