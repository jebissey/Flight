<?php
//--------------------------------------------------------------------------------------------------
// Der PostController verarbeitet die Anzeige eines einzelnen Beitrags. Existiert der spezifische
// Beitrag (xyz.md) nicht, dann wird die Konreolle an das Flight Microframework zurück gegeben
// und stoppt die weitere Verarbeitung.
//--------------------------------------------------------------------------------------------------

class PostController 
{ 
  	function __construct($category, $post) 
    {
		Debug::out('PostController.php','Start',$category.', '.$post);
		global $dpr, $pd, $pde;
      	$post_file_path = CONTENT_DIR.$category.'/'.$post.CONTENT_EXT; 								// Pfad: /content/cetagorie/post.md
      
      	if(file_exists($post_file_path))															// Existiert der Beitrag?
        {
			Debug::out('PostController.php','Load File',$post_file_path);
      		$post_file_content = file_get_contents($post_file_path);								// existiert der Beitrag, dann öffnen
        } 
      	else 
        {
			Debug::out('PostController.php','File NotFound',$post_file_path);
			Flight::hook('onError','');																// start Plugins by Hook 'onError'
          	Flight::halt(404, ERROR_404_DOC);														// existiert der Beitrag nicht, dann Error 404
        }

		foreach (Dipper::parse(Page::meta($post_file_content)) as $key=>$value) 					// NEW: YAML Parser zerlegt den Dateiinhalt
        {
			Debug::out('PostController.php','Read Meta-Info',$key.' -> '.$value);
			$template_token_name    = strtolower($key);												// Platzhaltervariable im Template
			$template_token_content = $value;														// Inhalt des Platzhalters
          	Flight::view()->set($template_token_name, $template_token_content);						// in Template einsetzen
        }
      
		Debug::out('PostController.php','Parse','Content-Section');
		$post_content_section = $pde->text(Page::content($post_file_content)); 						// Content-Bereich [2] speichern
		$post_content_section = Flight::hook('afterParseContent', $post_content_section);			// Plugins auf den Content loslassen

		Debug::out('PostController.php','Set View','$content');
		Flight::view()->set('content', $post_content_section);

		Debug::out('PostController.php','Render',VIEWS_DIR.'/post'.VIEWS_EXT);
		Flight::render('post');
    }
}
?>