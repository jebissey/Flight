---
Title:       Plugin 'Sidebar'
Author:      FlightCMS
Date:        2021-12-21
Robots:      all
Featured:	 false
Tags:        Logbuch,Log,Status
Logo:        /img/flightcms-plugin.svg
Description: Das Plugin <em>Sidebat</em> zeigt ein Menü mit allen Kategorien und deren Beiträge an.
---
## Anzeige des Seitenmenüs ## {#Seitenmenue}

Mit Sidebar kannst du ein Seitenmenü aller Kategorien und deren Beiträge einblenden. Das Layout legst du im Plugin Sidebar selbst fest und stimmst es auf den restlichen Look deiner Webseite ab.

	<?php echo Sidebar::menue(CONTENT_DIR); ?>
_Statischer Aufruf des Menü_

Mit dem obigen Codeschnipsel kannst du das Menü-Plugin in dein eigenes Template einhängen. Wenn du magst, kannst du ihm ein bestimmtes Verzeichnis vorgeben oder mit:

	CONTENT_DIR
_Standard Verzeichnis_

den Standardpfad des FlightCMS für den Content mitgeben.

>Plugins können ausschließlich innerhalb des FlightCMS verwendet werden, ein externer Aufruf ist nicht möglich und wird mit einem Fehler quittiert. Das gilt für alle Standard-Plugins des FlightCMS.