			</div><!-- .container -->
		</section><!-- #content -->
		<footer id="sitefooter" role="contentinfo">
		<div class="container">
		<?php
			/* A sidebar in the footer? Yep. You can can customize
			 * your footer with four columns of widgets.
			 */
			get_sidebar( 'footer' );
		?>
			<section id="copyright">
					<?php echo 'Copyright &copy;2010&ndash;' . date("Y"); ?> <span class="sitelogo"><a id="footerlogo" href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			</section>
			<section id="credits">
			</section>
		</div><!-- container -->
		</footer><!-- footer -->

<!-- JAVASCRIPT FILES -->
	<!-- JQUERY FROM GOOGLE WITH LOCAL FALLBACK -->
		<!-- from mobile boilerplate -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.js">\x3C/script>')</script>

	<!-- SCRIPTS FOR PLUGINS -->
		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/plugins.js"></script>
	<!-- Mobile Boilerplate Helper Scripts -->
		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/mbphelper.js"></script>
	<!-- SCRIPT-STARTER -->
		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/script-starter.js"></script>
	<!-- END JAVASCRIPT FILES -->
	
	<?php if(DESKTOP) { ?>
		<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/desktop.js"></script>
	<?php } ?>

<?php
	wp_footer();
?>
	</body>
</html>