<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
 
  if (!is_user_logged_in()){ 
    if(get_option('login_page')){
        $lp_page=  get_option('login_page');
        wp_redirect(get_permalink($lp_page)); 
    }else{
            wp_redirect(site_url()."/login/");    
    }
    exit;
    }
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1.0, width=device-width,  minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fonts/stylesheet.css" />
	
    <?php wp_head(); ?>
    <script>var $ = jQuery.noConflict(); </script>
    <?php
    global $current_user;
    global $user_role;
    $user = wp_get_current_user();
    if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
    		foreach ( $user->roles as $role )
    		$user_role =  $role;
    	} 
 ?>
    <script src="<?php echo get_template_directory_uri(); ?>/js/grids.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/general.js"></script>
    <script>
            var xhr;
            function auto_sudgest(){
                var cu = '<?php echo $user_role; ?>';
            var ctxt= jQuery('.search_box input').val();
               jQuery('.auto_sudgest').hide();
               jQuery('.auto_sudgest li').remove();
            jQuery('.search_box').addClass("loading");
                 var params = {"ctxt":ctxt,"user":cu,action:"get_sudgets"}
                         if(xhr){
                            xhr.abort();
                        }
                		xhr = jQuery.post("<?php echo home_url(); ?>/wp-admin/admin-ajax.php",params,function(data){
                            
                           
                              if(data){
                               jQuery('.auto_sudgest').append(data);
                                jQuery('.auto_sudgest').show();
                                jQuery('.search_box').removeClass("loading");
        
                               }else{
                                jQuery('.search_box').removeClass("loading");
                                jQuery('.auto_sudgest').hide();
                               }
                        });
        }
        jQuery(document).ready(function(){
            var count = 0;
              jQuery(".search_box input").keyup(function(){
                        var keyword = jQuery(this).val();
                        if(keyword.length >= 3  && count == 0){
                            jQuery('.auto_sudgest').html('');
                            auto_sudgest();
                       }else{
                        jQuery('.auto_sudgest').hide();
                       }
            	});
               $('body').not('.auto_sudgest').click(function(){
                    $(".auto_sudgest").hide();
                });
        })
    </script>
   
            
</head>

<body <?php body_class(); ?>>
    <div class="relative">
    <div class="mobile_nav">
        <div class="mob_wrap">
            <a class="mob_close" href="javascript:;"></a>
            <div class="primary_nav">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu cf' ) ); ?>
            </div>
            <div class="custom_nav">
                <?php wp_nav_menu( array( 'theme_location' => 'top_menu', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
            </div>
            <div class="login_section">
                <?php if (is_user_logged_in()){ $current_user = wp_get_current_user(); ?>
                <div class="user_link">
                    Logged in as: <strong><?php echo  $current_user->display_name; ?></strong>
                 </div>
                  <a class="client_login logout_link" href="<?php echo wp_logout_url( home_url()); ?>">Logout</a>
                 <?php }  ?>
            </div>
        </div>
    </div>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header cf" role="banner">
		<div class="header-main wrapper cf">
        <div id="site-header">
            <?php if ( get_header_image() ) : ?>
        		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        		</a>
                <?php if(get_option( 'sa_custom_title')){ ?><span class="header_email"><?php echo get_option( 'sa_custom_title'); ?></span><?php } ?>
            <?php else: ?>
    		  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php endif; ?>            
        </div>
		<div class="top_nav">
            <?php wp_nav_menu( array( 'theme_location' => 'top_menu', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
            <?php  if (is_user_logged_in()){ $current_user = wp_get_current_user(); ?>
                <div class="user_link"><a href="javascript:;" class="logout_link"><i class="fa fa-user"></i><?php echo  $current_user->display_name; ?><i class="fa fa-angle-down"></i></a>
                    <ul class="sub_links">
                    <li><a class="client_login" href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
            <a href="javascript:;" class="mob_menu"></a>
            <nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>
			</nav>
		</div>
	</header><!-- #masthead -->
 <div id="main" class="site-main">
