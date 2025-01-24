---
Title:       CMS Konstanten
Author:      FlightCMS
Date:        2023-12-21
Robots:      all
Featured:	 false
Tags:        Konstanten
Logo:        /img/flightcms-templates.svg
Description: FlightCMS bringt einige Konstanten mit, die für das Templating hilfreich sind.
---
## `VIEWS_DIR` - Pfad zum Template ## {#Pfad-zum-Template}
	
Sofern du mehrere Templates in deinem CMS installierst, kannst du die Konstante `VIEWS_DIR` dazu verwenden, den Stylecheet dynamisch anzugeben, statt den Namen fest vorzugeben, beispielsweise so:

	<link href="/<?php echo VIEWS_DIR; ?>/css/style.css" rel="stylesheet">
_Dynamischer Pfad zum Template_
	
Würdest du das CSS stattdessen so implementieren:

	<link href="default-theme/css/style.css" rel="stylesheet">
_Fester Pfad zum Theme_
	
würden alle Templates nicht mehr korrekt funktionieren, wenn du den Namen des Templates plötzlich änderst.

## `THEME_NAME` - Name des Theme bzw. des Templates ## {#Name-des-Templates}
	
Wenn du den Namen deines Templates anzeigen möchtest, kannst du die Konstanten `THEME_NAME` nutzen, um ihn mit:

	<?php echo THEME_NAME; ?>
_Name des Theme anzeigen_

anzuzeigen.

## `VERSION` - aktuelle Version des FlightCMS ## {#Version}
	
Manchmal kann es durchaus hilfreich sein, die aktuelle Version der Programmsammlung in der Fußzeile anzuzeigen, etwa so:

	<?php echo VERSION; ?>
_Version ausgeben_

## `CONTACT_MAIL` - zentrale Mail-Adresse ## {#Mail-Adresse}
	
Im FlightCMS ist eine zentrale Mailadresse, bspw. für den Newsletter o.ä., hinterlegt, die du auch in Templates als Kontaktadresse anzeigen lassen kannst, etwa so:

	 <?php echo CONTACT_MAIL; ?>
_Zentrale Mail anzeigen_