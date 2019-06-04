<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

    <link href="<?php echo get_template_directory_uri(); ?>/library/img/favicon.png" rel="shortcut icon">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

	<header class="row container">
		<div class="left-nav col6">
			<a href="/">Graphic and Media Design<br/>
			Degree Show 2018</a>
		</div>

		<nav role="navigation" class="col6" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php wp_nav_menu(array(
								 'container' => false,                           // remove nav container
								 'container_class' => 'menu',                 // class of container (should you choose to use it)
								 'menu' => __( 'Header Nav' ),  // nav name
								 'menu_class' => 'nav right-nav',               // adding custom nav class
								 'theme_location' => 'main-nav',                 // where it's located in the theme
								 'before' => '',                                 // before the menu
											 'after' => '',                                  // after the menu
											 'link_before' => '',                            // before each link
											 'link_after' => '',                             // after each link
											 'depth' => 0,                                   // limit the depth of the nav
								 'fallback_cb' => ''                             // fallback function (if there is one)
			)); ?>
		</nav>
	</header>

	<header class="mobile-header">
		<div class="mobile-header-title"><a href="/">GMD LCC <span class="mobile-header-slash">/</span> Salon XVIII</a></div>
		<a href="#index" class="header-icon"><img class="icon-white" src="<?php echo get_template_directory_uri(); ?>/library/img/index_icon_white.svg"><img class="icon-pink" src="<?php echo get_template_directory_uri(); ?>/library/img/index_icon.svg"></a>
	</header>
