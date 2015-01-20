<?php

Class Establecimientos_Controller extends Base_Controller{
    
    public $layout = "templates.backend.admin";
    
    public function index() {
        /*$data = array();
        $this->layout->nest('child', 'backend.pages.')
            ->shares('data', $data);*/
    }
    
    public function action_nuevo_registro($type) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $id_categoria = DB::table('categorias')
            ->where('nombre', '=', $type)->get(array('id_categoria'));
        $zonas = DB::table('zonas')->get();
        
        $id_categoria = $id_categoria[0]->id_categoria;
        $zonas_list = array();
        
        foreach($zonas as $z) {
            $zonas_list[$z->id_zona] = $z->nombre;
        }
        
        $this->layout->nest('child', 'backend.forms.nuevo_registro')
            ->shares('zonas', $zonas_list)
            ->shares('id_categoria', $id_categoria);
    }
    
    public function action_nuevo_registro_post($id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $categoria = DB::table('categorias')->where('id_categoria', '=', $id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        $rules = array(
                        'nombre' => 'required',
                        'descripcion' => 'required',
                        'telefono' => 'required',
                        'id_zona' => 'required',
                        'direccion' => 'required',
                        'url_mapa' => 'required',
                        'url_imagen' => 'required',
                        'prioridad' => 'required',
                        'destacado' => 'required',
                        'estado'    => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen'));
        
        $catalogue = array(
                            'nombre' => Input::get('nombre'),
                            'descripcion' => Input::get('descripcion'),
                            'telefono' => Input::get('telefono'),
                            'id_zona' => Input::get('id_zona'),
                            'direccion' => Input::get('direccion'),
                            'url_mapa' => Input::get('url_mapa'),
                            'url_imagen' => $url_imagen,
                            'prioridad' => Input::get('prioridad'),
                            'destacado' => Input::get('destacado'),
                            'estado'    => Input::get('estado'),
                           );
        
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').$categoria , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['sitio_web'] = Input::get('sitio_web');
            $catalogue['url_facebook'] = Input::get('url_facebook');
            $catalogue['id_categoria'] = $id_categoria;
            return Redirect::to('/admin-control/nuevo-registro/'.$categoria)->with('catalogo',$catalogue);
        }
        
        $catalogue['sitio_web'] = Input::get('sitio_web');
        $catalogue['url_facebook'] = Input::get('url_facebook');
        $catalogue['id_categoria'] = $id_categoria;
        // Save it
        DB::table('establecimientos')->insert($catalogue);
        return Redirect::to('/admin-control/menu/'.$categoria);
        
    }
    
    public function action_editar_registro($id_registro) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $registro_info =   DB::table('establecimientos')
            ->join('zonas', 'establecimientos.id_zona', '=', 'zonas.id_zona')
            ->where('establecimientos.id_establecimiento', '=', $id_registro)
            ->get(array('establecimientos.*', 'zonas.nombre as zona', 'zonas.id_zona'));
            
        $registro_info = $registro_info[0];
        
        $categoria = DB::table('categorias')->where('id_categoria', '=', $registro_info->id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        
        $zonas = DB::table('zonas')->get();
        $zonas_list = array();
        foreach($zonas as $z) {
            $zonas_list[$z->id_zona] = $z->nombre;
        }
        
        $this->layout->nest('child', 'backend.forms.editar_registro')
            ->shares('zonas', $zonas_list)
            ->shares('categoria', $categoria)
            ->shares('info', $registro_info);
    }
    
    public function action_editar_registro_post($id_registro, $id_categoria) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $categoria = DB::table('categorias')->where('id_categoria', '=', $id_categoria)->get(array('nombre'));
        $categoria = $categoria[0]->nombre;
        $rules = array(
                        'nombre' => 'required',
                        'descripcion' => 'required',
                        'telefono' => 'required',
                        'id_zona' => 'required',
                        'direccion' => 'required',
                        'url_mapa' => 'required',
                        'url_imagen' => 'required',
                        'prioridad' => 'required',
                        'destacado' => 'required',
                        'estado'    => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen_old'));
        
        $catalogue = array(
                            'nombre' => Input::get('nombre'),
                            'descripcion' => Input::get('descripcion'),
                            'telefono' => Input::get('telefono'),
                            'id_zona' => Input::get('id_zona'),
                            'direccion' => Input::get('direccion'),
                            'url_mapa' => Input::get('url_mapa'),
                            'url_imagen' => $url_imagen,
                            'prioridad' => Input::get('prioridad'),
                            'destacado' => Input::get('destacado'),
                            'estado'    => Input::get('estado'),
                           );
        
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').$categoria , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['sitio_web'] = Input::get('sitio_web');
            $catalogue['url_facebook'] = Input::get('url_facebook');
            $catalogue['id_categoria'] = $id_categoria;
            return Redirect::to('/admin-control/editar-registro/'.$id_registro)->with('catalogo',$catalogue);
        }
        
        $catalogue['sitio_web'] = Input::get('sitio_web');
        $catalogue['url_facebook'] = Input::get('url_facebook');
        $catalogue['id_categoria'] = $id_categoria;
        // Save it
        DB::table('establecimientos')->where('id_establecimiento', '=', $id_registro)->update($catalogue);
        return Redirect::to('/admin-control/menu/'.$categoria);
    }
    
    public function action_eliminar_registro_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        if(isset($_POST) && is_array($_POST) && !empty($_POST['id_list'])) {
            foreach($_POST['id_list'] as $id) {
                $result = DB::table('establecimientos')->where('id_establecimiento', '=', $id)->delete();
            }
            $message = ($result) ? 'Establecimientos eliminados exitosamente!' : 'problema al eliminar los establecimientos, por favor comuniquese con su administrador de sistema.';
            die(json_encode(array('result'=> $result, 'message'=>$message)));
        }
    }
}