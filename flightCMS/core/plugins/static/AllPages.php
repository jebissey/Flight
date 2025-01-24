<?php
//-------------------------------------------------------------------------------------------------
// Versuche mittels GLOB einen neuen Ansatz für das Problem des Filehandling mit '/' oder '\' in 
// den bisherigen Plugins 'Sidebar' und 'Featured' zu finden. 'AllPages.php' ist daher die 
// Schablone für die neue 'Sidebar.php' und 'Features.php'.
// AllPages listet ALLE Beiträge der Webseite auf.
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class AllPages
{
    //---------------------------------------------------------------------------------------------
    // statischer Aufruf z.B.: '...echo Featured::dir_rekursiv('DIR');...'
    //---------------------------------------------------------------------------------------------
    static function menue($dir) 
    {
        $dpr = new Dipper();

        foreach (glob($dir.'*', GLOB_ONLYDIR) as $file_name) 
		{
            foreach (glob($file_name.'/*'.CONTENT_EXT) as $file_name) 
            {
                if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))
          	    {
                    $file_link        = str_replace(CONTENT_EXT,'',explode('/',$file_name)[1].'/'.explode('/',$file_name)[2]);
                    $file_content     = file_get_contents($file_name);
                    $file_title       = $dpr->parse(Page::meta($file_content))['Title'];
                    $file_description = $dpr->parse(Page::meta($file_content))['Description'];
                    $file_featured    = $dpr->parse(Page::meta($file_content))['Featured'];
                    $file_logo        = $dpr->parse(Page::meta($file_content))['Logo'];

                    echo '<div class="col-sm-3">';
                    echo '<img src="'.$file_logo.'" class="img-fluid w-50">';
				    echo '<p class=""><a href="/'.$file_link.'">'.$file_title.'</a></p>';
                    echo '<p class="fs-6">'.$file_description.'</p>';
                    echo '</div>';
			    }
            }
		}
    }
}
?>