<?php
//-------------------------------------------------------------------------------------------------
// Aktuell wird diese Klasse nicht genutzt.
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Url
{
    //---------------------------------------------------------------------------------------------
    // Extrahiert den Domain-Namen (der Unterschied von '\' zu '/' ist mich schleierhaft)
    //---------------------------------------------------------------------------------------------
  	public static function getDomain($url)
    {
        if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
        {
            return explode('\\', $url)[0];          // local Path-Delimiter '\' (Windows)
        } else {
            return explode('/', $url)[0];           // remote Path-Delimiter '/' (LINUX)
        }
    }
    //---------------------------------------------------------------------------------------------
    // Extrahier die Kategorie aus der URL
    //---------------------------------------------------------------------------------------------
    public static function getCategory($url)
    {
        /*if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
        {
            return explode('\\', $url)[1];
        } else {*/
            return CONTENT_DIR.'/'.explode('/', $_SERVER['REQUEST_URI'])[1];
        //}
    }
    //---------------------------------------------------------------------------------------------
    // Extrahiert den Beitrag aus der URL
    //---------------------------------------------------------------------------------------------
    public static function getPost($url)
    {
        /*if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
        {
            return explode('\\', $url)[2];
        } else {*/
            return explode('/', $url)[2];
        //}
    }
    //---------------------------------------------------------------------------------------------
    // von: '\content\kategorie\beitrag.md' zu: '\kategorie\beitrag'
    // von: '\content\beitrag.md'           zu: '\beitrag'
    //
    // Es ist zu bedenken, das es sich um physikalische Dateizugriffe auf der Festplatte handelt,
    // die mit '\' getrennt sind, im Unterschied zu URL Separatoren, die mit '/' zu verwenden sind.
    // Die Methode behebt auch das Problem, das bspw. 'content' als Bestandteil des Dateinamens
    // fälschlicherweise nicht mehr entfernt wird und Fehler vermiden werden. Der Bestandteil
    // 'content' wurde bis dahin aus der URL entfernt, egal ob es ein Dateiname oder ein Pfad war.
    // Der erste URL-Bestandteil 'content' wird entfernt, da er nicht benötigt wird.
    // Während das Plugin Sidebar.php den '/' immer in '\' ersetzen muss - ist mir ein Rätsel???
    // Die Plugins Sidebar.php und Featured.php machen prinzipiell das gleiche, jedoch muss
    // Sidebar '/' in '\' umwandeln, jedoch Featured nicht, warum?
    //---------------------------------------------------------------------------------------------
    public static function getPostUrl($url)
    {
        $url_part1 = '';
        $url_part2 = '';
        $url_part3 = '';
        $full_url  = '';

        if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
        {
            if(isset(explode('\\',$url)[0])) {
                $url_part1 = explode('\\',$url)[0];
                //$url_part1 = str_replace(CONTENT_EXT,'',$url_part1);
                //$full_url .= '\\'.$url_part1;                                                         // 'content/' wird nicht benötigt
            }
            if(isset(explode('\\',$url)[1])) {
                $url_part2 = explode('\\',$url)[1];
                $url_part2 = str_replace(CONTENT_EXT,'',$url_part2);                                    // 'kategorie' oder 'beitrag.md'
                $full_url .= '\\'.$url_part2;
            }
            if(isset(explode('\\',$url)[2])) {
                $url_part3 = explode('\\',$url)[2];
                $url_part3 = str_replace(CONTENT_EXT,'',$url_part3);                                    // 'kategorie/beitrag.md'
                $full_url .= '\\'.$url_part3;
            }
        } else {
            if(isset(explode('/',$url)[0])) {
                $url_part1 = explode('/',$url)[0];
                //$url_part1 = str_replace(CONTENT_EXT,'',$url_part1);
                //$full_url .= '\\'.$url_part1;                                                         // 'content/' wird nicht benötigt
            }
            if(isset(explode('/',$url)[1])) {
                $url_part2 = explode('/',$url)[1];
                $url_part2 = str_replace(CONTENT_EXT,'',$url_part2);                                    // 'kategorie' oder 'beitrag.md'
                $full_url .= '/'.$url_part2;
            }
            if(isset(explode('/',$url)[2])) {
                $url_part3 = explode('/',$url)[2];
                $url_part3 = str_replace(CONTENT_EXT,'',$url_part3);                                    // 'kategorie/beitrag.md'
                $full_url .= '/'.$url_part3;
            }
        }
        Debug::out('Url.php','getPostUrl()',$full_url);
        return $full_url;
    }
    //---------------------------------------------------------------------------------------------
    // 'flightcms-beitraege-sortieren.md' zu: 'flightcms-beitraege-sortieren'
    //---------------------------------------------------------------------------------------------
    public static function getPostName($file)
    {
        str_replace(array(CONTENT_EXT),'',$file);
    }
}
?>