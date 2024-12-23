<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo('charset'); ?>" />
	<?php wp_head(); ?>
</head>
<?php $header_group = get_setting_field('header_group') ?? []; ?>

<body <?php body_class(); ?>>
	<header class="container-fluid p-0 position-sticky top-0">
		<div class="bg-dark header-strip d-md-block d-none">
			<div class="container h-100">
				<div class="row align-items-center bg-dark h-100">
					<div class="col-10">
						<div class="text"><?= $header_group['top_header_news_text_strip'] ?? ''; ?></div>
					</div>
					<div class="col-2 d-flex align-items-center gap-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#wpml-change-language-modal">
						<?= get_language_selector_html() ?>
					</div>
				</div>
			</div>
		</div>
		<nav class="header-main navbar navbar-expand-lg navbar-light bg-white">
			<div class="container">
				<a class="navbar-brand me-5 pe-4" href="<?= home_url(); ?>">
					<img src="<?= $header_group['main_website_logo']['url'] ?? '' ?>" alt="metzer-logo" class="metzer-logo">
				</a>
				<div class="d-flex gap-3">
					<div class="mobile-lang-switcher d-md-none d-flex align-items-center gap-1">
						<?= get_language_selector_html() ?>
					</div>
					<button class="navbar-toggler border-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon color-dark"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse position-relative" id="navbarNav">
					<button type="button" class="btn-close btn-close-menu align-self-end mt-3 me-3 d-md-none position-absolute end-0" aria-label="Close" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"></button>

					<?php
					wp_nav_menu(array(
						'theme_location' => 'header',
						'container'      => false,
						'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0 w-100 align-items-md-center gap-3 mt-md-0 mt-5',
						'fallback_cb'    => '__return_false',
						'depth'          => 3,
						'walker'         => new Bootstrap_NavWalker(),
					));
					?>
				</div>
				<div class="navbar-overlay"></div>

			</div>
		</nav>
	</header>