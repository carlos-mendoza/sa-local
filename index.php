<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();
$page_title = get_post_meta(get_option('page_for_posts'), 'page_title', true); 
?>


<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content wrapper inner_content" role="main">
            
            <?php sa_breadcrumbs(); ?>
            <div class="entry-content cf">
             <?php  ?>
            <h1 class="page_title"><?php if($page_title){ echo $page_title; }else if(get_option('page_for_posts')){ echo get_the_title(get_option('page_for_posts')); } ?></h1>
            
                <?php
                	if ( have_posts() ) :
    				// Start the Loop.
    			 	while ( have_posts() ) : the_post();
                   	get_template_part( 'content', get_post_format() );                				
    				endwhile;
                    // Previous/next post navigation.
   					sa_post_nav();
                    	else :
				// If no content, include the "No posts found" template.
			 	get_template_part( 'content', 'none' );

			 endif;
    			?>
                  
            </div>
        <div class="push"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //  get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
