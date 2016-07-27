<?php
/**
 * The template for displaying 404 pages (Not Found)
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
            
            <h1 class="page_title"><?php _e( '404 Not Found', 'sa' ); ?></h1>
            
               <div> 
                    <p>The page you requested cannot be found. The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                    <p><strong style="color: rgb(204, 0, 0);">Please try the following:</strong></p>
                    <div id="specialize-list">
                        <ul>
                            <li>If you typed the page address in the Address bar, make sure that it is spelled correctly. </li>
                            <li>Open the <a href="<?php echo site_url(); ?>">Home page</a> and look for links to the information you want. </li>
                            <li>Use the navigation bar on the left or top to find the link you are looking for. </li>
                            <li>Click the Back button to try another link.</li>
                        </ul>
                    </div> 
                </div>
                 
            </div>
        <div class="push"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
