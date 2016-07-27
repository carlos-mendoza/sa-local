<?php
/**
 * Template Name: Home Page Template
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 
$post_id = get_the_ID();
$home_q_note = get_post_meta($post_id, 'home_q_note', true);
$home_q_note_title = get_post_meta($post_id, 'home_q_note_title', true);
$home_learn_more_text = get_post_meta($post_id, 'home_learn_more_text', true);
$home_learn_more_link = get_post_meta($post_id, 'home_learn_more_link', true);
$home_learn_more_ntab = get_post_meta($post_id, 'home_learn_more_ntab', true);
$homeapp_select = get_post_meta($post_id, 'homeapp_select', true);

$home_view_all_app_link = get_post_meta($post_id, 'home_view_all_app_link', true);
$home_training_title = get_post_meta($post_id, 'home_training_title', true);
$home_all_training_cources = get_post_meta($post_id, 'home_all_training_cources', true);
$home_all_cources_link = get_post_meta($post_id, 'home_all_cources_link', true);

$custom_privacy ;
if($user_role == "administrator"){
    $custom_privacy = array();
}else{
    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare' => 'LIKE',)));
}


 ?>
<div class="home_page_banner">
<div class="wrapper cf table">
<div class="left table_cell">
<h3 class="quick_note"><?php echo $home_q_note; ?></h3>

<h1 class="quick_note_title"><?php echo $home_q_note_title; ?></h1>
<?php if($home_learn_more_link){ ?><a href="<?php echo $home_learn_more_link; ?>" class="learn_more_button" <?php if($home_learn_more_ntab){ echo 'target="_blank"'; } ?> ><?php echo $home_learn_more_text; ?></a><?php } ?>
</div>
<div class="right table_cell">

<?php 

$posts = json_decode($homeapp_select);
if( $posts ): ?>
    <ul class="home_apps cf">
    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php $myposts = get_post(array( 'page_id' => $post ) ); 
             setup_postdata( $myposts ); ?>
        <li>
            <a href="<?php echo get_post_meta(get_the_ID(), 'app_box_link ', true); ?>" target="_blank"><?php the_title(); ?></a>
        </li>
    <?php endforeach; ?>
      <?php wp_reset_postdata();?>
      
      <?php if($home_view_all_app_link){  ?>
        <li class="view_all">
            <a href="<?php echo $home_view_all_app_link; ?>">View All Apps <i class="fa fa-long-arrow-right"></i></a>
        </li>
        <?php } ?>
    </ul>
  
<?php endif; ?>

<?php wp_reset_query(); ?>

<?php wp_reset_postdata(); ?>

</div>
</div>
</div>

<div class="latest_courses">
<div class="wrapper">
<h2 class="training_cource_title"><?php echo $home_training_title; ?></h2>
<?php
    $args = array('post_type'=> array( 'courses'),'posts_per_page'=>3,'order_by'=>'menu_order');
    query_posts( array_merge($args,$custom_privacy) );
	 while ( have_posts() ) : the_post();                    
 ?><a href="<?php echo get_permalink(get_the_ID()); ?>" target="_blank">
    <div class="recent_cources">
        <div class="icon_cource">
            <i class="fa fa-desktop"></i>
        </div>
        <div class="right_cource">
            <div class="cource_title"><?php the_title(); ?></div>
            <div class="cource_date">Added on: <?php echo get_the_date('F d')."<sup>".get_the_date('S')."</sup> ".get_the_date('Y'); ?>
            </div>
        </div>
        
    </div>
    </a>
<?php endwhile; wp_reset_query(); ?>

<?php if($home_all_cources_link){ ?><a href="<?php echo $home_all_cources_link; ?>" class="view_all_cource" target="_blank"><?php echo $home_all_training_cources; ?></a><?php } ?>
</div>
</div>

 <div class="push"></div>
<?php 
get_footer();

