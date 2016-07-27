<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>

		</div><!-- #main -->
   
		<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="wrapper cf">

            <div id="supplementary">
            	<div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
                <?php if (is_user_logged_in()){ 
                        global $wp_roles;
                            $current_user = wp_get_current_user();
                            $roles = $current_user->roles;
	                       $role = array_shift($roles);
                             ?>  
                        <aside class="widget widget_text right">
                            <div class="textwidget"><div class="user_type">User Type: <strong><?php  if(isset($wp_roles->role_names[$role])){ echo translate_user_role($wp_roles->role_names[$role] ); } ?></strong></div>
                            </div>
                        </aside>
                    <?php } ?>
                    
            		<?php dynamic_sidebar( 'sidebar-3' ); ?>
                    
                    
                      
            
            	</div><!-- #footer-sidebar -->
            </div><!-- #supplementary -->

            
             
        </div>
		</footer><!-- #colophon -->
	</div><!-- #page -->
</div>
	<?php wp_footer(); ?>
</body>
</html>