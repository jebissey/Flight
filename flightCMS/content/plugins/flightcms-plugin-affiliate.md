---
Title:       Plugin 'Affiliate'
Author:      FlightCMS
Date:        2024-01-25
Robots:      all
Featured:	 true
Tags:        Affiliate,Plugin
Logo:        /img/flightcms-affiliate.svg
Description: Mit dem enthaltenen <em>Affiliate</em>-Plugin von FlightCMS, kannst du einfach mit deiner Webseite Geld verdienen.
---
## Das Affiliate Plugin ## {#Plugin-Affiliate}

Das in _FlightCMS_ enthaltene Plugin _Affiliate_ blendet zufällige, so genannte Affiliate Links oberhalb des Content-Bereichs eines Beitrags ein und hört auf den Hook _afterParseContent_. Affiliate-Links dienen dazu, mit Produktempfehlungen und Verkäufen über die eigene Webseite Geld zu verdienen. Das Plugin _Affiliate_ nutzt zur Speicherung der zu empfehlenen Produkte eine kleine YAML-Datenbank (Flatfile). Die YAML-Syntax bietet eine günstige Formatierung, zum Beispiel für die Erstellung von Sammlungen und großen Listen von Produkten.

    produkt-1:
        title:       Titel Produkt 1
        logo:        https://...jpg
        url:         https://...
        description: Beschreibung des Artikels oder des ersten Produkts

    produkt-2:
        title:       Titel Produkt 2
        logo:        https://...jpg
        url:         https://...
        description: Beschreibung des zweiten Produkts

    ...
_YAML-Datei um Affiliate-Links zu speichern_

Sofern keine Affiliate-Datenbank existiert, legt das Plugin im selben Verzeichnis eine YAML-Datei mit Demo-Einträgen an, diese können dann durch eigene Affiliate-Links anderer Werbenetzwerke ersetzt werden - aktuell ist das Partnernet Amazon eingestellt. Sie können die Liste nahezu unendlich erweitern.

>Hinweis: Je nach verwendetem Netzwerk, müssen Sie einen Hinweis anbringen, aus dem ersichtlich wird, dass Sie mit solchen Links Geld verdienen! Bringen Sie keinen solchen Hinweis an, so kann dies zur Sperrung Ihrer Partner-ID bei diesem Werbenetzwerk führen.

>Hinweis: Sofern Sie nicht mit dem YAML-Format vertraut sind, sollten Sie die Einrücktiefe der Demo-Einträge genau einhalten, da YAML die Anzahl der Einrückungen dazu verwendet Strukturen und Listen automatisch zu erkennen.