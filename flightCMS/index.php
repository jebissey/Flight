<?php
// --- Config the FlightCMS ---
define('VERSION',                          '2.4.02');														// aktuelle FlightCMS Version

// --- Path and Routes def. ---
define('CONTENT_EXT',                      '.md');															// Dateiendung des Beitrags
define('CONTENT_DIR',                      'content/');														// Basisverzeichnis
define('PLUGINS_HOOKED_DIR',               'core/plugins/hook');											// Hooked Plugins
define('PLUGINS_STATIC_DIR',               'core/plugins/static');											// statische Plugins
define('THEME_NAME',                       'blog');														// Verzeichnis des actives 'Theme'
define('VIEWS_DIR',                        'core/views/'.THEME_NAME);										// 'Themes' Sammlung
define('VIEWS_EXT',                        '.php');															// Dateierweiterung von Templates
define('SORTING',                          'DESC');															// ASC, DESC, asc, desc
define('SORT_BY',                          'DATE');															// Date, Title, date, title

// --- Error Documents ---
define('ERROR_404_DOC',                    file_get_contents(VIEWS_DIR.'/error-404.php'));					// Error 404 Template

// --- Logging def. ---
define('LOG_DIR',                          'log');															// global Log-Dir

// --- Debug def. ---
define('DEBUG_ACTIVE',                     false);															// activate/deactivate Debugging
define('DEBUG_FILE',                       'debug.html');													// Name of Debug-File

// --- Contact Form def. ---
define('CONTACT_ACTIVE',                   true);
define('CONTACT_MAIL',                     'Kontakt@FlightCMS.de');											// your own Mail-Address
define('CONTACT_FORM',                     '/contact');
define('CONTACT_ACTION',                   '/contact-action');
define('CONTACT_SEND',                     '/contact-send');
define('CONTACT_ERROR',                    '/contact-error');

// --- Newsletter def. ---
define('NEWSLETTER_ACTIVE',                true);															// Turn Newsletter On or Off (DEACTIVE)
define('NEWSLETTER_REGISTER_FILE',         LOG_DIR.'/newsletter-register.csv');								// File for Newsletter Mail-Register
define('NEWSLETTER_UNREGISTER_FILE',       LOG_DIR.'/newsletter-unregister.csv');							// File for Newsletter Mail-Unregister
define('NEWSLETTER_FORM',                  '/newsletter');													// Route to Display Newsletter-Formular
define('NEWSLETTER_ACTION',                '/newsletter-action');											// Route to Process the Formular-Data
define('NEWSLETTER_REGISTER',              '/newsletter-register');											// Route to Display Register-Confirmation
define('NEWSLETTER_UNREGISTER',            '/newsletter-unregister');										// Route to Display unRegister-Confirmation
define('NEWSLETTER_ERROR',                 '/newsletter-error');											// Route to Display unspezific Error

// --- Load external Components ---
require 'core/flight/Flight.php';																			// include Flight Microframework
require 'core/dipper/Dipper.php';																			// include Dipper fast YAML Parser
require 'core/helpers/Page.php';																			// little easy Helpers
require 'core/helpers/Debug.php';																			// little easy Helpers
require 'core/helpers/Purify.php';																			// little easy Helpers
//require 'core/helpers/Yml.php';																			// little easy Helpers
//require 'core/helpers/Json.php';																			// little easy Helpers
require 'core/helpers/Url.php';																			// little easy Helpers

// --- Load Controllers ---
require 'core/controller/CategoryController.php';															// Load Controller
require 'core/controller/PostController.php';																// Load Controller
require 'core/controller/HomeController.php';																// Load Controller
require 'core/controller/NewsletterController.php';															// Load Controller
require 'core/controller/ContactController.php';															// Load Controller

// --- Load Models ---
require 'core/model/CategoriesModel.php';																	// Load Model
require 'core/model/PagesModel.php';																		// Load Model

// --- Load Parser ---
require 'core/parsedown/Parsedown.php';																		// Load Parsedown
require 'core/parsedown/ParsedownExtra.php';																// Load ParsedownExtra

// --- set Flight-Variables ---
Flight::set('plugins');																						// collect Hooked-Plugins in List
Flight::set('flight.views.path',      VIEWS_DIR);															// set Views-Path to Flight-Framework
Flight::set('flight.views.extension', VIEWS_EXT);															// set Extension-Type of Views
Flight::set('flight.log_errors', 	  true);

$pd  = new Parsedown();																						// start Instance of Parsedown
$pde = new ParsedownExtra();																				// start Instance of ParsedownExtra (extends Parsedown)

// --- Create the single NewsController ---
Flight::set('news_controller',    new NewsletterController());												// create NewsController Object
Flight::set('contact_controller', new ContactController());													// create ContactController Object

Debug::start();

