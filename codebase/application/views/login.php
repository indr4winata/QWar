<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>QWar by Thinker</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href='http://fonts.googleapis.com/css?family=Orbitron:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Orbitron:400,700' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css"> -->
        <!-- <link rel="stylesheet" href="css/style.css"> -->
		<link rel="shortcut icon" href="<?php echo base_url("assets/images/qwar16x16.png");?>">
		<?php $this->load->view("general/css"); ?>
        <!--script src="js/vendor/modernizr-2.6.2.min.js"></script-->
    </head>
    <body class="loginpage">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="container vertical-align"> 
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="loginform text-center orbitron">
                        <!-- img src="<?php echo site_url('assets'); ?>/images/qwar_logo.png" alt="" class="img-responsive center-block" style="max-width: 200px;margin-bottom: 30px;"-->
                        <h1 class="mt0"><strong>Q-WAR</strong></h1>
                        <a href="<?php echo site_url('login/facebook'); ?>" class="btn-facebook"><i class="fa fa-facebook"></i> Login using Facebook</a>
                        <p class="text-center">OR</p>
                        <a href="<?php echo site_url('login/twitter'); ?>" class="btn-twitter"><i class="fa fa-twitter"></i> Login using Twitter</a>
                       
                    </div>
                </div>
            </div>
        </div>
        

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

        <!-- script src="js/plugins.js"></script-->
        <!-- script src="js/main.js"></script-->
		<?php $this->load->view("general/javascript"); ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    </body>
</html>
