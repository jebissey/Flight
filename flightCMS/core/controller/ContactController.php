<?php
//--------------------------------------------------------------------------------------------------
// 07.01.2024 - Initial
//--------------------------------------------------------------------------------------------------

class ContactController 
{
  	function formContact() 
    {
      	Flight::view()->set('type',        'form');
		Flight::view()->set('title',       'Kontakt oder Kommentar schreiben');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Nutzen Sie unser Kontakt-Formular, um mit dem Team von <em>FlightCMS</em> Kontakt aufzunehmen. Bitte formulieren Sie einen aussagekräftigen Betreff für Ihre Anfrage.');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('contact');																// Template 'newsletter' rendern
    }
  
  	function formError()
	{
		Flight::view()->set('type',        'error');
  		Flight::view()->set('title',       'Oh je, da ist was schief gelaufen...');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Die Verarbeitung des Kontaktformulars kann nicht abgeschlossen werden, da ein Fehler vorliegt. Bitte prüfe deine Daten.');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('contact');
	}
  
  	function formSend()
	{
		Flight::view()->set('type',        'send');
  		Flight::view()->set('title',       'Gesendet');
		Flight::view()->set('robots',      'all');
		Flight::view()->set('description', 'Dein Kontaktgesuch wurde gesendet und wir werden uns so schnell wie möglich mit dir in Verbindung setzen.');
		Flight::view()->set('logo',        '/img/flightcms-logo.svg');
		Flight::render('contact');
	}
  
  	function processContact()
	{
      	if(!isset($_POST['robot']) && $_POST['betreff'] && $_POST['mitteilung'] && $_POST['email'] && $_POST['name'])
        {
          	//$purify_message = substr(str_replace(array('<','>','#','&'),'.',$_POST['mitteilung']), 0, 1200);
          	//$purify_subject = substr(str_replace(array('<','>','#','&'),'.',$_POST['betreff']), 0, 40);
          	//$purify_mail    = substr(str_replace(array('<','>','#','&'),'.',$_POST['email']), 0,40);
          	//$purify_name    = substr(str_replace(array('<','>','#','&'),'.',$_POST['name']), 0,40);

			$purify_message = substr(Purify::input($_POST['mitteilung']), 0, 1200);
          	$purify_subject = substr(Purify::input($_POST['betreff']), 0, 40);
          	$purify_mail    = substr(Purify::input($_POST['email']), 0,40);
          	$purify_name    = substr(Purify::input($_POST['name']), 0,40);

          	$purify_public  = 'nein';
          	if (isset($_POST['oeffentlich'])) $purify_public = 'ja';
          
          	$empfaenger = CONTACT_MAIL;
			$betreff    = $purify_subject;
			$nachricht  = 'von: '.$purify_name.' ('.$purify_mail.')'."\n".'darf publiziert werden: '.$purify_public."\n\n".$purify_message;
			$header     = 'From: '.$purify_mail . "\r\n" .
    					  'Reply-To: '.$purify_mail . "\r\n" .
    					  'X-Mailer: PHP/' . phpversion();

			mail($empfaenger, $betreff, $nachricht, $header);
          
          	Flight::redirect(CONTACT_SEND);
        } else {
      		Flight::redirect(CONTACT_ERROR);
        }
    }
}
?>