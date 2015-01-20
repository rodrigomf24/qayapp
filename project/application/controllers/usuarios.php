<?php

Class Usuarios_Controller extends Base_Controller{
    
    public $layout = "templates.backend.admin";
    
    public function action_index() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $user = DB::table('backend_usuarios')->where('email', '=', Session::get('user'))->get(array('tipo'));
        $user = $user[0];
        if($user->tipo == '2' || $user->tipo == '10'){
            $listado =  DB::table('backend_usuarios')
                        ->paginate(3, array('id_usuario', 'nombre', 'apellido', 'email', 'estado', 'tipo'));
            $this->layout->nest('child', 'backend.pages.usuarios')
                ->shares('listado', $listado->results)
                ->shares('pagination', $listado);
        } else {
            Session::flash('form_error', 'No tiene los privilegios para acceder a esta seccion.');
            return Redirect::to('admin-control/dashboard');
        }
    }
    
    public function action_agregar_usuario() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $this->layout->nest('child', 'backend.forms.agregar_usuario');
    }
    
    public function action_agregar_usuario_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $user = DB::table('backend_usuarios')->where('email', '=', Session::get('user'))->get(array('tipo'));
        $user = $user[0];
        if($user->tipo == '2' || $user->tipo == '10'){
            $rules = array(
                            'nombre' => 'required',
                            'apellido' => 'required',
                            'email' => 'required',
                            'password' => 'required',
                            'password_validate' => 'required',
                            'estado' => 'required',
                            'tipo' => 'required',
                           );
            
            
            $catalogue = array(
                            'nombre' => Input::get('nombre'),
                            'apellido' => Input::get('apellido'),
                            'email' => Input::get('email'),
                            'password' => Input::get('password'),
                            'password_validate' => Input::get('password_validate'),
                            'estado' => Input::get('estado'),
                            'tipo' => Input::get('tipo'),
                           );
            
            
            $validation = Validator::make($catalogue, $rules);
            if ($validation->fails() || $catalogue['password'] != $catalogue['password_validate']){
                Session::flash('form_error', 'Revise sus datos');
                return Redirect::to('/admin-control/nuevo-usuario')->with('catalogo',$catalogue);
            }
            
            $catalogue['password'] = Hash::make($catalogue['password']);
            
            unset($catalogue['password_validate']);
            
            DB::table('backend_usuarios')->insert($catalogue);
            return Redirect::to('/admin-control/menu/usuarios');
        } else {
            Session::flash('form_error', 'No tiene los privilegios para acceder a esta seccion.');
            return Redirect::to('admin-control/dashboard');
        }
    }
    
    public function action_editar_usuario($id_usuario) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $user = DB::table('backend_usuarios')->where('email', '=', Session::get('user'))->get(array('tipo'));
        $user = $user[0];
        if($user->tipo == '2' || $user->tipo == '10'){
            $user_edit = DB::table('backend_usuarios')->where('id_usuario', '=', $id_usuario)->get();
            $user_edit = $user_edit[0];
            $this->layout->nest('child', 'backend.forms.editar_usuario')->shares('usuario', $user_edit);
        } else {
            Session::flash('form_error', 'No tiene los privilegios para acceder a esta seccion.');
            return Redirect::to('admin-control/dashboard');
        }
    }
    
    public function action_editar_usuario_post($id_usuario) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $user = DB::table('backend_usuarios')->where('email', '=', Session::get('user'))->get(array('tipo'));
        $user = $user[0];
        if($user->tipo == '2' || $user->tipo == '10'){
            $rules = array(
                            'nombre' => 'required',
                            'apellido' => 'required',
                            'email' => 'required',
                            'estado' => 'required',
                            'tipo' => 'required',
                           );
            
            
            $catalogue = array(
                            'nombre' => Input::get('nombre'),
                            'apellido' => Input::get('apellido'),
                            'email' => Input::get('email'),
                            'estado' => Input::get('estado'),
                            'tipo' => Input::get('tipo'),
                           );
            
            $password = Input::get('password');
            $password_v = Input::get('password_validate');
            
            if(empty($password) && empty($password_v)) {
                $validation = Validator::make($catalogue, $rules);
                if ($validation->fails()){
                    Session::flash('form_error', 'Revise sus datos');
                    $catalogue['id_usuario'] = $id_usuario;
                    return Redirect::to('/admin-control/editar-usuario/'.$id_usuario)->with('catalogo',$catalogue);
                }
            }else{
                $rules['password'] = 'required';
                $rules['password_validate'] = 'required';
                $catalogue['password'] = $password;
                $catalogue['password_validate'] = $password_v;
                $validation = Validator::make($catalogue, $rules);
                if ($validation->fails() || $catalogue['password'] != $catalogue['password_validate']){
                    Session::flash('form_error', 'Revise sus datos');
                    $catalogue['id_usuario'] = $id_usuario;
                    return Redirect::to('/admin-control/editar-usuario/'.$id_usuario)->with('catalogo',$catalogue);
                }
                $catalogue['password'] = Hash::make($catalogue['password']);
                unset($catalogue['password_validate']);
            }
            
            DB::table('backend_usuarios')->where('id_usuario', '=', $id_usuario)->update($catalogue);
            return Redirect::to('/admin-control/menu/usuarios');
        } else {
            Session::flash('form_error', 'No tiene los privilegios para acceder a esta seccion.');
            return Redirect::to('admin-control/dashboard');
        }
    }
    
    public function action_eliminar_usuarios_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        if(isset($_POST) && is_array($_POST) && !empty($_POST['id_list'])) {
            foreach($_POST['id_list'] as $id) {
                $result = DB::table('publicidad')->where('id_publicidad', '=', $id)->delete();
            }
            $message = ($result) ? 'Usuarios eliminados exitosamente!' : 'problema al eliminar los usuarios, por favor comuniquese con su administrador de sistema.';
            die(json_encode(array('result'=> $result, 'message'=>$message)));
        }
    }
}