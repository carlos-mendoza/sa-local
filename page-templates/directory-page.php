<?php
/**
 * Template Name: Directory Page Template
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
    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare'> 'LIKE',)));
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
     $('.masonary .cont_box').responsiveEqualHeightGrid();	
     $container = $('.masonary').isotope({
  itemSelector: '.box',
  percentPosition: true,
  masonry: {
    columnWidth: '.box'
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
</script>


<div id="main-content" class="main-content">
<div class="cf top_app">
<div class="wrapper cf">
<h1 class="page_title"><?php if($page_title){ echo $page_title; }else{ the_title(); }?></h1>
<?php
 $su2 = array_filter($user_type);
if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
<div class="filter_nav">
 <a data-filter="*" class="selected" href="javascript:;">All</a>
 <?php 
$taxonomies = array('department');
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
         <?php $taxonomies = array('department');
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
<?php } ?>

</div>
    
    


</div>
	<div id="primary" class="content-area">
		<div id="content" class="site-content application_wrapper" role="main">
        
            <div class="wrapper cf ">
              <?php
                 $su2 = array_filter($user_type);
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <div class="masonary cf">
        	<?php   $args = array('post_type'=> array( 'team-members'),'posts_per_page'=>-1,'order'=>'ASC','orderby'=>'meta_value','meta_key'=>'home_l_name');
                    query_posts( array_merge($args,$custom_privacy) );
				    while ( have_posts() ) : the_post(); 
                    $first_name = get_post_meta(get_the_ID(), 'home_f_name', true);
                    $last_name = get_post_meta(get_the_ID(), 'home_l_name', true);
                    $designation = get_post_meta(get_the_ID(), 'home_designation', true);
                    $email = get_post_meta(get_the_ID(), 'home_email', true);
                    $work = get_post_meta(get_the_ID(), 'home_work', true);
                    $cell_no = get_post_meta(get_the_ID(), 'home_cell_no', true);
                    $u_type = get_post_meta(get_the_ID(), 'home_u_type', true); ?>
               
                    <div class="box directory_box <?php $terms1 = get_the_terms( $post->ID, 'department' ); foreach ( $terms1 as $term2 ) {echo $term2->slug." ";} ?>">
                        <div class="cont_box ">
                            <div class="header_directory">
                                <h3 class="box_title"><?php echo $first_name; ?> <?php echo $last_name;?></h3>
                                <p class="designation"><?php echo $designation; ?></p>
                            </div>
                            <?php if($email){ ?>
                            <div class="data_value">
                                <span>Email</span>
                                <a href="mailto:<?php echo $email; ?>" class="email_directory"><?php echo $email; ?></a>
                            </div>
                            <?php } ?>
                            
                            <?php if($work){ ?>
                            <div class="data_value">
                                <span>Work</span>
                                <strong><?php echo $work; ?></strong>
                            </div>
                            <?php } ?>
                            
                            <?php if($cell_no){ ?>
                            <div class="data_value">
                                <span>CELL</span>
                                <strong><?php echo $cell_no; ?></strong>
                            </div>
                            <?php } ?>
                            
                            <?php $terms1 = get_the_terms( $post->ID, 'department' ); 
                                $current_depat = array();
                                foreach ( $terms1 as $term2 ) { $current_depat[] = $term2->name; } 
                                ?>
                            <?php if($current_depat){ ?>
                            <div class="data_value">
                                <span>department</span>
                                <strong><?php echo implode(", ", $current_depat); ?>
                                </strong>
                            </div>
                            <?php } ?>
                            
                             <?php  if($u_type){ ?>
                            <div class="data_value">
                                <span>User Type</span>
                                <strong><?php echo $u_type; ?>
                                </strong>
                            </div>
                            <?php } ?>
                            
                            
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

