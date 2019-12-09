<?php defined( '_JEXEC' ) or die; ?>
<?php include_once JPATH_THEMES.'/'.$this->template.'/logic.php'; ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
	<?php if(isset($_COOKIE['cb-enabled']) AND $_COOKIE['cb-enabled'] == 'accepted') : ?>
		<?= $tag_head ?>
	<?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<jdoc:include type="head" />
</head>
<body>

	<?php if(isset($_COOKIE['cb-enabled']) AND $_COOKIE['cb-enabled'] == 'accepted') : ?>
		<?= $tag_body ?>
	<?php endif; ?>

	<?php if ($this->countModules('overlay')) : ?>
		<jdoc:include type="modules" name="overlay" />
	<?php endif; ?>

	<div class="site-wrap">
	  <ul class="list-unstyled mb-0 skip-link">
	    <li class="text-center goto-burger"><a href="#open-button" accesskey="1" title="<?php echo JText::_('TPL_LIGHT_SKIPLINK_GOTO_MENU') ?>" class="page-scroll"><?php echo JText::_('TPL_LIGHT_SKIPLINK_GOTO_MENU') ?></a></li>
	    <li class="text-center goto-content"><a href="#main-content" accesskey="2" title="<?php echo JText::_('TPL_LIGHT_SKIPLINK_GOTO_CONTENT') ?>" class="page-scroll"><?php echo JText::_('TPL_LIGHT_SKIPLINK_GOTO_CONTENT') ?></a></li>
	  </ul>

	  <header>
			<?php if ($this->countModules('htop')) : ?>
	    <div class="header-top">
	      <div class="container">
	        <div class="row">
						<?php //if ($this->countModules('htop-left')) : ?>
							<!-- <nav class="col-2 col-lg-7 htop-left d-flex justify-content-start top-nav navbar-expand-lg">
								<button class="navbar-toggler" type="button" data-toggle="offcanvas-collapse">
									<i class="fal fa-bars"></i>
							  </button>
								<div class="navbar-collapse offcanvas-collapse" id="top-nav">
		              <jdoc:include type="modules" name="htop-left" />
								</div>
							</nav> -->
							<!-- <nav class="col htop-left d-flex justify-content-start">
	              <jdoc:include type="modules" name="htop-left" />
							</nav> -->
						<?php //endif; ?>
						<?php //if ($this->countModules('htop')) : ?>
						<div class="col htop d-flex justify-content-end">
							<jdoc:include type="modules" name="htop" />
						</div>
						<?php //endif; ?>
	        </div>
	      </div>
	    </div><!-- end .header-top -->
			<?php endif; ?>

			<?php if ($this->countModules('navbar')) : ?>
	    <div class="header-nav">
	      <div class="container">
					<nav class="navbar navbar-expand-lg navbar-light bg-faded">
						<a href="<?php echo JURI::base() ?>" class="navbar-brand" title="<?= $sitename ?>">
							<?php if(isset($logo) AND $logo != '') : ?>
								<img src="<?php echo $logo ?>" alt="<?php echo $sitename ?>">
							<?php else : ?>
								<img src="http://logo.pizza/img/tri-arc/tri-arc-connected.svg" width="50" height="50" alt="<?php echo $siteName ?>">
							<?php endif; ?>
							<h1 class="sitename"><?php echo $sitename ?></h1>
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#meganav" aria-controls="meganav" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fal fa-bars"></i>
							<span class="navbar-toggler-text"><?= JText::_('TPL_LIGHT_NAVIGATION') ?></span>
					  </button>
	          <div class="collapse navbar-collapse" id="meganav">
	            <jdoc:include type="modules" name="navbar" />
	          </div>
	        </nav>
	      </div>
	    </div>
			<?php endif; ?>
	  </header>

	  <?php if ($this->countModules('hero')) : ?>
	    <jdoc:include type="modules" name="hero" />
	  <?php endif; ?>

	  <?php if($this->countModules('breadcrumbs')) : ?>
	    <jdoc:include type="modules" name="breadcrumbs" />
	  <?php endif; ?>

		<?php if($this->countModules('nav-component')) : ?>
			<div class="nav-component bg-light">
				<div class="container">
					<jdoc:include type="modules" name="nav-component" />
				</div>
			</div>
	  <?php endif; ?>

	  <!-- posizione di supporto - before component -->
	  <?php if($this->countModules('position-1')) : ?>
	    <jdoc:include type="modules" name="position-1" />
	  <?php endif; ?>
	  <!-- posizione di supporto - before component -->

		<jdoc:include type="message" />

	  <main id="main-content">
	    <jdoc:include type="component" />
	  </main>

	  <!-- posizione di supporto - after component -->
	  <?php if($this->countModules('position-2')) : ?>
	    <jdoc:include type="modules" name="position-2" />
	  <?php endif; ?>
	  <!-- posizione di supporto - after component -->

	  <footer class="wrapper footer">
	    <div class="container footer-wrapper">
	      <div class="row footer-sitename">
	        <div class="col-12 d-flex align-items-center">
	          <?php if(isset($logo) AND $logo != '') : ?>
	            <img src="<?php echo $logo ?>" class="rounded img-fluid float-left mr-3" alt="<?php echo $siteName ?>">
	          <?php else : ?>
	            <img src="http://logo.pizza/img/tri-arc/tri-arc-connected.svg" width="80" height="80" class="rounded img-fluid float-left mr-3" alt="<?php echo $siteName ?>">
	          <?php endif; ?>
	          <p><?= $sitename ?></p>
	        </div>
	      </div>

	      <?php if ($this->countModules('footer-bottom')) : ?>
	      <div class="row footer-bottom">
	        <jdoc:include type="modules" name="footer-bottom" style="footer" />
	      </div>
	      <?php endif; ?>
	    </div>
			<div class="footer-links">
				<div class="container">
					<div class="row">
						<?php if ($this->countModules('footer-links')) : ?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-6">
								<jdoc:include type="modules" name="footer-links" />
							</div>
						<?php endif; ?>
						<div class="col-12 col-sm-12 col-md-12 col-lg">
							<?php echo JLayoutHelper::render('joomla.content.spedisrl'); ?>
						</div>
					</div>
				</div>
			</div>
	  </footer>
	</div>

	<?php if($aos) : ?>
		<script src="<?php echo TPATH ?>/dist/aos/aos.js"></script>
		<script> AOS.init(); </script>
	<?php endif; ?>
</body>
</html>
