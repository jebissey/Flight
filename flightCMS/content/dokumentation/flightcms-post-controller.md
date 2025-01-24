---
Title:       PostController
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Der <em>PostController</em> wickelt den Arbeitsprozess des CMS für einen konkreten Beitrag ab.
---
## Der PostController ## {#postController}

Der _PostController_ regelt die Verarbeitung des CMS wenn der Leser einen konkreten Beitrag aus dem Content Management Systems anfordert. Er greift auf den konkreten Beitrag zu und bereitet die Anzeige im Browser auf.

	class PostController 
	{ 
  		function __construct($category, $post) 
    	{
			global $dpr, $pd, $pde;
      		$post_file_path = CONTENT_DIR.$category.'/'.$post.CONTENT_EXT;
      
      		if(file_exists($post_file_path))							
        	{
      			$post_file_content = file_get_contents($post_file_path);
        	} 
      		else 
        	{
				Flight::hook('onError','');
          		Flight::halt(404, ERROR_404_DOC);
        	}

			foreach (Dipper::parse(Page::meta($post_file_content)) as $key=>$value)
        	{
				$template_token_name    = strtolower($key);							
				$template_token_content = $value;									
          		Flight::view()->set($template_token_name, $template_token_content);
        	}
      
			$post_content_section = $pde->text(Page::content($post_file_content));
			$post_content_section = Flight::hook('afterParseContent', $post_content_section);

			Flight::view()->set('content', $post_content_section);
			Flight::render('post');
    	}
	}
_Version 2.4.01_

Die Verarbeitung durch den `PostController.php` startet damit, das er die benötigten externen Bibliotheken `Parsedown()`, `ParsedownExtra()` und `Dipper()` in den Speicher läd und die Objekte als Variablen `$pd`, `$pde` und `$dpr` für den weiteren Zugriff zur Verfügung stellt.

Das _FlightCMS_ muss als nächstes prüfen, ob es sich bei dem Request um eine existierende Datei handelt und prüft die Existenz mit `file_exists()`. Existiert diese Datei nicht, dann übergibt der Controller die Steuerung an das _Flight Microframework_ und es gibt eine Fehlerseite (404) aus und stoppt die weitere Verarbeitung. Ansonsten wird das angeforderte Flatfile mit `file_get_contents()` geladen.

Mit Hilde des YAML-Parsers _Dipper_, wird die interne Struktur des angeforderten Beitrags in Key-Value Paare zerlegt und mit `Flight::view()` in die _View_ kopiert. Es entsteht dort beispielsweise der Token `Title` mit dem Inhalt `Das ist die Beitragsüberschrift`.

Im nächsten Schritt wird der eigentliche Content des Beitrags mit `explode()` herausgelöst und die die Templatevariable `content` kopiert, zuvor übersetzt der Markdown-Praser den Text in valides HTML-Format.

Mit `Flight::render()` weist FlightCMS das Framework an, die _View_ `post.php` zu laden und den Inhalt des Templates dort 