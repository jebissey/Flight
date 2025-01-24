<?php
//--------------------------------------------------------------------------------------------------
// Das "CategoriesModel" behandelt den Umgang mit den Kategorien (Ordnern) und liefert ein Array
// mit den enthaltenen Indexen der jeweiligen Kategorien an den Controller zurück. Da es aktuell
// lediglich eine einstufige Strukturebene gibt, ist das zu lesende Basis-Verzeichnis fix auf die
// Ebene "content/" beschränkt.
//--------------------------------------------------------------------------------------------------

class CategoriesModel
{
  	private $categories;

  	function __construct($dir) 
    {
      	foreach (glob(CONTENT_DIR.'*', GLOB_ONLYDIR) as $dir_name) 
        {
          	if(!preg_match('{_}', $dir_name))
          	{
          		$index_content = file_get_contents($dir_name.'/index'.CONTENT_EXT);

				foreach (Dipper::parse(explode('---',$index_content)[1]) as $key=>$value)			// NEW: statt: ...$dpr->parse($index_content)...
        		{
              		$folders[strtolower($key)]   = $value; 											// Array mit allen 'index.md' Files der Verzeichnisse
              		$this->categories[$dir_name] = $folders; 										// Array mit Directory-Namen
        		}
				$folders['url'] = str_replace(CONTENT_DIR,'',$dir_name);			            	// 'content/kategorie' zu '/kategorie' machen
				$this->categories[$dir_name] = $folders;											// URL-Attribut dem Categories-Array anhängen
            }
		}
    }

	//---------------------------------------------------------------------------------------------
	// Zugriff über die 'magische Methode' ist günstiger als über einen dedizierten 'getter'
	//---------------------------------------------------------------------------------------------
	function __get($value)
	{
		return $this->$value;
	}
}
?>