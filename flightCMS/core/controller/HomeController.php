<?php
//--------------------------------------------------------------------------------------------------
// Der HomeController wickelt alle Arbeiten ab, die auf der Startseite erforderlich sind, dazu
// gehören aktuell die Anzeige der Verfügbaren Kategorien (Ordner) und die Anzeige des Inhaltes der
// index.md.
// Der HomeController kann zudem auch Beiträge laden, die im Wurzelverzeichnis von 'home' liegen, 
// jedoch verhindert das Routing den Zugriff auf einen solchen Beitrag noch. Wobei im 'home' keine
// Beiträge liegen sollten, da ihnen sonst eine Thematisierung und Kategorisierung fehlen würden.
// Beiträge die in 'home' liegen werden daher ohne Link zum Beitrag angezeigt, lediglich 'Title' und
// 'Description', mehr nicht.
//--------------------------------------------------------------------------------------------------

class HomeController 
{
  	function __construct() 
    {
		Debug::out('HomeController.php','Start','');
		global $pd, $pde;
      	$pages_model        = new PagesModel(str_replace('/','',CONTENT_DIR));      		// home-dir = '/' aus 'content//' 'content/' machen
      	$categories_model   = new CategoriesModel(CONTENT_DIR.'*');
      	$index_file_content = file_get_contents(CONTENT_DIR.'index'.CONTENT_EXT);
      
		foreach (Dipper::parse(Page::meta($index_file_content)) as $key=>$value)			// NEW: Meta in Template Tokens kopieren
        {
			Debug::out('HomeController.php','Read Meta-Info',$key.' -> '.$value,0,60);
			$template_token_name    = strtolower($key);										// Platzhaltervariable im Template
			$template_token_content = $value;												// Inhalt des Platzhalters
          	Flight::view()->set($template_token_name, $template_token_content);				// in Template einsetzen
        }

		Debug::out('HomeController.php','Parse','Content-Section');
		$index_content_section = $pde->text(Page::content($index_file_content));			// Content-Bereich von index.md speichern
      	$index_content_section = Flight::hook('afterParseContent', $index_content_section);	// Plugins auf den Content loslassen

		Debug::out('HomeController.php','Set View','$pages, $categories, $content');
		Flight::view()->set('pages',      $pages_model->pages);								// Liste (Array) der Beiträge in diesem Ordner
		Flight::view()->set('categories', $categories_model->categories);				    // Template-Token 'categories' Array aufbauen
		Flight::view()->set('content',    $index_content_section);							// Template-Token 'content' aufbauen

		Debug::out('HomeController.php','Render',VIEWS_DIR.'/home'.VIEWS_EXT);
		Flight::render('home');																// Template 'home' rendern
    }
}
?>