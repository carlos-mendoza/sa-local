<?php
/**
 * Template Name: Full Width Page
 *
 */

get_header();
$user_type = get_post_meta(get_the_ID(), 'user_type', true);
$page_title = get_post_meta(get_the_ID(), 'page_title', true);
 if(!$user_type){
    $user_type = array();
} 
?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content wrapper inner_content" role="main">
            
            <?php sa_breadcrumbs(); ?>
            <div class="entry-content cf">
             <?php
                 $su2 = $user_type;
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <h1 class="page_title"><?php if($page_title){ echo $page_title; }else{ the_title(); } ?></h1>
            
                <?php
    				// Start the Loop.
    			 	while ( have_posts() ) : the_post();
                    the_content();                        				
    				endwhile;
    			?>
                  <?php }else{ ?>
               <div class="">
                    <h2 style="text-align:  center;" ><?php echo get_option( 'access_denied_message' ); ?></h2>
                </div>
              <?php } ?>
            </div>
        <div class="push"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //  get_sidebar( 'content' ); ?>
</div><!-- #main-content -->
<?php
get_footer();
