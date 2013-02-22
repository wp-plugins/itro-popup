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
function get_itro_style() { ?>
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

#donateForm
{
}
#leftColumn
{
	float:left;
}

#rightColumn
{
	float:right;
	margin-right:10%;
}

#colorTable
{
	margin: 0 auto;
	display: block; 
	width:400px;
	height:400px;
	clear:right;
}

#popup
{
	position: fixed;
	margin: 0 auto;
	left:30px;
	right:30px;
    font-size: 10px;
    font-family: Verdana;
	z-index: 999999;
	border: 4px solid <?php echo itro_get_option('popup_border_color');?>;
	border-radius: 8px 8px 8px 8px;
	width: <?php echo itro_get_option('popup_width');?>%;
	background-color: <?php echo itro_get_option('popup_background'); ?>;
}

#popup_image
{
    font-size: 10px;
    font-family: Verdana;
	z-index: 99998;
	width:80%;
	height:80%;
	margin-left:10%;
}

/* POPUP */
#popup_text {
	z-index:99999;
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
<?php } ?>