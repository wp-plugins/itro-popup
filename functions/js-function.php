<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
function itro_popup_js()
{
	echo '<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>';
	//this condition, control if the popup must or not by displayed in a specified page
	$selected_page_id = json_decode(itro_get_option('selected_page_id'));
	$id_match = NULL;
	if( isset($selected_page_id) ) 
	{
		foreach ($selected_page_id as $single_id)
		{if ($single_id==get_the_id()) $id_match++; }
	}
	if(itro_get_option('page_selection')!='any' && !isset($_COOKIE['popup_cookie']) )
	if( ($id_match != NULL) || (itro_get_option('page_selection')=='all') )
	{
	//------------------------- insert script under this line to load it only if popup is displayed
	?>
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
				<?php 
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
}

function itro_onOff($tag_id){
?>
<style>#<?php echo $tag_id;?>{overflow:hidden;}</style>
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