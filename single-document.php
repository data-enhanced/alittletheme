<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage aLittle320andUpTheme
 * @since aLittle320andUpTheme 1.0
 */

get_header(); ?>

<div id="primary-wrap">
<div id="primary">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	// usually needed
	global $custom_metabox;
	 
	// get the meta data for the current post
	$custom_metabox->the_meta();
	$multi = $custom_metabox->the_meta();
	$panels = $multi['panel'];
	$images = $multi['images'];
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>

			<?php the_post_thumbnail(); ?>

			<div class="entry-meta">
				<?php alittle_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
			<?php if($images) { ?>	
				<h3>Sample Images</h3>
				<div id="images">
					<ul>
						<?php $i=1; ?>	
						<?php foreach($images as $k => $v) { ?>
								<li>
									<img src="<?php echo $v['sample_image']; ?>"/>				
								</li>							
						
						<?php $i++; } ?>
					
					</ul>
				</div><!-- closes #slideshow -->					
			<?php } // ends if/panels ?>	

				<h3>Custom Fields</h3>
				<p><strong>Categories: </strong><?php echo $custom_metabox->the_value('categories');?><br/>
				<p><strong>Era: </strong><?php echo $custom_metabox->the_value('type');?><br/>
				<p><strong>Title: </strong><?php echo $custom_metabox->the_value('title');?><br/>
				<strong>Description: </strong><?php echo $custom_metabox->the_value('description');?><br/>
				<strong>Author: </strong><?php echo $custom_metabox->the_value('author');?><br/>
				<p><strong>Still alive?</strong><?php echo ucfirst($custom_metabox->the_value('alive'));?><br/>
				<strong>Author: </strong><?php echo $custom_metabox->the_value('author');?><br/>
				<strong>Year Published: </strong><?php echo $custom_metabox->the_value('date_published');?><br/>
				</p>
			
			<?php if($panels) { ?>	
				<h3>Slideshow</h3>
				<div id="slideshow">
					<ul>
						<?php $i=1; ?>	
						<?php foreach($panels as $k => $v) { ?>
								<li>
									<?php echo $v['panel']; ?>				
								</li>							
						
						<?php $i++; } ?>
					
					</ul>
				</div><!-- closes #slideshow -->					
			<?php } // ends if/panels ?>	
				
				<h3>The content</h3>
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'boilerplate' ), 'after' => '' ) ); ?>
			</div><!-- .entry-content -->
<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
			<footer id="entry-author-info">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'alittle_author_bio_avatar_size', 60 ) ); ?>
				<h2><?php printf( esc_attr__( 'About %s', 'boilerplate' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php printf( __( 'View all posts by %s &rarr;', 'boilerplate' ), get_the_author() ); ?>
				</a>
			</footer><!-- #entry-author-info -->
<?php endif; ?>
			<footer class="entry-utility">
				<?php alittle_posted_in(); ?>
				<?php edit_post_link( __( 'Edit', 'boilerplate' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-utility -->
		</article><!-- #post-## -->
		<nav id="nav-below" class="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'boilerplate' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'boilerplate' ) . '</span>' ); ?></div>
		</nav><!-- #nav-below -->
		<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>

</div><!-- end #primary -->
</div><!-- end #primary-wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>