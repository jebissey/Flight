---
Title:       htaccess
Author:      FlightCMS
Date:        2024-01-25
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Das zentrale <em>Routing</em> wird mit dem PHP-Programm <em>index.php</em> abgewickelt, das im Wurzelverzeichnis liegt.
---
## Anfragen auf `index.php` umleiten ## {#auf-index-umleiten}

Damit alle Anfragen an das CMS vom zentralen Startscript `index.php` verarbeitet werden können, muss in der Datei `.htaccess` eine Umleitung eingetragen werden, etwa so:

	RewriteEngine On
	RewriteBase /

	# - Process by index.php -
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule (.*) /index.php/$1 [L]
_Umleitung auf index.php_

Mit diesem Codeblock werden Anfragen gegen Verzeichnisse (`!-d`) und Dateien (`!-f`) gegen die Datei `index.php` umgeleitet. Nützlicher Nebeneffekt ist, das die URL deutlich sprechender und suchmaschinenfreundlicher ausfallen.

## Alte URI Schablone ## {#alte-url-schablone}

Die bisherige URL-Schablone:

	www.webseite.de/index.php?kategorie=Musik&beitrag=DavidBowie
_Traditioneller Request_

ist zwar technisch vollkommen korrekt, sollte aber durch:

	www.webseite.de/musik/davidbowie
_Suchmaschinen freundlicher Request_

ersetzt werden. Diese Schreibweise wird von Suchmaschinen deutlich bevorzugt und ist auch für die menschliche Lesart angenehmer und sinnvoller.

>Die Umleitung aller URI-Requests auf die `index.php` in der `htaccess`, ist in fast allen populären CMS Standard - hier gibt es nur sehr selten Abweichungen von dieser Regel.