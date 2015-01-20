<?php
/**
 * Clase para metodos auxiliares que se necesitan a traves del sitio
 * @author José Blanco <joseblanco77@gmail.com>
 * @package System
 */
class Tools
{
    public static $this_url = "";
    public static $breadcrumbs = array('starMedia'=>'http://starmedia.com/','Horóscopo'=>'/');
    public static $stylesheets = array();
    public static $javascripts = array();
    public static $scripts     = array();
    public static $metatags    = array();
    public static $logvars     = array();

    /**
     * Vuelca un dato en la consola de Firebug,por medio de FirePHP
     * @global object $firephp Librería externa
     * @param string $key Etiqueta a mostrar
     * @param mixed $value Data a volcar
     */
    public static function dump($key, $value) {
        if(Request::env() == 'development' && !constant('STM_CLI')) {
            global $firephp;
            $firephp->dump($key, $value);
        }
    }

    /**
     * Devuelve la URL probeida para la vista seleccionada
     * @return string URL actual
     */
    public static function get_url() {
        return self::$this_url;
    }

    /**
     * Devuelve el HTML generado de un pagelet
     * @param string $pagelet Pagelet a renderear
     * @param array Parámetros a pasarle al pagelet
     * @return \Laravel\View Pagelet rendereado
     */
    public static function get_pagelet($pagelet,$params = array()) {
        return \Laravel\View::make($pagelet)->shares('params', $params)->render();
    }

    /**
     * gets the data from a URL
     * source: http://davidwalsh.name/curl-download
     * @param string $url URL a obtener
     * @return mixed Data obtenida
     */
    public static function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Agrega uno o más enlaces (link y texto) a los breadcrumb del sitio
     * @param array $breadcrumb Listado de enlaces a agregar al breadcrumb
     */
    public static function set_breadcrumbs($breadcrumb = array()) {
        foreach( $breadcrumb as $name => $link ) {
            self::$breadcrumbs[$name] = $link;
        }
    }

    /**
     * Devuelve el breadcrumb según la data almacenada
     * @return string Cadena con el breadcrumb ya formado
     */
    public static function get_breadcrumbs() {
        $breadcrumb = "";
        $i = 0;
        foreach (self::$breadcrumbs as $name => $link) {
            $i++;
            if($i == 1) {
                $breadcrumb .= "<span class='parent' itemprop='title'><a href='{$link}' title='{$name}'  itemprop='url'>{$name}</a></span>";
            } elseif($i <= count(self::$breadcrumbs) - 2) {
                $breadcrumb .= "<span class='hrscBreadcrumbSeparator'>›</span><span class='parent' itemprop='title'><a href='{$link}' title='{$name}'  itemprop='url'>{$name}</a></span>";
            } elseif($i == count(self::$breadcrumbs) - 1) {
                $breadcrumb .= "<span class='hrscBreadcrumbSeparator'>›</span><span class='parent' itemprop='title'><a href='{$link}' title='{$name}'  itemprop='url'>{$name}</a></span>";
            } elseif(!substr_count($link, '.html')) {
                $breadcrumb .= "<span class='hrscBreadcrumbSeparator'>›</span><span class='child' itemprop='title'><a href='{$link}' title='{$name}'  itemprop='url'>{$name}</a></span>";
            }
        }
        Tools::dump('get_breadcrumbs()', self::$breadcrumbs);
        return $breadcrumb;
    }

   /**
    * Agrega una ruta de archivo al stack de hojas de estilo inyectables
    * @param string $file Ruta del archivo a agregar
    */
    public static function add_stylesheet($file) {
        if(file_exists(path('public').$file)) {
            self::$stylesheets[] = '/'.$file;
            Tools::dump('added: stylesheet', '/'.$file);
        } else {
            Tools::dump('FAILURE: stylesheet ', '/'.$file.' doesn´t exists!!');
        }
    }

    /**
     * Encadena las hojas de estilo inyectables para su impresión en el template
     * @return string Cadena de tags <link>
     */
    public static function get_stylesheets() {
        $files_to_add = "";
        foreach (self::$stylesheets as $stylesheet) {
            $files_to_add .= '<link rel="stylesheet" href="'.$stylesheet.'?system=001">'.PHP_EOL;
        }
        return $files_to_add;
    }

   /**
    * Agrega una ruta de archivo al stack de scripts JS inyectables
    * @param string $file Ruta del archivo a agregar
    */
    public static function add_javascript($file) {
        if(file_exists(path('public').$file)) {
            self::$javascripts[] = '/'.$file;
            Tools::dump('added: javascript', '/'.$file);
        } else {
            Tools::dump('FAILURE: javascript ', '/'.$file.' doesn´t exists!!');
        }
    }

    /**
     * Encadena los JS inyectables para su impresión en el template
     * @return string Cadena de tags <script>
     */
    public static function get_javascripts() {
        $files_to_add = "";
        foreach (self::$javascripts as $javascript) {
            $files_to_add .= '<script type="text/javascript" src="'.$javascript.'?system=001"></script>'.PHP_EOL;
        }
        return $files_to_add;
    }

   /**
    * Agrega un código al stack de scripts JS inyectables
    * @param string $text Código a agregar
    */
    public static function add_script($text) {
        self::$scripts[] = $text;
    }

    /**
     * Encadena los scripts JS inyectables para su impresión en el template
     * @return string Conjunto de scripts inyectados
     */
    public static function get_scripts() {
        return implode(PHP_EOL, self::$scripts) .PHP_EOL;
    }

