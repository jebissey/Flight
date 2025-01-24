<?php
//-------------------------------------------------------------------------------------------------
// Die Sidebar baut eine Liste aller verfügbarer Beiträge der Webseite als Seitenmenü auf. Als
// Standardsortierung ist hier fest alphanumerisch ausfteigend (A...Z) eingestellt. Die Sortierung
// kann für das CMS global eingestellt werden, jedoch wird die Sidebar davon nicht beeinflusst.
// Die Sortierung von A-Z ist die natürlichste und erwartete Einstellung, warum sollte sie also
// verändert werden.
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Sidebar
{
    //---------------------------------------------------------------------------------------------
    // statischer Aufruf z.B.: '...echo Sidebar::menue(CONTENT_DIR);...'
    //
    // $file_name:                  content/dokumentation
    //                              content/plugins
    //                              content/...
    //
    // $_SERVER['REQUEST_URI']:     /dokumentation/flightcms-log-as-csv
    // $file_link:                  /dokumentation/flightcms-log-as-csv
    //---------------------------------------------------------------------------------------------
    static function menue($title=true, $description=true, $logo=true)
    {
        $sorted_file_list = array();
        $dpr = new Dipper();

        //foreach (glob($dir.'*', GLOB_ONLYDIR) as $file_name)
        foreach (glob(CONTENT_DIR.'*', GLOB_ONLYDIR) as $file_name)
		{
            $index_content     = file_get_contents($file_name.'/index'.CONTENT_EXT);
            $index_title       = $dpr->parse(Page::meta($index_content))['Title'];
            $index_description = $dpr->parse(Page::meta($index_content))['Description'];
            $index_logo        = $dpr->parse(Page::meta($index_content))['Logo'];

            if($title)       echo '<p>'.$index_title.'</p>';
            if($description) echo '<p class="fs-6">'.$index_description.'</p>';
            if($logo)        echo '<div class="text-center"><img src="'.$index_logo.'" class="img-fluid w-50"></div>';

            echo '<nav>';
            echo '<ul class="sidebar">';

            $sorted_file_list = Page::sortPagesByTitleAsc($file_name);

            foreach ($sorted_file_list as $file_name)
            {
                if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))
          	    {
                    $file_link    = str_replace(CONTENT_EXT,'',explode('/',$file_name)[1].'/'.explode('/',$file_name)[2]);
                    $file_content = file_get_contents($file_name);
                    $file_title   = $dpr->parse(Page::meta($file_content))['Title'];

                    if (str_contains($_SERVER['REQUEST_URI'], $file_link))
                    {
                        echo '<li class="fs-6 fw-bold">&#187; <a href="/'.$file_link.'">'.$file_title.'</a></li>';  // Hervorhebung wenn active
                    } else {
				        echo '<li class="fs-6"><a href="/'.$file_link.'">'.$file_title.'</a></li>';                 // ohne Hervorhebung
                    }
			    }
            }
            echo '</ul>';
            echo '</nav>';
		}
    }
}
?>