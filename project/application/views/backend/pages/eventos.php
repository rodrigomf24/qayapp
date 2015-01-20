
<div class="row eventos-content">
    <div class="span7 offset1">
        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav">
                    <?php
                        foreach($categorias as $cat) {
                            echo '<li><a href="/admin-control/nuevo-evento/'.$cat->id_categoria.'">'.ucfirst($cat->nombre).'</a></li><li class="divider-vertical"></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="span12" style="padding: 1em;">
        <div class="btn-group">
            <!--<button class="btn btn btn-info" id="nuevo-registro"><span class="icon-pencil"></span> Nuevo</button>-->
            <button class="btn" id="editar-evento"><span class="icon-edit"></span> Editar</button>
            <button class="btn btn btn-danger" id="eliminar-evento"><span class="icon-remove"></span> Borrar</button>
        </div>
    </div>
    <div class="span10">
        <table class="table table-striped">
            <thead>
                <th></th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Establecimiento</th>
                <th>URL Imagen</th>
                <th>Fecha</th>
                <th>URL Mapa</th>
                <th>Destacado</th>
                <th>Prioridad</th>
                <th>Estado</th>
            </thead>
            <?php
                if(isset($listado) && is_array($listado) && !empty($listado)) {
                    foreach($listado as $est) {
                        $checkbox = $est->id_evento.'/'.$est->id_categoria;
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
                        $image = '<img src="/images/eventos/'.$est->nombre_categoria.'/'.$est->url_imagen.'" style="width: 45px; height:45px;"/>';
                        $descripcion = explode('.', $est->descripcion);
                        $descripcion = $descripcion[0].'...';
                        echo <<<HTML
                            <tr>
                                <td><input type="checkbox" value="{$checkbox}"/></td>
                                <td>{$est->nombre}</td>
                                <td>{$descripcion}</td>
                                <td>{$est->nombre_establecimiento}</td>
                                <td>{$image}</td>
                                <td>{$est->fecha}</td>
                                <td>{$est->url_mapa}</td>
                                <td>{$destacado}</td>
                                <td>{$prioridad}</td>
                                <td>{$estado}</td>
                            </tr>
HTML;
                    }
                }
            ?>
        </table>
        <div class="pagination">
            <?php echo $pagination->links(); ?>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $('document').ready(function(){
        $('#nuevo-evento').click(function(){window.location.href="/admin-control/nuevo-evento";});
        $('#editar-evento').click(function(){
            var n = $( "input:checked" ).length;
            if( n < 1) {
                $('.eventos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay eventos seleccionados, debe seleccionar un eventos.</div>'); 
            } else if (n < 2) {
                var id = $('input[type=checkbox]:checked').val();
                window.location.href="/admin-control/editar-evento/"+id;
            } else {
                 $('.eventos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Solamente puede editar un registro a la vez.</div>'); 
            }
        });
        $('#eliminar-evento').click(function(){
            var id = new Array();
            $('input[type=checkbox]:checked').each(function(i){
                id[i] = $(this).val();    
            });
            if (id < 1) {
                $('.eventos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay eventos seleccionados para eliminar, debe seleccionar un evento.</div>'); 
            } else {
                $.post('/admin-control/eliminar-evento', {'id_list':id})
                    .done(function(response){
                        var resp = $.parseJSON(response);
                        console.log(resp);
                        if (resp.result === 1) {
                            $('.eventos-content').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" onclick="location.reload();">&times;</button>'+ resp.message +'</div>'); 
                        } else {
                            $('.eventos-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" >&times;</button><strong>ERROR:</strong> '+ resp.message +' </div>'); 
                        }
                        
                    })
                    .fail(function(){});
            }
        });      
    });
</script>