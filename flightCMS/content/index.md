---
Title:       FlightCMS a blazing fast CMS, based on Flight-Microframework
Author:      FlightCMS
Date:        2023-11-01
Robots:      all
Tags:        CMS,YAML,Markdown,PHP,Flight,Dipper
Logo:        /img/flightcms-logo.svg
Description: FlightCMS basiert auf dem Flight Microframework, einem YAML-Parser, dem Markdownparser ParsedownExtra und Parsedown. FlightCMS nutzt MVC-Patterns.
---
## Das ist FlightCMS ##

_FlightCMS_ ist ein **vollwertiges Blog- und Webseiten-System** und wird _headless_ betrieben. Für das Content Management System benötigst du keine Datenbank, da es den Inhalt als so genanntes _Flatfiles_ im beliebten _YAML-Markdown_-Format speichert. Du kannst individuelle Templates und eigene Plugins entwickeln. _FlightCMS_ kannst du **uneingeschränkt zum Bau deiner Webseite und deines Blog verwenden**.

Die grundlegende Motivation zu _FlightCMS_ ist jedoch eine andere. Du solltest das Content Management System als **Ausgangsbasis** und **Conding-Grundlage** für die Entwicklung eines eigenen CMS mit **Plugins**, **Newsletter**, **Kontaktformular** und **Templates** verstehen. Der Quell-Code ist daher **einfach** gehalten und soll dir eine **schnelle Weiterentwicklung** für individuelle CMS-Projekte, auf der Basis von PHP, ermöglichen - aber nur wenn du magst.

Funktionen des _FlightCMS_:

- Beiträge **100% PICO- oder YELLOW CMS** kompatibel
- **sperrt verdächtige** Zugriffe automatisch 24h
- **Affiliate-Plugin** für Amazon.Partnernet o.ä.
- wird **ohne Admin-Backend** betrieben
- Content im **YAML**, **Markdown** Format
- hat den **kleinsten Angriffsvektor**
- benötigt **keine Datenbank**
- besitzt einen **Newsletter**
- FlightCMS ist **kostenlos**
- ist einfach **erweiterbar**
- ist rasend **schnell**
- **Templating** fähig
- **Plugin** fähig

Das headless-CMS implementiert die Komponenten **Dipper** (YAML-Parser), **Flight** (PHP-Microframework), den beliebten Markdown-Parser **ParsedownExtra** bzw. **Parsedown** und **Bootstrap** (CSS Framework), damit deine Webseite responsiv auf allen Endgeräten sinnvoll angezeigt werden kann.

