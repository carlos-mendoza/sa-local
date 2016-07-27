<?php
/**
 * Template Name: P&P Page Template
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();

$custom_privacy ;
if($user_role == "administrator"){
    $custom_privacy= array() ;
}else{
    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare' => 'LIKE',)));
}

$user_type = get_post_meta(get_the_ID(), 'user_type', true);
$page_title = get_post_meta(get_the_ID(), 'page_title', true);
if(!$user_type){
    $user_type = array();
}
$all = array();
$cp_id = "";
 ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/isotope.pkgd.min.js"></script>
<script>

jQuery(document).ready(function($){
    $('.masonary .cont_box').responsiveEqualHeightGrid();	
     $container = $('.masonary').isotope({
  itemSelector: '.box',
  percentPosition: true,
  masonry: {
    columnWidth: '.box'
  },
  layoutMode: 'fitRows',
})

  
})

jQuery(window).load(function($){

        
     $container = jQuery('.masonary').isotope({
  itemSelector: '.box',
  percentPosition: true,
  masonry: {
    columnWidth: '.box'
  },
  layoutMode: 'fitRows',
})

   
})

</script>
<style>
#masthead{position: relative;}
.top_header_bar{position: relative;}
#main{padding-top: 0 !important;}
.top_header_bar.fixed{position: fixed; top: 0;}
@media (min-width:0px) and (max-width:767px){
{}    
.top_header_bar.fixed{position: relative; top: 0;}
#main-content{padding-top: 0 !important;}
}
</style>


<script>
function inside_sticky(){
    
    jQuery(window).scroll(function($) {
        var top_sc = jQuery("#masthead").outerHeight();
        if (jQuery(this).scrollTop() >= top_sc) {
           jQuery(".top_header_bar").addClass("fixed");
               var top_header_bar = jQuery(".top_header_bar").outerHeight();
                jQuery("#main-content").css("padding-top",top_header_bar);
        } else {
            jQuery(".top_header_bar").removeClass("fixed");
            jQuery("#main-content").css("padding-top",0);
        }
    })
           var mc= jQuery('#content').width();
        var lc= jQuery('.right_policies').width();
        var sw= mc-lc-2;
        jQuery('.sidebar').css("width",sw);
}
jQuery(document).ready(function(){
    inside_sticky();
    
})
jQuery(window).load(function(){
    inside_sticky();
})
jQuery(window).resize(function(){
    inside_sticky();
})
</script>
<div class="top_header_bar">
    <div class="wrapper cf">
    
    <h2 class="pp_title"><?php if($page_title){ echo $page_title; }else{ echo get_the_title(); } ?></h2>
    <a href="javascript:;" class="mobile_search_policy"><i class="fa fa-search"></i></a>
    <div class="search_box">
    <input type="text" value="" placeholder="Search by Number or Title" />
    <ul class="auto_sudgest">
    </ul>
    </div>
    <?php
        $prpo=get_previous_post(); 
        $nepo=get_next_post(); 
    ?>
   
    <div class="mobile_policy">
        <a href="javascript:;" class="mobile_menu_policy"><i class="fa fa-align-justify"></i></a>
        <div class="sidebar_policies">
         <div class="inside_div">
            <?php
           
             $taxonomies = array('policies-type');
              $args = array(
                'orderby'           => 'name', 
                'order'             => 'ASC',
                'hide_empty'        => false, 
                'fields'            => 'all',
                'parent'            => 0,
                'hierarchical'      => true,
                'child_of'          => 0,
                'pad_counts'        => false,
                'cache_domain'      => 'core'    
              );
              $terms = get_terms($taxonomies, $args);
              echo  '<div class="mob_main_policies"><ul class="mob_au_height">'; 
                foreach ( $terms as $term ) {
                                $su1 = get_metadata( $term->term_id,'user_type', true );
                               if(!$su1){
                        	   $su1 = array();
                               } 
                      
                        if(in_array($user_role,$su1) || $user_role == "administrator"){
                     $subterms = get_terms($taxonomies, array('parent'   => $term->term_id,'hide_empty' => false)); ?>
                        <li id="category-<?php echo $term->term_id; ?>" class="toggle <?php  if (in_array($term->term_id, $all)){ echo "widget_subpages_current_page"; } ?>"><a href="<?php if($subterms){ echo "javascript:;"; }else{  echo get_term_link($term);  } ?>" class="<?php if($subterms){ echo "mob_click_slide"; } ?>"><?php echo $term->name; ?></a>
                    <?php
                      
                      if($subterms){  
                        
                        
                        echo  '<div class="mob_slide_policies"><a href="javascript:;" class="mob_back_policies"><i class="fa fa-long-arrow-left"></i> All Categories</a><span class="current_selected">'.$term->name.'</span><ul class="mon_sub_open">';
                        foreach ( $subterms as $subterm ) {
                             $su2 = get_metadata( $term->term_id,'user_type', true );
                               if(!$su2){
                        	   $su2 = array();
                               } 
                            //$su2 = array_filter(get_field('user_type','policies-type_'.$subterm->term_id));
                        if(in_array($user_role,$su2) || $user_role == "administrator"){
                        
                            $my_query = array_merge(array( 'post_type' => 'policies','order' => 'DESC','orderby'=>'menu_order','posts_per_page' =>-1,'tax_query' => array(array('taxonomy' => 'policies-type','field' => 'term_id','terms' => $subterm->term_id,))),$custom_privacy);
                            $two= get_posts($my_query);
                            $subterms_two = count($two);
                            wp_reset_postdata();
                             ?>
                      <li id="category-<?php echo $subterm->term_id; ?>" class="<?php if($subterms_two > 0){ echo "sub_down"; }?> <?php  if (in_array($subterm->term_id, $all)){ echo "widget_subpages_current_page"; } ?>"><a href="<?php if($subterms_two > 0){ echo "javascript:;"; }else{  echo get_term_link($subterm);  } ?>" class="<?php if($subterms_two > 0){ echo "mob_down_slide"; } ?>"><?php echo $subterm->name; ?></a>
                      <?php 
                      if($subterms_two > 0){
                        $my_querys = array_merge(array( 'post_type' => 'policies','order' => 'DESC','orderby'=>'menu_order','posts_per_page' =>-1,'tax_query' => array(array('taxonomy' => 'policies-type','field' => 'term_id','terms' => $subterm->term_id,))),$custom_privacy);
                        echo "<ul class='mob_toggle_policies'>";
                        query_posts($my_querys);
                        while ( have_posts() ) : the_post();?>
                                <li id="category-<?php echo get_the_ID(); ?>" class="toggle <?php  if ($cp_id ==  get_the_ID()){ echo "widget_subpages_current_page"; } ?>"><a href="<?php  echo get_permalink(); ?>"><?php the_title(); ?></a></li>
                      <?php   
                        endwhile;
                        wp_reset_query();
                        echo "</ul>";
                                    }
                      echo "</li>";
                        }
                    }
                    echo '</ul></div>'; //end subterms ul
                    }
                    echo "</li>";
                    }           
                 //end terms li
                } //end foreach term
            
              echo '</ul></div>';
              
            ?>
            </div>
        </div>
    </div>
    </div>
</div>
<div id="main-content" class="main-content">
	<div id="primary" class="content-area page_sidebar">
		<div id="content" class="site-content wrapper " role="main">
            <div class="right_policies">
              
                <div class="entry-content cf policiy_content" style="padding-top: 0;">
                
                <div class="content_gray">
                    
                    <?php
                     $taxonomies = array('policies-type');
                      $args = array(
                        'orderby'           => 'name', 
                        'order'             => 'ASC',
                        'hide_empty'        => false, 
                        'fields'            => 'all',
                        'parent'            => 0,
                        'hierarchical'      => true,
                        'child_of'          => 0,
                        'pad_counts'        => false,
                        'cache_domain'      => 'core'    
                      );
                      $terms = get_terms($taxonomies, $args);
                       
                      if($terms){ ?>
                    
                    <div class="masonary cf">
                	<?php   foreach($terms as $tp){ 
                	   $dd = get_metadata( $tp->term_id,'user_type', true );
                       if(!$dd){
                	   $dd = array();
                       }                           
                                if(in_array($user_role,$dd) || $user_role == "administrator"){
                	   ?>
                       
                            <div class="box ">
                                <a href="<?php echo get_term_link($tp) ?>" >
                                <div class="cont_box ">
                                    <h3 class="box_title"><?php echo $tp->name; ?></h3>
                                    <p class="box_desc"><?php  echo $tp->description; ?></p>
                                </div>
                                </a>
                             </div>
                      <?php } } ?>
                    </div>
                    <?php } ?>
                   
                     <div class="push"></div>
                </div>
                   
                </div>
            </div>
            <div class="left_policies sidebar">
         
            <div class="sidebar_policies">
                <?php
                                
                     $taxonomies = array('policies-type');
                      $args = array(
                        'orderby'           => 'name', 
                        'order'             => 'ASC',
                        'hide_empty'        => false, 
                        'fields'            => 'all',
                        'parent'            => 0,
                        'hierarchical'      => true,
                        'child_of'          => 0,
                        'pad_counts'        => false,
                        'cache_domain'      => 'core'    
                      );
                      $terms = get_terms($taxonomies, $args);
                      echo  '<div class="main_policies"><ul class="au_height">'; 
                        foreach ( $terms as $term ) {
                             $su1 = get_metadata( $term->term_id,'user_type', true );
                               if(!$su1){
                        	   $su1 = array();
                               }  
                                    if(in_array($user_role,$su1) || $user_role == "administrator"){
                                        
                             $subterms = get_terms($taxonomies, array('parent'   => $term->term_id,'hide_empty' => false)); ?>
                                <li id="category-<?php echo $term->term_id; ?>" class="toggle <?php  if (in_array($term->term_id, $all)){ echo "widget_subpages_current_page"; } ?>"><a href="<?php if($subterms){ echo "javascript:;"; }else{  echo get_term_link($term);  } ?>" class="<?php if($subterms){ echo "click_slide"; } ?>"><?php echo $term->name; ?></a>
                            <?php
                              
                              if($subterms){  
                                
                                
                                echo  '<div class="slide_policies"><a href="javascript:;" class="back_policies"><i class="fa fa-long-arrow-left"></i> All Categories</a><span class="current_selected">'.$term->name.'</span><ul class="sub_open">';
                                foreach ( $subterms as $subterm ) {
                                        $su2 = get_metadata( $term->term_id,'user_type', true );
                                       if(!$su2){
                                	   $su2 = array();
                                       }
                                    
                                    if(in_array($user_role,$su2) || $user_role == "administrator"){
                                    
                                    $my_query = array_merge(array( 'post_type' => 'policies','order' => 'DESC','orderby'=>'menu_order','posts_per_page' =>-1,'tax_query' => array(array('taxonomy' => 'policies-type','field' => 'term_id','terms' => $subterm->term_id,))),$custom_privacy);
                                    $two= get_posts($my_query);
                                    $subterms_two = count($two);
                                    wp_reset_postdata();
                                 ?>
                              <li id="category-<?php echo $subterm->term_id; ?>" class="<?php if($subterms_two > 0){ echo "sub_down"; }?> <?php  if (in_array($subterm->term_id, $all)){ echo "widget_subpages_current_page"; } ?>"><a href="<?php if($subterms_two > 0){ echo "javascript:;"; }else{  echo get_term_link($subterm);  } ?>" class="<?php if($subterms_two){ echo "down_slide"; } ?>"><?php echo $subterm->name; ?></a>
                              <?php 
                              if($subterms_two > 0){
                                 $my_querys = array_merge(array( 'post_type' => 'policies','order' => 'DESC','orderby'=>'menu_order','posts_per_page' =>-1,'tax_query' => array(array('taxonomy' => 'policies-type','field' => 'term_id','terms' => $subterm->term_id,))),$custom_privacy);
                                echo "<ul class='toggle_policies'>";
                                query_posts($my_querys);
                                while ( have_posts() ) : the_post();
                                 ?>
                                        <li id="post-<?php echo get_the_ID(); ?>" class="toggle <?php  if ( $cp_id ==  get_the_ID()){ echo "widget_subpages_current_page"; } ?>"><a href="<?php  echo get_permalink(); ?>"><?php the_title(); ?></a></li>
                              <?php                                 
                               
                                endwhile;
                                wp_reset_query();
                                echo "</ul>";
                                }
                              echo "</li>";
                              }
                            
                            }
                            echo '</ul></div>'; //end subterms ul
                            }
                            echo "</li>";
                            }
                    
                           //end terms li
                        } //end foreach term
                    
                      echo '</ul></div>';
                      
                    ?>
                </div>
            </div>
            <div class="border_horizontal"></div>
        <div class="cf"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //  get_sidebar( 'content' ); ?>
</div><!-- #main-content -->
<?php
get_footer();