//-------------------------------------------------------------------------------------------------
// NotFound start 404 Error-Doc
//-------------------------------------------------------------------------------------------------
Flight::map('notFound', function() 
{
	Debug::out('Index.php','notFound','');
	Flight::hook('onError','');																				// start Plugins by Hook 'onError'
  	Flight::halt(404, ERROR_404_DOC);																		// Start Error-Document and stop the FlightCMS
});

//-------------------------------------------------------------------------------------------------
// System-Error start 404 Error-Doc
//-------------------------------------------------------------------------------------------------
Flight::map('error', function(Exception $ex) 
{
	Debug::out('Index.php','error', $ex);
	Flight::hook('onError','');																				// start Plugins by Hook 'onError'
  	Flight::halt(404, ERROR_404_DOC);																		// Start Error-Document and stop the FlightCMS
});

//-------------------------------------------------------------------------------------------------
// Start HOME
//-------------------------------------------------------------------------------------------------
Flight::route('/', function () 
{
	Debug::out('Index.php','Route','/');
  	$controller = new HomeController();																		// User at the home-Page
});

//-------------------------------------------------------------------------------------------------
// Newsletter process
//-------------------------------------------------------------------------------------------------
Flight::route(NEWSLETTER_ACTION, function() 
{
	Debug::out('Index.php','Route',NEWSLETTER_ACTION);
	Flight::get('news_controller')->processNewsletter();
});
Flight::route(NEWSLETTER_FORM, function() 
{
	Debug::out('Index.php','Route',NEWSLETTER_FORM);
	Flight::get('news_controller')->formNewsletter();
});
Flight::route(NEWSLETTER_REGISTER, function() 
{
	Debug::out('Index.php','Route',NEWSLETTER_REGISTER);
	Flight::get('news_controller')->formRegister();
});
Flight::route(NEWSLETTER_UNREGISTER, function() 
{
	Debug::out('Index.php','Route',NEWSLETTER_UNREGISTER);
	Flight::get('news_controller')->formUnRegister();
});
Flight::route(NEWSLETTER_ERROR, function() 
{
	Debug::out('Index.php','Route',NEWSLETTER_ERROR);
	Flight::get('news_controller')->formError();
});

//-------------------------------------------------------------------------------------------------
// Contact
//-------------------------------------------------------------------------------------------------
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

//-------------------------------------------------------------------------------------------------
// Start Category or Post
//-------------------------------------------------------------------------------------------------
Flight::route('/@category', function ($category) 
{ 
	Debug::out('Index.php','Route',$category);
  	if(is_dir(CONTENT_DIR.explode('/',Flight::request()->url)[1])) 
	{
      	$controller = new CategoryController($category);													// domain.de/path is a Directory
    } else {
  		$controller = new PostController('/', $category);													// domain.de/path is af MD-File
    }
});

//-------------------------------------------------------------------------------------------------
// Start Post
//-------------------------------------------------------------------------------------------------
Flight::route('/@category/@post', function ($category, $post) 
{
	Debug::out('Index.php','Route',$category.' -> '.$post);
  	$controller = new PostController($category, $post);														// load a Post
});

//-------------------------------------------------------------------------------------------------
// Not legal Structure
//-------------------------------------------------------------------------------------------------
Flight::route('/*/*/*', function()
{
	Debug::out('Index.php','Route -> '.$category.' -> '.$post.' -> ???');
	Flight::hook('onError','');																				// start Plugins by Hook 'onError'
  	Flight::halt(404, ERROR_404_DOC);																		// Start Error-Document and stop the FlightCMS
});

//-------------------------------------------------------------------------------------------------
// Start Plugin by Hook
//-------------------------------------------------------------------------------------------------
Flight::map('hook', function($hook, $var) 
{
	Debug::out('Index.php','Call Hook',$hook.' -> '.$var);
  	$plugin_list = Flight::get('plugins');
  
  	if(isset($plugin_list[$hook])) 
	{
        foreach ($plugin_list[$hook] as $value) 
		{
          	$var = $value->run($var);																		// call a Plugin by Hook and start run() Methode
        }
    }
  
	return $var;
});

//-------------------------------------------------------------------------------------------------
// Load Hooked Plugins and static Plugins. Plugins named '_plugin-name.php' was ignored.
//-------------------------------------------------------------------------------------------------
Flight::map('loadPlugins', function() 
{
	Debug::out('Index.php','Load Plugins',PLUGINS_HOOKED_DIR);
  	$plugin_list = Flight::get('plugins');
  
	// --- Load hooked Plugins (core/plugins) ---
	foreach (glob(PLUGINS_HOOKED_DIR.'/*.php') as $file_name) 
	{
		if (!preg_match('{_}', $file_name)) 
		{
          	$class_name = str_replace('.php','',explode('/', $file_name)[3]);
          	include($file_name);

			Flight::register('user_plugin', $class_name);
          	$plugin = Flight::user_plugin();
          	$plugin_list[$plugin->hook()][] = $plugin;														// temporäre Plugin-Liste (Array) aufbauen
			//$plugin_list[$plugin->$hook][] = $plugin;														// funktioniert nicht als magische Methode, da keine Instanz existiert
          	Flight::set('plugins', $plugin_list); 															// temp.Plugin-Liste zurück in die Flight-Variable speichern
		}
	}

	// --- Load static Plugins (core/plugins/static) ---
	Debug::out('Index.php','Load Plugins',PLUGINS_STATIC_DIR);
	foreach (glob(PLUGINS_STATIC_DIR.'/*.php') as $file_name) 
	{
		if (!preg_match('{_}', $file_name)) 
		{
          	include($file_name);																			// include static Plugins for static Call
		}
	}
});

