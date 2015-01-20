<?php

Class Page_loader_Controller extends Base_Controller{
    
    public $layout = "templates.default";
    
    public function action_index(){
        
        $css='/ui/css/main.css';
        $script = '/ui/script/script.css';
        
        $data = array(
            'css' => $css,
            'script' => $script
        );
        $this->layout
            ->nest('child', 'pages.main')
            ->shares('data', $data);
        
    }
    
    public function action_load($page){

        $css='/ui/css/'.$page.'.css';
        $script = '/ui/script/'.$page.'.js';
        $data = array(
            'css' => $css,
            'script' => $script
        );
        $this->layout
            ->nest('child', 'pages.'.$page)
            ->shares('data', $data);

    }
}