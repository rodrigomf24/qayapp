<?php

Class Publicidad_Controller extends Base_Controller{
    
    public $layout = "templates.backend.admin";
    
    public function action_index() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $listado =  DB::table('publicidad')
                    ->paginate(5, array('id_publicidad', 'titulo', 'descripcion', 'url_imagen', 'enlace', 'area', 'prioridad', 'estado'));
        $this->layout->nest('child', 'backend.pages.publicidad')
            ->shares('listado', $listado->results)
            ->shares('pagination', $listado);
    }
    
    public function action_nueva_publicidad() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $this->layout->nest('child', 'backend.forms.nueva_publicidad');
    }
    
    public function action_nueva_publicidad_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $rules = array(
                        'titulo' => 'required',
                        'descripcion' => 'required',
                        'url_imagen' => 'required',
                        'enlace' => 'required',
                        'area' => 'required',
                        'prioridad' => 'required',
                        'estado'    => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen'));
        
        $catalogue = array(
                        'titulo' => Input::get('titulo'),
                        'descripcion' => Input::get('descripcion'),
                        'url_imagen' => $url_imagen,
                        'enlace' => Input::get('enlace'),
                        'area' => Input::get('area'),
                        'prioridad' => Input::get('prioridad'),
                        'estado'    => Input::get('estado'),
                       );
        
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').'publicidad/' , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            return Redirect::to('/admin-control/nueva-publicidad')->with('catalogo',$catalogue);
        }
        
        DB::table('publicidad')->insert($catalogue);
        return Redirect::to('/admin-control/menu/publicidad');
    }
    
    public function action_editar_publicidad($id_publicidad) {
        $publicidad = DB::table('publicidad')->where('id_publicidad', '=', $id_publicidad)->get();
        $publicidad = $publicidad[0];
        $this->layout->nest('child', 'backend.forms.editar_publicidad')
            ->shares('publicidad', $publicidad);
    }
    
    public function action_editar_publicidad_post($id_publicidad) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $rules = array(
                        'titulo' => 'required',
                        'descripcion' => 'required',
                        'url_imagen' => 'required',
                        'enlace' => 'required',
                        'area' => 'required',
                        'prioridad' => 'required',
                        'estado'    => 'required',
                       );
        
        $files = Input::file();
        
        $url_imagen = (!empty($files['url_imagen']['name']))
            ? (Tools::getFilename($files['url_imagen'])) : (Input::get('url_imagen_old'));
        
        $catalogue = array(
                        'titulo' => Input::get('titulo'),
                        'descripcion' => Input::get('descripcion'),
                        'url_imagen' => $url_imagen,
                        'enlace' => Input::get('enlace'),
                        'area' => Input::get('area'),
                        'prioridad' => Input::get('prioridad'),
                        'estado'    => Input::get('estado'),
                       );
        
        if(!empty($files['url_imagen']['name'])) {
            // uploads:url_imagen
            Input::upload('url_imagen', path('images').'publicidad/' , $catalogue['url_imagen']);
        }
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['id_publicidad'] = $id_publicidad;
            return Redirect::to('/admin-control/editar-publicidad/'.$id_publicidad)->with('catalogo',$catalogue);
        }
        
        DB::table('publicidad')->where('id_publicidad', '=', $id_publicidad)->update($catalogue);
        return Redirect::to('/admin-control/menu/publicidad');
    }
    
    public function action_eliminar_publicidad_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        if(isset($_POST) && is_array($_POST) && !empty($_POST['id_list'])) {
            foreach($_POST['id_list'] as $id) {
                $result = DB::table('publicidad')->where('id_publicidad', '=', $id)->delete();
            }
            $message = ($result) ? 'Registros de publicidad eliminados exitosamente!' : 'problema al eliminar los registros de publicidad, por favor comuniquese con su administrador de sistema.';
            die(json_encode(array('result'=> $result, 'message'=>$message)));
        }
    }
}