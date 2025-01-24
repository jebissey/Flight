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

    <!-- Kopfbereich -->
    <div class="container-fluid bg-primary py-5 text-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-center">
					<a href="/" title="home"><img src="<?php echo $logo; ?>" class="img-fluid w-75" alt="Logo"></a>
				</div>

				<div class="col-sm-5 my-auto">
                  
                    <!-- Newsletter Formular -->
                    <?php if ($type == 'form'): ?>
					    <form action="<?php echo NEWSLETTER_ACTION; ?>" method="post">
                        <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-6 mb-0">Anrede <sup>*</sup></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Vorname Name">
                        </div>

                        <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-6 mb-0">E-Mail Addresse <sup>*</sup></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        </div>

                        <div class="form-check mb-3 form-check-inline">
					    <input class="form-check-input" type="checkbox" value="register" name="unregister" id="flexCheckDefault">
  					    <label class="form-check-label" for="flexCheckDefault">
    				    nicht mehr abonieren
  					    </label>
					    </div>

                        <div class="form-check mb-3 form-check-inline">
					    <input class="form-check-input" type="checkbox" value="roboter" name="robot" id="bot" checked>
  					    <label class="form-check-label" for="bot">
    				    ich bin ein Roboter
  					    </label>
					    </div>

                        <div class="mb-3">
                        <button type="submit" class="btn btn-secondary mb-0">Send</button><br>
                        <span class="fs-6 opacity-50"><em>*) Pflichtfelder</em></span>
                        </div>
                  	    </form>
                    <?php endif ?>

                    <!-- Register Confirmation Info -->
                    <?php if ($type == 'register'): ?>
                        <h1 class="fw-bold"><?php echo $title; ?></h1>
                        <hr class="my-5">
                        <p class="lead"><?php echo $description; ?></p>
                    <?php endif ?>

                    <!-- Un-Register Confirmation Info -->
                    <?php if ($type == 'unregister'): ?>
                        <h1 class="fw-bold"><?php echo $title; ?></h1>
                        <hr class="my-5">
                        <p class="lead"><?php echo $description; ?></p>
                    <?php endif ?>

                    <!-- unspezific error -->
                    <?php if ($type == 'error'): ?>
                        <h1 class="fw-bold"><?php echo $title; ?></h1>
                        <hr class="my-5">
                        <p class="lead"><?php echo $description; ?></p>
                    <?php endif ?>

				</div>
			</div>
        </div>
    </div>
    <!-- Kopfbereich -->

    <!-- Content Area -->
    <div class="container py-5">

        <!-- Newsletter Form-Content -->
        <?php if ($type == 'form'): ?>
            <h1 class="text-primary _bg-light p-4 my-5 border-start">Vorteile des FlightCMS Newsletter</h1>

            <p>Wir informieren dich gerne über die Neuerungen, Sicherheitsupdates und 
            kostenlosen Erweiterungen, wie Plugins oder Themes, die es im <em>FlightCMS</em> gibt.</p>

            <p>Vielleicht hast du sogar Lust, einer unserer vielen Beta-Tester zu werden und 
            kannst damit einen sehr wichtigen Beitrag zur sicheren Entwicklung des 
            <em>FlightCMS</em> leisten.</p> 

            <blockquote>Natürlich fällt uns die Anrede über deinen <em>Real</em>-Namen 
            leichter als über einen <em>Alias</em>-Namen, dies ist aber keine Bedingung 
            für die Teilnahme am Newsletter.</blockquote>
        <?php endif ?>

        <!-- Register Info-Content -->
        <?php if ($type == 'register'): ?>
            <h2 class="text-primary _bg-light p-4 my-5 border-start">Newsletter aboniert</h2>
            <p>Danke das Du dich für unseren Newsletter mit Deiner Mail-Adresse registeriert 
            hast. Mit unserem Newsletter bleibst du immer auf dem aktuellen Stand der 
            Entwicklung und erfährst Neuigkeiten rund um Updates und Fehlerbehebungen zu 
            <em>FlightCMS</em>.</p>
        <?php endif ?>
      
        <!-- Un-Register Info-Content -->
        <?php if ($type == 'unregister'): ?>
            <h2 class="text-primary _bg-light p-4 my-5 border-start">Newsletter nicht mehr aboniert</h2>
      	    <p>Du hast den Newsletter abbestellt und wir werden dich sehr vermissen. 
            Schön das du uns eine Weile begleitet hast.</p>
        <?php endif ?>

        <!-- unspezific Error -->
        <?php if ($type == 'error'): ?>
            <h2 class="text-primary _bg-light p-4 my-5 border-start">Gründe für den Abbruch</h2>
            <ul>
            <li>du hast das <strong>Abo bereits beendet</strong> und versuchst den Newsletter <strong>nochmals zu kündigen</strong></li>
            <li>du bist bereits registriert und versuchst dich <strong>noch einmal zu registrieren</strong></li>
            <li>du hast <strong>unvollständige</strong> oder <strong>falsche Daten eingegeben</strong></li>
            <li>du hast vergessen dich <strong>als Mensch auszuweisen</strong></li>
            </ul>
            <p>Bitte überprüfe zunächst, ob einer der oben stehenden Fehler möglich ist und korrigieren deine Eingabe entsprechend.</p>
        <?php endif ?>

    </div>
    <!-- Content Area -->
  
    <?php include('footer.php'); ?>

</body>
</html>