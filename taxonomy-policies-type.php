<?php
/**
 * The template for displaying Post Format pages
 *
 * Used to display archive-type pages for posts with a post format.
 * If you'd like to further customize these Post Format views, you may create a
 * new template file for each specific one.
 *
 * @todo https://core.trac.wordpress.org/ticket/23257: Add plural versions of Post Format strings
 * and remove plurals below.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 

$queried_object = get_queried_object();

$term_id = $queried_object->term_id;
$all = get_ancestors( $term_id, 'policies-type' );
$all[] = $term_id;

$posts = get_posts(array(
    'post_type' => 'policies',
    'numberposts' => 1,
    'post_status' => 'publish',
    'policies-type' => $queried_object->slug,
    'order' => 'DESC','orderby'=>'menu_order'
));
$cp_id;
if($posts){
$cp_id = $posts[0]->ID;
$termsp = get_the_terms( $cp_id, 'policies-type' );
foreach($termsp as $t){
  $all[]= $t->term_id;
}
}else{
$cp_id ;    
}


$custom_privacy ;
if($user_role == "administrator"){
    $custom_privacy = array();
}else{    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare' => 'LIKE',)));
}

   ?>
<style>
#masthead{position: relative;}
.top_header_bar{position: relative;}
#main{padding-top: 0 !important;}
.top_header_bar.fixed{position: fixed; top: 0;}
.right_policies{min-height: 400px;}
@media (min-width:0px) and (max-width:767px){
{}    
.top_header_bar.fixed{position: relative; top: 0;}
#main-content{padding-top: 0 !important;}
.right_policies{min-height: 0px;}
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
        
        if(jQuery(this).scrollTop()<=top_sc){
             jQuery('.sidebar').removeClass("sticky");
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
    window.setTimeout(function(){
    footer_push();    
    },120);
    
})
jQuery(window).resize(function(){
    inside_sticky();
    footer_push();
})

</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/stickySidebar.js"></script>
<script>
jQuery(document).ready(function($){
    
    $('.sidebar').stickySidebar({
	    headerSelector: '#masthead',
        navSelector: '',
        contentSelector: '#main',
        footerSelector: '',
        sidebarTopMargin: 60,
        footerThreshold: 0
        
	});
})
</script>
<div class="top_header_bar">
    <div class="wrapper cf">
    
    <h2 class="pp_title"><?php echo get_option( 'sa_pp_main_title'); ?></h2>
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
    <div class="post_nav <?php if($prpo && $nepo){  }else{ echo "no_sep"; } ?>">
    <div id="project-prev"><?php previous_post_link('%link', '<i class="fa fa-long-arrow-left"></i> Previous'); ?></div>
    <div class="sep">|</div>
    <div id="project-next"><?php next_post_link('%link', 'Next <i class="fa fa-long-arrow-right"></i>'); ?></div>
    </div>
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
		<div id="content" class="site-content wrapper border_right " role="main">
        
            <div class="right_policies">
            
              <?php sa_breadcrumbs(); ?>
                <?php
                    
                    $my_query = array('orderby' => 'menu_order','order'   => 'DESC',);;
                    if($user_role == "administrator"){
                        
                    }else{
                     $my_query = array(
                          'meta_query'	=> array(array('key'=> 'user_type','value'=> $user_role,'compare'=> 'LIKE',)),
                          'orderby' => 'menu_order','order'   => 'DESC',
                          );
                     }
                 global $wp_query;
                    query_posts(
                    	array_merge(
                    		$wp_query->query,
                    		$my_query
                    	)
                    ); 
                
                if ( have_posts() ) :
                 $i=1;	while ( have_posts() ) : the_post(); 
                    ?>
                <div class="entry-content cf policiy_content">
                <div class="table_content">
                    <div class="table_cell left_title">
                        <h1 class="page_title"><?php  the_title();  ?></h1>
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'policies-type' );
                        
                        $s = get_ancestors( current($terms)->term_id, 'policies-type' );
                        if($s){
                            $array = get_term_by('id', end($s), 'policies-type', 'ARRAY_A');
                            $name=  $array['name']; 
                            
                        }else{
                            $array = get_term_by('id', current($terms)->term_id, 'policies-type', 'ARRAY_A'); 
                            $name =  $array['name'];
                            
                        }
                        if($name){
                        ?>
                        <span class="cat_name"><em>Category:</em> <?php echo $name; ?></span>
                        <?php } ?>
                    </div>
                    <div class="table_cell right_table">
                        <table>
                            <?php $policy_doc_type = get_post_meta(get_the_ID(), 'policy_doc_type', true); if($policy_doc_type){ ?>
                            <tr>
                                <td class="right">Document Number</td>
                                <td><strong><?php echo $policy_doc_type; ?></strong></td>
                            </tr>
                            <?php } ?>
                            <?php $policy_effective_date = get_post_meta(get_the_ID(), 'policy_effective_date', true); if($policy_effective_date){ ?>
                            <tr>
                                <td class="right">Effective Date</td>
                                <td><strong><?php echo $policy_effective_date; ?></strong></td>
                            </tr>
                            <?php } ?>
                            <?php $policy_revision_date = get_post_meta(get_the_ID(), 'policy_revision_date', true); if($policy_revision_date){ ?>
                            <tr>
                                <td class="right">Revision Date</td>
                                <td><strong><?php echo $policy_revision_date; ?></strong></td>
                            </tr>
                            <?php } ?>
                            <?php $policy_rev_no = get_post_meta(get_the_ID(), 'policy_rev_no', true);  if($policy_rev_no){ ?>
                            <tr>
                                <td class="right">Revision Number</td>
                                <td><strong><?php echo $policy_rev_no; ?></strong></td>
                            </tr>
                            <?php } ?>
                            <?php $policy_approved_by = get_post_meta(get_the_ID(), 'policy_approved_by', true);  if($policy_approved_by){ ?>
                            <tr>
                                <td class="right">Approved By</td>
                                <td><strong><?php echo $policy_approved_by; ?></strong></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="content_gray">
                    <?php $policy_purpose = get_post_meta(get_the_ID(), 'policy_purpose', true);  if($policy_purpose){ ?>
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>1.0</em> Purpose
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_purpose); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_persons = get_post_meta(get_the_ID(), 'policy_persons', true);  if($policy_persons){ ?>
                    
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>2.0</em> Persons Affected
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_persons); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_policy = get_post_meta(get_the_ID(), 'policy_policy', true);  if($policy_policy){ ?>
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>3.0</em> Policy
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_policy); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_definitions = get_post_meta(get_the_ID(), 'policy_definitions', true); if($policy_definitions){ ?>
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>4.0</em> Definitions
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_definitions); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_responsibilities = get_post_meta(get_the_ID(), 'policy_responsibilities', true); if($policy_responsibilities){ ?>
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>5.0</em> Responsibilities
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_responsibilities); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_procedures = get_post_meta(get_the_ID(), 'policy_procedures', true); if($policy_procedures){ ?>
                        <div class="box_content">
                            <h2 class="box_title">
                                <em>6.0</em> Procedures
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_procedures); ?>
                        </div>
                    <?php } ?>
                     <?php $policy_approvals = get_post_meta(get_the_ID(), 'policy_approvals', true); if($policy_approvals){ ?>
                        <div class="box_content approval_box">
                            <h2 class="box_title">
                                <em>7.0</em> Approvals
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_approvals); ?>
                        </div>
                    <?php } ?>
                    <?php $policy_revision_history= get_post_meta(get_the_ID(), 'policy_revision_history', true); if($policy_revision_history){ ?>
                        <div class="box_content revision_history">
                            <h2 class="box_title">
                                <em>8.0</em> Revision History
                            </h2>
                            <?php  echo apply_filters('the_content',$policy_revision_history); ?>
                        </div>
                    <?php } ?>
                </div>
                    
                    
                    <?php
        				// Start the Loop.
        			 
                        // the_content();                        				
        			//	endwhile;
                          
        			?>
                 
                </div>
                <?php if($i=="1"){ break; } ?>
                
                <?php $i++;  endwhile; ?>
                <?php else: ?>
                
                <div class="entry-content cf policiy_content">
                <h2 >No Policies &amp; Procedures Found.</h2>
                </div>
                <?php endif; ?>
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
            
        <div class="push"></div>
        <div class="cf"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //  get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
