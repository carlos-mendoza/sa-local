<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
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
	<div id="primary" class="content-area page_sidebar">
		<div id="content" class="site-content wrapper " role="main">
            <div class="right_content">
               <?php sa_breadcrumbs(); ?>
                <div class="entry-content cf">
                 <?php
                // $su2 = array_filter(get_field('user_type',get_the_ID()));
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
            </div>
            <div class="left_content sidebar">
               <?php $su2 = $user_type;
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
                <?php dynamic_sidebar('sidebar-2'); ?>
                <?php } ?>
                <div class="border_horizontal"></div>
            </div>
            
        <div class="push"></div>
        <div class="cf"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
