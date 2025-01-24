<!-- Footer -->
<div class="container-fluid py-5 bg-primary text-light">
	<div class="container">
  		<div class="row">
    		<div class="col-sm">
              	<h3>Datenschutz</h3>
              	<hr>
      			<p>Die Webseite verwendet keine Tracking oder Speichermechanismen, mit dem Zwecke der Weitergabe an Dritte.</p>
              	<p>FlightCMS verwendet keine Cookies, folglich wird kein Cookie-Banner angezeigt.</p>
				<p>Im Falle von korrupten Zugriffen, speichert FlightCMS die IP-Adresse und sperrt diese ggf. für weitere Zugriffe für die Dauer von 24h.</p>
    		</div>
    		<div class="col-sm">
              	<h3>Impressum</h3>
              	<hr>
      			<p>FlightCMS ist eine Projektseite für die Entwicklung eines eigenen Content Management Systems. FlightCMS existiert ohne Kenntnis des Projektes FlightPHP.com und unterhält keinerlei Beziehungen dorthin, abgesehen von der Nutzung des kostenlosen Frameworks.</p>
    		</div>
    		<div class="col-sm">
              	<h3>Affiliate</h3>
              	<hr>
      			<p>
                  Die gezeigten Affiliate-Links (oben im Text) dienen ausschließlich der technischen 
                  Demonstration der Funktionsweise des Affiliate-Plugins. Du musst die Demolinks durch 
                  persönliche Links deines Werbepartners ersetzen, um mit Affiliate-Marketing auf deiner 
                  Webseite Geld verdienen zu können.
              	</p>
    		</div>
  		</div>
	</div>
</div>

<div class="container-fluid py-5 bg-primary text-light">
	<div class="container">
  		<h3>Link-Juice, Blogroll, Backlinks und Referenzen</h3>
		<hr>
		<div class="row">

			<!-- Blogroll je col-sm-3 -->
			<?php echo Blogroll::display(); ?>

		</div>
		<p>
			Wir geben gerne ein bisschen <em>Link-Juice</em> an dich weiter. Wenn du mitmachen möchtest nimm Kontakt mit uns auf, denn
			das Internet lebt von den Verbindungen der Webseiten untereinander - ansonsten würde das Web sterben.
			<sup><a href="/plugins/flightcms-plugin-blogroll" title="Plugin-Beschreibung"><i class="bi bi-plug-fill text-dark opacity-50"></i></a></sup>
		</p>
	</div>
</div>

<div class="container-fluid py-5 bg-secondary text-light">
	<div class="container">
  		<div class="row">
    		<div class="col-sm" id="kontakt">
              	<h3>Kontakt</h3>
      			<p>Sie können mit der Redaktion und Administration mittels eMail Kontakt aufnehmen. Senden Sie eine Mail mit aussagekräftigem Betreff an: <img src='https://MailPNG.de?string=Kontakt@Oliver-Lohse.de&size=5&R=FF&G=FF&B=FF' alt="Kontakt"></p>
    		</div>
    		<div class="col-sm">
              	<h3>MailPNG</h3>
              	<p>Die Webseite nutzt den kostenlosen Service von <a href="https://mailpng.de" class="text-light" title="MailPNG">https://MailPNG.de</a>, um die Klartext Mail-Adresse in ein PNG-Bild umzuwandeln, das ist ein wirksamer Schutz vor Spam und unerwünschtem Datenklau.</p>
    		</div>
  		</div>
      
      	<p class="text-center lead fs-6 py-5">
			<img src="https://flightcms.de/img/flight-cms-logo.png" width="23">
			<a href="https://FlightCMS.de" class="text-light">FlightCMS</a> - Copyright &copy; by Oliver Lohse
			<?php echo ' - Version: '.VERSION; ?>
		</p>
	</div>
</div>
<!-- Footer -->
