<?php
/**
 * Template Name: Core Values Template
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 

$custom_privacy ;
if($user_role == "administrator"){
    $custom_privacy = array();
}else{
    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare' => 'LIKE',)));
}
$user_type = get_post_meta(get_the_ID(), 'user_type', true);
$page_title = get_post_meta(get_the_ID(), 'page_title', true);
 if(!$user_type){
    $user_type = array();
}
?>
<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.dotdotdot.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/fancybox/jquery.fancybox.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fancybox/jquery.fancybox.css" />

<script src="<?php echo get_template_directory_uri(); ?>/js/isotope.pkgd.min.js"></script>
<script>
jQuery(document).ready(function($){
    
      $('.masonary .cont_box').responsiveEqualHeightGrid();	
      
     $container = $('.masonary').isotope({
        itemSelector: '.box',
        percentPosition: true,
        masonry: {
        columnWidth: '.box'
      }
})
	jQuery('.fancybox').fancybox({
	   padding:[0,0,0,0],
       tpl: {
				closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;">Close <i class="fa fa-close"></i></a>',
			},
	});
    
})

jQuery(window).load(function($){
    $container = jQuery('.masonary').isotope({
  itemSelector: '.box',
  percentPosition: true,
  masonry: {
    columnWidth: '.box'
  }
})

})


</script>


<div id="main-content" class="main-content">
    <div class="cf top_app">
        <div class="wrapper cf">
            <h1 class="page_title"><?php if($page_title){ echo $page_title; }else{ the_title(); }?></h1>
        </div>
    </div>
</div>
	<div id="primary" class="content-area main_course">
		<div id="content" class="site-content application_wrapper" role="main">
        
            <div class="wrapper cf ">
             <?php
                 $su2 = $user_type;
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <div class="masonary cf cources_main">
        	<?php   $args = array('post_type'=> array( 'core-values'),'posts_per_page'=>-1,'order_by'=>'menu_order');
                    query_posts( array_merge($args,$custom_privacy) );
                    $i=1;
				    while ( have_posts() ) : the_post(); 
                    global $post;
                    $slug = get_post( $post )->post_name;
                    
                   
                    ?>
               
                    <div class="box directory_box course_box numberd_box">
                        <div class="cont_box ">
                            <div class="header_directory">
                                <h3 class="box_title"><i class="num"><?php echo $i; ?></i><?php the_title(); ?></h3>
                                <p class="designation"></p>
                            </div>
                            
                            <?php if(get_the_excerpt()){ ?>
                            <div class="data_value about_data" >
                                <div class="wrap_about" style="height: auto;" >
                                    <strong><?php echo get_the_excerpt(); ?></strong>
                                </div>
                            </div>
                            <?php } ?>
                            
                           	<div id="<?php echo $slug; ?>" class="fancy_popup" style="max-width:980px;display: none;width: 100%;">
                                <div class="header_directory">
                                        <h3 class="box_title"><i class="num"><?php echo $i; ?></i><?php the_title(); ?></h3>
                                </div>
                                <div class="data_value about_data entry-content popup_height">
                                    <?php  the_content(); ?>
                                </div>
                    	   </div>
                            
                            <a href="#<?php echo $slug; ?>" class="couses_link fancybox" >More Info <i class="fa fa-long-arrow-right"></i></a>
                            
                            
                            
                        </div>
                        
                     </div>
              <?php $i++; endwhile; ?>
              </div>
                  <?php }else{ ?>
               <div class="">
                    <h2 style="text-align:  center;" ><?php echo get_option( 'access_denied_message' ); ?></h2>
                </div>
              <?php } ?>
              </div>
    		</div><!-- #content -->
         <div class="push"></div>
	</div><!-- #primary -->
    
</div><!-- #main-content -->

<?php
get_footer();

