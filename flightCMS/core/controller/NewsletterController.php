<?php
//-------------------------------------------------------------------------------------------------
// 07.01.2024 - Initial
// 13.01.2024 - Form und Confirm-Views
// 16.01.2024 - zentrale Einstiegsmethode aus der 'index.php' herausgelöst (Optimierung)
//-------------------------------------------------------------------------------------------------

class NewsletterController 
{
	//---------------------------------------------------------------------------------------------
	// Anzeigen der Form, um den Newsletter zu abonieren oder zu kündigen
	//-------------------------------------------------------------------------------------------------
  	function formNewsletter() 
    {
		Debug::out('NewsController.php','formNewsletter','');
		Flight::view()->set('type',        'form');							// Switch to Input Form
		Flight::view()->set('title',       'FlightCMS Newsletter');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Bleib auf dem Laufenden und aboniere den <em>FlightCMS</em>-Newsletter. In regelmäßigen Abständen bekommst du Post zu Neuigkeiten oder kostenlosen Updates zum <em>FlightCMS</em> - wenn du magst.');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('newsletter');										// Template 'newsletter' rendern
    }
  
	//---------------------------------------------------------------------------------------------
	// Anzeigen der Bestätigung des Newsletter-Abos
	//-------------------------------------------------------------------------------------------------
	function formRegister()
	{
		Debug::out('NewsController.php','formRegister','');
		Flight::view()->set('type',        'register');						// switch to Form Register
  		Flight::view()->set('title',       'Newsletter aboniert');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Danke das du unseren Newsletter abonierst, damit bleibst du auf dem aktuellen Stand');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('newsletter');										// Template 'newsletter' rendern
	}

	//---------------------------------------------------------------------------------------------
	// Anzeigen der Bestätigung der Kündigung des Newsletters
	//-------------------------------------------------------------------------------------------------
	function formUnRegister()
	{
		Debug::out('NewsController.php','formUnRegister','');
		Flight::view()->set('type',        'unregister');					// swicth to Form Unregister
  		Flight::view()->set('title',       'Newsletter nicht mehr aboniert');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Schade das du uns verlassen willst aber vielleicht schaust du auch so mal wieder vorbei?');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('newsletter');										// Template 'newsletter' rendern
	}

	//---------------------------------------------------------------------------------------------
	// Anzeigen der Bestätigung der Kündigung des Newsletters
	//---------------------------------------------------------------------------------------------
	function formError()
	{
		Debug::out('NewsController.php','formError','');
		Flight::view()->set('type',        'error');
  		Flight::view()->set('title',       'Oh je, da ist was schief gelaufen...');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Die Verarbeitung des Newsletters kann nicht abgeschlossen werden, da ein Fehler vorliegt. Bitte prüfe deine Daten.');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('newsletter');
	}

	//---------------------------------------------------------------------------------------------
	// Zentraler Einstieg in die Verarbeitung des Newsletters
	// 16.01.2024 - Init
	//---------------------------------------------------------------------------------------------
	function processNewsletter()
	{
		Debug::out('NewsController.php','processNewsletter','');
		if(!isset($_POST['robot']) && $_POST['email'] && $_POST['name'])			// is Roboter, Mail and Name are filled?
		{
			Debug::out('NewsController.php','processNewsletter','is Human');
			if(isset($_POST['unregister']))											// Option 'Unregister' selected
			{
				Debug::out('NewsController.php','processNewsletter','unregister');
				if(!file_exists(NEWSLETTER_UNREGISTER_FILE)) 						// Unregister-File exsist?
				{
					file_put_contents(NEWSLETTER_UNREGISTER_FILE,'');				// create Unregister-File!
				}
				$this->unregisterNewsletter();										// process Unregister
			} else {																// Option 'Register' selected
				Debug::out('NewsController.php','processNewsletter','register');
				if(!file_exists(NEWSLETTER_REGISTER_FILE)) 							// Register-File exsist?
				{
					file_put_contents(NEWSLETTER_REGISTER_FILE,'');					// create Register-File!
				}
				$this->registerNewsletter();										// process Register
			}
			usleep(50000); 															// wait 500ms slowdown the System
		} else {
			Debug::out('NewsController.php','processNewsletter','is Robot');
			Flight::redirect(NEWSLETTER_ERROR);										// Error when all wrong
		}
	}

	//---------------------------------------------------------------------------------------------
	// Verarbeitung der Eingaben des Users (Abo kündigen) mit Post/Redirect/Get-Pattern.
	// Sofern das NEWSLETTER_REGISTER_FILE noch nicht existiert, wird es erzeugt, dann wird
	// nachgesehen, ob die IP bereits dort eingetragen ist, ist sie noch nicht eingetragen, wird
	// sie dort gespeichert, existiert sie bereits, erscheint ein Hinweis, das mehrfache
	// Anmeldungen zum Abo nich möglich sind.
	//---------------------------------------------------------------------------------------------
  	private function registerNewsletter()
    {
		Debug::out('NewsController.php','registerNewsletter','');
		if(substr_count(file_get_contents(NEWSLETTER_REGISTER_FILE), $_SERVER['REMOTE_ADDR']) < 1)	// ist die IP noch nicht vorhanden?
		{
      		//$email = str_replace(array('<','>','#','?'), '', $_POST['email']);
			$email = Purify::input($_POST['email']);
  			$email = trim(substr($email, 0, 40));
  			//$name  = str_replace(array('<','>','#','?'), '', $_POST['name']);
			$name  = Purify::input($_POST['name']);
			$name  = trim(substr($name, 0, 40));

      		file_put_contents(NEWSLETTER_REGISTER_FILE, $email.';'.$name.';'.$_SERVER['REMOTE_ADDR']."\n", FILE_APPEND | LOCK_EX)!==false;

			Flight::redirect(NEWSLETTER_REGISTER); 						// Register Confirmation -> Meldung 'du bist registriert'
		} else {
			Flight::redirect(NEWSLETTER_ERROR);							// IP ist bereits registriert -> Meldung
		}
    }

	//---------------------------------------------------------------------------------------------
	// Verarbeitung der Eingaben des Users (nicht mehr abonieren) mit Post/Redirect/Get-Pattern.
	// Sofern das NEWSLETTER_UNREGISTER_FILE nicht existiert, wird es angelegt, dann wird geprüft
	// ob für diese IP bereits ein Eintrag existiert, wenn kein Eintrag existiert, kann die IP
	// für die Abmeldung vom Newsletter eingetragen werden, andernfalls erscheint eine 
	// Fehlermeldung
	//---------------------------------------------------------------------------------------------
	private function unregisterNewsletter()
	{
		Debug::out('NewsController.php','unregisterNewsletter','');
		if(substr_count(file_get_contents(NEWSLETTER_UNREGISTER_FILE), $_SERVER['REMOTE_ADDR']) < 1)
		{
			$email = Purify::input($_POST['email']);
  			$email = trim(substr($email, 0, 40));
			$name  = Purify::input($_POST['name']);
			$name  = trim(substr($name, 0, 40));

      		file_put_contents(NEWSLETTER_UNREGISTER_FILE, $email.';'.$name.';'.$_SERVER['REMOTE_ADDR']."\n", FILE_APPEND | LOCK_EX)!==false;

			Flight::redirect(NEWSLETTER_UNREGISTER);
		} else {
			Flight::redirect(NEWSLETTER_ERROR);							// unspezifisch ist besser
		}
	}
}
?>