[Flight](https://flightphp.com/ "FlightPHP"){.link}
[Dipper](http://github.com/secondparty/dipper "Dipper fast YAML Parser"){.link} 
[YAML](https://yaml.org "YAML.org"){.link} 
[Parsedown](https://github.com/erusev/parsedown "Parsedown"){.link}
[Extended](https://github.com/erusev/parsedown-extra "Extended"){.link}
[Bootstrap](https://getbootstrap.com "Bootstrap CSS"){.link}

## Flight PHP-Microframework ##

_FlightCMS_ nutzt das elegante PHP-Microframework _Flight_ und steuert damit einen Großteil der Arbeitsweise deines Content Management Systems. Dadurch wurde deine Entwicklungszeit stark reduziert und du musst nur noch bei Bedarf eigenen Code schreiben.

## FlightCMS ist headless ##

![small](/img/flightcms-logo.svg)

_FlightCMS_ ist ein so genanntes _headless_ Content Management System und wird ohne _Admin-Backend_ bzw. _Dashboard_ betrieben. Dadurch eliminierst du das bedeutendste Einfallstor für Hacker und Angreifer, das sensible Backend der Webseite und verringerst den Angriffsvektor auf nahezu '0'.

>Die so genannten _headless-CMS_ werden grundsätzlich als sicherer betrachtet als Content Management Systeme mit Admin-Backend oder Dashboard, da ihnen das typische Einfallstor für Hacker fehlt. Dadurch sind sie in den letzten Jahren extrem populär und beliebt geworden, da sie einem höheren Sicherheitsbedarf der heutigen Webseitenbetreiber gerechter werden können. Vielen Usern ist die höhere Sicherheit wichtiger, als luxuriöser Funktionsumfang.

## Dipper fast YAML Parser ##

FlightCMS nutzt _YML_ bzw. _YAML_ (eine abgewandelte, lesbare Art des _XML_) als strukturierte Auszeichnungssprache für den Inhalt eines Beitrags, dadurch kannst du Beitragstexte individuell attributieren und klassifizieren. Mit _YAML_ bekommst du einen überaus wichtigen Einblick in die sehr beliebte Struktursprache, die an vielen Stellen des Internets anzutreffen ist und lernst, warum _YAML_ leichter als _JSON_ oder _XML_ zu verwenden ist.

[YAML Parser online](https://codebeautify.org/yaml-parser-online){.link}

## Markdown statt HTML ##

Um deinen redaktionellen Prozess zu beschleunigen, verwendet FlightCMS _Parsedown_ und _ParsedownExtra_, dadurch wird die Erstellung deines Content noch schneller, da du dich nicht mehr mit nervigen HTML-Formatierungen herumschlagen musst.

[Dillinger](https://dillinger.io/ "Online Markdown Parser"){.link}
	
>Markdown-Beiträge lassen sich übrigens deutlich leichter recyceln als WordPress-Beiträge, da sie nicht um HTML-Tags angereichert werden. Markdown-Beiträge lassen sich folglich leichter in andere Platformen migrieren.

## Beiträge 100% kompatibel zu PICO CMS oder YELLOW CMS ##
	
Beiträge aus den beiden sehr beliebten Content Management Systemen [PICO](https://picocms.org/){.link-inline} oder [YELLOW](https://datenstrom.se/yellow/){.link-inline}, können uneingeschränkt und ohne Anpassung auch in FlightCMS verwendet werden. Du kannst also problemlos deine gesamten Artikel in das FlightCMS überführen und musst nichts anpassen.

## Offenes Microframework ##

_FlightCMS_ nutzt ein offenes PHP-Framework und ermöglicht die weitere Implementierung externer Komponenten, wie beispielsweise den sehr beliebten Templateparser [Smarty](https://www.smarty.net/){.link-inline} oder die Anbindung einer performanten Datenbankschnittstelle in das CMS.

## FlightCMS sperrt verdächtige IP Adressen automatisch ##

Das Content Management System _FlightCMS_ analysiert verdächtige Zugriffe und sperrt die betreffende IP für die Dauer von 24 Stunden. Der Sperrzeitraum kann individuell vorgegeben werden.

>Verdächtige Zugriffe werden anhand einer _Ratio_ (Empfindlichkeit) durch das CMS bewertet und ggf. für einen bestimmten Zeitraum gesperrt.

## FlightCMS bringt ein Affiliate-Marketing (Plugin) mit ##

Du möchtest mit deiner Webseite Geld verdienen? Kein Problem! _FlightCMS_ bringt bereits ein funktionsfähiges Affiliate-Plugin mit, mit dem du beispielsweise _Amazon-Affiliates_ in Beiträgen einblenden kannst. Das Plugin speichert Artikel in einem leicht zu pflegenden _YAML_-File.

## Newsletter ##
	
Zwar ist der so genannte _Newsletter_ in den vergangenen Jahren, zu Gunsten anderer Kommunikationswege, in Vergessenheit geraten aber dennoch ist diese Funktion in _FlightCMS_ implementiert. Leser können deinen Newsletter abonieren oder diesen kündigen.

## Kontakt-Formular ##
	
Kontaktformulare sind nach wie vor sehr beliebt und laden zur schnellen Kommunikation mit dir und deinem Leser ein. Auch wenn es in der heutigen Zeit modernere und direktere Kanäle der Kommunikation gibt, so scheint das traditionelle Kontaktformular immer noch _state of the Art_ zu sein (da es vermutlich als recht sicher gilt und ausreichend Privatsphäre schafft).

>Dieses Content Management System erhebt nicht den Anspruch perfekt zu sein, es soll vorrangig als Ideengeber für eigene Entwicklungen dienen und den Einstieg in die PHP-Programmierung zu einem eigenen CMS beschleunigen. Besonderes Augenmerk liegt dabei auf der Verwendung bekannter Microframeworks wie beispielsweise _Limonade_, _FatFree_, _Slim_ oder _Lumen_, die eine bedeutende Lücke in der Entwicklung eigener Content Management Systeme schließen und zwar die aufwändige Verarbeitung der Routen (URI-Requests an den Server) mittels PHP. Zudem sind Microframeworks klein genug, um dennoch keine Sicherheitslücken wegen erhöhter Komplexität oder ungewollter Emergenzen für das eigene CMS befürchten zu müssen.