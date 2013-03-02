<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/
function itro_popup_js()
{ 
	?>
	<script type="text/javascript">
	<?php
	if (itro_get_option('age_restriction')==NULL)
	{?>
		document.onkeydown = function(event) 
		{
			event = event || window.event;
			var key = event.keyCode;
			if(key==27){popup.style.visibility='Hidden'; opaco.style.visibility='Hidden';} 
		}
	<?php
	}?>
	
	<?php 
		if (itro_get_option('age_restriction')==NULL) //if is not set age restriction option popup will be closed automatically
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
			}
		<?php 
		}
		if( itro_get_option('auto_margin_check') != NULL )
		{?>
			setInterval(function(){marginRefresh()},100); //refresh every 0.1 second the popup top margin (needed for browser window resizeing)
			function marginRefresh()
			{
				//assign to x the window width and to y the window height
				var w = window, d = document, e = d.documentElement, g = d.getElementsByTagName('body')[0], x = w.innerWidth||e.clientWidth||g.clientWidth ;
				var y = w.innerHeight||e.clientHeight||g.clientHeight ;
				var popupHeight = document.getElementById('popup').offsetHeight ; 		//display the actual px size of popup div
				poupTopMargin = (y - popupHeight)/2; 									//calculate the top margin
				if(poupTopMargin > 0) {poupTopMargin = poupTopMargin/8};
				document.getElementById('popup').style.marginTop = poupTopMargin ; 		//update the top margin of popup
			}
		<?php 
		}?>
		function lastLoad() 
		{
			var customHtml = document.getElementById('customHtml');
			var html = '<?php echo stripslashes(itro_get_field('custom_html')); //insert custom html code?>';
			customHtml.innerHTML = html;
		}
		window.onload = lastLoad;
	</script>
<?php
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