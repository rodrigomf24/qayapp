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
    echo Form::open_for_files('/admin-control/editar-evento/'.$evento->id_evento.'/'.$id_categoria,'POST'); 
    echo Form::label('nombre', 'Nombre'); 
    echo Form::text('nombre', ($catalogo)?$catalogo['nombre']:$evento->nombre, array('class'=>'span12'));
    echo Form::label('descripcion', 'Descripcion'); 
    echo Form::textarea('descripcion', ($catalogo)?$catalogo['descripcion']:$evento->descripcion, array('class'=>'span12'));
    echo Form::label('id_establecimiento', 'Establecimiento'); 
    echo Form::select('id_establecimiento',$establecimientos, ($catalogo)?$catalogo['id_establecimiento']:$evento->id_establecimiento, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('url_imagen', 'URL Imagen');
    echo '<img src="/images/eventos/'.$categoria.'/'.$evento->url_imagen.'" style="width: 45px; height: 45px;"/>';
    echo Form::text('url_imagen_old', $evento->url_imagen, array('style'=>'display:none;'));
    echo Form::file('url_imagen', array('class'=>'span12'));
    echo Form::label('url_evento_fb', 'URL Evento en Facebook'); 
    echo Form::url('url_evento_fb', ($catalogo)?$catalogo['url_evento_fb']:$evento->url_evento_fb, array('class'=>'span12'));
    echo Form::label('url_evento', 'URL Evento'); 
    echo Form::url('url_evento', ($catalogo)?$catalogo['url_evento']:$evento->url_evento, array('class'=>'span12'));
    echo Form::label('url_mapa', 'URL Mapa'); 
    echo Form::url('url_mapa', ($catalogo)?$catalogo['url_mapa']:$evento->url_mapa, array('class'=>'span12'));
     echo Form::label('tipo_registro', 'Elija el tipo de registro: ');
    echo '<div style="padding:1em;">';
    if(($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 1) || ($evento && isset($evento->tipo_registro) && $evento->tipo_registro == 1)) {
        echo Form::radio('tipo_registro', '1', true).' Repetitivo(multiples dias/por dia)'.'<br/>';
    } else {
        echo Form::radio('tipo_registro', '1').' Repetitivo(multiples dias/por dia)'.'<br/>';
    }
    if(($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 2) || ($evento && isset($evento->tipo_registro) && $evento->tipo_registro == 2)) {
        echo Form::radio('tipo_registro', '2', true).' Fecha especifica'.'<br/>';
    } else {
        echo Form::radio('tipo_registro', '2').' Fecha especifica'.'<br/>';
    }
    echo '</div>';
    echo '<div class="dias-box" style="padding:1em;">';
    echo Form::label('dias', 'Dias a repetir el Evento'); 
    echo ($catalogo) ? (($catalogo['lunes']) ? Form::checkbox('dias[]', '1', true) .' Lunes'.'<br/>' : Form::checkbox('dias[]', '1').' Lunes'.'<br/>')
                    : (($evento->lunes) ? Form::checkbox('dias[]', '1', true) .' Lunes'.'<br/>' : Form::checkbox('dias[]', '1').' Lunes'.'<br/>');
    echo ($catalogo) ? (($catalogo['martes']) ? Form::checkbox('dias[]', '2', true) .' Martes'.'<br/>' : Form::checkbox('dias[]', '2').' Martes'.'<br/>')
                    : (($evento->martes) ? Form::checkbox('dias[]', '2', true) .' Martes'.'<br/>' : Form::checkbox('dias[]', '2').' Martes'.'<br/>');
    echo ($catalogo) ? (($catalogo['miercoles']) ? Form::checkbox('dias[]', '3', true) .' Miercoles'.'<br/>' : Form::checkbox('dias[]', '3') .' Miercoles'.'<br/>')
                    : (($evento->miercoles) ? Form::checkbox('dias[]', '3', true) .' Miercoles'.'<br/>' : Form::checkbox('dias[]', '3') .' Miercoles'.'<br/>');
    echo ($catalogo) ? (($catalogo['jueves']) ? Form::checkbox('dias[]', '4', true) .' Jueves'.'<br/>' : Form::checkbox('dias[]', '4').' Jueves'.'<br/>')
                    : (($evento->jueves) ? Form::checkbox('dias[]', '4', true) .' Jueves'.'<br/>' : Form::checkbox('dias[]', '4').' Jueves'.'<br/>');
    echo ($catalogo) ? (($catalogo['viernes']) ? Form::checkbox('dias[]', '5', true) .' Viernes'.'<br/>' : Form::checkbox('dias[]', '5').' Viernes'.'<br/>')
                    : (($evento->viernes) ? Form::checkbox('dias[]', '5', true) .' Viernes'.'<br/>' : Form::checkbox('dias[]', '5').' Viernes'.'<br/>');
    echo ($catalogo) ? (($catalogo['sabado']) ? Form::checkbox('dias[]', '6', true) .' Sabado'.'<br/>' : Form::checkbox('dias[]', '6').' Sabado'.'<br/>')
                    : (($evento->sabado) ? Form::checkbox('dias[]', '6', true) .' Sabado'.'<br/>' : Form::checkbox('dias[]', '6').' Sabado'.'<br/>');
    echo ($catalogo) ? (($catalogo['domingo']) ? Form::checkbox('dias[]', '7', true) .' Domingo'.'<br/>' : Form::checkbox('dias[]', '7').' Domingo'.'<br/>')
                    : (($evento->domingo) ? Form::checkbox('dias[]', '7', true) .' Domingo'.'<br/>' : Form::checkbox('dias[]', '7').' Domingo'.'<br/>');
    echo ($catalogo) ? (($catalogo['todos']) ? Form::checkbox('dias[]', '8', true) .' Todos'.'<br/>' : Form::checkbox('dias[]', '8').' Todos'.'<br/>')
                    : (($evento->todos) ? Form::checkbox('dias[]', '8', true) .' Todos'.'<br/>' : Form::checkbox('dias[]', '8').' Todos'.'<br/>');
    echo '</div>';
    echo '<div class="fecha-box">';
    echo Form::label('fecha', 'Fecha del Evento'); 
    echo Form::date('fecha', ($catalogo)?date('Y-m-d',strtotime($catalogo['fecha'])):date('Y-m-d', strtotime($evento->fecha)), array('class'=>'span12'));
    echo '</div>';
    echo Form::label('destacado', 'Destacado'); 
    echo Form::select('destacado',array('1'=>'Si', '0'=>'No'), ($catalogo)?$catalogo['destacado']:$evento->destacado, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('prioridad', 'Prioridad'); 
    echo Form::select('prioridad',array('1'=>'Exclusivo', '2'=>'Alta', '3'=>'Normal', '4'=>'Baja'), ($catalogo)?$catalogo['prioridad']:$evento->prioridad, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('estado', 'Estado'); 
    echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:$evento->estado, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::submit('Agregar',array('class'=>'btn btn-primary pull-right'));
    echo Form::token(); 
    echo Form::close();
//$data?date('Y-m-d',strtotime($data['fch_inicio'])) : null
?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        <?php
            if(($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 1) || ($evento && isset($evento->tipo_registro) && $evento->tipo_registro == 1)) {
                echo 'var type = 1;';
            } elseif(($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 2) || ($evento && isset($evento->tipo_registro) && $evento->tipo_registro == 2)) {
                echo 'var type = 2;';
            } else {
                echo 'var type = 0;';
            }
        ?>
        
        if (type == 1) {
            $('.fecha-box').hide();
            $('#fecha').val('');
        } else if (type == 2) {
            $('.dias-box').hide();
            $('input:checkbox').each(function(){
                $(this).attr('checked', false);
            });
        } else {
            $('.dias-box').hide();
            $('.fecha-box').hide();
        }
    });
    
    $('input:radio').click(function(){
        var tipo = $(this).val();
        switch (tipo) {
            case '1' :
                $('.dias-box').show();
                $('.fecha-box').hide();
                 $('#fecha').val('');
                break;
            case '2' :
                $('.dias-box').hide();
                $('.fecha-box').show();
                $('input:checkbox').each(function(){
                    $(this).attr('checked', false);
                });
                break;
        }
    });
</script>