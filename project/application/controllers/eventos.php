<?php

Class Eventos_Controller extends Base_Controller{
    
    public $layout = "templates.backend.admin";
    
    public function action_index() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $listado =  DB::table('eventos')
            ->join('establecimientos', 'establecimientos.id_establecimiento', '=', 'eventos.id_establecimiento')
            ->join('categorias', 'establecimientos.id_categoria', '=', 'categorias.id_categoria')
            ->paginate(5, array('eventos.id_evento','eventos.nombre', 'eventos.descripcion', 'establecimientos.nombre as nombre_establecimiento', 'establecimientos.id_categoria',
                               'eventos.url_evento_fb', 'eventos.url_evento', 'eventos.url_imagen', 'eventos.fecha', 'eventos.url_mapa', 'eventos.destacado',
                               'eventos.prioridad', 'categorias.nombre as nombre_categoria', 'eventos.estado'));
        
        $categorias = DB::table('categorias')->get();
        return View::make('templates.backend.admin')
            ->nest('child', 'backend.pages.eventos')
            ->shares('listado', $listado->results)
            ->shares('pagination', $listado)
            ->shares('categorias', $categorias);
    }
    
    public function action_nuevo_evento($id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $establecimientos = DB::table('establecimientos')->where('id_categoria', '=', $id_categoria)->get(array('id_establecimiento', 'nombre'));
        $listado_establecimientos = array();
        foreach($establecimientos as $info) {
            $listado_establecimientos[$info->id_establecimiento] = $info->nombre;
        }
        $this->layout->nest('child', 'backend.forms.nuevo_evento')
            ->shares('establecimientos', $listado_establecimientos)
            ->shares('id_categoria', $id_categoria);
    }
    
    public function action_nuevo_evento_post($id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        
        $dias_cat = (isset($_POST['dias']) && is_array($_POST['dias'])) ? $_POST['dias'] : array();
        $dias = array('1'=>'lunes', '2'=>'martes', '3'=>'miercoles', '4'=>'jueves', '5'=>'viernes', '6'=>'sabado', '7'=>'domingo', '8'=>'todos');
        
        $categoria = DB::table('categorias')->where('id_categoria', '=', $id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        $rules = array(
                        'nombre' => 'required',
                        'descripcion' => 'required',
                        'id_establecimiento' => 'required',
                        'url_imagen' => 'required',
                        'prioridad' => 'required',
                        'destacado' => 'required',
                        'estado' => 'required',
                        'tipo_registro' => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen'));
            
        $catalogue = array(
                           'nombre' => Input::get('nombre'),
                           'descripcion' => Input::get('descripcion'),
                           'id_establecimiento' => Input::get('id_establecimiento'),
                           'url_imagen' => $url_imagen,
                           'prioridad' => Input::get('prioridad'),
                           'destacado' => Input::get('destacado'),
                           'estado'    => Input::get('estado'),
                           'tipo_registro' => Input::get('tipo_registro'),
                          );
         
        
        
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').'eventos/'.$categoria , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['url_evento'] = Input::get('url_evento');
            $catalogue['url_evento_fb'] = Input::get('url_evento_fb');
            $catalogue['url_mapa'] = Input::get('url_mapa');
            $catalogue['fecha'] = Input::get('fecha');
            if(!in_array('8', $dias_cat)) {
                foreach($dias_cat as $dia) {
                    if(array_key_exists($dia, $dias)) {
                        $catalogue[$dias[$dia]] = 1;
                    } else {
                        $catalogue[$dias[$dia]] = 0;
                    }
                }
            } else {
                $catalogue['todos'] = 1;
            }
            return Redirect::to('/admin-control/nuevo-evento/'.$id_categoria)->with('catalogo',$catalogue);
        }
        
        if(!in_array('8', $dias_cat)) {
            foreach($dias_cat as $dia) {
                if(array_key_exists($dia, $dias)) {
                    $catalogue[$dias[$dia]] = 1;
                } else {
                    $catalogue[$dias[$dia]] = 0;
                }
            }
        } else{
            $catalogue['todos'] = 1;
        }
        
        if(empty($dias_cat) && !is_array($dias_cat)) {
            $catalogue['fecha'] = Input::get('fecha');
        }
        
        $catalogue['url_evento'] = Input::get('url_evento');
        $catalogue['url_evento_fb'] = Input::get('url_evento_fb');
        $catalogue['url_mapa'] = Input::get('url_mapa');
        
        DB::table('eventos')->insert($catalogue);
        return Redirect::to('/admin-control/menu/eventos');
    }
    
    public function action_editar_evento($id_evento, $id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        
        $categoria = DB::table('categorias')->where('id_categoria', '=', $id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        $evento = DB::table('eventos')
            ->join('establecimientos', 'eventos.id_establecimiento', '=', 'establecimientos.id_establecimiento')
            ->where('id_evento', '=', $id_evento)->get(array('eventos.*', 'establecimientos.id_establecimiento'));
            
        $establecimientos = DB::table('establecimientos')->where('id_categoria', '=', $id_categoria)->get(array('id_establecimiento', 'nombre'));
        $listado_establecimientos = array();
        foreach($establecimientos as $info) {
            $listado_establecimientos[$info->id_establecimiento] = $info->nombre;
        }
        
        $evento = $evento[0];
         $this->layout->nest('child', 'backend.forms.editar_evento')
            ->shares('establecimientos', $listado_establecimientos)
            ->shares('evento', $evento)
            ->shares('categoria', $categoria)
            ->shares('id_categoria', $id_categoria);
        
    }
    
    public function action_editar_evento_post($id_evento, $id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        
        $dias_cat = (isset($_POST['dias']) && is_array($_POST['dias'])) ? $_POST['dias'] : array();
        $dias = array('1'=>'lunes', '2'=>'martes', '3'=>'miercoles', '4'=>'jueves', '5'=>'viernes', '6'=>'sabado', '7'=>'domingo', '8'=>'todos');
        
        $categoria = DB::table('categorias')->where('id_categoria', '=', $id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        $rules = array(
                        'nombre' => 'required',
                        'descripcion' => 'required',
                        'id_establecimiento' => 'required',
                        'url_imagen' => 'required',
                        'prioridad' => 'required',
                        'destacado' => 'required',
                        'tipo_registro' => 'required',
                        'estado'    => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen_old'));
            
        $catalogue = array(
                            'nombre' => Input::get('nombre'),
                            'descripcion' => Input::get('descripcion'),
                            'id_establecimiento' => Input::get('id_establecimiento'),
                            'url_imagen' => $url_imagen,
                            'prioridad' => Input::get('prioridad'),
                            'destacado' => Input::get('destacado'),
                            'tipo_registro' => Input::get('tipo_registro'),
                            'estado'    => Input::get('estado')
                           );
         
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').'eventos/'.$categoria , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['url_evento'] = Input::get('url_evento');
            $catalogue['url_evento_fb'] = Input::get('url_evento_fb');
            $catalogue['url_mapa'] = Input::get('url_mapa');
            $catalogue['fecha'] = Input::get('fecha');
            if(!in_array('8', $dias_cat)) {
                foreach($dias_cat as $dia) {
                    if(array_key_exists($dia, $dias)) {
                        $catalogue[$dias[$dia]] = 1;
                    }
                }
            } else {
                $catalogue['todos'] = 1;
            }
            return Redirect::to('/admin-control/editar-evento/'.$id_evento.'/'.$id_categoria)->with('catalogo',$catalogue);
        }
        
        if(!in_array('8', $dias_cat)) {
            foreach($dias_cat as $dia) {
                if(array_key_exists($dia, $dias)) {
                    $catalogue[$dias[$dia]] = 1;
                }
            }
        } else{
            $catalogue['todos'] = 1;
        }
        
        if(empty($dias_cat) && !is_array($dias_cat)) {
            $catalogue['fecha'] = Input::get('fecha');
        }
        
        $catalogue['url_evento'] = Input::get('url_evento');
        $catalogue['url_evento_fb'] = Input::get('url_evento_fb');
        $catalogue['url_mapa'] = Input::get('url_mapa');
        
        DB::table('eventos')->where('id_evento', '=', $id_evento)->update($catalogue);
        return Redirect::to('/admin-control/menu/eventos');
    }
    
     public function action_eliminar_evento_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        if(isset($_POST) && is_array($_POST) && !empty($_POST['id_list'])) {
            foreach($_POST['id_list'] as $id) {
                $result = DB::table('eventos')->where('id_evento', '=', $id)->delete();
            }
            $message = ($result) ? 'Eventos eliminados exitosamente!' : 'problema al eliminar los eventos, por favor comuniquese con su administrador de sistema.';
            die(json_encode(array('result'=> $result, 'message'=>$message)));
        }
    }

}