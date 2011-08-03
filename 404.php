<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage aLittle320andUpTheme
 * @since aLittle320andUpTheme 1.0
 */

get_header(); ?>

<div id="primary-wrap">
<div id="primary">

			<article id="post-0" class="post error404 not-found" role="main">
				<h1><?php _e( 'Not Found', 'boilerplate' ); ?></h1>
				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'boilerplate' ); ?></p>
				<?php get_search_form(); ?>
				<script>
					// focus on search field after it has loaded
					document.getElementById('s') && document.getElementById('s').focus();
				</script>
			</article>

</div><!-- end #primary -->
</div><!-- end #primary-wrap -->			

<?php get_footer(); ?>
