<div class="row publicidad-content">
    <div class="span12" style="padding: 1em;">
        <div class="btn-group">
            <button class="btn btn btn-info" id="nuevo-registro"><span class="icon-pencil"></span> Nuevo</button>
            <button class="btn" id="editar-registro"><span class="icon-edit"></span> Editar</button>
            <button class="btn btn btn-danger" id="eliminar-registro"><span class="icon-remove"></span> Borrar</button>
        </div>
    </div>
    <div class="span10">
        <table class="table table-striped">
            <thead>
                <th></th>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Enlace</th>
                <th>Area</th>
                <th>Prioridad</th>
                <th>Estado</th>
            </thead>
            <?php
            if(isset($listado) && is_array($listado) && !empty($listado)) {
                    foreach($listado as $est) {
                        switch($est->area) {
                            case '1':
                                $area = 'Menu';
                                break;
                            case '2':
                                $area = 'Busqueda';
                                break;
                            case '3':
                                $area = 'Resultados';
                                break;
                            case '4':
                                $area = 'Todos';
                                break;
                        }
                        
                        switch($est->prioridad) {
                            case '1':
                                $prioridad ='Importante';
                                break;
                            case '2':
                                $prioridad = 'Normal';
                                break;
                            case '3':
                                $prioridad = 'Irrelevante';
                                break;
                        }
                        $estado = ($est->estado == '1') ? 'Activo' : 'Inactivo';
                        $image = '<img src="/images/publicidad/'.$est->url_imagen.'" style="width: 45px; height:45px;"/>';
                        $descripcion = explode('.', $est->descripcion);
                        $descripcion = $descripcion[0].'...';
                        echo <<<HTML
                            <tr>
                                <td><input type="checkbox" value="{$est->id_publicidad}"/></td>
                                <td>{$est->titulo}</td>
                                <td>{$descripcion}</td>
                                <td>{$image}</td>
                                <td>{$est->enlace}</td>
                                <td>{$area}</td>
                                <td>{$prioridad}</td>
                                <td>{$estado}</td>
                            </tr>
HTML;
                    }
            }
            ?>
        </table>
    </div>
    <div class="pagination">
        <?php echo $pagination->links(); ?>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        $('#nuevo-registro').click(function(){window.location.href="/admin-control/nueva-publicidad";});
        $('#editar-registro').click(function(){
            var n = $( "input:checked" ).length;
            if( n < 1) {
                $('.publicidad-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay registros seleccionados, debe seleccionar un registro.</div>'); 
            } else if (n < 2) {
                var id = $('input[type=checkbox]:checked').val();
                window.location.href="/admin-control/editar-publicidad/"+id;
            } else {
                 $('.publicidad-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Solamente puede editar un registro a la vez.</div>'); 
            }
        });
        $('#eliminar-registro').click(function(){
            var id = new Array();
            $('input[type=checkbox]:checked').each(function(i){
                id[i] = $(this).val();    
            });
            if (id < 1) {
                $('.publicidad-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay registros seleccionados para eliminar, debe seleccionar un registro.</div>'); 
            } else {
                $.post('/admin-control/eliminar-publicidad', {'id_list':id})
                    .done(function(response){
                        var resp = $.parseJSON(response);
                        if (resp.result === 1) {
                            $('.publicidad-content').prepend('<div class="alert alert-success"><button type="button" class="close"  onclick="location.reload();" data-dismiss="alert">&times;</button>'+ resp.message +'</div>'); 
                        } else {
                            $('.publicidad-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>ERROR:</strong> '+ resp.message +' </div>'); 
                        }
                        
                    })
                    .fail(function(){});
            }

        });   
    });
</script>