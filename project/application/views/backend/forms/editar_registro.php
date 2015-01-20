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
        echo Form::open_for_files('/admin-control/editar-registro/'.$info->id_establecimiento.'/'.$info->id_categoria,'POST'); 
        echo Form::label('nombre', 'Nombre de Establecimiento'); 
        echo Form::text('nombre', ($catalogo)?$catalogo['nombre']:$info->nombre, array('class'=>'span12'));
        echo Form::label('descripcion', 'Descripcion'); 
        echo Form::textarea('descripcion', ($catalogo)?$catalogo['descripcion']:$info->descripcion, array('class'=>'span12'));
        echo Form::label('telefono', 'Telefono'); 
        echo Form::text('telefono', ($catalogo)?$catalogo['telefono']:$info->telefono, array('class'=>'span12'));
        echo Form::label('id_zona', 'Zona'); 
        echo Form::select('id_zona',$zonas, ($catalogo)?$catalogo['id_zona']:$info->id_zona, 
                array('class'=>'span12','autocomplete'=>'off'));
        echo Form::label('direccion', 'Direccion'); 
        echo Form::text('direccion', ($catalogo)?$catalogo['direccion']:$info->direccion, array('class'=>'span12'));
        echo Form::label('url_facebook', 'URL Facebook'); 
        echo Form::url('url_facebook', ($catalogo)?$catalogo['url_facebook']:$info->url_facebook, array('class'=>'span12'));
        echo Form::label('sitio_web', 'Sitio Web'); 
        echo Form::url('sitio_web', ($catalogo)?$catalogo['sitio_web']:$info->sitio_web, array('class'=>'span12'));
        echo Form::label('url_mapa', 'URL Mapa'); 
        echo Form::url('url_mapa', ($catalogo)?$catalogo['url_mapa']:$info->url_mapa, array('class'=>'span12'));
        echo Form::label('url_imagen', 'URL Imagen');
        echo ($catalogo)?'<img src="/images/'.$categoria.'/'.$catalogo['url_imagen'].'" style="width: 45px; height: 45px;"/>':'<img src="/images/'.$categoria.'/'.$info->url_imagen.'" style="width: 45px; height: 45px;"/>';
        echo Form::text('url_imagen_old', ($catalogo)?$catalogo['url_imagen']:$info->url_imagen, array('style'=>'display:none;'));
        echo Form::file('url_imagen', array('class'=>'span12'));
        echo Form::label('destacado', 'Destacado'); 
        echo Form::select('destacado',array('1'=>'Si', '0'=>'No'), ($catalogo)?$catalogo['destacado']:$info->destacado, 
                array('class'=>'span12','autocomplete'=>'off'));
        echo Form::label('prioridad', 'Prioridad'); 
        echo Form::select('prioridad',array('1'=>'Exclusivo', '2'=>'Alta', '3'=>'Normal', '4'=>'Baja'), ($catalogo)?$catalogo['prioridad']:$info->prioridad, 
                array('class'=>'span12','autocomplete'=>'off'));
        echo Form::label('estado', 'Estado'); 
        echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:$info->estado, 
            array('class'=>'span12','autocomplete'=>'off'));
        echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
        echo Form::token(); 
        echo Form::close();
?>
    </div>
</div>