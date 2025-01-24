---
Title:       Plugin 'AllPages'
Author:      FlightCMS
Date:        2024-01-31
Robots:      all
Featured:	 false
Tags:        Plugin,Verzeichnis,Vorlage,Author,Beitrag,Post
Logo:        /img/flightcms-plugin.svg
Description: Das Plugin AllPages soll alle Seiten aus allen Kategorien des Blog anzeigen.
---
## Plugin AllPages ## {#Plugin-AllPages}

Das Plugin `AllPages` zeigt alle Beiträge der Webseite an und kann als Vorlage für weitere Plugins diese Art dienen. Das Plugin verwendet den praktischen PHP-Befehl [glob()](https://www.php.net/manual/en/function.glob){.link-inline}.

    class AllPages
    {
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
_Plugin AllPages_

Möchtest du beispielsweise Beiträge eines bestimmten Autors anzeigen, dann erstelle eine Kopie dieses Plugins und nenne es zum Beispiel `PagesByAuthor.php` (den Class-Name nicht vergessen) und passe den Code um eine Abfrage nach dem Autor an.

Klammere die `echo`-Ausgabe mit der folgenden `if`-Klausel ein, um nach dem Autor _Max_ zu suchen:

    ...
    if (isset($dpr->parse(Page::meta($file_content))['Author']))         // Field 'Author' exsist?
    {
        if ($dpr->parse(Page::meta($file_content))['Author'] == 'Max')   // check
        {
            echo...
            echo...
            echo...
        }
    }
    ...
_Anpassung für Autor-Abfrage_

Hänge den Pluginaufruf in ein Template deiner Wahl mit der folgenden Befehlszeile ein:

    <?php echo PagesByAuthor::menue(CONTENT_DIR); ?>
_Übergabe eines Verzeichnis_

Statt des Standardverzeichnisses `CONTENT_DIR` kannst du auch ein ganz bestimmtes Verzeichnis dort übergeben, um in einer bestimmten Kategorie nach Beiträgen des Autors _Max_ zu suchen.