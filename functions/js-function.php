<?php
/*
Copyright 2013  I.T.RO.® (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.
All Right Reserved.
*/

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