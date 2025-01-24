---
Title:       HomeController
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Featured:	 true
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Der <em>HomeController</em> wickelt den Arbeitsprozess des CMS für die Startseite des CMS ab.
---
## Der HomeController der Startseite ## {#HomeController-Startseite}

Der _HomeController_ regelt die Verarbeitung des CMS wenn sich der Leser auf der Startseite des Content Management Systems befindet. Er greift über das entsprechende _Model_ auf Daten zu und wickelt die Anzeige am Browser ab.

	class HomeController 
	{
  		function __construct() 
    	{
			global $pd, $pde;
      		$pages_model        = new PagesModel(str_replace('/','',CONTENT_DIR));
      		$categories_model   = new CategoriesModel(CONTENT_DIR.'*');
      		$index_file_content = file_get_contents(CONTENT_DIR.'index'.CONTENT_EXT);
      
			foreach (Dipper::parse(Page::meta($index_file_content)) as $key=>$value)
        	{
				$template_token_name    = strtolower($key);
				$template_token_content = $value;
          		Flight::view()->set($template_token_name, $template_token_content);
        	}

			$index_content_section = $pde->text(Page::content($index_file_content));
      		$index_content_section = Flight::hook('afterParseContent', $index_content_section);

			Flight::view()->set('pages',      $pages_model->pages);
			Flight::view()->set('categories', $categories_model->categories);
			Flight::view()->set('content',    $index_content_section);

			Flight::render('home');
    	}
	}
_Version 2.4.01_

In der magischen Methode `__construct()` wird die Verarbeitung durch dieses Script initiiert und beginnt damit, die benötigten externen Komponenten, wie `Parsedown()`, `ParsedownExtra()`, `Dipper()`, `PagesModel()` und das `CategoriesModel()` in den Arbeitsspeicher zu laden. Mit `file_get_contents()` wird der Inhalt der `index.md` des Content-Verzeichnis eingelesen.

Die `foreach()` Schleife nutzt den YAML-Parser Dipper, um die interne Struktur des Beitrags `index.md` in einzelne Tokens wie beispielsweise `Title`, `Description`, `Author` usw. aufzuteilen, dabei wird der Token-Name und der Token-Inhalt mit `Flight::view()` in die _View_ kopiert, die später mit `Flight::render()` geladen und im Browser angezeigt wird.

Damit die _View_ auch in der Lage ist die Beiträge unterhalb der Startseite anzuzeigen, wird `pages` mit einem Array aus dem `PagesModel.php` gefüllt, ebenso werden verfügbare Kategorien mit dem Template-Token `categories` in die _View_ kopiert und konnen dann im Template nach belieben iteriert und mit HTML-Befehlen gestaltet werden.