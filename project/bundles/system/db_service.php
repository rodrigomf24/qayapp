<?php
/**
 * Clase para manejo de base de datos
 * @author José Blanco <joseblanco77@gmail.com>
 * @package System
 */
class DbService
{
    public static function query($query){
        $results = DB::query($query);
        Tools::dump('DbService::query()', array(
            'query'   => $query,
            'results' =>$results
        ));
        if(count($results)==1){
            return $results[0];
        }
        return $results;
    }
    
}
