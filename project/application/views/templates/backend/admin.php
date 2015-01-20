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
	    <div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
		  <div class="container">
		    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		    </button>
		    <a class="brand" href="/admin-control/dashboard">Qay-Admin</a>
		    <div class="nav-collapse collapse">
		      <ul class="nav pull-right">
			<li><a href="/admin-control/menu/logout">Logout</span></a></li>
		      </ul>
		    </div>
		  </div>
		</div>
	    </div>
            <section id="container">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span2">
                            <div class="span12">
                                <div class="well sidebar-nav">
                                    <ul class="nav nav-list">
                                        <li class="nav-header">Categorias</li>
                                        <li><a href="/admin-control/menu/bares">Bares</a></li>
                                        <li><a href="/admin-control/menu/restaurantes">Restaurantes</a></li>
                                        <li><a href="/admin-control/menu/discotecas">Discotecas</a></li>
					<li><a href="/admin-control/menu/teatro">Teatro</a></li>
					<li><a href="/admin-control/menu/deportes">Deportes</a></li>
					<li><a href="/admin-control/menu/espectaculos">Espectaculos</a></li>
					<li><a href="/admin-control/menu/eventos">Evento del dia</a></li>
					<li><a href="/admin-control/menu/shopping">Shopping</a></li>
                                        <li class="nav-header">Publicidad</li>
                                        <li><a href="/admin-control/menu/publicidad">Listado</a></li>
					<li class="nav-header">Zonas</li>
					<li><a href="/admin-control/menu/zonas">Listado</a></li>
					<li class="nav-header">Usuario</li>
					<li><a href="/admin-control/menu/usuarios">Listado</a></li>
                                    </ul>
                                </div><!--/.well -->
                            </div><!--/span-->
                        </div>
			           
                        <div class="span10">
			    <?php
			    $form_error = Session::get('form_error');
			    if(!is_null($form_error)) echo AdminHelpers::redAlert($form_error);
			    ?>              
			    <?php
			    $form_advice = Session::get('form_advice');
			    if(!is_null($form_advice)) echo AdminHelpers::blueAlert($form_advice);
			    ?>   
                            <?php echo $child ?>
                        </div>
                    </div>
                </div>
            </section>
	</div>
    </body>
</html>