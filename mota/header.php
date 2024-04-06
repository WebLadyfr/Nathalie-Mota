<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body>

<header class="main-menu">
<a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">
				<img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/Nathalie-Mota.png" 
				alt="Logo <?php echo bloginfo('name'); ?>">
			</a>

   <nav id="menu">
   <?php
     wp_nav_menu(array(
	'theme_location' => 'primary',
	'menu_class' => 'menu',
	));
   ?>
   </nav>
</header>