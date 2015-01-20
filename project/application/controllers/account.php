<?php

class Account_Controller extends Base_Controller{
    
    public function action_index(){
        echo "This is the progile page";
    }
    
    public function action_login(){
        echo "This is the login form";
    }
    
    public function action_logout(){
        echo "THis is the logout action";
    }
    
    public function action_welcome($name, $place){
        $data = array(
            'name' => $name,
            'place' => $place
        );
        return View::make('welcome', $data);
    }
    
    public function action_form(){
        return View::make('form');
    }
    
}

?>