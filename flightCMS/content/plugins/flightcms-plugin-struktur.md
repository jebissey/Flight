---
Title:       Plugin Aufbau
Author:      FlightCMS
Date:        2021-12-21
Robots:      all
Featured:	 false
Tags:        Logbuch,Log,Status
Logo:        /img/flightcms-plugin.svg
Description: Grundlegender Aufbau eines FlightCMS Plugins
---
## Struktur eines Plugin für FlightCMS ## {#Struktur-von-Plugins}

Der Aufbau aller Plugins in _FlightCMS_ unterliegt dem folgenden Aufbau:

	class HalloWeltPlugin {
    
		function hook() {
      		return 'afterParseContent';
    	}

  		function run($var) {      
        	... Verarbeitung von $var
            ...
            ...
      		return $var;
    	}
	}
_Demo Code_

Das Plugin `HalloWeltPlugin` wird traditionell als PHP-Klasse angelegt. Die Methode `hook()` legt den _HOOK_ des Plugins fest und die Methode `run()` wird standardmäßig vom CMS gestartet, wenn der _HOOK_ ausgerufen wird. In diese Methode findet die Verarbeitung des Plugin statt. Mit `$var` kann ihr Inhalt für die Verarbeitung übergeben werden.

## Der Hook ## {#Plugin-Hook}

Den Hook kannst du prinzipiell selbst frei vergeben, allerdings solltest du es nicht übertreiben, denn du könntest sonst schnell den Überblick verlieren und Plugins könnten sich gegenseitig nachteilig beeinflussen. Aktuell bringt FlightCMS bereits einige System-Hooks mit:

- beforeStart
- afterStart
- afterParseContent
- beforeParseContent

die du zunächst unbedenklich nutzen kannst.