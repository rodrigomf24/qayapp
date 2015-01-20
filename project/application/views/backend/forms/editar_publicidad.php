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
    $id_publicidad = ($catalogo) ? $catalogo['id_publicidad'] : $publicidad->id_publicidad;
    echo Form::open_for_files('/admin-control/editar-publicidad/'.$id_publicidad,'POST'); 
    echo Form::label('titulo', 'Titulo'); 
    echo Form::text('titulo', ($catalogo)?$catalogo['titulo']:$publicidad->titulo, array('class'=>'span12'));
    echo Form::label('descripcion', 'Descripcion'); 
    echo Form::textarea('descripcion', ($catalogo)?$catalogo['descripcion']:$publicidad->descripcion, array('class'=>'span12'));
    echo Form::label('url_imagen', 'URL Imagen');
    echo ($catalogo)?'<img src="/images/publicidad/'.$catalogo['url_imagen'].'" style="width: 45px; height: 45px;"/>':'<img src="/images/publicidad/'.$publicidad->url_imagen.'" style="width: 45px; height: 45px;"/>';
    echo Form::text('url_imagen_old', ($catalogo)?$catalogo['url_imagen']:$publicidad->url_imagen, array('style'=>'display:none;'));
    echo Form::file('url_imagen', array('class'=>'span12'));
    echo Form::label('enlace', 'Enlace'); 
    echo Form::url('enlace', ($catalogo)?$catalogo['enlace']:$publicidad->enlace, array('class'=>'span12'));
    echo Form::label('area', 'Area'); 
    /*echo Form::select('area',array('1'=>'menu', '2'=>'busqueda', '3'=>'resultados'), ($catalogo)?$catalogo['area']:$publicidad->area, 
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
    } elseif($publicidad) {
        switch($publicidad->area) {
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
    }else {
        echo Form::radio('area', '1').' Menu'.'<br/>';
        echo Form::radio('area', '2').' Busqueda'.'<br/>';
        echo Form::radio('area', '3').' Resultados'.'<br/>';
        echo Form::radio('area', '4').' Todos'.'<br/>';
    } 
    echo '</div>';
    echo Form::label('prioridad', 'Prioridad'); 
    echo Form::select('prioridad',array('1'=>'Importante', '2'=>'Normal', '3'=>'Irrelevante'), ($catalogo)?$catalogo['prioridad']:$publicidad->prioridad, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('estado', 'Estado'); 
    echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:$publicidad->estado, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
?>
    </div>
</div>