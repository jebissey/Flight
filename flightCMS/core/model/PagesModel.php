<?php
//--------------------------------------------------------------------------------------------------
// Das PagesModel sucht im Verzeichnis nach Beiträgen (1...n) und verpackt deren Inhalt in ein 
// Array und gibt es an den Aufrufer zurück.
//--------------------------------------------------------------------------------------------------

class PagesModel
{
	private $pages;																					// Liste aller Beiträge dieser Kategorie

  	function __construct($dir) 
    {
		Debug::out('PagesModel.php','Start',$dir);
		global $pd, $pde;
		$sorted_file_list = array();																// nimmt die sortierten Beiträge auf

		if(strtolower(SORT_BY) == 'date')  {$sorted_file_list = Page::sortPagesByDate($dir);} 		// Sortierung der gefundenen Beiträge nach 'Date'
		if(strtolower(SORT_BY) == 'title') {$sorted_file_list = Page::sortPagesByTitle($dir);}		// Sortierung der gefundenen Beiträge nach 'Title'

		foreach ($sorted_file_list as $file_name)													// sorting by Date, Title, ASC, DESC
        {
			$file_content = file_get_contents($file_name);											// den oder die gefundenen Beiträge laden
			Debug::out('PagesModel.php','Load File',$file_name);

			foreach (Dipper::parse(Page::meta($file_content)) as $key=>$value)						// korrekte Implementierung
			{
				if($value)
				{
					Debug::out('PagesModel.php','Read Meta-Info',$key.' -> '.substr($value,0,60));
					$page[strtolower($key)]  = $value;												// Meta-Attribute (Key:Value) ermitteln
					$this->pages[$file_name] = $page;												// zum Schlüssel (Dateiname) hinzufügen
				}
			}
			Debug::out('PagesModel.php','Read Meta-Info','url -> '.str_replace(array(CONTENT_DIR,CONTENT_EXT),'',$file_name));
			$page['url']             = str_replace(array(CONTENT_DIR,CONTENT_EXT),'',$file_name);	// 'content/filename.md' zu '/filename' machen
			$this->pages[$file_name] = $page;														// URL-Attribut dem Pages-Array anhängen

			$page['content']         = $pde->text(Page::content($file_content));					// den Content parsen und ebenfalls anhängen
			$this->pages[$file_name] = $page;														// Content an den Schlüssel anhängen
		}
    }

	//---------------------------------------------------------------------------------------------
	// Zugriff über die 'magische Methode' ist günstiger als über einen dedizierten 'getter'
	//---------------------------------------------------------------------------------------------
	function __get($value)
	{
		Debug::out('PagesModel.php','Return',$value);
		return $this->$value;
	}

/* ------------------------------------------------------------------------------------------------
Das 'PagesModel' durchsucht ein Verzeichnis '$dir' nach Beiträgen, sortiert diese mit 
'Page::sort..()' und erzeugt daraus ein sortiertes Array das an den Aufrufer zurück gegeben wird.
Das Array kann entweder nur einen Beitrag oder unendlich viele Beiträge enthalten. Das 
Schlüssel-Attribut ist dabei der Dateiname mit vollem physikalischem Pfad, etwa so:

array(2) 
{ 
	["content/cmsworkbench-startet-mit-FlightCMS.md"] => array(9) 
	{ 
		["title"]		=> string(36) 	"CMSWorkbench stellt auf FlightCMS um" 
		["author"]		=> string(9) 	"FlightCMS" 
		["date"]		=> string(10) 	"2023-12-21" 
		["robots"]		=> string(3) 	"all" 
		["tags"]		=> string(18) 	"Logbuch,Log,Status" 
		["logo"]		=> string(31) 	"/img/flightcms-blazing-fast.svg" 
		["description"]	=> string(127) 	"Seit dem Dezember 2023 gibt es einen neuen Stern am CMS-Himmel, FlightCMS." 
		["url"]			=> string(34) 	"cmsworkbench-startet-mit-FlightCMS" 
		["content"]		=> string(352) 	"<p>FlightCMS ist ein <em>leichtgewichtiges kostenloses</em> Content Management...</p>" 
	} 
	["content/cmsworkbench-on-flightcms.md"] => array(9) 
	{ 
		["title"]		=> string(15) 	"NEU - FlightCMS" 
		["author"]		=> string(9) 	"FlightCMS" 
		["date"]		=> string(10) 	"2023-12-21" 
		["robots"]		=> string(3) 	"all" 
		["tags"]		=> string(18) 	"Logbuch,Log,Status" 
		["logo"]		=> string(31) 	"/img/flightcms-blazing-fast.svg" 
		["description"]	=> string(127) 	"Seit dem Dezember 2023 gibt es einen neuen Stern am CMS-Himmel, FlightCMS." 
		["url"]			=> string(25) 	"cmsworkbench-on-flightcms" 
		["content"]		=> string(352) 	"<p>FlightCMS ist ein <em>leichtgewichtiges kostenloses</em> Content Management...</p>" 
	} 
	["..."]
	{
		...
		...
		...
	}
}
------------------------------------------------------------------------------------------------ */
}
?>