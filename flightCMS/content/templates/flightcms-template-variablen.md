---
Title:       Template Variablen
Author:      FlightCMS
Date:        2023-12-21
Robots:      all
Featured:	 false
Tags:        Template,Tokens,Variablen
Logo:        /img/flightcms-templates.svg
Description: FlightCMS unterstützt einige Template-Variablen für die Anzeige des Content.
---
## FlightCMS Template-Variablen bzw. Template-Tokens ## {#Template-Tokens}

Für die Erstellung eigener Templates und Webseiten nach individuellen Wünschen, bietet FlightCMS einige Template-Variablen bzw. Template-Tokens.

### Übersicht ### {#Uebersicht}

<table>
	<tr>
		<th> Token     </th>
		<th> Bedeutung </th>
	</tr>
	<tr>
		<td> 
			$title
		</td>
		<td> 
			Titel (H1) aus der <code>index.md</code> oder der <code>beitrag.md</code> (für gutes SEO, nicht mehr als 50-65 Zeichen) 
		</td>
	</tr>
	<tr>
		<td> 
			$logo
		</td>
		<td>
			Teaser bzw. Beitragsbild <code>/img/logo.png</code> oder <code>https://domain.de/img/logo.png</code> (implizit bevorzugen Suchmaschinen das Grafik-Format <code>Webp</code>)
		</td>
	</tr>
	<tr>
		<td>
			$description
		</td>
		<td>
			Aussagekräftiger und signifikanter Anleser oder Beschreibungstext der Kategorie, Post (für gutes SEO, nicht mehr als 150-160 Zeichen)
		</td>
	</tr>
	<tr>
		<td>
			$content
		</td>
		<td>
			Beitragsinhalt der <code>index.md</code> oder der <code>beitrags.md</code> (der Content wird mit Hilfe von Markdown formatiert)
		</td>
	</tr>
	<tr>
		<td>
			$date
		</td>
		<td>
			Datumsvermerk wann der Beitrag oder die Kategorie erzeugt wurde
		</td>
	</tr>
	<tr>
		<td>
			$robots
		</td>
		<td>
			Signalisiert der Suchmaschine, ob links weiter verfolgt und indexiert werden soll oder nicht
		</td>
	</tr>
	<tr>
		<td>
			$featured
		</td>
		<td>
			Je nach Template, erfolgt eine besondere Hervorhebung solcher Beiträge oder Kategorien (dies muss vom Template unterstützt werden)
		</td>
	</tr>
	<tr>
		<td>
			$author
		</td>
		<td>
			Üblicherweise ist das der Beitragsautor oder Redakteur (alternativ auch Mail-Adresse, Telefon, Kürzel, Alias, Kanal-Name, Webseite o.ä.)
		</td>
	</tr>
	<tr>
		<td>
			$tags
		</td>
		<td>
			Schlagworte, Stichworte, Keywords, Schlüsselbegriffe die den Beitrags oder die Kategorie klassifizieren
		</td>
	</tr>
	<tr>
		<td>
			$url
		</td>
		<td>
			Der Permalink (URL ausgehend vom Basisverzeichnis) des Beitrags oder der Kategorie
		</td>
	</tr>
	<tr>
		<td>
			$pages
		</td>
		<td>
			Liste (Array) mit Beiträgen in dieser Kategorie
		</td>
	</tr>
	<tr>
		<td>
			$categories
		</td>
		<td>
			Liste (Array) mit Kategorien unterhalb von home
		</td>
	</tr>
</table>

### Beispiele ### {#Beispiele}

Nachfolgend siehst du einige Beispiele, wie die Template-Tokens in dein eigenes Template engebunden werden können.

    <img src="<?php echo $logo; ?>">
    <h1><?php echo $title; ?></h1>
    <p><?php echo $description; ?></p>
    <?php echo $content; ?>
    ...
_Beispiel einiger Tokens_
    
>Der Template-Token $content benötigt keinen p-Tag (Paragraph), da dieser durch den Markdown Parser hinzugefügt wird.

### `$pages` - Beitragsliste verarbeiten ### {#Beitragsliste}

Wenn unterhalb des Ordners home Beiträge platzieren möchtest, erhältst du mit `$pages` eine Liste (PHP-Array), die du im Template auslesen und anzeigen kannst.

```php
<?php foreach($pages as $page): ?>
    <img src="<?php echo $page['logo'];?>">
	<a href="<?php echo $page['url']; ?>">
		<?php echo $page['title']; ?>
	</a>
	<p>
		<?php echo $page['description']; ?>
	</p>
<?php endforeach ?>
```
_Seiten verarbeiten_

### `$categories` - Kategorieliste verarbeiten ### {#Kategorie-Liste}

Unterhalb des Home-Verzeichnis liegen die Kategorien deines CMS, um diese Anzuzeigen, kannst du eine Liste mit der Variable `$categories` in dein Template einbauen, welches du auslesen und anzeigen kannst.

    <?php foreach($categories as $categorie): ?>
        <img src="<?php echo $categorie['logo'];?>">
		<a href="<?php echo $categorie['url']; ?>">
			<?php echo $categorie['title']; ?>
		</a>
        <p>
			<?php echo $categorie['description']; ?>
		</p>
    <?php endforeach ?>
_Kategorien verarbeiten_