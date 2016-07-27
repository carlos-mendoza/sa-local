<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();
$timezone = get_option('course_timezone');
if($timezone){
date_default_timezone_set($timezone);
}
$date = new DateTime;




// delete_post_meta(get_the_ID(),"complete_time");
// delete_post_meta(get_the_ID(),"complteted_user");


$page_title = ""; 
$new = array();
$nn_time = array();
$cuser = get_current_user_id();

$post_id = get_the_ID();
$old = get_post_meta($post_id,"complteted_user", true);
if($old){
$old = (array)$old;
}


if(isset($_POST['lesson_status'])){
    if($_POST["lesson_status"] == 1){
        $cime = get_post_meta(get_the_ID(),"complete_time", true);
        
        $cusertime = array();
        $cusertime['user_'.$cuser] = $date->format('M d, Y')."<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>".$date->format('h:i A');
        
        if($old != null){
            if(!in_array($cuser,$old)){
            array_push($old,$cuser);
            }
            update_post_meta($post_id,"complteted_user", $old);
            if($cime != null){
                $nn_time = array_merge($cusertime, $cime);
            }  
            update_post_meta($post_id,"complete_time", $nn_time);
        }else{
            $new = (array)$cuser;
             update_post_meta($post_id,"complteted_user",$new);
            update_post_meta($post_id,"complete_time",$cusertime);
        }
    }
    if($_POST["lesson_status"] == 0){
        $a = $old;
        $cu = (array)$cuser;
        $arr = array_diff($a, $cu);
        if(!empty($arr)){
             update_post_meta($post_id,"complteted_user",$arr);
        }else{
            delete_post_meta(get_the_ID(),"complteted_user");
        }
        
        
    }
}
 $updated = get_post_meta($post_id, "complteted_user", true);
 if(!$updated){
    $updated = array();
 }
 
 $user_type = get_post_meta(get_the_ID(), 'user_type', true);
 if(!$user_type){
    $user_type = array();
}
$cimes = get_post_meta(get_the_ID(),"complete_time", true);
?>
<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/fancybox/jquery.fancybox.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fancybox/jquery.fancybox.css" />
<script>
jQuery(document).ready(function(){
    
    jQuery('.fancybox').fancybox({ padding:[0,0,0,0],
       tpl: {
				closeBtn : '',
			},});

    jQuery(".confirm_box label").click(function(){
        jQuery(".hide").trigger("click");
        //jQuery("#lesson_type").submit();
    })
    jQuery(".yes_btn").click(function(){
        jQuery("#lesson_type").submit();
    })
    jQuery(".no_btn").click(function(){
        jQuery.fancybox.close();
    })
})
</script>

<div id="main-content" class="main-content lesson_page">
	<div id="primary" class="content-area page_sidebar">
		<div id="content" class="site-content wrapper " role="main">
            <div class="right_content">
               <?php sa_breadcrumbs(); ?>
                <div class="entry-content cf">
               
                <?php $su2 = array_filter($user_type);
                if(in_array($user_role,$su2) || $user_role == "administrator"){  ?>
                <h1 class="page_title"><?php if($page_title){ echo $page_title; }else{ the_title(); } ?></h1>
                 <?php  if(!in_array(get_current_user_id(),$updated)){ ?>
                        <div class="ls_status mobile">
                        <span class="title_lesson">Lesson Status</span>
                        <span class="status_lesson">Incomplete <i class="fa fa-minus-circle"></i></span>
                        </div>
                <?php } if(in_array(get_current_user_id(),$updated)){ ?>
                        <div class="ls_status mobile <?php if(in_array(get_current_user_id(),$updated)){ echo "completed"; } ?>">
                        <span class="title_lesson">Lesson Status</span>
                        <span class="status_lesson">Complete <i class="fa fa-check-square"></i> 
                            <?php if($cimes){
                                if (array_key_exists('user_'.$cuser, $cimes)){
                                    echo "<em >".$cimes['user_'.$cuser]."</em>";
                                }
                            }?>                
                        </span>
                        </div>
                <?php }  ?>
                    <?php
        				// Start the Loop.
        			 	while ( have_posts() ) : the_post();
                        the_content();                        				
        				endwhile;
        			?>
                    <?php }else{  ?>
                    <div class=""><h2 style="text-align:  center;" ><?php echo get_option( 'access_denied_message' ); ?></h2></div>
                    <?php } ?>
                  
                </div>
            </div>
            <div class="left_content sidebar">
            <?php $su2 = array_filter($user_type);
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <?php  if(!in_array(get_current_user_id(),$updated)){ ?>
            <div class="ls_status desktop">
            <span class="title_lesson">Lesson Status</span>
            <span class="status_lesson">Incomplete <i class="fa fa-minus-circle"></i></span>
            </div>
            <?php } if(in_array(get_current_user_id(),$updated)){ ?>
            <div class="ls_status desktop <?php if(in_array(get_current_user_id(),$updated)){ echo "completed"; } ?>">
            <span class="title_lesson">Lesson Status</span>
            <span class="status_lesson">Complete <i class="fa fa-check-square"></i> 
                <?php if($cimes){
                    if (array_key_exists('user_'.$cuser, $cimes)){
                        echo "<em >".$cimes['user_'.$cuser]."</em>";
                    }
                }?>                
            </span>
            </div>
            <?php }  ?>
            
            <?php $resource = get_post_meta(get_the_ID(), "ls_resource", true); 
            if($resource){ 
                // print_r($resource);
            ?>
            <ul class="resource_side">
                <li class="title_main">Lesson Resources</li>
                <?php foreach($resource as $r){ ?>
                <li>
                    <a href="<?php echo $r['url']; ?>" <?php if($r['link_newatab'] == "yes"){ echo "target='_blank'"; } ?> ><i class="fa <?php echo $r['select']; ?>"></i><?php echo $r['name']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
            <?php } ?>
            
            
            <?php $su2 = array_filter($user_type);
                if(in_array($user_role,$su2) || $user_role == "administrator"){ ?>
            <?php  if(!in_array(get_current_user_id(),$updated)){ ?>
            
            <div class="confirm_box">
            <strong>Confirm Completion</strong>
            <label>I've fully reviewed the lesson's materials.</label>
            <a class="hide fancybox" href="#confirmation"></a>
            	<div id="confirmation" style="max-width:370px;display: none; width:100%; min-width: 280px;">
            		<h3>Confirmation</h3>
                    <?php if(get_option( 'lesson_confirm_message' )){  ?>
            		<p><?php echo get_option( 'lesson_confirm_message' ); ?></p>
                    <?php }  ?>
                    <span class="buttons_popup">
                        <a href="javascript:;" class="yes_btn">Yes</a>
                        <a href="javascript:;" class="no_btn">No</a>
                    </span>
	           </div>
            </div>
            <?php }
            } ?>
                <?php // dynamic_sidebar('sidebar-2'); ?>
                
                <div class="border_horizontal"></div>
            </div>
            
        <div class="push"></div>
        <div class="cf"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<form action="" method="post" id="lesson_type" >
    <input type="hidden" name="lesson_status" value="1" />            
</form>
            
            
            
<?php
get_footer();
