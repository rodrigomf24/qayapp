<?php

class Contact_Controller extends Base_Controller{
    
    public $layout = "templates.default";
    
    public function action_index(){
        if (isset($_POST)){ $post = $_POST; print_r($_POST);}
    }
    
    public function action_check(){
        if (isset($_POST) && !empty($_POST)){
            $rules = array(
                           'name' => 'required|min:3|max:32|alpha',
                           'email' => 'required|email'
                           );
            $validator = Validator::make($_POST, $rules);
            
            if ($validator->fails()){
                $css='/ui/css/contact.css';
                $script = '/ui/script/contact.css';
                $errors = array(
                                'email' => $validator->errors->get('email'),
                                'name' => $validator->errors->get('name')
                                );
                $data = array(
                    'css' => $css,
                    'script' => $script,
                    'errors' => $errors
                );
                $this->layout
                    ->nest('child', 'pages.contact')
                    ->shares('data', $data);
            }else{
                $css='/ui/css/contact.css';
                $script = '/ui/script/contact.css';
                $message = "Subscription completed!";
                
                if($this->action_insert_contacts($_POST['name'], $_POST['email'])){
                    $result = "Todo bien";
                }else{
                    $result = "Error al insertar en DB";
                }
                
                $data = array(
                    'css' => $css,
                    'script' => $script,
                    'message' => $message,
                    'result' => $result
                );
                
                $this->layout
                    ->nest('child', 'pages.contact')
                    ->shares('data', $data);
            }
        }
    }
    
    public function action_insert_contacts($name, $email){
        return DB::table('contacts')->insert(array(
                                            'name'=>$name,
                                            'email'=>$email
                                            ));
    }
}

?>