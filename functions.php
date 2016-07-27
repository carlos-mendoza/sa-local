<?php
/*

 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/**
 * Twenty Fourteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}
require get_template_directory() . '/inc/theme-options.php';

if ( ! function_exists( 'sa_setup' ) ) :
/**
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 */
function sa_setup() {


	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', sa_font_url(), 'genericons/genericons.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'sa-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'sa' ),
		'top_menu' => __( 'Top Menu', 'sa' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	/*add_theme_support( 'custom-background', apply_filters( 'sa_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
/*	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'sa_get_featured_posts',
		'max_posts' => 6,
	) );*/

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // sa_setup
add_action( 'after_setup_theme', 'sa_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 */
function sa_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'sa_content_width' );

/**
 * Getter function for Featured Content Plugin.
 */
function sa_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 */
	return apply_filters( 'sa_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 */
function sa_has_featured_posts() {
	return ! is_paged() && (bool) sa_get_featured_posts();
}

/**
 * Register three Twenty Fourteen widget areas.
 *
 */
function sa_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'SA_Subpages_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'sa' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'sa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'sa' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'sa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'sa' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'sa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'sa_widgets_init' );

/**
 * Register Lato Google font for Twenty Fourteen.
 *
 */
function sa_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'sa' ) ) {
		$query_args = array(
			'family' => urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 */
function sa_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'sa-lato', sa_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );

	// Load our main stylesheet.
	wp_enqueue_style( 'sa-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'sa-ie', get_template_directory_uri() . '/css/ie.css', array( 'sa-style' ), '20131205' );
	wp_style_add_data( 'sa-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sa-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'sa-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'sa-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'sa' ),
			'nextText' => __( 'Next', 'sa' )
		) );
	}

	
}
add_action( 'wp_enqueue_scripts', 'sa_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function sa_admin_fonts() {
	wp_enqueue_style( 'sa-lato', sa_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'sa_admin_fonts' );

if ( ! function_exists( 'sa_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 */
function sa_the_attached_image() {
	$post                = get_post();
	/**
	 */
	$attachment_size     = apply_filters( 'sa_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'sa_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 */
function sa_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'sa' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 */
function sa_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'sa_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 */
function sa_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'sa_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 */
function sa_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'sa' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'sa_wp_title', 10, 2 );

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
/*if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}*/



function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}

add_filter('show_admin_bar', '__return_false');

function my_jquery_init() {
    wp_enqueue_script('jquery');
}    
add_action('init', 'my_jquery_init');



/** post types **/
add_action( 'init', 'sa_register_my_cpts' );
function sa_register_my_cpts() {
	$labels = array(
		"name" => __( 'Applications', 'sa-hq' ),
		"singular_name" => __( 'Application', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Applications', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => true,
        'menu_icon'=> 'dashicons-building',
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "application", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title"),				
	);
	register_post_type( "application", $args );

	$labels = array(
		"name" => __( 'Policies', 'sa-hq' ),
		"singular_name" => __( 'Policies', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Policies', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
        'menu_icon'=> 'dashicons-clipboard',
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "policies", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title", "page-attributes" ),				
	);
	register_post_type( "policies", $args );

	$labels = array(
		"name" => __( 'Team Members', 'sa-hq' ),
		"singular_name" => __( 'Team Member', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Team Members', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
        'menu_icon'=> 'dashicons-universal-access',
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "team-members", "with_front" => true ),
		"query_var" => true,
        //"menu_position"=>20,				
		"supports" => array( "title" ),				
	);
	register_post_type( "team-members", $args );

    
    $labels = array(
		"name" => __( 'Intentional Learning', 'sa-hq' ),
		"singular_name" => __( 'Intentional Learning', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Intentional Learning', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
        'menu_icon'=> 'dashicons-book-alt',
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "intentional-learning", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title" ),				
	);
	register_post_type( "intentional-learning", $args );
    
    
    	$labels = array(
		"name" => __( 'Core Values', 'sa-hq' ),
		"singular_name" => __( 'Core Values', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Core Values', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
        'menu_icon'=> 'dashicons-image-filter',
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "core-values", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title","excerpt", "editor"),				
	);
	register_post_type( "core-values", $args ); 

}

add_action( 'init', 'sa_register_my_cpts_glossaries' );
function sa_register_my_cpts_glossaries() {
	$labels = array(
		"name" => __( 'Glossary', 'sa-hq' ),
		"singular_name" => __( 'Glossary', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Glossary', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
        'menu_icon'=> 'dashicons-schedule',
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "glossaries", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title", "thumbnail" ),				
	);
	register_post_type( "glossaries", $args );
}


/** all taxonomy **/
add_action( 'init', 'sa_register_my_taxes' );
function sa_register_my_taxes() {
	$labels = array(
		"name" => __( 'Application Type', 'sa-hq' ),
		"singular_name" => __( 'Application Type', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Application Type', 'sa-hq' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Application Type",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'application-type', 'with_front' => true, 'hierarchical' => true ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "application-type", array( "application" ), $args );

	$labels = array(
		"name" => __( 'Policies Type', 'sa-hq' ),
		"singular_name" => __( 'Policies Type', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Policies Type', 'sa-hq' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Policies Type",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'policies-type', 'with_front' => true , 'hierarchical' => true ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "policies-type", array( "policies" ), $args );

	$labels = array(
		"name" => __( 'Department', 'sa-hq' ),
		"singular_name" => __( 'Department', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Department', 'sa-hq' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Department",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'department', 'with_front' => true, 'hierarchical' => true ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "department", array( "team-members" ), $args );

    
    $labels = array(
		"name" => __( 'Learning Type', 'sa-hq' ),
		"singular_name" => __( 'Learning Type', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Learning Type', 'sa-hq' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Learning Type",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'learning-type', 'with_front' => true , 'hierarchical' => true ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "learning-type", array( "intentional-learning" ), $args );

}


/** Home Page Fields **/
function custom_admin_scripts() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
    
    wp_enqueue_script('sa-chosen', get_template_directory_uri().'/js/chosen.jquery.js');
	wp_enqueue_style('jquery-chosen-sa', get_template_directory_uri().'/css/chosen.css');
    
	wp_enqueue_script('sa-js', get_template_directory_uri().'/js/custom-js.js');
	wp_enqueue_style('jquery-ui-sa', get_template_directory_uri().'/css/jquery-ui-custom.css');
}
add_action('admin_enqueue_scripts','custom_admin_scripts');

// add some custom js to the head of the page
add_action('admin_head','add_custom_scripts');
function add_custom_scripts() {
    /*
	global $custom_meta_fields, $post;
	
	$output = '<script type="text/javascript">
				jQuery(function() {';
	
	foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types
		// date
		if($field['type'] == 'date')
			$output .= 'jQuery(".datepicker").datepicker();';
		// slider
		if ($field['type'] == 'slider') {
			$value = get_post_meta($post->ID, $field['id'], true);
			if ($value == '') $value = $field['min'];
			$output .= '
					jQuery( "#'.$field['id'].'-slider" ).slider({
						value: '.$value.',
						min: '.$field['min'].',
						max: '.$field['max'].',
						step: '.$field['step'].',
						slide: function( event, ui ) {
							jQuery( "#'.$field['id'].'" ).val( ui.value );
						}
					});';
		}
	}
	
	$output .= '});
		</script>';
		
	echo $output;*/
}
function add_custom_meta_box() {
    global $post;
    $template_file = get_post_meta($post->ID,'_wp_page_template',TRUE);
    
 if ($template_file == 'page-templates/home-page.php') {
        add_meta_box(
    		'home_meta_box', // $id
    		'Home Page Fields', // $title 
    		'show_home_meta_box', // $callback
    		'page', // $page
    		'normal', // $context
    		'high'); // $priority
    }
    
     if ($template_file == 'page-templates/applications-page.php' 
     || $template_file == 'page-templates/glossary-page.php' 
     || $template_file == 'page-templates/p&p-page.php'
     || $template_file == 'page-templates/courses-list-page.php'
     || $template_file == 'page-templates/core-values.php'
     || $template_file == 'page-templates/courses-page.php' 
     || $template_file == 'page-templates/full-width.php'
     || $template_file == 'default'
     || $template_file == 'page-templates/directory-page.php') {
        add_meta_box(
    		'app_page_meta_box', // $id
    		'Page Fields', // $title 
    		'show_app_meta_box', // $callback
    		'page', // $page
    		'normal', // $context
    		'high'); // $priority
    }
    
    add_meta_box(
		'application_meta_box', // $id
		'Application Fields', // $title 
		'show_application_meta_box', // $callback
		'application', // $page
		'normal', // $context
		'high');
        
    add_meta_box(
	'glossaries_meta_box', // $id
	'Glossary Fields', // $title 
	'show_glossaries_meta_box', // $callback
	'glossaries', // $page
	'normal', // $context
	'high'); 
    
    add_meta_box(
	'team_meta_box', // $id
	'Team Fields', // $title 
	'show_teams_meta_box', // $callback
	'team-members', // $page
	'normal', // $context
	'high'); 
    
    add_meta_box(
    'policies_meta_box', // $id
    'Policy Fields', // $title 
    'show_policies_meta_box', // $callback
    'policies', // $page
    'normal', // $context
    'high');
    
     add_meta_box(
    'learning_meta_box', // $id
    'Learning Fields', // $title 
    'show_learning_meta_box', // $callback
    'intentional-learning', // $page
    'normal', // $context
    'high');
    
     add_meta_box(
    'core_calues_meta_box', // $id
    'User Type Field', // $title 
    'show_core_meta_box', // $callback
    'core-values', // $page
    'normal', // $context
    'high');
           
}
add_action('add_meta_boxes', 'add_custom_meta_box');


$args = array('post_type'=> 'application','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
$applications = get_posts($args);
$tpa = array();
if( $applications ) {
foreach ( $applications as $ap ) {
    $tpa[$ap->ID] = array ('label' => $ap->post_title,'value'	=> $ap->ID);
	}
}

global $wp_roles;
$user_role = array();
foreach ( $wp_roles->role_names as $role => $name ) {
    $user_role[$role] = array ('label' => $name,'value'	=> $role);
}

// Fields for Home Pages
$prefix = 'home';
$home_meta_fields = array(
	array(
		'label'	=> 'Quick Note',
		'desc'	=> '',
		'id'	=> $prefix.'_q_note',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Quick Note Title',
		'desc'	=> '',
		'id'	=> $prefix.'_q_note_title',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Learn More Button Text',
		'desc'	=> '',
		'id'	=> $prefix.'_learn_more_text',
		'type'	=> 'text',
        'value' => 'Learn More <i class="fa fa-long-arrow-right"></i>'
	),
    array(
		'label'	=> 'Learn More Button Link',
		'desc'	=> '',
		'id'	=> $prefix.'_learn_more_link',
		'type'	=> 'text',
        'value' => '#'
	),
	array(
		'label'	=> 'Learn More In New Tab',
		'desc'	=> 'Yes',
		'id'	=> $prefix.'_learn_more_ntab',
		'type'	=> 'checkbox',
        'value'	=> 'Yes'
	),
    
   	array(
		'label'	=> 'Applications Selection',
		'desc'	=> 'Select Maximum 8 Applications.',
		'id'	=> $prefix.'app_select',
		'type'	=> 'multi_select',
		'options' => $tpa
	),
    
   	array(
		'label'	=> 'View All App Link',
		'desc'	=> '',
		'id'	=> $prefix.'_view_all_app_link',
		'type'	=> 'text',
        'value'	=> '#'
	),
    array(
		'label'	=> 'Training Title',
		'desc'	=> '',
		'id'	=> $prefix.'_training_title',
		'type'	=> 'text',
        'value'	=> ''
	),
    array(
		'label'	=> 'View All Cources Title',
		'desc'	=> '',
		'id'	=> $prefix.'_all_training_cources',
		'type'	=> 'text',
        'value'	=> 'View All Courses <i class="fa fa-long-arrow-right"></i>'
	),
     array(
		'label'	=> 'View All Cources Link',
		'desc'	=> '',
		'id'	=> $prefix.'_all_cources_link',
		'type'	=> 'text',
        'value'	=> '#'
	),
);


// Fields for Pages
$prefix_app_page = 'app_page';
$app_page_meta_fields = array(
	array(
		'label'	=> 'Page Title',
		'desc'	=> '',
		'id'	=> 'page_title',
		'type'	=> 'text'
	),
    
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);


// Fields for Application Post type
$prefix_app = 'app_box';
$application_meta_fields = array(
	array(
		'label'	=> 'Application Description',
		'desc'	=> '',
		'id'	=> $prefix_app.'_desctiption',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Application Link',
		'desc'	=> '',
		'id'	=> $prefix_app.'_link',
		'type'	=> 'text'
	),
    
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);


// Fields for Glossary Post type
$prefix_glosary = 'app_gl';
$glossaries_meta_fields = array(
	array(
		'label'	=> 'Glossary Content',
		'desc'	=> '',
		'id'	=> $prefix_glosary.'_desctiption',
		'type'	=> 'textarea'
	),
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);

$core_values_meta_fields = array(
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);

// Fields for Team Members Post type
$prefix_team = 'team';
$teams_meta_fields = array(
	array(
		'label'	=> 'First Name',
		'desc'	=> '',
		'id'	=> $prefix.'_f_name',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Last Name',
		'desc'	=> '',
		'id'	=> $prefix.'_l_name',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Designation',
		'desc'	=> '',
		'id'	=> $prefix.'_designation',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Email',
		'desc'	=> '',
		'id'	=> $prefix.'_email',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Work',
		'desc'	=> '',
		'id'	=> $prefix.'_work',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Cell No.',
		'desc'	=> '',
		'id'	=> $prefix.'_cell_no',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'User Types',
		'desc'	=> '',
		'id'	=> $prefix.'_u_type',
		'type'	=> 'text'
	),
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);


// Fields for Policies Post type
$prefix_policy = 'policy';
$policy_meta_fields = array(
	array(
		'label'	=> 'Document Number',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_doc_type',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Effective Date',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_effective_date',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Revision Date',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_revision_date',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Revision Number',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_rev_no',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Approved By',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_approved_by',
		'type'	=> 'text'
	),
    array(
		'label'	=> '1.0 Purpose',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_purpose',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
     array(
		'label'	=> '2.0 Persons',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_persons',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
    array(
		'label'	=> '3.0 Policy',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_policy',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
    array(
		'label'	=> '4.0 Definitions',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_definitions',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
     array(
		'label'	=> '5.0 Responsibilities',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_responsibilities',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
    array(
		'label'	=> '6.0 Procedures',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_procedures',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
    array(
		'label'	=> '7.0 Approvals',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_approvals',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
     array(
		'label'	=> '8.0 Revision History',
		'desc'	=> '',
		'id'	=> $prefix_policy.'_revision_history',
		'type'	=> 'wysiwyg',
        'meta_id' => 'policies_meta_box'
	),
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);


// Fields for Learning Post type
$prefix_IL = 'il_box';
$leaning_meta_fields = array(
	array(
		'label'	=> 'Platform',
		'desc'	=> '',
		'id'	=> $prefix_IL.'_platform',
		'type'	=> 'text'
	),
    array(
		'label'	=> 'About',
		'desc'	=> '',
		'id'	=> $prefix_IL.'_about',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Link to Course',
		'desc'	=> '',
		'id'	=> $prefix_IL.'_link_course',
		'type'	=> 'text'
	),
    	array(
		'label'	=> 'Open Course in New Tab',
		'id'	=> $prefix_IL.'checkbox',
        'desc' => "Yes",
		'type'	=> 'checkbox'
	),
    
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);

// The Callback home page 
function show_home_meta_box() {
	global $custom_meta_fields, $post,$home_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($home_meta_fields);
}
// The Callback Application Post type
function show_application_meta_box() {
	global $custom_meta_fields, $post,$application_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($application_meta_fields);
}
// The Callback Page Fields
function show_app_meta_box() {
	global $custom_meta_fields, $post,$app_page_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($app_page_meta_fields);
}
// The Callback Glossaries Post type
function show_glossaries_meta_box() {
	global $custom_meta_fields, $post,$glossaries_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($glossaries_meta_fields);
}
// The Callback Team Members Post type
function show_teams_meta_box() {
	global $custom_meta_fields, $post,$teams_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($teams_meta_fields);
}
// The Callback Policies Post type
function show_policies_meta_box() {
	global $custom_meta_fields, $post,$policy_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($policy_meta_fields);
}
function show_learning_meta_box() {
	global $custom_meta_fields, $post,$leaning_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($leaning_meta_fields);
}

function show_core_meta_box() {
	global $custom_meta_fields, $post,$core_values_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_meta($core_values_meta_fields);
}


function display_meta($custom_fields){
    global $custom_meta_fields, $post;

    // Begin the field table and loop
	echo '<table class="form-table">';
        
	foreach ($custom_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
                    
                    case 'multi_select':
                            $meta = json_decode($meta);
                            
						echo '<select name="'.$field['id'].'[]" id="'.$field['id'].'" multiple class="multi_select">';
						foreach ($field['options'] as $option) {
							echo '<option',  in_array($option['value'] ,$meta) == true ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                        
					break;
                    
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
    					$items = get_posts( array (
    						'post_type'	=> $field['post_type'],
    						'posts_per_page' => -1
    					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '0';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/images/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
                    // wysiwyg
                    case 'wysiwyg':
                        $meta_box_id = $field['meta_id'];
                        $editor_id = $field['id'];
                        echo "<style type='text/css'>
                                        #$meta_box_id #edButtonHTML, #$meta_box_id #edButtonPreview {background-color: #F1F1F1; border-color: #DFDFDF #DFDFDF #CCC; color: #999;}
                                        #$editor_id{width:100%;}
                                        #$meta_box_id #editorcontainer{background:#fff !important;}
                                </style>
                            
                                <script type='text/javascript'>
                                        jQuery(function($){
                                                $('#$meta_box_id #editor-toolbar > a').click(function(){
                                                        $('#$meta_box_id #editor-toolbar > a').removeClass('active');
                                                        $(this).addClass('active');
                                                });
                                                
                                                if($('#$meta_box_id #edButtonPreview').hasClass('active')){
                                                        $('#$meta_box_id #ed_toolbar').hide();
                                                }
                                                
                                                $('#$meta_box_id #edButtonPreview').click(function(){
                                                        $('#$meta_box_id #ed_toolbar').hide();
                                                });
                                                
                                                $('#$meta_box_id #edButtonHTML').click(function(){
                                                        $('#$meta_box_id #ed_toolbar').show();
                                                });
                				//Tell the uploader to insert content into the correct WYSIWYG editor
                				$('#media-buttons a').bind('click', function(){
                					var customEditor = $(this).parents('#$meta_box_id');
                					if(customEditor.length > 0){
                						edCanvas = document.getElementById('$editor_id');
                					}
                					else{
                						edCanvas = document.getElementById('content');
                					}
                				});
                                        });
                                </script>
                        ";
                        
                        
                        $content = get_post_meta($post->ID, $field['id'], true);
                        $editor_settings = array('media_buttons' => false);
                        wp_editor($content, $editor_id, $editor_settings);
                        //wp_editor($content, $editor_id);                        
                        echo "<div style='clear:both; display:block;'></div>";
						
					break;
                    
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
				}
		echo '</td></tr>';
	} 
	echo '</table>'; 
}

// Save the Data
function save_sa_meta($post_id) {
    global $custom_meta_fields;
	global $home_meta_fields;
    global $application_meta_fields,$app_page_meta_fields,$glossaries_meta_fields,$teams_meta_fields,$policy_meta_fields,$leaning_meta_fields,$core_values_meta_fields;
    
	// verify nonce
	if (!isset( $_POST['custom_meta_box_nonce'] )  || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
    
  $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
  $post_tp = get_post_type($post_id);
  
    if ($template_file == 'page-templates/home-page.php') {        
    	foreach ($home_meta_fields as $field) {
    		if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	} 
    }
    
    if ($template_file == 'page-templates/applications-page.php' 
    || $template_file == 'page-templates/glossary-page.php' 
    || $template_file == 'page-templates/p&p-page.php'
    || $template_file == 'page-templates/courses-list-page.php'
    || $template_file == 'page-templates/core-values.php'
    || $template_file == 'page-templates/courses-page.php'
    || $template_file == 'page-templates/full-width.php'
    || $template_file == 'default'
    || $template_file == 'page-templates/directory-page.php') {
        foreach ($app_page_meta_fields as $field) {
    		if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
    
    
    if($post_tp == 'application'){ 
        foreach ($application_meta_fields as $field) {
    		if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
	
    if($post_tp == 'glossaries'){
        foreach ($glossaries_meta_fields as $field) {
    		if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
    
    if($post_tp == 'team-members'){
         foreach ($teams_meta_fields as $field) {
    		if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
     }
    if($post_tp == 'policies'){
         foreach ($policy_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
      if($post_tp == 'intentional-learning'){
         foreach ($leaning_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
     if($post_tp == 'core-values'){
         foreach ($core_values_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
    
   
   
	// save taxonomies
	/* $post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' ); */
}
add_action('save_post', 'save_sa_meta');



/** Taxonomy Policy Type **/

$prefix_p_type = 'policy_type';
global $wp_roles;
$user_role = array();
foreach ( $wp_roles->role_names as $role => $name ) {
    $user_role[$role] = array ('label' => $name,'value'	=> $role);
}
$p_type_meta_fields = array(
	array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);  

add_action( 'policies-type_add_form_fields', 'add_p_type_group_field', 10, 2 );
function add_p_type_group_field($taxonomy) {
    global $p_type_meta_fields;
	foreach ($p_type_meta_fields as $field) {
		$meta = "";
		echo '<div class="form-field term-group">
				<label for="'.$field['id'].'">'.$field['label'].'</label><div class="custom_checkbox">';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				
              
				}
		echo '</div></div>';
	} 
}


add_action( 'created_policies-type', 'save_policies_type', 10, 2 );
function save_policies_type( $term_id, $tt_id ){
    
        if( isset( $_POST['user_type'] ) && '' !== $_POST['user_type'] ){
        $group = $_POST['user_type'];
        add_term_meta( $term_id, 'user_type', $group, true );
    }
}


add_action( 'policies-type_edit_form_fields', 'edit_policies_type_field', 10, 2 );
function edit_policies_type_field( $term, $taxonomy ){
  global $feature_groups;

 global $p_type_meta_fields;
    
            
	foreach ($p_type_meta_fields as $field) {
		$feature_group = get_metadata( $term->term_id, $field['id'], true );
		$meta = $feature_group;
		echo '<tr class="form-field term-group-wrap"><th scope="row"><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				
              
				} 
		echo '</td></tr>';
	} 
}

add_action( 'edited_policies-type', 'update_policies_type', 10, 2 );
function update_policies_type( $term_id, $tt_id ){
        global $p_type_meta_fields;
        foreach ($p_type_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
            $old = get_metadata($term_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			 update_term_meta( $term_id, $field['id'], $new );
    		} elseif ('' == $new && $old) {
    			delete_term_meta($term_id, $field['id'], $old);
    		}
    	}
}
/** --Taxonomy Policy Type--  **/



/** Taxonomy learning-type Type **/

$prefix_p_type = 'lp_type';
global $wp_roles;
$user_role = array();
foreach ( $wp_roles->role_names as $role => $name ) {
    $user_role[$role] = array ('label' => $name,'value'	=> $role);
}
$lp_type_meta_fields = array(
	array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);  

add_action( 'learning-type_add_form_fields', 'add_lp_type_group_field', 10, 2 );
function add_lp_type_group_field($taxonomy) {
    global $lp_type_meta_fields;
	foreach ($lp_type_meta_fields as $field) {
		$meta = "";
		echo '<div class="form-field term-group">
				<label for="'.$field['id'].'">'.$field['label'].'</label><div class="custom_checkbox">';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				
              
				}
		echo '</div></div>';
	} 
}


add_action( 'created_learning-type', 'save_lp_type', 10, 2 );
function save_lp_type( $term_id, $tt_id ){
    
         if( isset( $_POST['user_type'] ) && '' !== $_POST['user_type'] ){
        $group = $_POST['user_type'];
        add_term_meta( $term_id, 'user_type', $group, true );
    }
    
}


add_action( 'learning-type_edit_form_fields', 'edit_lp_type_field', 10, 2 );
function edit_lp_type_field( $term, $taxonomy ){
  global $feature_groups;

 global $lp_type_meta_fields;
    
            
	foreach ($lp_type_meta_fields as $field) {
		$feature_group = get_metadata( $term->term_id, $field['id'], true );
		$meta = $feature_group;
		echo '<tr class="form-field term-group-wrap"><th scope="row"><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				
              
				} 
		echo '</td></tr>';
	} 
}

add_action( 'edited_learning-type', 'update_lp_type', 10, 2 );
function update_lp_type( $term_id, $tt_id ){
        global $lp_type_meta_fields;
        foreach ($lp_type_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
            $old = get_metadata($term_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			 update_term_meta( $term_id, $field['id'], $new );
    		} elseif ('' == $new && $old) {
    			delete_term_meta($term_id, $field['id'], $old);
    		}
    	}
}
/** --learning-type Type--  **/
function sa_get_taxonomy_parents( $id, $taxonomy = 'category', $link = false, $separator = '/', $nicename = false, $visited = array() ) {

            $chain = '';
            $parent = get_term( $id, $taxonomy );

            if ( is_wp_error( $parent ) )
                    return $parent;

            if ( $nicename )
                    $name = $parent->slug;
            else
                    $name = $parent->name;

            if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
                    $visited[] = $parent->parent;
                    $chain .= sa_get_taxonomy_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
            }

            if ( $link )
                    $chain .= '<a href="' . esc_url( get_term_link( $parent,$taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;
            else
                    $chain .= $name.$separator;

            return $chain;
    }

/** Breadcrumbs **/
function sa_breadcrumbs() {
    // Settings
    $separator          = '&nbsp;&nbsp;/&nbsp;&nbsp;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
        // Build the breadcrums
        echo '<div id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
        // Home page
        echo '<span class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<span class="separator separator-home"> ' . $separator . ' </li>';
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
            echo '<span class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</span></li>';
        } else if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
            // If post is a custom post type
            $post_type = get_post_type();
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                echo '<span class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<span class="separator"> ' . $separator . ' </span>';
            }
            $custom_tax_name = get_queried_object()->name;
            echo '<span class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></span>';
        } else if ( is_single() ) {
            // If post is a custom post type
            $post_type = get_post_type();
            // If it is a custom post type display name and link
            if($post_type == "policies"){
                $terms = get_the_terms( get_the_ID(), 'policies-type' );
                $last_category = end($terms);
                $get_cat_parents = rtrim(sa_get_taxonomy_parents($last_category->term_id,'policies-type', true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<span class="item-cat">'.$parents.'</span>';
                    $cat_display .= '<span class="separator"> ' . $separator . ' </span>';
                }
            }else if($post_type != 'post' && $post_type != 'courses' && $post_type != 'lessons') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                echo '<span class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<span class="separator"> ' . $separator . ' </span>';
            }
            if($post_type == 'courses'){
                if(get_option('course_main_page')){ 
                $post_type_archive = get_permalink(get_option('course_main_page'));
                echo '<span class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . get_the_title(get_option('course_main_page')) . '">' . get_the_title(get_option('course_main_page')) . '</a></li>';
                echo '<span class="separator"> ' . $separator . ' </span>';
                }
            }
            
            if($post_type == 'lessons'){
                
                $cid= get_the_ID();
        		  $args = array('post_type'=> 'courses','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
                    $pages = get_posts($args);
                    $tmp = array();
                    if( $pages ) {
                    foreach ( $pages as $ap ){ 
                        $duration = get_post_meta( $ap->ID, 'home_lession_select', true );
                        $duration = json_decode($duration);
                        if($duration){
                        if(in_array($cid,$duration)){
                            $tmp[] = get_permalink($ap->ID); 
                            } 
                        }
                        }
                    } 
                if(isset($_SERVER['HTTP_REFERER']))
                {
                    $post_type_archive = $_SERVER['HTTP_REFERER'];
                    if(in_array($post_type_archive , $tmp)){
                        $post_type_archive = $_SERVER['HTTP_REFERER'];
                        $postid = url_to_postid( $post_type_archive );
                        $ctitle = get_the_title($postid);
                    }else{
                       $post_type_archive = $tmp[0];
                        $postid = url_to_postid( $post_type_archive );
                        $ctitle = get_the_title($postid);  
                    }
                }else{
                        $post_type_archive = $tmp[0];
                        $postid = url_to_postid( $post_type_archive );
                        $ctitle = get_the_title($postid);
                    
                }
                echo '<span class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' .$ctitle. '">' . $ctitle. '</a></li>';
                echo '<span class="separator"> ' . $separator . ' </span>';
                
                 
            }
            // Get post category info
            $category = get_the_category();
            if(!empty($category)) {
                // Get last category post is in
                $last_category = end(array_values($category));
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<span class="item-cat">'.$parents.'</span>';
                    $cat_display .= '<span class="separator"> ' . $separator . ' </span>';
                }
            } 
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
            }
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></span>';
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                echo '<span class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></span>';
                echo '<span class="separator"> ' . $separator . ' </span>';
                echo '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></span>';
            } else {
                if($post_type != 'courses'){
                echo '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></span>';
                }
            }
        } else if ( is_category() ) {
            // Category page
            echo '<span class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></span>';
        } else if ( is_page() ) {
            // Standard page
            if( $post->post_parent ){
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                // Get parents in the right order
                $anc = array_reverse($anc);
                // Parent page loop
                $parents ="";
                if($anc){
                    foreach ( $anc as $ancestor ) {
                        $parents .= '<span class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></span>';
                        $parents .= '<span class="separator separator-' . $ancestor . '"> ' . $separator . ' </span>';
                    }
                }
                // Display parent pages
                echo $parents;
                // Current page
                echo '<span class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></span>';
            } else {
                // Just display current page if not parents
                echo '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></span>';
            }
        } else if ( is_tag() ) {
            // Tag page
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
            // Display the tag name
            echo '<span class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></span>';
        } elseif ( is_day() ) {
            // Day archive
            // Year link
            echo '<span class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></span>';
            echo '<span class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </span>';
            // Month link
            echo '<span class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></span>';
            echo '<span class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </span>';
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></span>';
        } else if ( is_month() ) {
            // Month Archive
            // Year link
            echo '<span class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></span>';
            echo '<span class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </span>';
            // Month display
            echo '<span class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></span>';
        } else if ( is_year() ) {
            // Display year archive
            echo '<span class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></span>';
        } else if ( is_author() ) {
            // Auhor archive
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
            // Display author name
            echo '<span class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></span>';
        } else if ( get_query_var('paged') ) {
            // Paginated archives
            echo '<span class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</span></span>';
        } else if ( is_search() ) {
            // Search results page
            echo '<span class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</span></span>';
        } elseif ( is_404() ) {
            // 404 page
            echo '<span>' . '404' . '</span>';
        }else if(is_tax()){
              $term = get_term_by("slug", get_query_var("term"), get_query_var("taxonomy") );

                    $tmpTerm = $term;
                    $tmpCrumbs = array();
                    while ($tmpTerm->parent > 0){
                        $tmpTerm = get_term($tmpTerm->parent, get_query_var("taxonomy"));
//                         print_r($tmpTerm);
                        $crumb = '<span class="item-cat item-cat-' . $tmpTerm->term_id . ' item-cat-' . $tmpTerm->slug . '">
                        <a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '" class="bread-cat bread-cat-' . $tmpTerm->term_id . ' bread-cat-' . $tmpTerm->slug . '" title="' . $tmpTerm->name . '">' . $tmpTerm->name . '</a></span><span class="separator"> ' . $separator . ' </span>';
                        array_push($tmpCrumbs, $crumb);
                    }
                    $tp ='<span class="separator"> ' . $separator . ' </span>';
                    echo implode('', array_reverse($tmpCrumbs));
                    echo '<span class="item-cat item-cat-' . $term->term_id . ' item-cat-' . $term->slug . '"><a href="' . get_term_link($term, get_query_var('taxonomy')) . '" class="bread-cat bread-cat-' . $term->term_id . ' bread-cat-' . $term->slug . '" title="' . $term->name . '">' . $term->name . '</a></span>';
        }
        echo '</div>';
    }
}




/** auto Sudgest **/

function get_sudgets()
{
    $ctxt = $_POST['ctxt'];
    $ul= $_POST['user'];
    $q1 = get_posts(array(
        'post_type' => 'policies',
        's' => $ctxt
    ));
    $q2 = get_posts(array(
            'post_type' => 'policies',
            'meta_query' => array(
                array(
                   'key' => 'policy_doc_type',
                   'value' => $ctxt,
                   'compare' => 'LIKE'
                )
             )
    ));
      

$merged = array_merge( $q1, $q2 );

$post_ids = array();
foreach( $merged as $item ) {
    $post_ids[] = $item->ID;
}

$unique = array_unique($post_ids);
if($unique){
$args;
if($ul == "administrator"){
     $args = array(
    'post_type' => 'policies',
    'post__in' => $unique,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    );
}else{
    $args = array(
    'post_type' => 'policies',
    'post__in' => $unique,
    'post_status' => 'publish',
    'posts_per_page' => -1,
     'meta_query'=> array(array('key' => 'user_type','compare' => 'LIKE','value' => $ul,)),
    );
}
$stc = query_posts($args);
if ( have_posts() ) :  while (have_posts()) : the_post();
   $txt ="";
   $policy_doc_type = get_post_meta(get_the_ID(), 'policy_doc_type', true);
   if($policy_doc_type){ 
    $txt = $policy_doc_type.":";
    }
     ?> 
      <li onClick="selectPolicy('<?php echo get_permalink(); ?>')"><?php echo $txt;?> <?php the_title(); ?></li>
   <?php
    endwhile; endif; wp_reset_query(); 
    }
    die();
}
add_action("wp_ajax_nopriv_get_sudgets","get_sudgets");
add_action("wp_ajax_get_sudgets","get_sudgets");


function slugify($text)
{
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}


if(get_option( 'user_role')){
global $wp_roles;
$user_r = array();
foreach ( $wp_roles->role_names as $role => $name ){
    $user_r[] = $role;
}    
    
  foreach(get_option( 'user_role') as $row) {
    $st = strtolower($row);
    $name = slugify($st);
    if(!in_array($name,$user_r)){
      add_role($name,$row,array('read'=> true,));
      }
   }
}


/** Menu Selection **/



function admin_init(){

		if( ! class_exists( 'Walker_Nav_Menu_Edit_Roles' ) ){
			global $wp_version;
		    if ( version_compare( $wp_version, '4.5.0', '>=' ) ){
				include_once( get_template_directory() . '/inc/class.Walker_Nav_Menu_Edit_Roles_4.5.php');
			} else {
				include_once( get_template_directory() . '/inc/class.Walker_Nav_Menu_Edit_Roles.php');
			}
        }

//		register_importer();

	}
add_action( 'admin_init',  'admin_init' );

function edit_nav_menu_walker( $walker ) {
		return 'Walker_Nav_Menu_Edit_Roles';
}       
add_filter( 'wp_edit_nav_menu_walker', 'edit_nav_menu_walker' );

function custom_fields( $item_id, $item, $depth, $args ) {
		global $wp_roles;

	   $display_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names, $item );

		if( ! $display_roles ) return;

	   $roles = get_post_meta( $item->ID, '_nav_menu_role', true );

		$logged_in_out = '';

	   if( is_array( $roles ) || $roles == 'in' ){
			$logged_in_out = 'in';
		} else if ( $roles == 'out' ){
			$logged_in_out = 'out';
		}
		$checked_roles = is_array( $roles ) ? $roles : false;
		$hidden = $logged_in_out == 'in' ? '' : 'display: none;';
		?>
		<input type="hidden" name="nav-menu-role-nonce" value="<?php echo wp_create_nonce( 'nav-menu-nonce-name' ); ?>" />
		<div class="field-nav_menu_role nav_menu_logged_in_out_field description-wide" style="margin: 5px 0;">
		    <span class="description"><?php _e( "Display Mode", 'nav-menu-roles' ); ?></span>
		    <br />
		    <input type="hidden" class="nav-menu-id" value="<?php echo $item->ID ;?>" />
		    <div class="logged-input-holder" style="float: left; width: 35%;">
		        <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_logged_in-for-<?php echo $item->ID ;?>" <?php checked( 'in', $logged_in_out ); ?> value="in" />
		        <label for="nav_menu_logged_in-for-<?php echo $item->ID ;?>">
		            <?php _e( 'Logged In Users', 'nav-menu-roles'); ?>
		        </label>
		    </div>

		    <div class="logged-input-holder" style="float: left; width: 35%;">
		        <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_logged_out-for-<?php echo $item->ID ;?>" <?php checked( 'out', $logged_in_out ); ?> value="out" />
		        <label for="nav_menu_logged_out-for-<?php echo $item->ID ;?>">
		            <?php _e( 'Logged Out Users', 'nav-menu-roles'); ?>
		        </label>
		    </div>

		    <div class="logged-input-holder" style="float: left; width: 30%;">
		        <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_by_role-for-<?php echo $item->ID ;?>" <?php checked( '', $logged_in_out ); ?> value="" />
		        <label for="nav_menu_by_role-for-<?php echo $item->ID ;?>">
		            <?php _e( 'Everyone', 'nav-menu-roles'); ?>
		        </label>
		    </div>

		</div>

		<div class="field-nav_menu_role nav_menu_role_field description-wide" style="margin: 5px 0; <?php echo $hidden; ?>">
		    <span class="description"><?php _e( "Restrict menu item to a minimum role", 'nav-menu-roles' ); ?></span>
		    <br />

		    <?php
		    $i = 1;
		    foreach ( $display_roles as $role => $name ) {
		        $checked = checked( true, ( is_array( $checked_roles ) && in_array( $role, $checked_roles ) ), false );
		        ?>
		        <div class="role-input-holder" style="float: left; width: 33.3%; margin: 2px 0;">
		        <input type="checkbox" name="nav-menu-role[<?php echo $item->ID ;?>][<?php echo $i; ?>]" id="nav_menu_role-<?php echo $role; ?>-for-<?php echo $item->ID ;?>" <?php echo $checked; ?> value="<?php echo $role; ?>" />
		        <label for="nav_menu_role-<?php echo $role; ?>-for-<?php echo $item->ID ;?>">
		        <?php echo esc_html( $name ); ?>
		        <?php $i++; ?>
		        </label>
		        </div>
		<?php } ?>
		</div>
		<?php
}
add_action( 'wp_nav_menu_item_custom_fields','custom_fields', 10, 4 );


function enqueue_scripts( $hook ){
		if ( $hook == 'nav-menus.php' ){
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			// wp_enqueue_script( 'nav-menu-roles', get_template_directory_uri( 'js/nav-menu-roles' . $suffix . '.js' , __FILE__ ), array( 'jquery' ), true );
            wp_register_script('nav-menu-roles', get_template_directory_uri().'/js/nav-menu-roles.js', array('jquery'), true);
            wp_enqueue_script('nav-menu-roles');
		}
	}
add_action( 'admin_enqueue_scripts' ,'enqueue_scripts');


function nav_update( $menu_id, $menu_item_db_id ) {
		global $wp_roles;

		$allowed_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names );

		// verify this came from our screen and with proper authorization.
		if ( ! isset( $_POST['nav-menu-role-nonce'] ) || ! wp_verify_nonce( $_POST['nav-menu-role-nonce'], 'nav-menu-nonce-name' ) ){
			return;
		}
		
		$saved_data = false;

		if ( isset( $_POST['nav-menu-logged-in-out'][$menu_item_db_id]  )  && $_POST['nav-menu-logged-in-out'][$menu_item_db_id] == 'in' && ! empty ( $_POST['nav-menu-role'][$menu_item_db_id] ) ) {
			
			$custom_roles = array();
			
			// only save allowed roles
			foreach( (array) $_POST['nav-menu-role'][$menu_item_db_id] as $role ) {
				if ( array_key_exists ( $role, $allowed_roles ) ) {
					$custom_roles[] = $role;
				}
			}
			if ( ! empty ( $custom_roles ) ) {
				$saved_data = $custom_roles;
			}
		} else if ( isset( $_POST['nav-menu-logged-in-out'][$menu_item_db_id]  ) && in_array( $_POST['nav-menu-logged-in-out'][$menu_item_db_id], array( 'in', 'out' ) ) ) {
			$saved_data = $_POST['nav-menu-logged-in-out'][$menu_item_db_id];
		}

		if ( $saved_data ) {
			update_post_meta( $menu_item_db_id, '_nav_menu_role', $saved_data );
		} else {
			delete_post_meta( $menu_item_db_id, '_nav_menu_role' );
		}
}
add_action( 'wp_update_nav_menu_item', 'nav_update', 10, 2 );

function setup_nav_item( $menu_item ) {

		$roles = get_post_meta( $menu_item->ID, '_nav_menu_role', true );

		if ( ! empty( $roles ) ) {
			$menu_item->roles = $roles;
		}
		return $menu_item;
	}

add_filter( 'wp_setup_nav_menu_item', 'setup_nav_item' );

		
if ( ! is_admin() ) {
    function exclude_menu_items( $items ) {

		$hide_children_of = array();

		// Iterate over the items to search and destroy
		foreach ( $items as $key => $item ) {

			$visible = true;

			// hide any item that is the child of a hidden item
			if( in_array( $item->menu_item_parent, $hide_children_of ) ){
				$visible = false;
				$hide_children_of[] = $item->ID; // for nested menus
			}

			// check any item that has NMR roles set
			if( $visible && isset( $item->roles ) ) {

				// check all logged in, all logged out, or role
				switch( $item->roles ) {
					case 'in' :
					$visible = is_user_logged_in() ? true : false;
						break;
					case 'out' :
					$visible = ! is_user_logged_in() ? true : false;
						break;
					default:
						$visible = false;
						if ( is_array( $item->roles ) && ! empty( $item->roles ) ) {
							foreach ( $item->roles as $role ) {
								if ( current_user_can( $role ) )
									$visible = true;
							}
						}

					break;
				}
			}
			// add filter to work with plugins that don't use traditional roles
			$visible = apply_filters( 'nav_menu_roles_item_visibility', $visible, $item );

			// unset non-visible item
			if ( ! $visible ) {
				$hide_children_of[] = $item->ID; // store ID of item
				unset( $items[$key] ) ;
			}

		}
        	return $items;
	}
    add_filter( 'wp_get_nav_menu_items','exclude_menu_items' );
}


class backup_restore_theme_options {

	function backup_restore_theme_options() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}
	function admin_menu() {
		// add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		// $page = add_submenu_page('themes.php', 'Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));

		// add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function);
		$page = add_theme_page('Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));

		add_action("load-{$page}", array(&$this, 'import_export'));
	}
	function import_export() {
		if (isset($_GET['action']) && ($_GET['action'] == 'download')) {
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="theme-options-'.date("dMy").'.dat"');
			echo serialize($this->_get_options());
			die();
		}
		if (isset($_POST['upload']) && check_admin_referer('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions')) {
			if ($_FILES["file"]["error"] > 0) {
				// error
			} else {
				$options = unserialize(file_get_contents($_FILES["file"]["tmp_name"]));
				if ($options) {
					foreach ($options as $option) {
						update_option($option->option_name, maybe_unserialize($option->option_value));
					}
				}
			}
			wp_redirect(admin_url('themes.php?page=backup-options'));
			exit;
		}
	}
	function options_page() { ?>

		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Backup/Restore Theme Options</h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<style>#backup-options td { display: block; margin-bottom: 20px; }</style>
				<table id="backup-options">
					<tr>
						<td>
							<h3>Backup/Export</h3>
							<p>Here are the stored settings for the current theme:</p>
							<p><textarea class="widefat code" rows="20" cols="100" onclick="this.select()"><?php echo serialize($this->_get_options()); ?></textarea></p>
							<p><a href="?page=backup-options&action=download" class="button-secondary">Download as file</a></p>
						</td>
						<td>
							<h3>Restore/Import</h3>
							<p><label class="description" for="upload">Restore a previous backup</label></p>
							<p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload file" /></p>
							<?php if (function_exists('wp_nonce_field')) wp_nonce_field('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions'); ?>
						</td>
					</tr>
				</table>
			</form>
		</div>

	<?php }
	function _display_options() {
		$options = unserialize($this->_get_options());
	}
	function _get_options() {
		global $wpdb;
        $out = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE 
        option_name = 'sa_custom_title' 
        OR option_name = 'sa_pp_main_title'
        OR option_name = 'login_page'        
        OR option_name = 'course_timezone'
        OR option_name = 'lesson_confirm_message' 
        OR option_name = 'user_role' 
        OR option_name = 'access_denied_message' 
        OR option_name = 'widget_text' 
        OR option_name = 'sidebars_widgets' 
        OR option_name = 'theme_mods_sa' " ); 
        return $out;
	}
}
new backup_restore_theme_options();

require get_template_directory() . '/inc/course-admin.php';


add_filter( 'embed_oembed_html', 'sa_oembed_filter', 10, 4 ) ;

function sa_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="videoWrapper">'.$html.'</div>';
    return $return;
}



add_action( 'init', 'blockusers_init' );
function blockusers_init() {
if ( is_admin() && ! current_user_can( 'administrator' ) &&
! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
wp_redirect( home_url() );
exit;
}
}