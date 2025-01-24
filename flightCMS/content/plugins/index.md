---
Title:       Plugins
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Featured:    false
Tags:        Kurven,Farben,Crossprozessing,Farbrurve,Kurve
Logo:        /img/flightcms-plugin.svg
Description: Schreiben Sie eigene Plugins und erweitern damit die Basisfunktionen des CMS um neue individuelle Eigenschaften.
---
## Der Start von Plugins über Hooks ##

Die Pluginschnittstelle von FlightCMS ist so ausgelegt, das Plugins sich an einen so genannten _Hook_ heften und auf dessen Aufruf warten. Ruft das CMS einen bestimmten _Hook_ aus, starten alle Plugins, die für diesen _Hook_ registriert sind der Reihe nach. Das FlightCMS besitzt eine ganze Reihe von _Hooks_ die über die gesamte Laufzeit verteilt sind und bestimmte Verarbeitungszustände des Content darstellen, in denen Plugins sinnvoll eingreifen können. Daneben gibt es noch weitere Möglichkeiten Plugins im CMS zu starten.

## Ein Plugin aus dem Template starten ##

Am sinnvollsten ist der Start von Plugins aus dem spezifischen Template heraus, denn damit wird auch definiert, an welcher Stelle Plugins ihre Ausgaben und Verarbeitungen ausgeben sollen. Grundsätzlich warten Plugins auf den Aufruf eines _Hooks_ zu dem sie sich registriert haben, um mit der Verarbeitung zu beginnen, etwa so:

    <h1>Überschrift</h1>
    <p>Textbeispiel mit anschließendem Plugin-Aufruf...</p>
    ...
    Flight::hook('afterParseContent', '');
    ...
_Plugin im Template über Hook starten_

Das obige Beispiel startet alle Plugins, die auf den Hook _afterParseContent_ warten, zusätzlich kann ihnen noch ein Parameter übergeben werden, falls sie damit etwas verarbeiten müssen.

>In einigen Fällen kann die Namensvergabe von Plugins zu ungewollten Störungen des CMS führen. Ursache dafür ist oft, dass es bereits gleichlautende Klassen innerhalb des FlightCMS gibt, wie Beispielsweise `Log` oder `Debug`.

## Alternativer Start von Plugins ##

Als alternative Lösung, lässt sich ein einzelnes Plugin in einem Template auch über die statische Plugin-Liste starten, etwa so:

    <?php Flight::get('plugins')['afterParseContent'][0]->run(''); ?>
_Alternative_

Das erste (0 statt 1) Plugin der Gruppe _afterParseContent_ wird ausgeführt. Zugegeben, der Aufruf ist recht kompliziert und kann zu Fehlern führen wenn Plugins beispielsweise ihre Reihenfolge in der Liste verändern. Die nächste Möglichkeit ist etwas sinnvoller nutzbar und wirkt sprechender:

    <?php $author = new AddAuthor(); echo $author->run(''); ?>
_Alternative_

Das Plugin _AddAuthor_ wird im Template an einer ganz dedizierten Stelle starten. 

>Diese Variante ist besonders dann sinnvoll, wenn das Plugin eine Verarbeitung im Arbeitsspeicher des Browsers erzeugt, die an verschiedenen Stellen des Templates benötigt oder angezeigt werden soll, da es als Objekt im Speicher persistiert wird.

Darüber hinaus ist es auch möglich, das Plugin _statisch_ aus einem Template zu starten, etwa so:

    <?php echo AddAuthor::addAuthor(''); ?>

Dafür ist es aber nötig, eine statische Methode, z.B. `static function addAuthor()`, im Plugin anzulegen. Die bisherigen Pflichtmethoden `run()` und `hook()` können leere Inhalte haben und müssen weiterhin existieren, beispielsweise so:

    function hook() {}
  	function run($var) {}
_Methoden leer bei statischem Aufruf_

>Rein statische Plugins sind beim Templatedesign sehr hilfreich und reichern das Design der Webseite mit neuen Funktionen an, allerdings benötigen sie eine laufende Instanz eines Templates (View) durch das _FlightCMS_ - statisch gerufene Plugins sparen daher Platz im Arbeitsspeicher des Browsers. Ganz anders verhalten sich Plugins die für einen _Hook_ registriert werden, denn diese können auch außerhalb eines Templates arbeiten, beispielsweise hat das _Logging_ Plugin kein dediziertes Template und ist an den _System-Hook_ _'afterStart'_ gehängt, um arbeiten zu können.

>Hinweis: außerhalb des _FlightCMS_ können keine Plugins gestartet werden, sie funktionieren außschließlich in der laufenden Instanz des _FlightCMS_.

## Einen individuellen Hook erzeugen ##

Die so genannten _Hooks_ sollten als Gruppen-Namen verstanden werden, unter dem sich Plugins organisieren und auf ihren Start warten. Ruft das FlightCMS einen _Hook_ auf, beginnen alle Plugins die sich für diesen Hook registriert haben, mit ihrer Arbeit - eines nach dem anderen.

>Die Aufrufreihenfolge eventuell konkurierender Plugins kann (noch) nicht individuell festgelegt werden. Plugins werden alphabetisch sortiert aufsteigend gestartet und nacheinander Abgearbeitet. Die Reihenfolge kann vorerst über eine geschickte Namensvergabe realisiert werden (sofern erforderlich).

FlightCMS besitzt zwar einige feste _System-Hooks_ die vom Framework gebildet werden aber der Anwender kann weitere _Hooks_ vollkommen frei definieren. Folglich ist ein _Hook_ mit dem Namen:

    Flight::hook('jetztGehtsLos','');
_individueller Hook_

absolut korrekt und möglich, jedoch muss es auch entsprechende Plugins geben, die auf den Aufruf des _Hook_ _jetztGehtsLos_ lauschen.

## Plugins für einen Hook registrieren ##

Damit ein Plugin auf einen _Hook_ hören kann, muss es sich für diesen anmelden bzw. registrieren. Im Plugin reicht es aus in der Methode `hook()`:

    function hook()
    {
      	return 'jetztGehtsLos';
    }
_Hook registrieren_

den gewünschten Hook-Namen `jetztGehtsLos` als return-Wert einzutragen, damit dieses Plugin zukünftig auf diesen _Hook_ reagiert. Nach dem Aufruf durch das CMS, wird die Plugin-Methode `run($var)` automatisch gestartet, in der die zentrale Verarbeitung durchgeführt wird.

>Die beiden Methode `run()` und `hook()` sind zwingend zu implementieren, da sie vom FlightCMS automatisch aufgerufen werden müssen.

## System-Hooks ##

FlightCMS bietet einige systemseitige _Hooks_ zu denen sich Plugins anmelden bzw. registrieren können:

- `beforeStart` (Ausführung bevor das FlightCMS startet)
- `afterStart` (nachdem der Request verarbeitet wurde und der Browser eine Seite anzeigt)

## Custom-Hooks ##

Im Default-Template sind eine Reihe individueller _Hooks_ definiert:

- `afterParseContent` (nachdem der Content durch Markdown in HTML umgewandelt wurde)
- `beforeParseContent` (bevor der Content-Bereich durch Markdown in HTML umgewandelt wird)