<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="index, follow">

<link href='http://fonts.googleapis.com/css?family=Orbitron:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo base_url("assets/images/qwar16x16.png");?>">
<?php $this->load->view("general/plugins"); ?>
<?php if(!isset($no_node) ){ ?>
<script src="<?php echo NODESERVERURL;?>/socket.io/socket.io.js"></script>
<script type="text/javascript">
var socket = io.connect("<?php echo NODESERVERURL;?>");
</script>
<?php } ?>
<?php $this->load->view("general/css"); ?>
<title><?php echo (isset($web_title))?$web_title:"QWar by Thinker";?></title>
</head>
<body>
<div id="base_url" alt="<?php echo base_url(); ?>" data-node="<?php echo NODESERVERURL;?>"></div>