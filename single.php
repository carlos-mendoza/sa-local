<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>


<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content wrapper inner_content" role="main">
            
            <?php sa_breadcrumbs(); ?>
            <div class="entry-content cf">
             <?php  ?>
            <h1 class="page_title"><?php the_title(); ?></h1>
            
                <?php
        				// Start the Loop.
        				while ( have_posts() ) : the_post();
        
        					/*
        					 * Include the post format-specific template for the content. If you want to
        					 * use this in a child theme, then include a file called called content-___.php
        					 * (where ___ is the post format) and that will be used instead.
        					 */
        					get_template_part( 'content', get_post_format() );
        
        				
        					// If comments are open or we have at least one comment, load up the comment template.
        					if ( comments_open() || get_comments_number() ) {
        						comments_template();
        					}
        				endwhile;
        			?>
                  
            </div>
        <div class="push"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //  get_sidebar( 'content' ); ?>
</div><!-- #main-content -->


<?php
get_footer();
