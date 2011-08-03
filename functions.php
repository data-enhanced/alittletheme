<?php
/**
 * aLittle320andUpTheme functions and definitions
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage aLittle320andUpTheme
 * @since aLittle320andUpTheme 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run alittle_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'alittle_setup' );

if ( ! function_exists( 'alittle_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override alittle_setup() in a child theme, add your own alittle_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function alittle_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Uncomment if you choose to use post thumbnails; add the_post_thumbnail() wherever thumbnail should appear
	//add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'alittle', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'alittle' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to alittle_header_image_width and alittle_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'alittle_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'alittle_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See alittle_admin_header_style(), below.
	add_custom_image_header( '', 'alittle_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/starkers.png',
			'thumbnail_url' => '%s/images/headers/starkers-thumbnail.png',
			/* translators: header image description */
			'description' => __( 'alittle', 'alittle' )
		)
	) );
}
endif;

if ( ! function_exists( 'alittle_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in alittle_setup().
 *
 * @since Twenty Ten 1.0
 */
function alittle_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 * 	vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */
function alittle_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'alittle' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'alittle' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'alittle' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'alittle_filter_wp_title', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function alittle_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'alittle_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function alittle_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'alittle_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function alittle_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading', 'alittle' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and alittle_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function alittle_auto_excerpt_more( $more ) {
	return ' &hellip;' . alittle_continue_reading_link();
}
add_filter( 'excerpt_more', 'alittle_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function alittle_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= alittle_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'alittle_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function alittle_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'alittle_remove_gallery_css' );

if ( ! function_exists( 'alittle_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own alittle_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function alittle_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
<!-- 				<?php echo get_avatar( $comment, 40 ); ?> -->
				<?php printf( __( '%s <span class="says">says:</span>', 'alittle' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'alittle' ); ?></em>
				<br />
			<?php endif; ?>
			<footer class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'alittle' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'alittle' ), ' ' );
				?>
			</footer><!-- .comment-meta .commentmetadata -->
			<div class="comment-body"><?php comment_text(); ?></div>
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-##  -->
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'alittle' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'alittle'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override alittle_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function alittle_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'alittle' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'alittle' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'alittle' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'alittle' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'alittle' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'alittle' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'alittle' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running alittle_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'alittle_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function alittle_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'alittle_remove_recent_comments_style' );

if ( ! function_exists( 'alittle_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function alittle_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'alittle' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'alittle' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'alittle_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function alittle_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'alittle' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'alittle' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'alittle' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/*	Begin alittle */
	// Add Admin
/* DC 2011.07.04 DISABLING alittle ADMIN 
	-- ADDING LINKS TO FILE MANUALLY IN HEADER.PHP AND FOOTER.PHP */
//		require_once(TEMPLATEPATH . '/alittle-admin/admin-menu.php');

	// remove version info from head and feeds (http://digwp.com/2009/07/remove-wordpress-version-number/)
		function alittle_complete_version_removal() {
			return '';
		}
		add_filter('the_generator', 'alittle_complete_version_removal');
/*	End alittle */

// add category nicenames in body and post class
	function alittle_category_id_class($classes) {
	    global $post;
	    foreach((get_the_category($post->ID)) as $category)
	        $classes[] = $category->category_nicename;
	        return $classes;
	}
	add_filter('post_class', 'alittle_category_id_class');
	add_filter('body_class', 'alittle_category_id_class');

// change Search Form input type from "text" to "search" and add placeholder text
	function alittle_search_form ( $form ) {
		$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
		<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
		<input type="search" placeholder="Search for..." value="' . get_search_query() . '" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
		</div>
		</form>';
		return $form;
	}
	add_filter( 'get_search_form', 'alittle_search_form' );

// added per WP upload process request
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
}

/* DC Custom Functions */

// ---------------------------------------------
// 	Strip out width/height on images
// ---------------------------------------------
add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// ---------------------------------------------
// 	Detect mobile browsers and provide a variable to test against
// ---------------------------------------------
session_start(); 
function device_capability() { 
	
// Some variables
	$width = 800; /* Under this is mobile, over is desktop */
	$cookie_expires = 365; /* Ammount of days it takes the cookie to expire */
		
// Default device set . 1 = that's the one
	$test_basic = 1; 
	$test_mobile = 0;
	$test_desktop = 0;
	$test_touch = 0;

/*
	To switch on the front end, simply add one of these to the end of a URL and when the 
	user clicks on it, it will override the automagical detection:
	?device=1 (or true, or blah blah blah. As long as the value is set)
	For example, all the links below will work: 
	
	<h3>Switch To..</h3>
	<ul>
		<li><a href="/?basic=1">Basic</a></li>
		<li><a href="/?mobile=yes">Mobile</a></li>
		<li><a href="/?full=true">Full</a></li>
	</ul>
	
	If for some reason, the url already has a ? in it, just use &:
	<li><a href="/?get=woot&full=1">Desktop</a></li>
	
*/
	
	// we need our functions that we'll be using for the rest of the scripts
	?> 
			<script type="text/javascript">function setCookie(c_name,value,exdays){var exdate=new Date();exdate.setDate(exdate.getDate()+exdays);var c_value=escape(value)+((exdays==null)?"":"; expires="+exdate.toUTCString());document.cookie=c_name+"="+c_value}function getCookie(c_name){var i,x,y,ARRcookies=document.cookie.split(";");for(i=0;i<ARRcookies.length;i++){x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);x=x.replace(/^\s+|\s+$/g,"");if(x==c_name){return unescape(y)}}}function HasClassName(objElement,strClass){if(objElement.className){var arrList=objElement.className.split(' ');var strClassUpper=strClass.toUpperCase();for(var i=0;i<arrList.length;i++){if(arrList[i].toUpperCase()==strClassUpper){return true}}}return false}</script> 
	<?php 
	
// FIRST, have we been through this before? If not, time to process.
	if(!isset($_SESSION['tested']) && !isset($_COOKIE['tested'])) { ?>
		
		<script type="text/javascript">
			
		// OK, NOW down to business. first step, are cookies even usable? 
			setCookie("cookies_enabled","yes",<?php echo $cookie_expires; ?>);

			if(getCookie('cookies_enabled')) {
		
				// So we're not basic. Well then, let's figure out the size	
				var screen_width = window.innerWidth;
				
			// Now, are we dealing with a higher density pixel count? We're targeting 800 REAL pixels. Yes, I'm talking to you Android and iPhone 4	
				var ppi = window.devicePixelRatio;
											
				if(typeof ppi == "undefined") {
					// should be dealing with a 1 ratio browser here
					var width = screen_width;
				} else {
					// Determine the real width				
					var width = screen_width/ppi;			
				}
				
			// Set them cookies
				setCookie("width",screen_width,<?php echo $cookie_expires; ?>);
				setCookie("trueWidth",width,<?php echo $cookie_expires; ?>);
				setCookie("pixelDensity",ppi,<?php echo $cookie_expires; ?>);
				setCookie("smart","yes",<?php echo $cookie_expires; ?>);
				
				// It's a small browser if 
				if(width < <?php echo $width; ?>) {
					setCookie("browser","mobile",<?php echo $cookie_expires; ?>);
				} else {
					setCookie("browser","desktop",<?php echo $cookie_expires; ?>);
				}
			
			// If this isn't set, we have to reload the page so that PHP can read the coookies
				var tested = getCookie('tested'); 
			
				if(!tested) {
					setCookie("tested","yes",<?php echo $cookie_expires; ?>);
					window.location = window.location;
				}
			
			}

		</script>
	
	<?php 		
		// ok, let's tell it we've already tested and move on.
		$_SESSION['tested'] = 'yes';	
	} // end if tested check

	// So, we've tested. Translate that to PHP
		if(isset($_COOKIE['smart'])) {
			$test_basic = 0;
		}
		
		// Mobile or desktop? If the cookie's set, let's tell PHP
		if(isset($_COOKIE['browser'])) {
			switch ($_COOKIE['browser']) {
			    case 'desktop':
					$test_desktop = 1;
			        break;
			    case 'mobile':
					$test_mobile = 1;
			        break;
			 }       
		}

	// Touch? 
		if(isset($_COOKIE['touch'])||isset($_SESSION['touch'])) {
			$_SESSION['touch'] = true;
			$test_touch = 1;
		}

	
// So, we've tested. But, does the user want us to override? 
	// All the possiblities ... 
		$set_basic = strip_tags($_GET['basic']);
		$set_mobile = strip_tags($_GET['mobile']);
		$set_desktop = strip_tags($_GET['full']);

		// if any one of those are set, set the override
		if($set_basic) {
			$_SESSION['override'] = 'basic';				
		} elseif($set_mobile) {
			$_SESSION['override'] = 'mobile';				
		} elseif($set_desktop) {
			$_SESSION['override'] = 'full';				
		}
	
	// If there's an override, reset everything and go with the override	
		if(isset($_SESSION['override'])) {
		
			// let's just reset this stuff to be safe
			$test_basic = 0;
			$test_mobile = 0;
			$test_desktop = 0;
						
			switch ($_SESSION['override']) {
			    case 'basic':
					$test_basic = 1;
			        break;
			    case 'mobile':
					$test_mobile = 1;
			        break;
			    case 'full':
					$test_desktop = 1;
			        break;
			}
			
			// update cookie		
		?>
			<script type="text/javascript">				
				
				var override = "<?php echo $_SESSION['override']; ?>";
				if(override.length > 0) {
					setCookie("browser",override,<?php echo $cookie_expires; ?>);
				}
			</script>
		<?php }// end if override ?>

		<script type="text/javascript">				
			// are we touch? 
			var check = document.getElementsByTagName('html');
			var has = HasClassName(check[0],'touch');

			if(has) {
				setCookie("touch","yes",<?php echo $cookie_expires; ?>);
			} 
		</script>

<?php
	// NOW we finally get to set the constants. 	
		define("BASIC",$test_basic);
		define("MOBILE",$test_mobile);
		define("TOUCH",$test_touch);
		define("DESKTOP",$test_desktop);
	
	// here's some debugging code down here. Comment/uncomment as needed. 
/*
		if(BASIC) {
				echo "I'm BASIC<br/>";
			} 
			
		if(MOBILE) {
			echo "I'm MOBILE<br/>";
		} 

		if(TOUCH) {
			echo "I'm TOUCH<br/>";
		} 
		
		if(DESKTOP) {
			echo "I'm DESKTOP<br/>";
		}
		echo "Supposed Width:".$_COOKIE['width'].'<br/>';
		echo "Pixel Density:".$_COOKIE['pixelDensity'].'<br/>';
		echo "True Width:".$_COOKIE['trueWidth'].'<br/>';
		
*/
			
}
add_action('wp_head', 'device_capability');




// ---------------------------------------------
// Custom Post Types
// ---------------------------------------------

add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
	register_post_type( 'document',
		array(
			'description' => __( 'A document is super duper!s' ),			
			'labels' => array(
				'name' => __( 'Documents' ),
				'singular_name' => __( 'Document' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Document' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Document' ),
				'new_item' => __( 'New Document' ),
				'view' => __( 'View Documents' ),
				'view_item' => __( 'View Document' ),
				'search_items' => __( 'Search Documents' ),
				'not_found' => __( 'No documents found' ),
				'not_found_in_trash' => __( 'No documents found in Trash' ),
				'parent' => __( 'Parent Document' ),			
			),
			'public' => true,
			'menu_position' => 20,
/* 			'menu_icon' => get_stylesheet_directory_uri() . '/images/super-duper.png', */
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}

// include the class in your theme or plugin
include_once 'wpalchemy/MetaBox.php';
include_once 'wpalchemy/MediaAccess.php';
 
// include css to help style our custom meta boxes
if (is_admin()) { 
	wp_enqueue_style('custom_meta_css', get_bloginfo('stylesheet_directory') . '/css/meta.css');
	wp_enqueue_script('jquery_livequery', get_bloginfo('stylesheet_directory') . '/js/jquery.livequery.js'); 
}
 
$custom_upload = new WPAlchemy_MediaAccess();

$custom_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'title' => 'Document Details',
	'types' => array('document'),
	'template' => STYLESHEETPATH . '/wpalchemy/metaboxes/template-documents.php'
));

// add the right enctype
if ( is_admin() ) {
    function add_post_enctype() {
        echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('#post').attr('enctype','multipart/form-data');
                  });
              </script>";
    }
    add_action('admin_head', 'add_post_enctype');
} 
?>