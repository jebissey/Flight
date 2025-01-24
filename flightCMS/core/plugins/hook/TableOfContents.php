<?php
//-------------------------------------------------------------------------------------------------
// Sucht nach Überschriften und erzeugt ein Inhaltsverzeichnis. Im MD-Beitrag muss dazu zwingend
// eine ID angegeben werden die gefunden und verlinkt werden kann, etwa so:
//
//     ## Geld mit dem Affiliate-Plugin verdienen ## {#mit-affiliate-geld-verdienen}
//
// Folglich wird '#kapitel1' als Link im Inhaltsverzeichnis hinzugefügt. Dies setzt ParsedownExtra
// voraus, da mit Parsedown die Vergabe von ID's nicht unterstützt wird. Führt allerdings auch
// dazu, das die ID ausschließlich für TOC genutzt werden kann.
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class TableOfContents
{   
  	function hook(){}
  
  	function run($content){}

	public static function toc($content)
	{
		echo '<div class="col-sm-7 bg-light p-4 my-5">';
		echo '<p class="fw-bold">Inhalt</p>';
		echo '<hr>';
		echo '<nav>';
		echo '<ul class="toc">';

		foreach(explode("\n",$content) as $value)
		{
			//if (preg_match('(h2.id=)', $value, $matches)) 								// <- ganz gut: sucht nach 'h2 id=' für '<h2 id="abcd">...'
			//if (preg_match('(h..id=)', $value)) 											// <- gut: sucht nach 'h* id=' für '<h2 id="abcd">...'
			//if (preg_match('(<h[1-6].id=)', $value)) 										// <- besser: sucht nach 'h* id=' für '<h2 id="abcd">...'
			if (preg_match('(<h[1-6].id=)', $value) && preg_match('(</h[1-6]>)', $value))	// <- boch besser: sucht nach 'h* id=' für '<h2 id="abcd">...'
			{
				$link    = explode('"',explode('id="', $value)[1])[0];						// trennt <h2 id="xyz"> je am " auf, um xyz zu erhalten
				$title   = str_replace(array('-','_'),' ',$link);                 			// Leerzeichen statt '_' oder '-' für gutes SEO
				$kapitel = strip_tags($value);
				echo '<li class="fs-6">';
				echo '<a href="#'.$link.'" title="'.$title.'">'.$kapitel.'</a>';
				echo '</li>';
			} else {
				if (preg_match('(<h[1-6])', $value) && preg_match('(</h[1-6]>)', $value))	// wurde keine ID vergeben, dann normalen Index erstellen
				{
					echo '<li class="fs-6">';
					echo strip_tags($value);
					echo '</li>';
				}
			}
		}

		echo '</ul>';
		echo '</nav>';
		echo '</div>';
	}
}
?>