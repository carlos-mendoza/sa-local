<?php
/**
 * Template Name: Courses Section
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
    
jQuery(".masonary  .box").each(function(){
    var cs= jQuery(this).find(".wrap_about");
    if(cs.outerHeight() < cs.children("strong").outerHeight()){
    var cp = cs.data('id');
    cs.append( '<a class="toggle fancybox" href="#'+cp+'">more</a>' );
    cs.dotdotdot({after: 'a.toggle'});
    }
})
})

jQuery(window).load(function($){
    $container = jQuery('.masonary').isotope({
  itemSelector: '.box',
  percentPosition: true,
  masonry: {
    columnWidth: '.box'
  }
})

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

jQuery(window).resize(function(){
    
    jQuery(".masonary  .box").each(function(){
    var cs= jQuery(this).find(".wrap_about");
    	cs.trigger( 'destroy' );
        cs.find(".toggle").remove();
      if(cs.outerHeight() < cs.children("strong").outerHeight()){
        var cp = cs.data('id');
        
        cs.append( '<a class="toggle fancybox" href="#'+cp+'">more</a>' );
       cs.dotdotdot({after: 'a.toggle'});
    }
})
})
</script>


<div id="main-content" class="main-content">
<div class="cf top_app">
<div class="wrapper cf">
<h1 class="page_title"><?php if($page_title){ echo $page_title; }else{ the_title(); }?></h1>
<?php
 $su2 = $user_type;
if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
<div class="filter_nav">
 <a data-filter="*" class="selected" href="javascript:;">All</a>
 <?php 
$taxonomies = array('course-categories');
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
foreach ( $term as $terms ){ 
$su1 = get_metadata( $terms->term_id,'user_type', true );
if(!$su1){
$su1 = array();
} 
if(in_array($user_role,$su1) || $user_role == "administrator"){
                            ?> 
    <a class="<?php echo $terms->slug; ?> " data-filter=".<?php echo $terms->slug; ?>" href="javascript:;"><?php echo $terms->name;?></a>
<?php $i++; } }  ?>
</div>


 <div class="mobile select_cat">
        <select class="mob_maz">
        <option value="*">All</option>
         <?php $taxonomies = array('course-categories');
            $args = array(
                'orderby'           => 'slug', 
                'order'             => 'ASC',
                'hide_empty'        => true, 
                'hierarchical'      => false, 
                'child_of'          => 0, 
            );
         ?>
        <?php $term= get_terms( $taxonomies, $args ); $i=1;
               foreach ( $term as $terms ){
               $su1 = get_metadata( $terms->term_id,'user_type', true );
                if(!$su1){
                $su1 = array();
                } 
                if(in_array($user_role,$su1) || $user_role == "administrator"){
                ?> 
                <option value=".<?php echo $terms->slug; ?>"> <?php echo $terms->name;?></option>
        <?php $i++; } }  ?>
        </select>
        </div>
        
 <?php } ?>
</div>
    
    


</div>
	<div id="primary" class="content-area main_course">
		<div id="content" class="site-content application_wrapper" role="main">
        
            <div class="wrapper cf ">
             <?php
                 $su2 = $user_type;
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <div class="masonary cf cources_main">
        	<?php   $args = array('post_type'=> array( 'courses'),'posts_per_page'=>-1,'order_by'=>'menu_order');
                    query_posts( array_merge($args,$custom_privacy) );
                    //query_posts($args);
				    while ( have_posts() ) : the_post(); 
                    global $post;
                    $slug = get_post( $post )->post_name;
                    
                    $il_box_platform = get_post_meta(get_the_ID(), 'cs_box_platform', true);
                    $il_box_about = get_post_meta(get_the_ID(), 'cs_box_about', true);
                    ?>
               
                    <div class="box directory_box course_box <?php $terms1 = get_the_terms( $post->ID, 'course-categories' ); foreach ( $terms1 as $term2 ) {echo $term2->slug." ";} ?>">
                        <div class="cont_box ">
                            <div class="header_directory">
                                <h3 class="box_title"><?php the_title(); ?></h3>
                                <p class="designation"></p>
                            </div>
                            <?php if($il_box_platform){ ?>
                            <div class="data_value">
                                <span>Platform</span>
                                <strong><?php echo $il_box_platform; ?></strong>
                            </div>
                            <?php } ?>
                            
                            <?php $terms1 = get_the_terms( $post->ID, 'course-categories' ); 
                                $current_depat = array();
                                foreach ( $terms1 as $term2 ) { $current_depat[] = $term2->name; } 
                                ?>
                            <?php if($current_depat){ ?>
                            <div class="data_value">
                                <span>Type</span>
                                <strong><?php echo implode(", ", $current_depat); ?>
                                </strong>
                            </div>
                            <?php } ?>
                            
                            <?php if($il_box_about){ ?>
                            <div class="data_value about_data">
                                <span>about</span>
                                <div class="wrap_about"  data-id="<?php echo $slug; ?>">
                                <strong><?php echo $il_box_about; ?></strong></div>
                            </div>
                            <?php } ?>
                            
                           	<div id="<?php echo $slug; ?>" class="fancy_popup" style="max-width:365px;display: none;">
                            
                                    <div class="header_directory">
                                        <h3 class="box_title"><?php the_title(); ?></h3>
                                    </div>
                                    <?php if($il_box_platform){ ?>
                                    <div class="data_value">
                                        <span>Platform</span>
                                        <strong><?php echo $il_box_platform; ?></strong>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php $terms1 = get_the_terms( $post->ID, 'course-categories' ); 
                                        $current_depat = array();
                                        foreach ( $terms1 as $term2 ) { $current_depat[] = $term2->name; } 
                                        ?>
                                    <?php if($current_depat){ ?>
                                    <div class="data_value">
                                        <span>Type</span>
                                        <strong><?php echo implode(", ", $current_depat); ?>
                                        </strong>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if($il_box_about){ ?>
                                    <div class="data_value about_data">
                                        <span>about</span>
                                        <strong><?php echo $il_box_about; ?></strong>
                                    </div>
                                    <?php } ?>
                                    
                                    <a href="<?php echo get_permalink(); ?>" class="couses_link" >Link to Course <i class="fa fa-long-arrow-right"></i></a>
                                    
                    	
                    	   </div>
                            
                            
                            <a href="<?php echo get_permalink(); ?>" class="couses_link" >Link to Course <i class="fa fa-long-arrow-right"></i></a>
                            
                            
                            
                        </div>
                        
                     </div>
              <?php endwhile; ?>
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

