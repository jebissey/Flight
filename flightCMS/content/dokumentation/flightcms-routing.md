---
Title:       Routing
Author:      FlightCMS
Date:        2024-01-22
Robots:      all
Featured:	 true
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: Das zentrale <em>Routing</em> wird mit dem PHP-Programm <em>index.php</em> abgewickelt, das im Wurzelverzeichnis liegt.
---
## Routing von Kategorien und Beiträgen ## {#routing-kategorie-beitrag}

Das zentrale _Routing_ wird über die Scriptdatei `index.php` abgewickelt. Das Startscript läd am Beginn alle benötigten externen Bibliotheken, wie `Flight`, `Dipper`, `xController`, `xModel` und `Parsedown`. Im wesentlichen wickelt das Flight-Microframework die folgenden Routen ab:


	Flight::route('/', function () {
  		$controller = new HomeController();
	});
	Flight::route('/@category', function ($category) { 
    	$controller = new CategoryController($category);
	});
	Flight::route('/@category/@post', function ($category, $post) {
  		$controller = new PostController($category, $post);
	});
_Version 2.4.01_

Mit `Flight::route()` werden die Routen angelegt, auf die das _FlightCMS_ reagieren soll, das sind die folgenden Zustände:

- `/` (wenn der Leser auf der Startseite ist => HomeController)
- `/@category` (Verarbeitung wenn Leser in Kategorie steht => CategoryController)
- `/@category/@post` (der Leser einen Beitrag anfordert => PostController)

## Routing zur Fehlerbehandlung ## {#routing-fehler}

Das Flight-Microframework bietet zudem auch Möglichkeiten an, Fehlersituationen im Routing entsprechend abzufangen

	Flight::map('notFound', function(){
  		Flight::halt(404, ERROR_DOC);
	});
	Flight::map('error', function(Exception $ex){
  		Flight::halt(404, ERROR_DOC);
	});
	Flight::route('/@category/@post/*', function(){
  		Flight::halt(404, ERROR_DOC);
	});
_Version 2.4.01_

Sollte der Leser eine unbekannten Beitrag in deinem CMS anfordern, wird die `notFound` Methode des Flight-Frameworks gestartet, FlightCMS zeigt ein 404 HTML-Dokument an und stoppt die Verarbeitung.

Wenn dein CMS einen Fehler verursacht, wird die Methode `error` ebenfalls mit einer Fehleranzeige und einem Stopp des Systems im Browser quittiert.

Die letzte Fehlersituation die dein CMS bewältigen muss ist, wenn der Leser sich mit `www/xxx/yyy/zzz...` außerhalb der vorgegebenen dreistufigen Struktur aus `domain.de/kategorie/beitrag` bewegt.

## Routing für ein Newsletter ## {#routing-newsletter}

Zwar ist ein Newsletter nicht mehr sehr populär, dennoch kannst du mit dem folgenden Routen das Flight-Microframework anweisen einen Newsletter zu verarbeiten.

	Flight::route(NEWSLETTER_ACTION, function() 
	{
		Flight::get('news_controller')->processNewsletter();
	});
	Flight::route(NEWSLETTER_FORM, function() 
	{
		Flight::get('news_controller')->formNewsletter();
	});
	Flight::route(NEWSLETTER_REGISTER, function() 
	{
		Flight::get('news_controller')->formRegister();
	});
	Flight::route(NEWSLETTER_UNREGISTER, function() 
	{
		Flight::get('news_controller')->formUnRegister();
	});
	Flight::route(NEWSLETTER_ERROR, function() 
	{
		Flight::get('news_controller')->formError();
	});
_Version 2.4.01_

Die tatsächlichen Routen werden durch Konstanten definiert und lassen sich in der Config leicht zentral anpassen.

>Bitte bedenke, das du bei solchen Formularen das Post-Get-Redirect Pattern nutzen solltest, daher ist das obige Routing etwas umständlich aber es soll dazu dienen, das dein Leser ein Formular nicht durch mehrfaches drücken der Taste F5 mehrfach absenden kann.

## Routing des Contact Formulars ## {#routing-contact-form}

Ein Kontakt-Formular solltest du in deinem CMS unbedingt implementieren, denn es hat sich zum Standard entwickelt.

	Flight::route(CONTACT_ACTION, function() {
		Flight::get('contact_controller')->processContact();
	});
	Flight::route(CONTACT_FORM, function() {
		Flight::get('contact_controller')->formContact();
	});
	Flight::route(CONTACT_SEND, function() {
		Flight::get('contact_controller')->formSend();
	});
	Flight::route(CONTACT_ERROR, function() {
		Flight::get('contact_controller')->formError();
	});
_Version 2.4.01_

>Anmerkung: viele Webseiten tauschen das Kontaktformular gegen Kontakt-Formen von Social-Media Kanälen aus und stellen immer mehr fest, das die Kontaktgesuche geringer werden oder gar aufhören, das ist verständlich, denn bei diesen Kontaktgesuchen über Social-Media ließt der dortige Betreiber immer mit und speichert sogar deine IP-Adresse, das wollen die meisten Leser nicht mehr.
