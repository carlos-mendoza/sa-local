<?php
/**
 * Template Name: Applications Page Template
 *
 * 
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
<script src="<?php echo get_template_directory_uri(); ?>/js/isotope.pkgd.min.js"></script>
<script>
jQuery(document).ready(function($){
    $container = $('.masonary').isotope({ itemSelector: '.box',percentPosition: true,masonry: {columnWidth: '.box'} }) 
})

jQuery(window).load(function($){
     $container = jQuery('.masonary').isotope({ itemSelector: '.box',percentPosition: true,masonry: {columnWidth: '.box'} })

    jQuery('.filter_nav').on('click','a',function(){
      var filterValue = jQuery(this).attr('data-filter');
      $container.isotope({ filter: filterValue });
      jQuery('.filter_nav a').removeClass('selected');
      jQuery(this).addClass('selected');  
      footer_push();
    });
    jQuery('.mob_maz').change( function() {
      var filterValue = jQuery(this).val();
      $container.isotope({ filter: filterValue });
      footer_push();
    });    
})
</script>


<div id="main-content" class="main-content">
<div class="cf top_app">
<div class="wrapper cf">
<h1 class="page_title"><?php  if($page_title){ echo $page_title; }else{ the_title(); }?></h1>
<?php
$su2 = array_filter($user_type);
if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>

<div class="filter_nav">
 <a data-filter="*" class="selected" href="javascript:;">All</a>
 <?php 
$taxonomies = array('application-type');
$args = array(
    'orderby'           => 'slug', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'hierarchical'      => false, 
    'child_of'          => 0, 

); ?>
<?php 
$term= get_terms( $taxonomies, $args );
$i=1;
foreach ( $term as $terms ){ ?> 
    <a class="<?php echo $terms->slug; ?> " data-filter=".<?php echo $terms->slug; ?>" href="javascript:;"><?php echo $terms->name;?></a>
<?php $i++; }  ?>
</div>


 <div class="mobile select_cat">
        <select class="mob_maz">
        <option value="*">All</option>
         <?php $taxonomies = array('application-type');
            $args = array(
                'orderby'           => 'slug', 
                'order'             => 'ASC',
                'hide_empty'        => true, 
                'hierarchical'      => false, 
                'child_of'          => 0, 
            );
         ?>
        <?php $term= get_terms( $taxonomies, $args ); $i=1;
               foreach ( $term as $terms ){ ?> 
                <option value=".<?php echo $terms->slug; ?>"> <?php echo $terms->name;?></option>
        <?php $i++; }  ?>
        </select>
        </div>
 <?php }  ?>
</div>
    
    


</div>
	<div id="primary" class="content-area">
		<div id="content" class="site-content application_wrapper" role="main">
        
            <div class="wrapper cf ">
              <?php
                 $su2 = array_filter($user_type);
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <div class="masonary cf">
        	<?php   $args = array('post_type'=> array( 'application'),'posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
                    // query_posts( $args );
               query_posts(array_merge($args,$custom_privacy));
				    while ( have_posts() ) : the_post();
                        $app_box_desctiption = get_post_meta(get_the_ID(), 'app_box_desctiption', true);
                        $app_box_link = get_post_meta(get_the_ID(), 'app_box_link', true); 
                       
                    ?>
               
                    <div class="box <?php $terms1 = get_the_terms( $post->ID, 'application-type' ); foreach ( $terms1 as $term2 ) {echo $term2->slug." ";} ?>">
                        <a href="<?php if($app_box_link){ echo $app_box_link; }else{  the_permalink(); } ?>" target="_blank">
                        <div class="cont_box ">
                            <h3 class="box_title"><?php the_title();?></h3>
                            <p class="box_desc"><?php echo $app_box_desctiption; ?></p>
                        </div>
                        </a>
                     </div>
              <?php endwhile; ?>
              </div>
              <?php }else{ ?>
               <div class="">
                    <h2 style="text-align:  center;" ><?php echo get_option( 'access_denied_message' ); ?></h2>
                </div>
              <?php } ?>
              
              </div>
              
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
				//	get_template_part( 'content', 'page' );

				endwhile;
			?>
		</div><!-- #content -->
         <div class="push"></div>
	</div><!-- #primary -->
    
</div><!-- #main-content -->

<?php

get_footer();