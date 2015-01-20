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
    echo Form::open_for_files('/admin-control/nueva-publicidad','POST'); 
    echo Form::label('titulo', 'Titulo'); 
    echo Form::text('titulo', ($catalogo)?$catalogo['titulo']:'', array('class'=>'span12'));
    echo Form::label('descripcion', 'Descripcion'); 
    echo Form::textarea('descripcion', ($catalogo)?$catalogo['descripcion']:'', array('class'=>'span12'));
    echo Form::label('url_imagen', 'URL Imagen'); 
    echo Form::file('url_imagen', array('class'=>'span12'));
    echo Form::label('enlace', 'Enlace'); 
    echo Form::url('enlace', ($catalogo)?$catalogo['enlace']:'', array('class'=>'span12'));
    echo Form::label('area', 'Area'); 
    /*echo Form::select('area',array('1'=>'menu', '2'=>'busqueda', '3'=>'resultados'), ($catalogo)?$catalogo['area']:'1', 
            array('class'=>'span12','autocomplete'=>'off'));*/
    echo '<div style="padding:1em;">';
    if($catalogo) {
        switch($catalogo['area']) {
            case '1' :
                echo Form::radio('area', '1', true).' Menu'.'<br/>';
                echo Form::radio('area', '2').' Busqueda'.'<br/>';
                echo Form::radio('area', '3').' Resultados'.'<br/>';
                echo Form::radio('area', '4').' Todos'.'<br/>';
                break;
            case '2' :
                echo Form::radio('area', '1').' Menu'.'<br/>';
                echo Form::radio('area', '2', true).' Busqueda'.'<br/>';
                echo Form::radio('area', '3').' Resultados'.'<br/>';
                echo Form::radio('area', '4').' Todos'.'<br/>';
                break;
            case '3' :
                echo Form::radio('area', '1').' Menu'.'<br/>';
                echo Form::radio('area', '2').' Busqueda'.'<br/>';
                echo Form::radio('area', '3', true).' Resultados'.'<br/>';
                echo Form::radio('area', '4').' Todos'.'<br/>';
                break;
            case '4' :
                echo Form::radio('area', '1').' Menu'.'<br/>';
                echo Form::radio('area', '2').' Busqueda'.'<br/>';
                echo Form::radio('area', '3').' Resultados'.'<br/>';
                echo Form::radio('area', '4', true).' Todos'.'<br/>';
                break;
            default:
                echo Form::radio('area', '1').' Menu'.'<br/>';
                echo Form::radio('area', '2').' Busqueda'.'<br/>';
                echo Form::radio('area', '3').' Resultados'.'<br/>';
                echo Form::radio('area', '4').' Todos'.'<br/>';
                break;
        }
    } else {
        echo Form::radio('area', '1').' Menu'.'<br/>';
        echo Form::radio('area', '2').' Busqueda'.'<br/>';
        echo Form::radio('area', '3').' Resultados'.'<br/>';
        echo Form::radio('area', '4').' Todos'.'<br/>';
    } 
    echo '</div>';
    echo Form::label('prioridad', 'Prioridad'); 
    echo Form::select('prioridad',array('1'=>'Importante', '2'=>'Normal', '3'=>'Irrelevante'), ($catalogo)?$catalogo['prioridad']:'2', 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('estado', 'Estado'); 
    echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:'1', 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
?>
    </div>
</div>