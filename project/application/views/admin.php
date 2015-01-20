<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Qay App</title>
        
	<link rel="stylesheet" href="/public/ui/css/global.css">
	<!--BOOTSRAP-->
	<link rel="stylesheet" href="/public/ui/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/public/ui/bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" href="/public/ui/backend/css/global.css">
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
                                        <li class="nav-header">Publicidad</li>
                                        <li><a href="/admin-control/menuidad_nuevo_registro">Nuevo</a></li>
                                        <li><a href="/admin-control/menuidad_listado">Listado</a></li>
					<li class="nav-header">Usuario</li>
					
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