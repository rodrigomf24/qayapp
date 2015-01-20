<div class="row espectaculos-content">
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
                <th>Nombre</th>
                <th>Zona</th>
                <th>Telefono</th>
                <th>Descripcion</th>
                <th>Direccion</th>
                <th>URL del Mapa</th>
                <th>Destacado</th>
                <th>Imagen</th>
                <th>Prioridad</th>
                <th>Estado</th>
            </thead>
            <?php
                if(isset($listado) && is_array($listado) && !empty($listado)) {
                    foreach($listado as $est) {
                        switch($est->destacado) {
                            case '1':
                                $destacado = 'Si';
                                break;
                            case '0':
                                $destacado= 'No';
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
                        $image = '<img src="/images/bares/'.$est->url_imagen.'" style="width: 45px; height:45px;"/>';
                        $descripcion = explode('.', $est->descripcion);
                        $descripcion = $descripcion[0].'...';
                        echo <<<HTML
                            <tr>
                                <td><input type="checkbox" value="{$est->id_establecimiento}"/></td>
                                <td>{$est->nombre}</td>
                                <td>{$est->zona}</td>
                                <td>{$est->telefono}</td>
                                <td>{$descripcion}</td>
                                <td>{$est->direccion}</td>
                                <td>{$est->url_mapa}</td>
                                <td>{$destacado}</td>
                                <td>{$image}</td>
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
        $('#nuevo-registro').click(function(){window.location.href="/admin-control/nuevo-registro/espectaculos";});
        $('#editar-registro').click(function(){
            var n = $( "input:checked" ).length;
            if( n < 1) {
                $('.espectaculos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay establecimientos seleccionados, debe seleccionar un establecimiento.</div>'); 
            } else if (n < 2) {
                var id = $('input[type=checkbox]:checked').val();
                window.location.href="/admin-control/editar-registro/"+id;
            } else {
                 $('.espectaculos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Solamente puede editar un registro a la vez.</div>'); 
            }
        });
        $('#eliminar-registro').click(function(){
            var id = new Array();
            $('input[type=checkbox]:checked').each(function(i){
                id[i] = $(this).val();    
            });
            if (id < 1) {
                $('.espectaculos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay establecimientos seleccionados para eliminar, debe seleccionar un establecimiento.</div>'); 
            } else {
                $.post('/admin-control/eliminar-registros', {'id_list':id})
                    .done(function(response){
                        var resp = $.parseJSON(response);
                        console.log(resp);
                        if (resp.result === 1) {
                            $('.espectaculos-content').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" onclick="location.reload();">&times;</button>'+ resp.message +'</div>'); 
                        } else {
                            $('.espectaculos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" >&times;</button><strong>ERROR:</strong> '+ resp.message +' </div>'); 
                        }
                        
                    })
                    .fail(function(){});
            }
        });   
    });
</script>