//-------------------------------------------------------------------------------------------------
// Check and create Log-Dir before Logging and Plugin start. Used by Plugins, Newsletter,...
//-------------------------------------------------------------------------------------------------
Flight::map('createLogDir', function()
{
	Debug::out('Index.php','Create Log-Dir',LOG_DIR);
	if (!is_dir(LOG_DIR)) {mkdir(LOG_DIR);}
});

//-------------------------------------------------------------------------------------------------
// Start Plugins by Hook 'afterStart'
//-------------------------------------------------------------------------------------------------
Flight::after('start', function(&$params, &$output) 
{
	Debug::out('Index.php','Run','after start');
	Flight::hook('afterStart','');																			// start Plugins hooked on 'afterStart'
});

//-------------------------------------------------------------------------------------------------
// Init the CMS
//-------------------------------------------------------------------------------------------------
Flight::before('start', function(&$params, &$output) 
{
	Debug::out('Index.php','Run','before start');
	Flight::createLogDir();																					// Check and create Log-Directory first
  	Flight::loadPlugins();																					// load all Plugin-Types
  	Flight::hook('beforeStart','');																			// and first Start by Hook 'beforeStart'
});

//-------------------------------------------------------------------------------------------------
// Start Flight-CMS after all
//-------------------------------------------------------------------------------------------------
Flight::start();
Debug::stop();

//-------------------------------------------------------------------------------------------------
//
//	LOG
//  ---
//
// 2023-11-01 - Erster Prototyp des FlightCMS
// 2023-12-29 - Models haben magische Methoden für Übergabe an den Controller bekommen
// 2023-12-xx - Plugin jetzt Flight-Framework konform
// 2023-12-xx - Plugin-Sicherheit verbessert
// 2023-12-xx - Beiträge im 'home' Dir möglich
// 2023-12-xx - Generierung 'sitemap.xml' via Plugin
// 2023-12-xx - Plugin/Hook-Schnittstelle implementiert
// 2023-12-xx - 404-Handling implementiert
// 2024-01-05 - Affiliate-Plugin läd Produktlinks aus YAML-File
// 2024-01-06 - YAML-Config-Verzeichnis aufgelöst und als DEFINE innerhalb des Codes aufgenommen
// 2024-01-06 - Unterscheidung nach 'statischen' Plugins und Plugins die an einem 'Hook' hängen
// v2.4.01 - dedizierte Theme-Ordner möglich
// v2.4.01 - check suspect IP and block them for 24h
// v2.4.01 - Implements Newsletter as a Post-Redirect-Get Pattern
// v2.4.01 - Verschlankung des Fehlerhandlings im Newsletter, jetzt unspezifische Fehlermeldung
// v2.4.01 - teilweise Umbau der internen Programmstruktur (Optimierung)
// v2.4.01 - Logmechanismen aus Core in externes Plugin überführt
// v2.4.01 - Kleinere Optimierungen und Straffungen des Codes und der Templates
// v2.4.01 - Plugin 'Blogroll.php' und Pending-Status für Backlink anfragen
// v2.4.01 - Sortierung von Beiträgen nach 'Datum' und 'Titel' möglich
// v2.4.01 - '/content/ketagorie/beitrag-table-of-content.md' ist jetzt nicht mehr fehlerhaft,
//           da die Entfernung von 'content' aus der URL jetzt korrekt verarbeitet wird.
//         - 'Sidebar.php' und 'Featured.php' wg. Unstimmigkeiten nochmals überarbeitet
// v2.4.02 - TOC-Plugin angefangen zu realisieren.
//         - Das 'PagesModel.php' angepasst, damit auch 'content' ausgegeben wird.
//         - Das Plugin 'Sidebar.php' bedient sich des Helpers 'Page.php' um die Anzeige des Menü
//           alphanumerisch aufsteigend zu sortieren. Gerade bei sehr vielen Beiträgen der
//           CMSWorkbench ist die sortierte Anzeige der Beiträge sinnvoller nutzbar als die
//           bisher unsortierte Anzeige.
//-------------------------------------------------------------------------------------------------