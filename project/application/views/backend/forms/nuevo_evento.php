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
    echo Form::open_for_files('/admin-control/nuevo-evento/'.$id_categoria,'POST'); 
    echo Form::label('nombre', 'Nombre'); 
    echo Form::text('nombre', ($catalogo)?$catalogo['nombre']:'', array('class'=>'span12'));
    echo Form::label('descripcion', 'Descripcion'); 
    echo Form::textarea('descripcion', ($catalogo)?$catalogo['descripcion']:'', array('class'=>'span12'));
    echo Form::label('id_establecimiento', 'Establecimiento'); 
    echo Form::select('id_establecimiento',$establecimientos, ($catalogo)?$catalogo['id_establecimiento']:'', 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('url_imagen', 'URL Imagen'); 
    echo Form::file('url_imagen', array('class'=>'span12'));
    echo Form::label('url_evento_fb', 'URL Evento en Facebook'); 
    echo Form::url('url_evento_fb', ($catalogo)?$catalogo['url_evento_fb']:'', array('class'=>'span12'));
    echo Form::label('url_evento', 'URL Evento'); 
    echo Form::url('url_evento', ($catalogo)?$catalogo['url_evento']:'', array('class'=>'span12'));
    echo Form::label('url_mapa', 'URL Mapa'); 
    echo Form::url('url_mapa', ($catalogo)?$catalogo['url_mapa']:'', array('class'=>'span12'));
    echo Form::label('tipo_registro', 'Elija el tipo de registro: ');
    echo '<div style="padding:1em;">';
    echo ($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 1) ? Form::radio('tipo_registro', '1', true).' Repetitivo(multiples dias/por dia)'.'<br/>'
                : Form::radio('tipo_registro', '1').' Repetitivo(multiples dias/por dia)'.'<br/>';
    echo ($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 2) ? Form::radio('tipo_registro', '2', true).' Fecha especifica'.'<br/>'
                : Form::radio('tipo_registro', '2').' Fecha especifica'.'<br/>';
    echo '</div>';
    echo '<div class="dias-box" style="padding:1em;">';
    echo Form::label('dias', 'Dias a repetir el Evento'); 
    echo ($catalogo && isset($catalogo['lunes']) && $catalogo['lunes']) ?  Form::checkbox('dias[]', '1', true) .' Lunes'.'<br/>' : Form::checkbox('dias[]', '1').' Lunes'.'<br/>';
    echo ($catalogo && isset($catalogo['martes']) && $catalogo['martes']) ?  Form::checkbox('dias[]', '2', true) .' Martes'.'<br/>' : Form::checkbox('dias[]', '2').' Martes'.'<br/>';
    echo ($catalogo && isset($catalogo['miercoles']) && $catalogo['miercoles']) ?  Form::checkbox('dias[]', '3', true) .' Miercoles'.'<br/>' : Form::checkbox('dias[]', '3').' Miercoles'.'<br/>';
    echo ($catalogo && isset($catalogo['jueves']) && $catalogo['jueves']) ?  Form::checkbox('dias[]', '4', true) .' Jueves'.'<br/>' : Form::checkbox('dias[]', '4').' Jueves'.'<br/>';
    echo ($catalogo && isset($catalogo['viernes']) && $catalogo['viernes']) ?  Form::checkbox('dias[]', '5', true) .' Viernes'.'<br/>' : Form::checkbox('dias[]', '5').' Viernes'.'<br/>';
    echo ($catalogo && isset($catalogo['sabado']) && $catalogo['sabado']) ?  Form::checkbox('dias[]', '6', true) .' Sabado'.'<br/>' : Form::checkbox('dias[]', '6').' Sabado'.'<br/>';
    echo ($catalogo && isset($catalogo['domingo']) && $catalogo['domingo']) ?  Form::checkbox('dias[]', '7', true) .' Domingo'.'<br/>' : Form::checkbox('dias[]', '7').' Domingo'.'<br/>';
    echo ($catalogo && isset($catalogo['todos']) && $catalogo['todos']) ?  Form::checkbox('dias[]', '8', true) .' Todos'.'<br/>' : Form::checkbox('dias[]', '8').' Todos'.'<br/>';
    echo '</div>';
    echo '<div class="fecha-box">';
    echo Form::label('fecha', 'Fecha del Evento'); 
    echo Form::date('fecha', ($catalogo)?date('Y-m-d',strtotime($catalogo['fecha'])):null, array('class'=>'span12'));
    echo '</div>';
    echo Form::label('destacado', 'Destacado'); 
    echo Form::select('destacado',array('1'=>'Si', '0'=>'No'), ($catalogo)?$catalogo['destacado']:0, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('prioridad', 'Prioridad'); 
    echo Form::select('prioridad',array('1'=>'Exclusivo', '2'=>'Alta', '3'=>'Normal', '4'=>'Baja'), ($catalogo)?$catalogo['prioridad']:3, 
            array('class'=>'span12','autocomplete'=>'off'));
    echo Form::label('estado', 'Estado'); 
    echo Form::select('estado',array('1'=>'Activo', '0'=>'Inactivo'), ($catalogo)?$catalogo['estado']:'1', 
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
        <?php echo ($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 1) ? 'var type = 1;' :  (($catalogo && isset($catalogo['tipo_registro']) && $catalogo['tipo_registro'] == 2) ? 'var type = 2;' : 'var type = 0;'); ?>
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
                break;
            case '2' :
                $('.dias-box').hide();
                $('.fecha-box').show();
                break;
        }
    });
</script>