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
    echo Form::open_for_files('/admin-control/nueva-zona','POST'); 
    echo Form::label('nombre', 'Nombre'); 
    echo Form::text('nombre', '', array('class'=>'span12'));
    echo Form::label('pais', 'Pais'); 
    echo Form::text('pais', '', array('class'=>'span12'));
    echo Form::label('departamento', 'Departamento/Estado'); 
    echo Form::text('departamento', '', array('class'=>'span12'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
?>
    </div>
</div>