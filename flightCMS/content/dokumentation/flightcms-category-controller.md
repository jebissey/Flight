---
Title:       CategoryController
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Der <em>CategoryController</em> wickelt den Arbeitsprozess des CMS für die Anzeige einer Kategorie ab.
---
## Der CategoryController der Startseite ## {#CategoryController}

Der _CategoryController_ regelt die Verarbeitung des CMS wenn sich der Leser in einer Kategorie des Content Management Systems befindet. Er greift über das entsprechende _Model_ auf Daten zu und wickelt die Anzeige am Browser ab.

	class CategoryController 
	{
  		function __construct($category) 
    	{
			global $dpr, $pd, $pde;
			$pages_model     = new PagesModel(CONTENT_DIR.$category);
      		$index_file_path = CONTENT_DIR.$category.'/index'.CONTENT_EXT;
      
      		if(file_exists($index_file_path))
        	{
      			$index_file_content = file_get_contents($index_file_path);
        	} 
      		else 
        	{
				Flight::hook('onError','');
          		Flight::halt(404, ERROR_404_DOC);
        	}
      
			foreach (Dipper::parse(Page::meta($index_file_content)) as $key=>$value)
        	{
				$template_token_name    = strtolower($key);
				$template_token_content = $value;
          		Flight::view()->set($template_token_name, $template_token_content);
        	}

			$index_content_section = $pde->text(Page::content($index_file_content));

			Flight::view()->set('pages', $pages_model->pages);
      		Flight::view()->set('content', $index_content_section);

			Flight::render('category');
    	}
	}
_Version 2.4.01_

Der _CategoryController_ beginnt mit der magischen Methode `__construct()` des Constructors wenn er das erste mal im Arbeitsspeicher erzeugt wird, dort werden die externen Bibliotheken `Parsedown()`, `ParsedownExtra()` und `Dipper()` für den weiteren Gebrauch hinzugeladen. Mit `$index_file_path` wird der physikalische Pfad auf die Datei `content/kategorie/index.md` gesetzt, damit die Kategoriebeschreibung später geladen werden kann.

Im nächsten Schritt muss der _Controller_ prüfen, ob es sich bei dem Request an das CMS um ein valides Verzeichnis handelt oder nicht, ist das nicht der Fall, stoppt das _FlightCMS_ die Verarbeitung und gibt eine _404-Error_ Seite im Browser aus.

Existiert die angeforderte Kategorie, wird die darin befindliche `index.md` geladen und mit Hilfe des YAML-Parsers in ihre Betsnadteile, wie `Title`, `Date`, `Author` usw. zerlegt. Diese einzelnen Tokens werden als Key-Value Paare in die _View_ des _FlightCMS_ kopiert und mit `Flight::render()` für die Anzeige des Templates gestartet.

Die Variable `pages` enthält dann alle Beiträge, die in dieser Kategorie vorhanden sind und `content` stellt den Inhalt der Kategoriebeschreibung dar und kann in den Templates ausgelesen werden.