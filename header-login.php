<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
  if (is_user_logged_in()){ 
    wp_redirect(site_url());

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
    
    <script>
    function footer_push(){
        jQuery(".push").height(0);
        var wh = jQuery(window).height();
        var dh = jQuery("body").height();
        var fh = 0;
        jQuery(".push").height(wh);
    }
    jQuery(document).ready(function($){footer_push();})
    jQuery(window).load(function(){footer_push();})
    jQuery(window).resize(function(){footer_push();})
    </script>
</head>

<body <?php body_class(); ?>>
<div class="relative">
<div id="login_page" class="hfeed site">
	<div id="main" class="site-main">