    /**
     * Agrega un tag <meta> stack de tags inyectables
     * @param string $tag Tag a agregar
     */
    public static function add_metatag($tag) {
        self::$metatags[] = $tag;
        Tools::dump('added: metatag', $tag);
    }

    /**
     * Encadena los metas inyectables para su impresión en el template
     * @return string Cadena de tags <meta>
     */
    public static function get_metatags() {
        $metas_to_add = implode(PHP_EOL, self::$metatags).PHP_EOL;
        return $metas_to_add;
    }

    /**
     * Almacena las variables para log de publicidad
     * @param string $adlogPath adlogPath
     * @param string $adlogPage adlogPage
     * @param string $adnombreTipo adnombreTipo
     */
    public static function set_logvars($adlogPath,$adlogPage,$adnombreTipo) {
        self::$logvars = array (
            'adlogPath'    => $adlogPath,
            'adlogPage'    => $adlogPage,
            'adnombreTipo' => $adnombreTipo,
        );
    }

    /**
     * Devuelve las variables para los de publicidad
     * @return string Variables den formato JS
     */
    public static function get_logvars() {
        $logvars = self::$logvars;
        $js_string = "
            var logPath = '{$logvars['adlogPath']}';
            var logPage = '{$logvars['adlogPage']}';
            var nombre_tipo_menu = '{$logvars['adnombreTipo']}';
            ";
            return $js_string;
    }

    /**
     * Recibe una fecha y un formato, para devolverla en un formato "latino"
     * @author Manolo Guerrero (manoloweb) <manolo@interdev.com.gt>
     * @link http://www.forosdelweb.com/f18/fecha-espanol-solucion-raiz-date_es-149339/ Fecha en español, solución de raiz... date_es();
     * @param type $formato
     * @param type $fecha
     * @return type
     */
    public static function date_es($formato="F j, Y",$fecha=0) {
        if ( preg_match ("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha,$partes)) {
            if (checkdate($partes[2],$partes[3],$partes[1])) {
                $fecha=strtotime($fecha);
            } else {
                return(-1);
            }
        } elseif ($fecha==0) {
            $fecha=time();
        }
        $dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
        $dias_c=array("Dom","Lun","Mar","Mie","Jue","Vie","Sab");
        $meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $meses_c=array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

        $valores=explode(" | ",date ("a | A | B | d | D | F | g | G | h | H | i | I | j | l | L | m | M | n | O | r | s | S | t | T | U | w | W | Y | y | z | Z",$fecha));
        $claves= array ("a","A","B","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z");
        for ($i=0;$i<count($claves);$i++) {
            $conv[$claves[$i]]=$valores[$i];
        }
        $conv["D"]=$dias_c[$conv["w"]];
        $conv["l"]=$dias[$conv["w"]];
        $conv["F"]=$meses[$conv["n"]];
        $conv["M"]=$meses_c[$conv["n"]];
        $conv["r"]=$conv["D"].", ".$conv["d"]." ".$conv["M"]." ".$conv["Y"]." ".$conv["H"].":".$conv["i"].":".$conv["s"]." ".$conv["O"];
        $conv["S"]="o";
        $escape='\\'; //<< VER NOTA AL FINAL DEL POST!!!!!!!!!!
        $escapado=0;
        $f=$formato;
        $res="";
        for ($t=0;$t<strlen($formato);$t++) {
            if ($escapado==1) {
                $res.=$f{$t};
                $escapado=0;
            } else {
                if($f{$t}==$escape) {
                    $escapado=1;
                } else {
                    if (isset($conv[$f[$t]])){
                        $res.=$conv[$f[$t]];
                    } else {
                        $res.=$f{$t};
                    }
                }
            }
        }
        return $res;
    }

    /**
     * Función para clear slugs
     * @param string $str Cadena a trabajar
     * @return string Slug limpio de caracteres extraños
     */
    public static function get_slug($str) {
        $replace=array();
        $delimiter='-';
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = str_replace(array('-a-','-de-','-la-','-los-','-las-','-lo-','-en-','-del-','-el-','-se-','-y-','  ','--'),'-',$clean);
        $clean = substr($clean,0,50);
        return $clean;
    }

    /**
     * Identifica si el llamado es un XMLHttpRequest
     * @return boolean True o False si el llamado es por ajax o no
     */
    public static function is_ajax() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * Construye un tag parsetear una fecha de expiración del caché
     * @return string Cadena con el tag Meta:Last-Modified
     */
    public static function getMetaExpireDaily() {
        $hourExpire = date('H');
        if((int)$hourExpire > 4 ){
            $fechaExpire = date('D, d M Y', strtotime("today")).' 04:00:00';
        } else {
            $fechaExpire = date('D, d M Y', strtotime("yesterday")).' 04:00:00';
        }
        $metaExpire = '<meta http-equiv="last-modified" content="'.$fechaExpire.' CST">'.PHP_EOL;
        return $metaExpire;
    }
    
    public static function getMicrotime() {
        return str_replace(array('.',' '),'',microtime());
    }
    
    public static function getFilename($file) {
        if($file['error']) {
            return '';
        }
        $microtime = Tools::getMicrotime();
        $parts     = explode('.',$file['name']);
        $ext       = array_pop($parts);
        return "{$microtime}.{$ext}";
    }
    
    public static function orderDate($date) {
        $parts = explode(' ', $date);
        if(!is_array($parts)) return false;
        $dateParts = explode('/',$parts[0]);
        if(!is_array($dateParts) && count($dateParts)<3) return false;
        return $dateParts[2].'-'.$dateParts[0].'-'.$dateParts[1].' '.$parts[1];
    }

}
