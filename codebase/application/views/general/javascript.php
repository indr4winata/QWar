<?php
if(isset($javascript)){
	foreach($javascript as $script){
	?>
	<script src="<?php echo base_url('assets/js/'.$script);?>" type="text/javascript"></script> 
	<?php
	}
}
?>