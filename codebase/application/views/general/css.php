<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2-3.5.2/select2.css');?>">

<link href="<?php echo base_url("assets/css/style.css");?>" media="all" rel="stylesheet" type="text/css">

<?php
if(isset($css)){
	foreach($css as $c){
	?>
	<link href="<?php echo base_url('assets/css/'.$c);?>" media="all" rel="stylesheet" type="text/css">
	<?php
	}
}
?>