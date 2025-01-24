---
Title:       Beiträge Sortierreihenfolge
Author:      FlightCMS
Date:        2024-01-28
Robots:      all
Featured:	 false
Tags:        Beitrag,Sortieren,Datum,Titel,ASC,DESC
Logo:        /img/flightcms-dokumentation.svg
Description: Beiträge kannst du in FlightCMS ganz einfach nach Datum oder Titel, auf- oder absteigend sortieren.
---
## Neue Beiträge oben ## {#beitraege-sortieren}
	
Möchtest du deine Webseite als Blog betreiben, dann ist es üblich den neusten Beitrag immer oben für den Leser anzuzeigen. Ältere Beiträge rutschen dadurch automatisch nach unten bzw. nach hinten. Du kannst dazu die folgende Einstellung in der Config-Section der `index.php` anpassen:

    'SORTING', 'DESC'
    'SORT_BY', 'DATE'
_Beitrag Datum aufsteigen_

Mit `DESC` sortiert FlightCMS die Anzeige aller Beiträge vom neuen Datum absteigend zum alten Datum.

## Alte Beiträge oben ## {#alte-beitraege-oben}

Wenn du allerdings immer den ältesten Beitrag als erstes für den Leser anzeigen möchtest, dann musst du die Reihenfolge der Anzeige und Sortierung ändern, etwa so:

    'SORTING', 'ASC'
    'SORT_BY', 'DATE'
_Beitrag Datum absteigend_

Durch den Wert `ASC` werden Beiträge dem Datum aufsteigend sortiert und auch so in den Kategorien angezeigt.

>Tipp: Die Sortierung der Beiträge erfolgt in FlightCMS anhand des Meta-Attributs `Date`, zwar liegt nahe dort ein Datum zu verwenden aber es ist natürlich auch möglich jeden anderen Wert zu verwenden, einfache Nummerierungen von `0...9` oder `A...Z` sind ebenfalls möglich.

## Keine Sortierung ## {#keine-sortierung}

Natürlich kannst du die Sortierung nach Beitragsdatum auch deaktivieren, dann werden Beiträge auf Basis des Kriteriums des Dateisystems verwendet und in alphanumerischer Reihenfolge angezeigt (ist vom Betriebssystem des Servers abhängig).

    'SORTING', ''
_Beitrag default Sortierung_

## Sortierung nach Titel ## {#sortieren-nacht-titel}

Neben der Datumssortierung im typischen Blogstyle, kannst du die Beiträge natürlich auch nach dem Titel des Beitrags sortieren, bitte verwechsle dies nicht mit dem physikalischen Dateinamen des Beitrags auf der Festplatte.

    'SORTING', 'ASC'        // ASC or DESC
    'SORT_BY', 'TITLE'      // DATE or TITLE
_Beitrag nach Titel absteigend_

>Im übrigen ist es vollkommen egal ob du `DATE`, `date`, `TITLE`, `title`, `ASC`, `asc`, `DESC` oder `desc` als Wert vergiebst, denn alle Werte werden intern in Großschrift umgewandelt.