---
Title:       Plugin 'TableOfContents'
Author:      FlightCMS
Date:        2023-12-21
Robots:      all
Featured:	 false
Tags:        Logbuch,Log,Status
Logo:        /img/flightcms-plugin.svg
Description: Beschreibung des Plugin TableOfContents	
---
## Plugin TableOfContents ## {#Plugin-TOC}

Das Plugin `TableOfContents` fügt vor dem eigentlichen Content-Bereich ein automatisches Inhaltsverzeichnis ein, dabei werden Überschriften der Stufen `h1` bis `h6` berücksichtigt und als Link-Liste oberhalb des Beitragstextes angezeigt.

## Titel mit Link erzeugen ## {#Titel-mit-Link}

Damit du das Plugin optimal nutzen kannst, musst du Üerschriften in deinem Beitrag entsprechend der ParsedownExtra-Syntax erstellen, das funktioniert aber ganz einfach. Hinter der Überschrift musst du mit geschweiften Klammern eine ID einsetzen.

    ## Titel ## {#Name-des-Link}
_Titel mit Link-ID_

Die ID wird vom Plugin verwendet, um den Link zunächst im Text anspringen zu können und um daraus einen SEO-relevanten `Title`-Tag zu erzeugen, daher sollte die ID genauer durchdacht werden, damit diese von Suchemaschinen ausreichend Beachtung findet.

## Titel ohne Link ## {#Titel-ohne-Link}

Erstellst du Überschriften ohne das Link-Attribut, etwa so:

    ## Titel ohne Link ##
_normaler Titel ohne Link-ID_

dann ist das nicht weiter schlimm, denn das Inhaltsverzeichnis wird trotzdem erzeugt, bietet jedoch keinen anklickbaren Link an.

## Syntax des Link-Textes ## {#Syntax-Link-Text}

Da die Link-ID vom Markdown-Parser in korrektes HTML umgewandelt werden kann, musst du bei der Namensvergabe ein paar Bedingungen einhalten:

- keine Leerzeichen (verwende '-' oder '_' als Trenner)
- keine Umlaute wie ä, ü, ö, ß, ...
- keine Sonderzeichen !, ?, *, #, ...

Wenn du Bindestriche oder Unterstriche im Linktext verwendest, werden diese zum Zeitpunkt des Renderns im Browser durch Leerzeichen ersetzt und als `Title="dieser Text erscheint als Tooltip"` Attribut dem Link hinzugefügt, du kannst dies am Tooltip erkennen wenn du mit der Maus darüber schwebst. Gut durchdachte Link- und Title-Texte sind bei Suchmaschinen überaus beliebt!

## Funktionsweise des Plugin ## {#Funktionsweise}

Die Funktionsweise des Plugins `TableOfContents` ist recht einfach umrissen. Das Plugin erhält mit der Variablen `$content` den gesamten Beitragstext (ohne Titel und ohne Beschreibung).

    010  foreach(explode("\n",$content) as $value)
	011  {
    012      if (preg_match('(<h[1-6].id=)', $value) && preg_match('(</h[1-6])', $value))
    013      {
    014         echo '<a href="">'.strip_tags($value).'</a>';
    015      } else {
    016          if (preg_match('(<h[1-6])', $value) && preg_match('(</h[1-6])', $value))
	017  		{
    018              echo strip_tags($value);
    019          }
    020      }
    021  }
_Schematischer Code_

In **Zeile 10** wird der Beitragstext mit [explode()](https://www.php.net/manual/en/function.explode){.link-inline} in Zeilenumbrüche zerlegt und Zeile für Zeile mit [foreach()](https://www.php.net/manual/de/control-structures.foreach.php){.link-inline} untersucht.

Mit Hilfe einer RegularExpression [preg_match()](https://www.php.net/manual/de/function.preg-match){.link-inline} in **Zeile 12**, wird auf die Existenz einer Zeichenkette, etwa "`H1 id=`", "`H2 id=`", "`H3 id=`" bis "`H6 id=`" untersucht. Das Suchpattern muss mit "`<H`" beginnen, gefolgt von Zahlen von "`0`" bis "`9`", einem beliebigen Zeichen "`.`" und endet mit "`id=`". Wird solch ein Pattern gefunden, dann wird der Inhalt der Zeile mit [strip_tags()](https://www.php.net/manual/de/function.strip-tags){.link-inline} von HTML-Elementen gereinigt und mit einem Link-Tag angezeigt. Das gilt aber nur, wenn auch ein Überschriften-Ende-Tag in der selben Zeile existiert.

>SEO-Tipp: pro Seite darf es nur ein H1-Tag geben, dieses ist für den Titel der Webseite vorbehalten. Sollte dieses Tag mehrfach auf deiner Seite existieren, wird dies von der Suchmaschine mit schlechterem Ranking bestraft.

Treffen alle die oben genannten Bedingungen nicht zu, wird ab **Zeile 15** nach einer regulären Überschrift von `H2` bis `H6` gesucht, damit sie ohne Link als Inhaltsverzeichnis angezeigt werden kann.

## Fehlerquellen bei der Verwendung ## {#Fehlerquellen}

Wenn du in deinem MD-Text allerdings den Überschriften-Tag <strong>&lt;H2&gt;</strong> verwendest (zum Beispiel in einer HTML-Dokumentation), kann das zu einem Problem mit dem Plugin führen, daher solltest du die Darstellung solcher Überschriften-Tags im Fließtext mit den Code Brackets <strong>&grave;&lt;H2&gt;&grave;</strong> kennzeichnen. Natürlich kannst du dich auch der [HTML-Sonderzeichen](https://seo-summary.de/html-sonderzeichen/){.link-inline} beidenen um diesen Fall im Text zu maskieren. Alternativ kannst du diese **H2** Tags im Text einfach groß schreiben.

>Tipp: Das Plugin `TableOfContent` ist die ideale Ausgangsbasis, wenn du so genannte Customfields oder eigene Shortcodes im Text durch etwas anderes ersetzen möchtest.