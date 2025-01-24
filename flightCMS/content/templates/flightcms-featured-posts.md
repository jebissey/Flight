---
Title:       Featured Posts
Author:      FlightCMS
Date:        2023-12-21
Robots:      all
Featured:	 false
Tags:        Konstanten
Logo:        /img/flightcms-templates.svg
Description: In FlightCMS kannst du bestimmte Beiträge für den Leser besonders hervorheben.
---
## Beiträge hervorheben ## {#Post-herforheben}
	
Schreibe zunächst einen ganz normalen Beitrag oder verwende einen bestehenden Beitrag als Vorlage. Trage im Metabereich (oben) das Attribut `Featured` mit dem Wert `true` ein.

	~~~
	Title:		...
	Featured: 	true
	Date:		...
	Logo:		...
	~~~
	...
_Beitrag empfehlen_

## Auf der Startseite einblenden ## {#auf-Startseite}

Mit dem folgenden Template-Token, bindest du die Anzeige hervorgehobener Beiträge auf der Startseite ein.

	<?php echo Featured::menu(CONTENT_DIR); ?>
_Featured Plugin einbinden_

Bei diesem Token handelt es sich in Wirklichkeit, um den statischen Aufruf des Plugins `Featured.php` aus dem Plugin-Verzeichnis. Das Plugin benötigt dann noch die Angabe des Verzeichnis in dem es solche Beiträge suchen soll.

>Das Plugin `Featured.php` gehört zur Sntandardauslieferung und ist daher immer verfügbar. Dem Plugin wird das Verzeichnis mitgegeben, das rekursiv durchsucht werden soll.


