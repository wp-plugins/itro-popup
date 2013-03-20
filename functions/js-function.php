<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
function itro_popup_js()
{
	echo '<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>'; ?>
	<script type="text/javascript">		
		<?php
		if (itro_get_option('age_restriction') == NULL) //insert script here to show when is not age restricted
		{?>			
			document.onkeydown = function(event) 
			{
				event = event || window.event;
				var key = event.keyCode;
				if(key==27){popup.style.visibility='Hidden'; opaco.style.visibility='Hidden';} 
			}
			<?php if ( itro_get_option('popup_time') != NULL )
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
				} <?php
			}
		}
		if( itro_get_option('auto_margin_check') != NULL )
		{?>
			var browserWidth = 0, browserHeight = 0;
			
			setInterval(function(){marginRefresh()},100); //refresh every 0.1 second the popup top margin (needed for browser window resizeing)
			function marginRefresh()
			{	
				if( typeof( window.innerWidth ) == 'number' ) 
				{
					//Non-IE
					browserWidth = window.innerWidth;
					browserHeight = window.innerHeight;
				} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
				{
					//IE 6+ in 'standards compliant mode'
					browserWidth = document.documentElement.clientWidth;
					browserHeight = document.documentElement.clientHeight;
				} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
				{
					//IE 4 compatible
					browserWidth = document.body.clientWidth;
					browserHeight = document.body.clientHeight;
				}
				popupHeight = document.getElementById('popup').offsetHeight ; 			//get the actual px size of popup div
				document.getElementById('popup').style.top = (browserHeight - popupHeight)/2; //update the top margin of popup					
			}
		<?php 
		}?>
	</script>
<?php	
}

function itro_admin_js()
{ ?>
	<script>
		function itro_mutual_check(checkbox_id_1,checkbox_id_2,box)
		{
			if (!box)
			{
				if( checkbox_id_2 == '' ) {document.getElementById(checkbox_id_1).checked = !document.getElementById(checkbox_id_1).checked; return 1;}
				if( checkbox_id_1 == '' ) {return 0;}
				if(checkbox_id_1 == checkbox_id_2) { return 0; }
				document.getElementById(checkbox_id_1).checked = !document.getElementById(checkbox_id_1).checked;
				if( document.getElementById(checkbox_id_1).checked || document.getElementById(checkbox_id_2).checked )
				{ document.getElementById(checkbox_id_2).checked = !document.getElementById(checkbox_id_1).checked; }
			}
			else
			{
				if( document.getElementById(checkbox_id_1).checked || document.getElementById(checkbox_id_2).checked )
				{ document.getElementById(checkbox_id_2).checked = !document.getElementById(checkbox_id_1).checked; }
			}
		}
		jQuery(document).ready(function() {
		
		var orig_send_to_editor = window.send_to_editor;
		var uploadID = ''; /*setup the var in a global scope*/

		jQuery('#upload_button').click(function() {
		uploadID = jQuery(this).prev('input'); /*set the uploadID variable to the value of the input before the upload button*/
		formfield = jQuery('.upload').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;amp;amp;TB_iframe=true');
		
		//restore send_to_editor() when tb closed
		jQuery("#TB_window").bind('tb_unload', function () {
		window.send_to_editor = orig_send_to_editor;
		});
		
		//temporarily redefine send_to_editor()
		window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		uploadID.val(imgurl); /*assign the value of the image src to the input*/
		document.getElementById('yes_bg').checked=true
		tb_remove();
		};
		
		return false;
		});

		
		});
	</script><?php
} 

function itro_onOff($tag_id,$overflow){
if( $overflow == 'hidden') {?>
	<style>#<?php echo $tag_id;?>{overflow:hidden;}</style><?php
} ?>
<script>
	var <?php echo $tag_id;?>_flag=true;
	function onOff_<?php echo $tag_id;?>() {
	   if (<?php echo $tag_id;?>_flag==true) { document.getElementById('<?php echo $tag_id;?>').style.height='0px'; }
	   else { document.getElementById('<?php echo $tag_id;?>').style.height='auto'; }
	<?php echo $tag_id;?>_flag=!<?php echo $tag_id;?>_flag;
	}
</script>
<?php 
}

function itro_onOff_checkbox($box_id,$tag_id,$init_state){
?>
<style>#<?php echo $tag_id;?>{overflow:hidden;}</style>
<script>
	function <?php echo $box_id;?>_checkbox_<?php echo $tag_id;?>()
	{
		if (<?php echo $box_id;?>.checked==<?php echo $init_state ?>) {document.getElementById('<?php echo $tag_id;?>').style.height='0px';}
		else {document.getElementById('<?php echo $tag_id;?>').style.height='auto';}
	}
</script>
<?php 
}
?>