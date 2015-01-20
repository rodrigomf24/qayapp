<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Qay App</title>
        <link rel="stylesheet" href="/public/ui/css/normalize.css">
	<link rel="stylesheet" href="/public/ui/css/global.css">
	<!--BOOTSRAP-->
	<link rel="stylesheet" href="/public/ui/bootstrap/css/bootstrap.css">
	    <link rel="stylesheet" href="/public/ui/bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" href="<?php if(isset($data) && !empty($data['css'])){echo $data['css'];}?>">
	
	<script type="text/javascript" src="/public/ui/script/jquery.js"></script>
	<script type="text/javascript" src="/public/ui/script/global.js"></script>
        <script type="text/javascript" src="<?php if(isset($data) && !empty($data['script'])){echo $data['script'];}?>"></script>
	<!--BOOTSRAP-->
	<script type="text/javascript" src="/public/ui/bootstrap/js/bootstrap.js"></script>
	
        <!--[if lt IE 9]>
		<script src="/public/ui/script/respond.min.js"></script>
	<![endif]-->
    </head>
    <body>
	<div class="wrapper">
	    <!--<header id="header">
		<div class="container">
		    <div class="row">
			<div class="span3 logo">
			    <a>
				<img id="header_logo" src="/public/ui/img/badge2.png"/>
			    </a>
			</div>
			<nav id="menu" class="pull-right">
			    <ul class="nav-pills">
				<li><a href="/" id="home">home</a></li>
				<li><a  href="/menu/about" id="about">about</a></li>
				<li><a href="/menu/portfolio">portfolio</a></li>
				<li><a href="/menu/contact" id="contact">contact</a></li>
				<li><a href="/menu/blog">blog</a></li>
			    </ul>
			</nav>
		    </div>
		</div>
	    </header>
	    <nav id="menu_small" class="">
		<ul>
		    <li><a id="show_menu_list">menu</a></li>
		    <li><a href="/" id="home">home</a></li>
		    <li><a  href="/menu/about" id="about">about</a></li>
		    <li><a href="/menu/portfolio">portfolio</a></li>
		    <li><a href="/menu/contact" id="contact">contact</a></li>
		    <li><a href="/menu/blog">blog</a></li>
		</ul>
	    </nav>
	    <div id="nav-bar" hidden class="row nav-bar-fixed nav-bar">
		<div class="nav-bar-wrapper">
		  <div class="row">
		    <nav>
		      <ul class="menu nav pull-right nav-pills">
			<li><a href="/" id="home">home</a></li>
			<li><a  href="/menu/about" id="about">about</a></li>
			<li><a href="/menu/portfolio">portfolio</a></li>
			<li><a href="/menu/contact" id="contact">contact</a></li>
			<li><a href="/menu/blog">blog</a></li>
		      </ul>
		    </nav>
		  </div>
		</div>
	    </div>-->
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