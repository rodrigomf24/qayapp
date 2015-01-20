<?php
    if(Session::has('catalogo')) {
        $catalogo = Session::get('catalogo');
    } else {
        $catalogo = false;
    }
?>
<div class="row">
    <div class="span8 offset1">
<?php
    echo Form::open_for_files('/admin-control/nuevo-usuario','POST'); 
    echo Form::label('nombre', 'Nombre'); 
    echo Form::text('nombre', ($catalogo)?$catalogo['nombre']:'', array('class'=>'span12'));
    echo Form::label('apellido', 'Apellido'); 
    echo Form::text('apellido', ($catalogo)?$catalogo['apellido']:'', array('class'=>'span12'));
    echo Form::label('email', 'Email'); 
    echo Form::email('email', ($catalogo)?$catalogo['email']:'',array('class'=>'span12'));
    echo Form::label('password', 'Contraseña'); 
    echo Form::password('password', array('class'=>'span12'));
    echo Form::label('password', 'Confirmar Contraseña');
    echo Form::password('password_validate', array('class'=>'span12'));
    echo Form::label('estado', 'Estado'); 
    echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:'1', 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('tipo', 'Tipo'); 
    echo Form::select('tipo',array('1'=>'Digitador', '2'=>'Administrador', '10'=>'Webadmin'), ($catalogo)?$catalogo['tipo']:'1', 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
?>
    </div>
</div>