<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 

$user_type = get_post_meta(get_the_ID(), 'user_type', true);
 if(!$user_type){
    $user_type = array();
}
?>
<div class="wrap">
 <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jprogress.css" />
<script src="<?php echo get_template_directory_uri(); ?>/js/jprogress.js" type="text/javascript"></script>
<div class="white_bg">
<div class="course_wrap cf inside_course">
 <?php sa_breadcrumbs(); ?>
 <?php $su2 = array_filter($user_type);
    if(in_array($user_role,$su2) || $user_role == "administrator"){  ?>
 <h1 class="course_title"><?php the_title(); ?></h1>

<div class="entry-content">

<div class="left_thumb">
<?php if(get_the_post_thumbnail($post->ID)){ ?>
<div class="course_thub">
<?php echo get_the_post_thumbnail($post->ID,'full'); ?>
</div>
<?php } ?>

<?php $lession = get_post_meta(get_the_ID(), 'home_lession_select', true);
$completed = 0;
if($lession){    
    $all_as = json_decode($lession);
    foreach($all_as as $p){
        $updated = get_post_meta($p, "complteted_user", true);
        if($updated){
            if(in_array(get_current_user_id(),$updated)){
            $completed++;
            }
        }
    }
$total_lession = count(json_decode($lession));
$cstring = $completed." Out of ".$total_lession." Lessons Completed"; 
$percent = ($completed*100)/ $total_lession;
?>
 <script>
 jQuery(document).ready(function(){
        jQuery(".progressbarsone").jprogress();
    
 })
</script>
<div class="info_complete"><?php echo $cstring; ?></div>
 <div class="progressbarsone" progress="<?php echo round($percent,2); ?>%"></div>
<?php } 
?>

</div>
<div class="right_course">
	       <?php while ( have_posts() ) : the_post();
				    the_content();
				endwhile;
			?>
</div>
<?php }else{  ?>
 <div class="entry-content">
    <h2 style="text-align:  center;" ><?php echo get_option( 'access_denied_message' ); ?></h2>
</div>
<?php } ?>

</div>

</div>
</div>


	<div id="primary" class="content-area">
		<div id="content" class="site-content list_c" role="main">
            <div class="course_wrap cf inside_course entry-content">
            <?php
            $su2 = array_filter($user_type);
            if(in_array($user_role,$su2) || $user_role == "administrator"){ 
                $lession = get_post_meta(get_the_ID(), 'home_lession_select', true); 
                if($lession){
                $all_lesson = json_decode($lession);
                ?>
            		  <h3 class="lesson_list_title">Course Lessons</h3>
                      
                      <ul class="lesson_list">
                      <?php foreach($all_lesson as $p){
                        $updated = get_post_meta($p, "complteted_user", true);
                        $user_acc = get_post_meta($p, "user_type", true);
                         if(!$user_acc){
                            $user_acc = array();
                         } 
                          $su3 = array_filter($user_acc);
                        if(in_array($user_role,$su3) || $user_role == "administrator"){
                       
                        ?>
                      <li class="<?php if($updated){ if(in_array(get_current_user_id(),$updated)){ echo "completed"; } } ?>"><a href="<?php echo get_permalink($p); ?>"><?php echo get_the_title($p); ?></a></li>
                      <?php } } ?>
                      </ul>
              <?php } 
              } ?>
            </div>
            <div class="push"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
</div>

<?php
get_footer();
