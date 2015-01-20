
<?php
    echo Form::open_for_files('/nuevo-registro-categoria','POST'); 
    echo Form::label('nombre', 'Nombre'); 
    echo Form::text('nombre', '', array('class'=>'span12'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
?>