<?php
//-------------------------------------------------------------------------------------------------
// Helper rund um eine einzelne Seite
//-------------------------------------------------------------------------------------------------

$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Page
{
	//---------------------------------------------------------------------------------------------
	// Liefert den oberen Meta-Bereich des MD-Beitrags zurück und soll den Passus:
	// "explode('---', $index_file_content)[1])" deutlich kürzen. Aufruf mit: "Page::meta();"
	// Zudem zeigte sich, das die bisherige Formulierung:
	//
	//     $date = Dipper::parse($file_content)['Date']
	//     $title = Dipper::parse($file_content)['Title']
	//
	// nicht trennschaft von Dipper analysiert wird und es immer wieder zu merkwürdigen Abbrüchen
	// kommt. Wird nun ausschließlich der Metabereich an Dipper übergeben, funktioniert das
	// Parsing der Metadaten fehlerfrei.
	//---------------------------------------------------------------------------------------------
	public static function meta($file_content)
	{
		Debug::out('Page.php','meta()',explode('---', $file_content)[1]);
		return explode('---', $file_content)[1];		// diese Notation ist noch recht ungenau
	}
	//---------------------------------------------------------------------------------------------
	// Liefert den unteren Content-Bereich des MD-Beitrags zurück und soll den Passus:
	// "explode('---', $index_file_content)[2])" deutlich kürzen. Aufruf mit: "Page::content();"
	// ACHTUNG: Hier gibt es ein Problem, wenn innerhalb des Content '---' auftaucht!
	//---------------------------------------------------------------------------------------------
	public static function content($file_content)
	{
		//return explode('---'."\n", $file_content)[2];												// könnte das die Lösung sein?
		return explode('---', $file_content)[2];													// diese Notation ist noch recht ungenau
	}

	//---------------------------------------------------------------------------------------------
	// Sortierung der Beiträge anhand des Datum im Beitrag. Die Methode bekommt ein Verzeichnis
	// übergeben und sortiert zuvor noch index.md und Ordner aus. Es entsteht eine sortierte Liste
	// mit Dateinamen. Erhält als Eingabe '$dir' mit bspw.:
	// 
	// $dir:
	// -----
	//     content/dokumentation
	//     content/plugins
	//     content/templates
	//---------------------------------------------------------------------------------------------
	public static function sortPagesByDate($dir)
	{
		Debug::out('Page.php','sortPagesByDate',$dir.' -> '.strtolower(SORTING));

		$unsorted_file_list = array();																// unsorted Flie-List Array
		$sorted_file_list   = array();																// sorted File-List Array

		foreach (glob($dir.'/*'.CONTENT_EXT) as $file_name) 
		{
			if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))		// exclude 'index' and '_' Files
          	{
				$file_content = file_get_contents($file_name);										// Load File Content
				$date = Dipper::parse(Page::meta($file_content))['Date'];							// oberen Meta-Bereich parsen
				$unsorted_file_list[] = $date.';'.$file_name;										// add '2024-01-26' + ';' + 'der-erste-beitrag.md'
			}
		}

		Debug::out('Page.php','sortPagesByDate()','-> sort()/rsort()');
		if(strtolower(SORTING) == 'asc')  sort($unsorted_file_list);								// sort Array Ascending
		if(strtolower(SORTING) == 'desc') rsort($unsorted_file_list);								// sort Array Descending

		foreach($unsorted_file_list as $value)
		{
			Debug::out('Page.php','sortPagesByDate', 'Order -> '.explode(';', $value)[0]);
			$sorted_file_list[] = explode(';', $value)[1];											// cut '2024-01-26'
		}
		Debug::out('Page.php','sortPagesByDate()','-> return');
		return $sorted_file_list;
	}

	//---------------------------------------------------------------------------------------------
	// Sortiert Beiträge anhand des reales Beitragstitels (nicht der Permalink). Alle Titel werden
	// in Kleinbuchstaben umgewandelt, um den Sortierunterschied zwischen 'A' und 'a' zu vermeiden.
	//
	// $dir:
	// -----
	//     content/dokumentation
	//     content/plugins
	//     content/templates
	//---------------------------------------------------------------------------------------------
	public static function sortPagesByTitle($dir)
	{
		Debug::out('Page.php','sortPagesByTitle',$dir.' -> '.strtolower(SORTING));

		$unsorted_file_list = array();																// unsorted Flie-List Array
		$sorted_file_list   = array();																// sorted File-List Array

		foreach (glob($dir.'/*'.CONTENT_EXT) as $file_name) 
		{
			if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))		// exclude 'index' and '_' Files
          	{
				$file_content = file_get_contents($file_name);										// Load File Content
				//$title = Dipper::parse($file_content)['Title'];									// ALT: extract the Title from upper File-Content
				$title = Dipper::parse(Page::meta($file_content))['Title'];							// oberen Meta-Bereich parsen
				$unsorted_file_list[]=strtolower($title).';'.$file_name;							// add 'title' + ';' + 'der-erste-beitrag.md'
			}
		}

		if(strtolower(SORTING) == 'asc')  sort($unsorted_file_list);								// sort Array Ascending
		if(strtolower(SORTING) == 'desc') rsort($unsorted_file_list);								// sort Array Descending

		foreach($unsorted_file_list as $value)
		{
			Debug::out('Page.php','sortPagesByTitle', 'Order -> '.explode(';', $value)[0]);
			$sorted_file_list[] = explode(';', $value)[1];											// cut '2024-01-26'
		}
		return $sorted_file_list;
	}

	//---------------------------------------------------------------------------------------------
	// Sortiert nach fester Reihenfolge alphabetisch aufsteigen von 'A' nach 'Z'. Beispielsweise
	// wird dies im Plugin 'Sidebar.php' genutzt, um Beiträge aufsteigend nach Titel für den Leser
	// anzuzeigen (natürlichste und üblichste Darstellung, während in der Kategorie-Anzeige nach
	// Datum absteigend sortiert ist - Blogstyle).
	//
	// $dir:
	// -----
	//     content/dokumentation
	//     content/plugins
	//     content/templates
	//---------------------------------------------------------------------------------------------
	public static function sortPagesByTitleAsc($dir)
	{
		Debug::out('Page.php','sortPagesByTitle',$dir.' -> '.strtolower(SORTING));

		$unsorted_file_list = array();																// unsorted Flie-List Array
		$sorted_file_list   = array();																// sorted File-List Array

		foreach (glob($dir.'/*'.CONTENT_EXT) as $file_name) 
		{
			if (!stripos($file_name, 'index'.CONTENT_EXT) && !preg_match('{_}', $file_name))		// exclude 'index' and '_' Files
          	{
				$file_content = file_get_contents($file_name);										// Load File Content
				$title = Dipper::parse(Page::meta($file_content))['Title'];							// oberen Meta-Bereich parsen
				$unsorted_file_list[]=strtolower($title).';'.$file_name;							// add 'title' + ';' + 'der-erste-beitrag.md'
			}
		}

		sort($unsorted_file_list);																	// sort Array Ascending
		//rsort($unsorted_file_list);																// sort Array Descending

		foreach($unsorted_file_list as $value)
		{
			Debug::out('Page.php','sortPagesByTitle', 'Order -> '.explode(';', $value)[0]);
			$sorted_file_list[] = explode(';', $value)[1];											// cut '2024-01-26'
		}
		return $sorted_file_list;
	}
}
?>