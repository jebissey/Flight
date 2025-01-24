<?php include('head.php'); ?>

    <div class="container-fluid bg-primary py-5 shadow text-light">
        <div class="container">
            <div class="row">
				<div class="col-sm-6 text-center">
					<a href="/"><img src="<?php echo $logo; ?>" class="img-fluid w-75"></a>
				</div>
				<div class="col-sm-6 my-auto">
					<h1 class="fw-bold"><?php echo $title; ?></h1>
                    <hr class="my-5">
                    <p class="lead"><?php echo $description; ?></p>
				</div>
			</div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row mb-5">

			<div class="col-sm-9">
				<div class="row">

					<!-- Pages in Folder -->
        			<?php foreach($pages as $url=>$page): ?>
    					<div class="col-sm-4">
          					<div class="text-center"><img src="<?php echo $page['logo'];?>" class="img-fluid w-50"></div>
							<h2 class="fs-5"><a href="<?php echo $page['url']; ?>"><?php echo $page['title']; ?></a></h2>
              				<p class="fs-6"><?php echo $page['description']; ?></p>
      					</div>
      				<?php endforeach ?>
					<!-- Pages in Folder -->

					<!-- Index.md Content -->
					<article>
        				<?php echo $content; ?>
					</article>
					<!-- Index.md Content -->

				</div>
			</div>

			<div class="col-sm-3">
				<!--                      Titl, Descr, Logo -->
              	<?php echo Sidebar::menue(true, false, false); ?>
          	</div>

        </div>

    </div>

  	<?php include('footer.php'); ?>
  
</body>
</html>