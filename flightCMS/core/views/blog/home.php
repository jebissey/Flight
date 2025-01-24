<?php include('head.php'); ?>

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
				<div class="col-sm-6 my-auto">
					<h1 class="fw-bold"><?php echo $title; ?></h1>
					<hr class="my-5">
                    <p class="lead"><?php echo $description; ?></p>
				</div>
			</div>
        </div>
    </div>
	<!-- Kopfbereich -->
  
	<!-- Feedback -->
	<div class="container-fluid bg-secondary text-light text-center text-uppercase py-2">
		<p class="lead pt-2">
			<a href="/newsletter" class="text-light">Newsletter</a>
			-
			<a href="/contact" class="text-light">Kontakt</a>
		</p>
	</div>
	<!-- Feedback -->

	<!-- Anzeige von Kategorien -->
    <div class="container-fluid bg-light py-5 shadow-lg">
      	<div class="container">
      		<div class="row">
              
              	<?php $count = 0; ?>
      			<?php foreach($categories as $categorie): ?>
              	<?php $count = $count+1; ?> 

					<?php if($count == 4): ?>
					<p class="my-5 fs-3 lead text-center">weitere Kategorien</p>
					<?php endif ?>

                  	<?php if($count > 3): ?>
						<!-- Kategorie 4,5,6... -->
              			<div class="col-sm-3 text-center">
                        <!-- <img src="<?php echo $categorie['logo'];?>" class="img-fluid w-50" alt="Teaser <?php echo $categorie['title']; ?>"><br> -->
                  		<a href="<?php echo $categorie['url']; ?>" title="<?php echo $categorie['title']; ?>">
							<?php echo $categorie['title']; ?>
						</a>
						<p class="fs-6"><?php echo $categorie['description']; ?></p>
              			</div>
                  	<?php else: ?>
						<!-- Kategorie 1,2,3 -->
                  		<div class="col-sm-4 mb-3 text-center">
              			<div class="text-center"><img src="<?php echo $categorie['logo'];?>" class="img-fluid w-50" alt="Teaser <?php echo $categorie['title']; ?>"></div>
              			<h2>
							<a href="<?php echo $categorie['url']; ?>" title="<?php echo $categorie['title']; ?>">
								<?php echo $categorie['title']; ?>
							</a>
						</h2>
              			<p><?php echo $categorie['description']; ?></p>
                        </div>
                  	<?php endif ?>
					
      			<?php endforeach ?>
              
          	</div>
      	</div>
  	</div>
	<!-- Anzeige von Kategorien -->
      
	<!-- Anzeige von Beiträgen in home -->
	<div class="container py-5">
		<div class="text-center"><p class="lead fs-3">Aktuelles</p></div>
		<?php $count=0; ?>
		<?php foreach($pages as $page): ?>
			<?php $count=$count+1; ?>
			<?php if($count%2 == 1): ?>

				<!-- Bild Links Text rechts -->
				<div class="row my-5 p-4 bg-primary text-light">
      			<div class="col-sm-4">
              		<div class="text-center"><img src="<?php echo $page['logo'];?>" class="img-fluid w-75" alt="Teaser <?php echo $page['title']; ?>"></div>
          		</div>
				<div class="col-sm mb-3">
					<a href="<?php echo $page['url']; ?>">
						<h3 class="lead fs-3 text-light"><?php echo $page['title']; ?></h3>
					</a>
                  	<hr class="my-4">
					<p class="lead"><?php echo $page['description']; ?></p>
					<p><?php echo $page['content']; ?></p>
				</div>
				</div>

			<?php else: ?>

				<!-- Bild rechts Text links -->
				<div class="row my-5 p-4 bg-light">
				<div class="col-sm">
					<a href="<?php echo $page['url']; ?>">
						<h3 class="lead fs-3"><?php echo $page['title']; ?></h3>
					</a>
              		<hr class="my-4">
					<p class="lead"><?php echo $page['description']; ?></p>
					<p><?php echo $page['content']; ?></p>
				</div>
				<div class="col-sm-4 mb-3">
              		<div class="text-center"><img src="<?php echo $page['logo'];?>" class="img-fluid w-75" alt="Teaser <?php echo $page['title']; ?>"></div>
      			</div>
				</div>

			<?php endif ?>
		<?php endforeach ?>
	</div>
	<!-- Anzeige von Beiträgen in home -->

	<!-- All Featured Posts -->
	<div class="container-fluid py-5 bg-light shadow-lg">
		<div class="container">
			<div class="text-center py-5 lead fs-3">Empfohlen</div>
			<div class="row">
				<?php echo Featured::menue(CONTENT_DIR); ?>
			</div>
		</div>
	</div>
	<!-- All Featured Posts -->

	<!-- Content -->
	<div class="container py-5">
      	<article>
        	<?php echo $content; ?>
      		<?php include('meta-line.php'); ?>
      	</article>
    </div>
	<!-- Content -->

  	<?php include('footer.php'); ?>

</body>
</html>