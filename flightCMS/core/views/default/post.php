<?php include('head.php'); ?>

	<div class="container-fluid bg-light py-3 shadow">
      	<div class="container">
			<div class="row">
				<div class="col-sm-1">
					<a href="/"><img src="<?php echo $logo; ?>" class="img-fluid"></a>
				</div>
				<div class="col-sm-11 my-auto">
					<h1 class="fw-bold"><?php echo $title; ?></h1>
				</div>
			</div>
      	</div>
  	</div>

  	<div class="container py-5">
      	<div class="row">
          	<div class="col-sm-9">
				<article>
  					<p class="lead py-5"><?php echo $description; ?></p>
      
      				<?php echo Flight::hook('beforeParseContent', ''); ?>

					<?php echo TableOfContents::toc($content); ?>
  					<?php echo $content; ?>
					<?php echo AddAuthor::addAuthor(); ?>
					<?php include('meta-line.php'); ?>
				</article>
          	</div>
          	<div class="col-sm-3">
              	<h3 class="py-5">Beiträge <sup><a href="/plugins/flightcms-plugin-sidebar"><i class="bi bi-plug-fill"></i></a></sup></h3>
              	<?php echo Sidebar::menue(CONTENT_DIR); ?>
          	</div>
		</div>
	</div>

</body>
</html>