---
Title:       PagesModel
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Das <em>PostModel</em> greift auf die physikalischen Daten des Beitrags und des Content zu und gibt sie an den Aufrufer.
---
## Das PagesModell greift auf Seitendaten zu ## {#zugriff-auf-daten}

Das _PagesModel_ kümmert sich um die Daten, die von einzelnen Beiträgen bereitgestellt werden, es liefert eine Liste verfügbarer Beiträge innerhalb einer konkreten Struktur bzw. einer Kategorie. Beiträge können wahlweise Auf- oder Absteigend für die Anzeige sortiert an den Aufrufer zurückgegeben werden.

	class PagesModel
	{
		private $pages;

  		function __construct($dir) 
    	{
			// === Start: Sorting ===
			$unsorted_file_list = array();
			$sorted_file_list   = array();

			foreach (glob($dir.'/*'.CONTENT_EXT) as $file_name) 
			{
				if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))
          		{
					$file_content = file_get_contents($file_name);
					$date = Dipper::parse($file_content)['Date'];
					$unsorted_file_list[]=$date.';'.$file_name;
				}
			}

			if(SORTING == 'ASC')  sort($unsorted_file_list);
			if(SORTING == 'DESC') rsort($unsorted_file_list);

			foreach($unsorted_file_list as $value)
			{
				$sorted_file_list[] = explode(';', $value)[1];
			}
			// === End: Sorting ===

			// === Start: Process Meta ===
			//foreach (glob($dir.'/*'.CONTENT_EXT) as $file_name)   // use this without sorting
			foreach ($sorted_file_list as $file_name)				// use sorted List
        	{
				$file_content = file_get_contents($file_name);

				foreach (Dipper::parse(Page::meta($file_content)) as $key=>$value)
				{
					if($value)
					{
						$page[strtolower($key)]  = $value;
						$this->pages[$file_name] = $page;
					}
				}
				$page['url'] = str_replace(array(CONTENT_DIR,CONTENT_EXT),'',$file_name);
				$this->pages[$file_name] = $page;
			}
			// === End: Process Meta ===
    	}

		function __get($value)
		{
			return $this->$value;
		}
	}
_Version 2.4.01_

Die Klasse `PagesModel` legt eine interne Variable `$pages` an, in der alle gefundenen Beiträge als Array gespeichert werden. Mit Hilfe von `glob` iteriert `foreach()` über das Array welches `glob` liefert. Ausgenommen davon sind allerdings die Datei `index.md` und `_*.md` (Deteien die mit Unterstrich beginnen).

Um die Sortierung der Beiträge zu realisieren, werden die Dateinamen, in der Form `Datum;Dateiname`, in das Array `$unsorted_file_list` eingetragen. Anschließend wird das Array sortiert und der Datums-Prefix mit `$sorted_file_list[] = explode(';', $value)[1];` entfernt und in das Array `$sorted_file_list` eingetragen. In der zweiten `foreach(...` kann die reguläre Verarbeitung der Meta-Attribute erfolgen.

Die _magische Methode_ `__get()` liefert die Beitragsliste an den _Controller_ zurück, der diese in eine Templatevariable kopiert, damit im Template die Beitragsvorschau aufgebaut werden kann.