<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Laravel | rmorales</title>
        
	<link rel="stylesheet" href="/ui/css/global.css">
	<!--BOOTSRAP-->
	<link rel="stylesheet" href="/ui/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/ui/bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="/ui/backend/css/global.css">
        <link rel="stylesheet" href="<?php if(isset($data) && !empty($data['css'])){echo $data['css'];}?>">
	
	<script type="text/javascript" src="/ui/script/jquery.js"></script>
	<script type="text/javascript" src="/ui/script/global.js"></script>
        <script type="text/javascript" src="<?php if(isset($data) && !empty($data['script'])){echo $data['script'];}?>"></script>
	<!--BOOTSRAP-->
	<script type="text/javascript" src="/ui/bootstrap/js/bootstrap.js"></script>
	
        <!--[if lt IE 9]>
		<script src="/ui/script/respond.min.js"></script>
	<![endif]-->
    </head>
    <body>
	<div class="wrapper">
	    <section id="container">
		<div class="container">
		    <div class="row">
			<section class="span12">
			    <?php echo $child ?>
			</section>
		    </div>
		</div>
	    </section>
	</div>
    </body>
</html>