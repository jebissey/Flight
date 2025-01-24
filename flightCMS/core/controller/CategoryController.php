<?php
//--------------------------------------------------------------------------------------------------
// Der CategoryController regelt die Anzeige der Webseite, wenn der Leser sich in einer Kategorie
// befindet. Der Controller liest die in der Kategorie befindliche 'index.md' zur Anzeige von
// Title, Description und Content der gewählten Kategorie. Zusätzlich werden die darin befindlichen
// Beiträge mit deren Meta-Attributen wie 'Title' und 'Description' angezeigt.
//--------------------------------------------------------------------------------------------------

class CategoryController 
{
  	function __construct($category) 
    {
		Debug::out('CategoryController.php','Start',$category);
		global $dpr, $pd, $pde;
		$pages_model     = new PagesModel(CONTENT_DIR.$category);      								// Pfad: /content/categorie
      	$index_file_path = CONTENT_DIR.$category.'/index'.CONTENT_EXT; 								// Pfad: /content/categorie/index.md
      
      	if(file_exists($index_file_path))															// Prüfen ob 'index.md' existiert
        {
			Debug::out('CategoryController.php','Load',$index_file_path);
      		$index_file_content = file_get_contents($index_file_path);								// Wenn 'index.md' existiert dann öffnen
        } else {
			Debug::out('CategoryController.php','Error','404');
			Flight::hook('onError','');																// start Plugins by Hook 'onError'
          	Flight::halt(404, ERROR_404_DOC);														// Wenn 'index.md' nicht existiert Error 404 ausgeben
        }
      
		foreach (Dipper::parse(Page::meta($index_file_content)) as $key=>$value)					// NEW: Metabereich in index.md einlesen
        {
			Debug::out('CategoryController.php','Read Meta-Info',$key.' -> '.$value);
			$template_token_name    = strtolower($key);												// Templatevariable
			$template_token_content = $value;														// Inhalt es Platzhalters
          	Flight::view()->set($template_token_name, $template_token_content);						// in Template einsetzen
        }

		Debug::out('CategoryController.php','Parse','Content-Section');
		$index_content_section = $pde->text(Page::content($index_file_content));					// Content-Bereich der 'index.md'

		Debug::out('CategoryController.php','Set View','$pages, $content');
		Flight::view()->set('pages', $pages_model->pages);											// Liste (Array) der Beiträge in diesem Ordner
      	Flight::view()->set('content', $index_content_section);										// Content aus dem index.md der Kategorie

		Debug::out('CategoryController.php','Render',VIEWS_DIR.'/category'.VIEWS_EXT);
		Flight::render('category');																	// Kategorie-Template anzeigen
    }
}
?>