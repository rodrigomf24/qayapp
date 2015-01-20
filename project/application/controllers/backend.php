<?php

Class Backend_Controller extends Base_Controller{
    
    public $layout = "templates.backend.default";
    
    public function action_index() {
        
        $css='/ui/css/main.css';
        $script = '/ui/script/script.css';
        
        $data = array(
            'css' => $css,
            'script' => $script
        );
        
        $layout = "templates.backend.admin";
        
        if (Session::has('user'))
        {
            return View::make('templates.backend.admin')
                ->nest('child', 'backend.dashboard')
                ->shares('data', $data);
        } else {
            return Redirect::to('admin-control'); 
        }
    }
    
    public function action_login() {
        Session::flush();
        $data = array(
            'css' => '',
            'script' => ''
        );
        $this->layout
            ->nest('child', 'backend.login')
            ->shares('data', $data);
    }
    
    public function action_logout() {
        Auth::logout();
        Session::flush();
        return Redirect::to('admin-control'); 
    }
    
    public function action_post_login() {
        if (isset($_POST) && !empty($_POST)){
            
            $catalogue = array(
                               'password' => Input::get('password'),
                               'email'    => Input::get('email')
                               );
            
            $rules = array(
                           'password' => 'required',
                           'email' => 'required|email'
                           );
            
            $validator = Validator::make($catalogue, $rules);
            
            if ($validator->fails()){
                $css='';
                $script = '';
                $errors = array(
                                'email' => $validator->errors->get('email'),
                                'password' => $validator->errors->get('password')
                                );
                $data = array(
                    'css' => $css,
                    'script' => $script,
                    'errors' => $errors
                );
                $this->layout
                    ->nest('child', 'backend.login')
                    ->shares('data', $data);
            }else{
                $css='';
                $script = '';
                $user = array();
                $user['email'] = $catalogue['email'];
                $user['password'] = $catalogue['password'];
                
                //$user_check = DB::table('backend_usuarios')->where('email', '=', $user['email'])->get();
                if(Auth::attempt(array('username'=> $user['email'], 'password'=>$user['password']))) {
                    Session::put('user', $user['email']);
                    return Redirect::to('admin-control/dashboard');
                } else {
                    $message = "No tiene los permisos necesarios para acceder a esta seccion!";
                    $data = array(
                        'css' => $css,
                        'script' => $script,
                        'message' => $message,
                    );
                    
                    $this->layout
                        ->nest('child', 'backend.login')
                        ->shares('data', $data);
                }
            }
        }
    }


    public function action_load($page){
        if(Session::has('user')) {
            $data = array();
            $id_categoria = DB::table('categorias')->where('nombre', '=', $page)->get(array('id_categoria'));
            $listado =  DB::table('establecimientos')
                ->join('zonas', 'establecimientos.id_zona', '=', 'zonas.id_zona')
                ->where('id_categoria', '=', $id_categoria[0]->id_categoria)
                ->paginate(2, array('establecimientos.id_establecimiento', 'establecimientos.nombre',  'zonas.nombre as zona',
                                    'establecimientos.telefono', 'establecimientos.descripcion', 'establecimientos.direccion',
                                    'establecimientos.sitio_web', 'establecimientos.url_facebook', 'establecimientos.url_mapa',
                                    'establecimientos.destacado', 'establecimientos.url_imagen', 'establecimientos.prioridad', 'establecimientos.estado'));
            $categorias = DB::table('categorias')->get();
            return View::make('templates.backend.admin')
                ->nest('child', 'backend.pages.'.$page)
                ->shares('listado', $listado->results)
                ->shares('pagination', $listado)
                ->shares('categorias', $categorias)
                ->shares('data', $data);
        } else {
            return Redirect::to('/admin-control');
        }
    }
}