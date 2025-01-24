<?php include('head.php'); ?>

	<!-- deactivate Back-Button -->
    <script>
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
    window.history.go(1);
    };
    </script>

    <!-- Download-Area -->
  	<div class="container-fluid bg-primary text-light p-0">
      <div class="container">
          	<div class="row">
              <div class="col-sm">
              </div>
              <div class="col-sm-3 bg-dark text-center p-4 shadow">
                	<a href="download/flightcms.zip" class="text-light" title="Download FlightCMS">Download <em>FlightCMS</em></a>
              </div>
          	</div>
      </div>
  	</div>
	<!-- Download-Area -->

    <div class="container-fluid bg-primary py-5 text-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-center">
					<a href="/" title="home"><img src="<?php echo $logo; ?>" class="img-fluid w-75" alt="Logo"></a>
				</div>

				<div class="col-sm-5 my-auto">
					
                  	<?php if ($type == 'form'): ?>
                  	<form action="<?php echo CONTACT_ACTION; ?>" method="post">
                    	<div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-6 mb-0">Betreff <sup>*</sup></label>
                    	<input type="text" class="form-control" name="betreff" id="exampleFormControlInput1" placeholder="Aussagekräftigen Titel eingeben">
                    	</div>
                      
                      	<div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-6 mb-0">Anrede <sup>*</sup></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Vorname Name">
                        </div>

                      	<div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-6 mb-0">E-Mail Addresse <sup>*</sup></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        </div>
                      
                    	<div class="mb-3">
                    	<label for="exampleFormControlTextarea1" class="form-label fs-6 mb-0">Mitteilung <sup>*</sup></label>
                    	<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="mitteilung"></textarea>
                    	<div class="fs-6 text-light opacity-50"><i>*) Pflichtfelder max.40 Zeichen. Nachricht max.1200 Zeichen, HTML, JavaScript, PHP oder sonstiger Code, nicht unterstützt.</i></div>
                    	</div>
                      
                      	<div class="form-check mb-3 form-check-inline">
					    <input class="form-check-input" type="checkbox" value="oeffentlich" name="oeffentlich" id="public">
  					    <label class="form-check-label" for="public">
    				    darf veröffentlicht werden
  					    </label>
                      	</div>
                      
                      	<div class="form-check mb-3 form-check-inline">
					    <input class="form-check-input" type="checkbox" value="roboter" name="robot" id="bot" checked>
  					    <label class="form-check-label" for="bot">
    				    ich bin ein Roboter
  					    </label>
                      	</div>

                    	<div class="mb-3">
                    	<button type="submit" class="btn btn-secondary mb-3">Send</button>
                    	</div>
                    </form>
                  	<?php endif ?>
                  
                  	<!-- Send Confirmation Info -->
                    <?php if ($type == 'send'): ?>
                        <h1 class="fw-bold"><?php echo $title; ?></h1>
                        <hr class="my-5">
                        <p class="lead"><?php echo $description; ?></p>
                    <?php endif ?>
                  
                  	<!-- Error Info -->
                    <?php if ($type == 'error'): ?>
                        <h1 class="fw-bold"><?php echo $title; ?></h1>
                        <hr class="my-5">
                        <p class="lead"><?php echo $description; ?></p>
                    <?php endif ?>

				</div>
			</div>
        </div>
    </div>

    <div class="container py-5">
      
      	<!-- Content Form -->
      	<?php if ($type == 'form'): ?>
        	<h1 class="text-primary _bg-light p-4 my-5 border-start"><?php echo $title ?></h1>
      		<p>
              Mit Hilfe des Kontaktformulars, kannst du mit uns über eMail in Verbindung treten.
              Bitte verfasse einen <em>signifikanten Betreff</em>, damit deine Mail in unserem Postfach 
              nicht übersehen wird - denn das wäre sehr schade. Es wäre schön, wenn du auch eine 
              <em>gültige Mail-Adresse</em> angibst, damit wir dir auch sinnvoll antworten können.
              Im übrigen speichern wir deine Mailadresse nicht!
      		</p>
      
      		<div class="alert alert-danger" role="alert">
              Deine <strong>Mailadresse wird nicht veröffentlicht</strong>, auch wenn du der 
              <strong>Veröffentlichung</strong> deiner Mitteilung oder deines Kommentars zustimmst! 
              Die Mitteilung erscheint mit <strong>Name, Betreff und Text</strong> unterhalb 
              der Startseite.
			</div>
      	<?php endif ?>
      
      	<!-- Content Send -->
      	<?php if ($type == 'send'): ?>
        	<h1 class="text-primary _bg-light p-4 my-5 border-start">Mitteilung wurde gesendet</h1>
        	<p>Deine Mitteilung wurde gesendet. Gib uns bitte ein paar Tage Zeit, um uns durch unsere
            vielen Mails zu kämpfen, wir nehemn dann so schnell wie möglich mit dir Kontakt auf.</p>
      	<?php endif ?>
      
      	<!-- Content Error -->
      	<?php if ($type == 'error'): ?>
        	<h1 class="text-primary _bg-light p-4 my-5 border-start">Gründe für den Abbruch</h1>
        	<p>Die Verarbeitung konnte nicht abgeschlossen werden, da die eingegebenen Daten fehlerhaft
      		oder unzureichend sind.</p>
      		<ul>
              <li>weise dich als Mensch aus, indem du den Haken in der Option <strong>ich bin ein Roboter</strong> herausnimmst</li>
              <li>fülle bitte <strong>alle Felder</strong> valide aus</li>
      		</ul>
      		<p>Bitte versuche es gleich noch einmal.</p>
      	<?php endif ?>

    </div>
  
    <?php include('footer.php'); ?>

</body>
</html>