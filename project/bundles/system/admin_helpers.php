<?php
/**
 * Clase para metodos auxiliares que se necesitan solo e el admin
 * @author José Blanco <joseblanco77@gmail.com>
 * @package System
 */
class AdminHelpers
{
    public static function redAlert($message) {
        return '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button>'.$message.'</div>';
    }
    
    public static function blueAlert($message) {
        return '<div class="alert alert-info"><button data-dismiss="alert" class="close" type="button">×</button>'.$message.'</div>';
    }
}