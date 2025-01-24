---
Title:       Logfiles im CSV-Format
Author:      FlightCMS
Date:        2024-01-28
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Damit du den Zustand deines CMS gut mit Excel überwachen kannst, werden Log- und Debug-Files als csv gespeichert.
---
## Bequem mit Excel auswerten ## {#log-als-csv}

FlightCMS erzeugt ein Log- und Error-File für die Auswertung der korrekten Zugriffe oder Angriffe gegen das Content Management System. Das Dateiformat ist auf CSV festgelegt, damit du die Daten sofort und einfach in Excel importieren und bequem weiterverarbeiten kannst.

![CSV Import](/img/csv-import.png)
_Import CSV Logfiles in OpenOffice_

Der Trenner für die einzelnen Datensegmente, ist standarmäßig auf '`;`' (Semikolon) eingestellt, dies kannst du aber ganz nach deinen persönlichen Vorlieben verändern.

>Damit der Aufruf von Excel oder OpenOffice aus dem Browser automatisch passiert, muss der MIME-Type korrekt eingestellt sein (in der Regel ist dies aber bereits korrekt eingetragen und du muss nichts weiter tun).