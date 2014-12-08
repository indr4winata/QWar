<script src="<?php echo base_url('assets/plugins/jquery-1.10.2.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/jquery.form.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/jquery-ui-1.9.2.custom.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/select2-3.5.2/select2.min.js');?>" type="text/javascript"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<?php
if(isset($plugins_js)){
	foreach($plugins_js as $js){
	?>
	<script src="<?php echo base_url('assets/plugins/'.$js);?>" type="text/javascript"></script> 
	<?php
	}
}
?>
<?php
if(isset($plugins_css)){
	foreach($plugins_css as $css){
	?>
	<link href="<?php echo base_url('assets/plugins/'.$css);?>" media="all" rel="stylesheet" type="text/css">
	<?php
	}
}
?>
<script src="<?php echo base_url('assets/js/general.js');?>" type="text/javascript"></script>
