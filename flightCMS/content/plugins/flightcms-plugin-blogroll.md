---
Title:       Plugin 'Blogroll'
Author:      FlightCMS
Date:        2024-01-27
Robots:      all
Featured:	 false
Tags:        Logbuch,Log,Status
Logo:        /img/flightcms-plugin.svg
Description: Das Plugin <em>Blogroll</em> zeigt, für besseres SEO, Links externer Webseiten, um Link-Juice zu teilen.
---
## Was macht Blogroll? ## {#was-ist-Blogroll}

Das Plugin _Blogroll_ zeigt Backlinks zu externen Webseiten, um den eigenen _Link-Juice_ bei Suchmaschinen zu verbessrn. Für die Pflege und Eingabe der Daten, nutzt _Blogroll_ eine YAML-Datei, in der Links mit einigen Attributen registriert werden können.

>Die Arbeitsweise des Plugins _Blogroll_ findest du auch auf der Startseite ganz unten im Footer der Webseite.

## YAML-Datenbank ## {#YAML-Datenbank}

Alle Einträge für die Blogroll kannst du in ein übersichtliches YAML-File strukturiert eintragen, etwa so:

![Demo Beitrag](/img/blogroll-plugin.png)
_Demo-Beitrag im YAML/MD Format_

Beginne zunächst mit einem Schlüsselwort, um den Eintrag für dich in der Datenbank zuordnen zu können und dann füllst du die weiteren Attribute

- Confirmed
- Title
- Logo
- Url
- Description

mit den gewünschten Werten hinzu.

>Beachte bitte die Einrücktiefe und führe dieses Schema für alle weiteren Einträge exakt so weiter fort, denn an den führenden Leerzeichen erkennt der YAML-Parser welche Attribute zu Listen gehören und welche nicht.

## Confirmed ## {#Status-Confirmed}

Währen die meisten Attribute selbsterklärend sind, möchte ich dir kurz `Confirmed` etwas näher erläutern.

![Blogroll Confirmed](/img/blogroll-plugin-pending.png)
_Wirkung des Status Confirmed_

Es ist oft so, das deine Webseite bei externen Anbietern um einen Backlink anfragt, du aber noch keine Rückantwort oder Bestätigung hast, solange stellst du den Beitrag auf mit `Confirmed` auf den Status `pending` (wartend).

>Das Plugin _Blogroll_ gehört mit zum FlightCMS und kann von dir sofort genutzt werden. Je nach Template, kannst du alle Attribute oder nur Teile aus der Liste anzeigen lassen. Schau dir mal die Blogroll auf FlightCMS an.