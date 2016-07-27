<?php

function sa_theme_setup_menu() {
	 add_menu_page('Theme settings', 'Theme settings', 'manage_options', 'sa-hq-theme-admin-page.php', 'sa_theme_init', 'dashicons-admin-generic' ); 
}
add_action( 'admin_menu', 'sa_theme_setup_menu' );

// Register options 
function register_sa_theme_settings() {
    register_setting( 'sa-theme-settings', 'sa_custom_title' );
    register_setting( 'sa-theme-settings', 'sa_pp_main_title' );
    register_setting( 'sa-theme-settings', 'course_main_page' );
    register_setting( 'sa-theme-settings', 'course_timezone' );
    register_setting( 'sa-theme-settings', 'lesson_confirm_message' );
    register_setting( 'sa-theme-settings', 'user_role' );
    register_setting( 'sa-theme-settings', 'access_denied_message' );
    register_setting( 'sa-theme-settings', 'login_page' );
    
    
}
add_action( 'admin_init', 'register_sa_theme_settings' );
 
 

function sa_theme_activate() {
  
if(!get_option('sa_pp_main_title')){    
    update_option( 'sa_pp_main_title', 'Policies & Procedures' );
}
if(!get_option('sa_custom_title')){    
    update_option( 'sa_custom_title', 'HQ' );
}
if(!get_option('access_denied_message')){    
    update_option( 'access_denied_message', 'Access denied for you.' );
}
if(!get_option('course_timezone')){    
    update_option( 'course_timezone', 'UTC' );
}

}
register_activation_hook(__FILE__, 'sa_theme_activate' );


 
function sa_theme_init(){ ?>
  <h2>Theme Settings</h2>  
  <form method="post" action="options.php">
  <?php if(isset($_GET['settings-updated']) ){ ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
    <?php } settings_fields( 'sa-theme-settings' ); 
        do_settings_sections( 'sa-theme-settings' );  ?>
        <table class="form-table">
      
         <tr valign="top">
            <th scope="row">Custom Tagline</th>
            <td><input type="text" name="sa_custom_title" class="regular-text ltr" value="<?php echo get_option( 'sa_custom_title' ); ?>"/></td>      
        </tr>
        <tr valign="top">
            <th scope="row">P&P Main Title</th>
            <td><input type="text" name="sa_pp_main_title" class="regular-text ltr" value="<?php echo get_option( 'sa_pp_main_title' ); ?>"/></td>      
        </tr>
        <tr valign="top">
            <th scope="row">Login Page Select</th>
            <td>
            <select name="login_page" class="regular-text ltr">
            <option value="">Select Page</option>
            <?php $args = array('post_type'=> 'page','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
            $pages = get_posts($args);
            $tpa = array();
            if( $pages ) {
            foreach ( $pages as $ap ){ ?>
                <option value="<?php echo $ap->ID; ?>" <?php if(get_option('login_page') ==$ap->ID ){ echo "selected"; }?> ><?php echo get_the_title($ap->ID); ?></option>
            <?php 	}
            } ?>
            </select>
            </td>      
        </tr>
        <tr valign="top">
            <th scope="row">Course Main Page</th>
            <td>
            <select name="course_main_page" class="regular-text ltr">
            <option value="">Select Page</option>
            <?php $args = array('post_type'=> 'page','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
            $pages = get_posts($args);
            $tpa = array();
            if( $pages ) {
            foreach ( $pages as $ap ){ ?>
                <option value="<?php echo $ap->ID; ?>" <?php if(get_option('course_main_page') ==$ap->ID ){ echo "selected"; }?> ><?php echo get_the_title($ap->ID); ?></option>
            <?php 	}
            } ?>
            </select>
            </td>      
        </tr>
         <tr valign="top">
            <th scope="row">Course Timezone</th>
            <td>
            <select name="course_timezone" class="regular-text ltr">
            <?php  $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            if( $tzlist ) {
            foreach ( $tzlist as $ap ){ ?>
                <option value="<?php echo $ap; ?>" <?php if(get_option('course_timezone') ==$ap ){ echo "selected"; }?> ><?php echo $ap; ?></option>
            <?php 	}
            } ?>
            </select>
            </td>      
        </tr>
        <tr valign="top">
            <th scope="row">Confirm Lesson Message</th>
            <td>
            <textarea name="lesson_confirm_message" id="lesson_confirm_message"><?php echo get_option( 'lesson_confirm_message' ); ?></textarea>
            </td>      
        </tr>
        
         <tr valign="top">
            <th scope="row">Add User Types</th>
            <td>
                    <?php 
                    $meta = get_option( 'user_role' );
                    echo '<a class="repeatable-add button" href="#">+</a>
                                <ul id="user_role-repeatable" class="custom_repeatable">';
                        $i = 0;
                        if ($meta) {
                            foreach($meta as $row) {
                                echo '<li><input type="text" name="user_role['.$i.']" id="user_role" value="'.$row.'" size="30" />
                                            <a class="repeatable-remove button" href="#">-</a></li>';
                                $i++;
                            }
                        } else {
                            echo '<li><input type="text" name="user_role['.$i.']" id="user_role" value="" size="30" />
                                        <a class="repeatable-remove button" href="#">-</a></li>';
                        }
                        echo '</ul>'; ?>
            </td>      
        </tr>
        <tr valign="top">
            <th scope="row">Access Denied Message</th>
            <td><input type="text" name="access_denied_message" class="regular-text ltr" value="<?php echo get_option( 'access_denied_message' ); ?>"/></td>      
        </tr>
        

            
        
</table> 
<div class="cf clearfix" style="clear: both;"></div>
<?php submit_button(); ?>
    </div>
  </form>
<style>
#wpfooter{position: relative;}
.note{font-size: 12px; line-height: 20px;}
.ui-datepicker-calendar {
    display: none;
}
.inside_text td{padding: 0; }
.inside_text h3{margin-bottom: 0; margin-top: 20px;}
</style>
<?php }

?>