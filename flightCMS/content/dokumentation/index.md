---
Title:       Dokumentation
Author:      FlightCMS
Date:        2022-07-11
Robots:      all
Tags:        Kurven,Farben,Crossprozessing,Farbrurve,Kurve
Logo:        /img/flightcms-dokumentation.svg
Description: Download und Installation von FlightCMS. Erster Beitrag und Kategorie. Tipps und Tricks für eigene Anpassungen
---
## Was ist Routing überhaupt? ##

Unter dem _Routing_ versteht man die funktionale Aufteilung einer URL bzw. eines Requests an eine Webseite, in verschiedene Funktionsbereiche. Ein typisches Routing wie das folgende:

    webseite.de/kategorie/beitrag
_Route eines Beitrags_

unterteilt den Request dementsprechend in eine _Kategorie_ und in einen _Beitrag_ auf. Dementsprechend ist _Parameter 1_ die Angabe der _Kategorie_ und _Parameter 2_ der betreffende _Beitrag_ den der Leser anfordert. Würde der Leser folglich:

    webseite.de/kategorie
_Route einer Kategorie_

im Browser als URL anfordern, wüsste das CMS, das es sich um eine Kategorie handelt und nicht um einen Beitrag.

### Standardrouting im FlightCMS ###

_FlightCMS_ nutzt ein solches Standard-Routing, wie es eingangs schon beschrieben ist und weist jeder dieser Routen eine Funktion zu. Nachdem das _Flight Microframework_ im Startscript _index.php_ geladen wurde, kann es die Routen erkennen und eine Verarbeitung durch einen dedizierten _Controller_ je Route starten.

    Flight::route('/', function () {
      	// Verarbeitung der Startseite ==>
    });

    Flight::route('/@category', function ($category) { 
        // Verarbeitung einer Kategorie ==>
    });

    Flight::route('/@category/@post', function ($category, $post) {
  	    // Verarbeitung eines Beitrags ==>
    });
_Standardrouten_

Mit diesem Routing ist das Content Management System in der Lage auf die folgenden drei Routen zu reagieren:

- webseite.de/
- webseite.de/kategorie/
- webseite.de/kategorie/beitrag

und kann in Abhängigkeit dieser drei Zustände eine spezielle Verarbeitung ausführen, wie zum Beispiel die Landingpage zeigen, eine Kategorie laden oder einen konkreten Beitrag im Browser des Lesers anzeigen.

>Im fertigen CMS müssen natürlich noch weitere Routen angelegt werden, die sich beispielsweise um das Fehlerhandling kümmern falls mehr als die dreistufige Route verarbeitet werden muss. Dazu aber später mehr.

## Der Controller ##

_FlightCMS_ nutzt das so genannte _MVC-Pattern_ (Model View Controller) für die pragmatische Unterteilung des Programmcodes in kleine logische Funktionseinheiten. Im konkreten Fall, treffen Sie beim Routing bereits auf die so genannten _Controller_ dieser Programm-Vorschrift.

_Controller_ sind als Steuereinheiten (reguläre PHP-Programme) zu verstehen, die Parameter entgegen nehmen können und die Verarbeitungen in einen programmatischen Ablauf bringen. Wie der Name schon sagt, kontrolliert und regelt er eine spezifische Verarbeitung, greift jedoch nicht direkt auf Daten zu (wird durch das _Model_ abgewickelt). Folglich würde die _index.php_ wie folgt um die so genannten _Controller_ erweitert werden:

    Flight::route('/', function () {
  	    $controller = new HomeController();
    });

    Flight::route('/@category', function ($category) { 
      	$controller = new CategoryController($category);
    });

    Flight::route('/@category/@post', function ($category, $post) {
  	    $controller = new PostController($category, $post);
    });
_Controller_

Dementsprechend haben Sie einen `HomeController.php`, der sich um die Verarbeitung kümmert, wenn der Leser die Startseite besucht. Der `CategorieController.php` startet die Verarbeitung, wenn der Leser eine Kategorie über den Browser vom CMS anfordert. Und letztendlich den `PostController.php`, der sich um die Verarbeitung eines konkreten Beitrags kümmert.

[siehe Wiki - MVC Pattern](https://de.wikipedia.org/wiki/Model_View_Controller){.link}

>Hiweis: das MVC-Pattern ist keine eigenständige Programmiersprache, sondern eine Richtlinie, wie Programmcode sinnvoll in übersichtliche Funktionseinheiten untergliedert wird. Da MVC eher als Vorschlag zu verstehen ist, steht es Ihnen natürlich vollkommen frei sich strikt daran zu halten oder von diese Vorschrift hier und da nach eigenem Geschmack abzuweichen.

### Parameter für den Controller ###

Das _Flight Microframework_ ist in der Lage, die Route in Parameter zu unterteilen und diese dem _Controller_ zu übergeben, damit er diese Information weiter verarbeiten kann. 

In `\` gibt es keinen Parameter, denn der Leser ist in der Startseite und der Pfad dahin ist dem CMS bekannt, denn er ist fix. Mit dem Parameter `@category` übergibt das Framework dem `CategoryController.php` den beliebigen Namen der gewünschten Kategorie.

Durch der Parameter `@post` erhält der `PostController.php` die Information, welcher konkrete Beitrag durch das CMS geladen werden soll.

## Das Model ##

Das so genannte _Model_ ist dafür gedacht, die Daten aus der Datenbank oder einem _Flatfile_ zu beschaffen und diese dann an den Aufrufer, dem _Controller_, zu übergeben. Im Falle des _FlightCMS_, greift das Model auf ein _Flatfile_ zu und liest die dortigen Daten aus und gibt sie zurück an den Aufrufer.

Die Datenstruktur des Flafiles unterliegt der YAML-Syntax und siet etwa so aus:

    ~~~
    Title:       Lorem ipsum
    Author:      FlightCMS
    Date:        01.01.2024
    Logo:        /img/logo.jpg
    Description: Lorem ipsum dolor sit amet, consetetur sadipscing elitr...
    ~~~
    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et 
    dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet 
    clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, 
    consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, 
    sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea 
    takimata sanctus est Lorem ipsum dolor sit amet.
    ...
_Struktur des Beitrags_

## Die View ist eine HTML-Schablone ##

Eine _View_ im _MVC-Pattern_, ist als HTML-Vorlage bzw. Vorschrift zu verstehen. Mit der _View_ definieren Sie einmalig eine Vorlage, wie beispielsweise ein Beitrag im Browser des Lesers auszusehen hat. Diese Definition wird im CMS einmalig erzeugt, und vielfach für ganz unterschiedliche Beiträge  verwendet

    <html>
    <head>
    ...
    </head>
    <body>
        <h1> {Title}       </h1>
        <p>  {Description} </p>
        <p>  {Content}     </p>
    </body>
    </html>
_HTML Template_

Die oben gezeigte rudimentäre _View_ stellt ein typisches HTML-Rahmengerüst einer Webseite dar. Statt diese Seite mit konkreten Daten zu füllen, werden dort Platzhalter eingesetzt, die das CMS später auf Anfrage durch den Leser mit echten Daten füllt.

>Natürlich werden Sie im Downloadpaket des FlightCMS deutlich mehr Views erkennen (dies ist der dynamischen Entwicklung des Projektes geschuldet), der Artikel soll lediglich einen schematischen Einstig in das Thema Views bilden.