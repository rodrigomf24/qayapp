<div class="row usuarios-content">
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
                <th>Apellido</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Tipo</th>
            </thead>
            <?php
                if(isset($listado) && is_array($listado) && !empty($listado)) {
                    foreach($listado as $est) {
                        switch($est->estado) {
                            case '1':
                                $estado = 'Activo';
                                break;
                            case '0':
                                $estado = 'Inactivo';
                                break;
                        }
                        
                        switch($est->tipo) {
                            case '1':
                                $tipo ='Digitador';
                                break;
                            case '2':
                                $tipo = 'Administrador';
                                break;
                            case '10':
                                $tipo = 'Webadmin';
                                break;
                        }
                        echo <<<HTML
                            <tr>
                                <td><input type="checkbox" value="{$est->id_usuario}"/></td>
                                <td>{$est->nombre}</td>
                                <td>{$est->apellido}</td>
                                <td>{$est->email}</td>
                                <td>{$estado}</td>
                                <td>{$tipo}</td>
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
        $('#nuevo-registro').click(function(){window.location.href="/admin-control/nuevo-usuario";});
        $('#editar-registro').click(function(){
            var n = $( "input:checked" ).length;
            if( n < 1) {
                $('.usuarios-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay usuarios seleccionados, debe seleccionar un usuario.</div>'); 
            } else if (n < 2) {
                var id = $('input[type=checkbox]:checked').val();
                window.location.href="/admin-control/editar-usuario/"+id;
            } else {
                 $('.usuarios-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Solamente puede editar un registro a la vez.</div>'); 
            }
        });
        $('#eliminar-registro').click(function(){
            var id = new Array();
            $('input[type=checkbox]:checked').each(function(i){
                id[i] = $(this).val();    
            });
            if (id < 1) {
                $('.usuarios-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay usuarios seleccionados para eliminar, debe seleccionar un usuario.</div>'); 
            } else {
                $.post('/admin-control/eliminar-usuario', {'id_list':id})
                    .done(function(response){
                        var resp = $.parseJSON(response);
                        console.log(resp);
                        if (resp.result === 1) {
                            $('.usuarios-content').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" onclick="location.reload();">&times;</button>'+ resp.message +'</div>'); 
                        } else {
                            $('.usuarios-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" >&times;</button><strong>ERROR:</strong> '+ resp.message +' </div>'); 
                        }
                        
                    })
                    .fail(function(){});
            }
        });     
    });
</script>