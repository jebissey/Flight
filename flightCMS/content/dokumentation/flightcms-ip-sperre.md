---
Title:       Sperrung suspekter IP
Author:      FlightCMS
Date:        2024-01-23
Robots:      all
Featured:	 true
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: FlightCMS <em>sperrt IP-Adressen</em> fragwürdiger oder falcher Zugriffe automatisch für 24 Stunden.
---
## IP-Sperre gegen Angriffsversuche ## {#ip-sperre}

Die meisten Angriffsversuche gegen ein Content Management System werden automatisiert von einem entfernten Rechner ausgeführt, dabei werden in kurzer Folge viele verschiedene Angriffsziele ausgetestet, wie zum Beispiel Login-Scripts, Plugins, Themes usw. Es erfolgen also viele Zugriffe in kurzer Folge von der selben IP-Adresse. Dieses Schema kann _FlightCMS_ erkennen und blockiert diese IP-Adresse zunächst für 24 Stunden. Damit wird der aktuell stattfindende Angriff sofort unterbrochen.

Im Gegensatz dazu verhalten sich Suchmaschinen anders. Suchmaschinen haben nur wenig Zeit, da diese nach Möglichkeit alle Webseiten des Internets so schnell wie möglich indexieren müssen, daher verlassen Suchmaschinen die Webseite recht schnell wenn sie auf einen _ERROR-404_ treffen und wenden sich der nächsten Domain zu. Folglich produzieren auch die nächtlichen Bots und Spider der großen Suchmaschinen Fehlzugriffe die als Angriff gewertet werden könnten, jedoch beläuft sich deren Anzahl auf nur ganz wenige Zugriffe pro Tag.

## Sammlung suspekter IP ## {#suspekte-ip-sammeln}

_FlightCMS_ sammelt zunächst suspekte und auffällige IP-Adressen, wenn diese versuchen fragwürdige Requests gegen das CMS abzusetzen. Ab einer bestimmten Empfindlichkeit (_Ratio_), stuft _FlightCMS_ die betreffende IP-Adresse als Angriff ein und sortiert den Besucher aus (zunächst für 24h). Zusätzlich erstellt _FlightCMS_ ein Protokoll, für die Überprüfung durch den Admin, mit den IP-Adressen die tatsächlich gesperrt wurden. Sofern sich darunter wertvolle Suchmaschinenanfragen befinden sollten, kann die _Ratio_ entsprechend verändert (erhöht) werden.

>Durch die Sperrung von IP Adressen, wird der automatisierte Angriff effektiv gestoppt. Bei einem manuellen und dedizierten Angriff durch einen menschlichen Hacker, muss dieser dann seine IP Adresse regelmäßig ändern um Erfolg zu haben, dies macht die Attacke allerdings sehr zeitintensiv und teuer. Letztendlich stellt sich dann auch die Frage, ob die Reputation der Webseite den hohen Aufwand rechtfertigt. Letztenendes wird der Angriff einfach zu teuer, für die Aussicht auf nur geringe Beute.

>Die Empfindlichkeit der Erkennung, kann so eingestellt werden, das Suchmaschinen mit falschen Zugriffen nicht davon betroffen werden und das SEO nicht darunter leidet.