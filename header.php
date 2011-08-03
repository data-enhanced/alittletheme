<?php
/**
 * Displays all of the <head> section and everything up to <section id="maincontent">
 *
 * @package WordPress
 * @subpackage aLittle320andUpTheme
 * @since aLittle320andUpTheme 1.0
 * 
 * Markup based on Mobile Boilerplate v1.1
 * and HTML5 Boilerplate v1.0
 */
?><!doctype html>

<!-- If Mobile touch ... -->

<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> 
	<!-- ... UNCOMMENT HERE ...
		<html class="no-js" manifest="default.appcache?v=1"> 
	... AND HERE --> 
	<!--<![endif]-->

<!-- If Desktop -->

<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

	  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
	       Remove this if you use the .htaccess -->
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		

		<title><?php
				/* see alittle_filter_wp_title() in functions.php */
				wp_title( '|', true, 'right' );
			?></title>

	<!-- http://t.co/y1jPVnT -->
	<link rel="canonical" href="/">

	<?php if(MOBILE) { ?>
	  <!-- Mobile viewport optimization http://goo.gl/b9SaQ -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320"/>

		<!-- For iPhone 4 -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/icons/h/apple-touch-icon.png">
		<!-- For iPad 1-->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/icons/m/apple-touch-icon.png">
		<!-- For iPhone 3G, iPod Touch and Android -->
		<link rel="apple-touch-icon-precomposed" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/icons/l/apple-touch-icon-precomposed.png">
		<!-- For Nokia -->
		<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/icons/l/apple-touch-icon.png">
		<!-- For everything else -->
		<link rel="shortcut icon" href="/favicon.ico">
		
		<!--iOS. Delete if not required -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<link rel="apple-touch-startup-image" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/icons/splash.png">
		
		<!--Microsoft. Delete if not required -->
		<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
	<?php } ?>

		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

		
<!-- STYLESHEET -->
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!-- MODERNIZR AND RESPOND.JS -->	

		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/modernizr.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/respond.js"></script>

<!-- WORDPRESS -->

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
		/* to support sites with threaded comments (when in use). */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		wp_head();
?>
	</head>
	<body <?php body_class('clearfix'); ?>>
		<header id="siteheader" role="banner" class="clearfix">
		<div class="container">
			<h1 class="sitelogo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="mainlogo"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
									
			<?php // SEARCH FORM
					get_search_form(); ?>
		</div><!-- /.container -->
		</header>
		<nav id="access" role="navigation" class="cf">
			<div class="container">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<a id="skip" href="#maincontent" title="<?php esc_attr_e( 'Skip to content', 'alittle' ); ?>"><?php _e( 'Skip to content', 'alittle' ); ?></a>
	<!-- MAIN NAV -->
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- .container -->
		</nav><!-- #access -->

		<section id="maincontent" role="main" class="clearfix">
			<div class="container">
