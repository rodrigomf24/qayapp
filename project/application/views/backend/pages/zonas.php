<div class="row zonas-content">
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
                <th>Pais</th>
                <th>Departamento</th>
            </thead>
            <?php
                if(isset($listado) && is_array($listado) && !empty($listado)) {
                    foreach($listado as $est) {
                        echo <<<HTML
                            <tr>
                                <td><input type="checkbox" value="{$est->id_zona}"/></td>
                                <td>{$est->nombre}</td>
                                <td>{$est->pais}</td>
                                <td>{$est->departamento}</td>
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
        $('#nuevo-registro').click(function(){window.location.href="/admin-control/nueva-zona";});
        $('#editar-registro').click(function(){
            var n = $( "input:checked" ).length;
            if( n < 1) {
                $('.zonas-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay zonas seleccionadas, debe seleccionar una zona.</div>'); 
            } else if (n < 2) {
                var id = $('input[type=checkbox]:checked').val();
                window.location.href="/admin-control/editar-zona/"+id;
            } else {
                 $('.zonas-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Solamente puede editar un registro a la vez.</div>'); 
            }
        });
        $('#eliminar-registro').click(function(){
            var id = new Array();
            $('input[type=checkbox]:checked').each(function(i){
                id[i] = $(this).val();    
            });
            if (id < 1) {
                $('.zonas-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay zonas seleccionados para eliminar, debe seleccionar una zona.</div>'); 
            } else {
                $.post('/admin-control/eliminar-zona', {'id_list':id})
                    .done(function(response){
                        var resp = $.parseJSON(response);
                        console.log(resp);
                        if (resp.result === 1) {
                            $('.zonas-content').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" onclick="location.reload();">&times;</button>'+ resp.message +'</div>'); 
                        } else {
                            $('.zonas-content').prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" >&times;</button><strong>ERROR:</strong> '+ resp.message +' </div>'); 
                        }
                        
                    })
                    .fail(function(){});
            }
        });     
    });
</script>