<?php
/**
 * Template Name: Login Page
 *
 */

get_header('login'); ?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
                    <div class="login_wrap">
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
			         <div class="login_form cf">
                      <form id="login" action="login" method="post" class="desktop_login">
                            <span class="status"></span>
                            
                            	<div class="block" ><input id="username" type="text" name="USERNAME" class="input-style" placeholder="Username"></div>
                            	<div class="block" ><input id="password" type="password" name="PASSWORD" class="input-style" placeholder="Password"></div>
                            	<div class="block submit_block"><input type="submit" name="submit" class="submit-style submit_button" value="LOGIN"></div>
                          
                            
                             <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                        </form> 
                    </div>
                    </div>
		</div><!-- #content -->
        <div class="push"></div>
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
get_footer('login');