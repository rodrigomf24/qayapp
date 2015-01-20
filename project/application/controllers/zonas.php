<?php

Class Zonas_Controller extends Base_Controller{
    
    public $layout = "templates.backend.admin";
    
    public function action_index() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $listado =  DB::table('zonas')
                    ->paginate(5, array('id_zona', 'nombre', 'departamento', 'pais'));
        $this->layout->nest('child', 'backend.pages.zonas')
            ->shares('listado', $listado->results)
            ->shares('pagination', $listado);
    }
    
    public function action_nueva_zona() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $this->layout->nest('child', 'backend.forms.nueva_zona');
    }
    
    public function action_nueva_zona_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $rules = array(
                        'nombre' => 'required',
                        'pais' => 'required',
                        'departamento' => 'required',
                       );
        
        
        $catalogue = array(
                        'nombre' => Input::get('nombre'),
                        'pais' => Input::get('pais'),
                        'departamento' => Input::get('departamento'),
                       );
        
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            return Redirect::to('/admin-control/nueva-zona')->with('catalogo',$catalogue);
        }
        
        DB::table('zonas')->insert($catalogue);
        return Redirect::to('/admin-control/menu/zonas');
    }
    
    public function action_editar_zona($id_zona) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        $zonas = DB::table('zonas')->where('id_zona', '=', $id_zona)->get();
        $zonas = $zonas[0];
        $this->layout->nest('child', 'backend.forms.editar_zona')->shares('zona', $zonas);
    }
    
    public function action_editar_zona_post($id_zona) {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
         $rules = array(
                        'nombre' => 'required',
                        'pais' => 'required',
                        'departamento' => 'required',
                       );
        
        $catalogue = array(
                        'nombre' => Input::get('nombre'),
                        'pais' => Input::get('pais'),
                        'departamento' => Input::get('departamento'),
                       );
        
        $validation = Validator::make($catalogue, $rules);
        if ($validation->fails()){
            Session::flash('form_error', 'Revise sus datos');
            $catalogue['id_zona'] = $id_zona;
            return Redirect::to('/admin-control/editar-zona/'.$id_zona)->with('catalogo',$catalogue);
        }
        
        DB::table('zonas')->where('id_zona', '=', $id_zona)->update($catalogue);
        return Redirect::to('/admin-control/menu/zonas');
    }
    
    public function action_eliminar_zona_post() {
        if(!Session::has('user')) {
            return Redirect::to('/admin-control');
        }
        if(isset($_POST) && is_array($_POST) && !empty($_POST['id_list'])) {
            foreach($_POST['id_list'] as $id) {
                $result = DB::table('zonas')->where('id_zona', '=', $id)->delete();
            }
            $message = ($result) ? 'Zonas eliminadas exitosamente!' : 'problema al eliminar las zonas, por favor comuniquese con su administrador de sistema.';
            die(json_encode(array('result'=> $result, 'message'=>$message)));
        }
    }

}