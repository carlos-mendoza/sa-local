<?php
// register Course
add_action( 'init', 'cptui_register_my_cpts_courses' );
function cptui_register_my_cpts_courses() {
	$labels = array(
		"name" => __( 'Courses', 'sa-hq' ),
		"singular_name" => __( 'Course', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'Courses', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
        'menu_icon'=> 'dashicons-welcome-learn-more',
		"hierarchical" => true,
		"rewrite" => array( "slug" => "courses", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title", "editor", "thumbnail" ),				
	);
	register_post_type( "courses", $args );
}

// register Lessons
add_action( 'init', 'cptui_register_my_cpts_lessons' );
function cptui_register_my_cpts_lessons() {
	$labels = array(
		"name" => __( 'Lessons', 'sa-hq' ),
		"singular_name" => __( 'Lessons', 'sa-hq' ),
		);

	$args = array(
		"label" => __( 'lessons', 'sa-hq' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "lessons", "with_front" => true ),
		"query_var" => true,
        'show_in_menu' => 'edit.php?post_type=courses',				
		"supports" => array( "title", "editor", "thumbnail" ),				
	);
	register_post_type( "lessons", $args );
}

// register Course Category
add_action( 'init', 'cptui_register_my_taxes_course_categories' );
function cptui_register_my_taxes_course_categories() {
	$labels = array(
		"name" => __( 'Course Categories', 'sa-hq' ),
		"singular_name" => __( 'Course Category', 'sa-hq' ),
		);
	$args = array(
		"label" => __( 'Course Categories', 'sa-hq' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Course Categories",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'course-categories','with_front' => true,'hierarchical' => true ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "course-categories", array( "courses" ), $args );
}




// Display Meta for Course
function display_cs_meta($custom_fields){
    global $custom_meta_fields, $post;

    // Begin the field table and loop
	echo '<table class="form-table">';
        
	foreach ($custom_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
                    
                    case 'multi_select':
                            $meta = json_decode($meta);
                            if(!$meta){
                                $meta = array();
                            }
                            
						echo '<select name="'.$field['id'].'[]" id="'.$field['id'].'" multiple class="multi_select">';
						foreach ($field['options'] as $option) {
							echo '<option',  in_array($option['value'] ,$meta) == true ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                        
					break;
                    
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
    					$items = get_posts( array (
    						'post_type'	=> $field['post_type'],
    						'posts_per_page' => -1
    					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '0';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/images/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
                    // wysiwyg
                    case 'wysiwyg':
                        $meta_box_id = $field['meta_id'];
                        $editor_id = $field['id'];
                        echo "<style type='text/css'>
                                        #$meta_box_id #edButtonHTML, #$meta_box_id #edButtonPreview {background-color: #F1F1F1; border-color: #DFDFDF #DFDFDF #CCC; color: #999;}
                                        #$editor_id{width:100%;}
                                        #$meta_box_id #editorcontainer{background:#fff !important;}
                                </style>
                            
                                <script type='text/javascript'>
                                        jQuery(function($){
                                                $('#$meta_box_id #editor-toolbar > a').click(function(){
                                                        $('#$meta_box_id #editor-toolbar > a').removeClass('active');
                                                        $(this).addClass('active');
                                                });
                                                
                                                if($('#$meta_box_id #edButtonPreview').hasClass('active')){
                                                        $('#$meta_box_id #ed_toolbar').hide();
                                                }
                                                
                                                $('#$meta_box_id #edButtonPreview').click(function(){
                                                        $('#$meta_box_id #ed_toolbar').hide();
                                                });
                                                
                                                $('#$meta_box_id #edButtonHTML').click(function(){
                                                        $('#$meta_box_id #ed_toolbar').show();
                                                });
                				//Tell the uploader to insert content into the correct WYSIWYG editor
                				$('#media-buttons a').bind('click', function(){
                					var customEditor = $(this).parents('#$meta_box_id');
                					if(customEditor.length > 0){
                						edCanvas = document.getElementById('$editor_id');
                					}
                					else{
                						edCanvas = document.getElementById('content');
                					}
                				});
                                        });
                                </script>
                        ";
                        
                        
                        $content = get_post_meta($post->ID, $field['id'], true);
                        $editor_settings = array('media_buttons' => false);
                        wp_editor($content, $editor_id, $editor_settings);
                        //wp_editor($content, $editor_id);                        
                        echo "<div style='clear:both; display:block;'></div>";
						
					break;
                    
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
				}
		echo '</td></tr>';
	} 
	echo '</table>'; 
}

// Add meta boxes
function leaning_section(){
add_meta_box(
    'course_meta_box', // $id
    'Course Fields', // $title 
    'show_course_meta_box', // $callback
    'courses', // $page
    'normal', // $context
    'high');
    
    add_meta_box(
    'lesson_meta_box', // $id
    'Lesson Fields', // $title 
    'show_ls_meta_box', // $callback
    'lessons', // $page
    'normal', // $context
    'high');
}
add_action('add_meta_boxes', 'leaning_section');
    
$args = array('post_type'=> 'lessons','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
$les = get_posts($args);
$lession = array();
if( $les ) {
foreach ( $les as $l ) {
    $lession[$l->ID] = array ('label' => $l->post_title,'value'	=> $l->ID);
	}
}

// Fields for Learning Post type
$prefix_c = 'cs_box';
$course_meta_fields = array(
	array(
		'label'	=> 'Platform',
		'desc'	=> '',
		'id'	=> $prefix_c.'_platform',
		'type'	=> 'text'
	),
    array(
		'label'	=> 'About',
		'desc'	=> '',
		'id'	=> $prefix_c.'_about',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Lesson Selection',
		'desc'	=> '',
		'id'	=> $prefix.'_lession_select',
		'type'	=> 'multi_select',
		'options' => $lession
	),
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);

function show_course_meta_box() {
	global $custom_meta_fields, $post,$course_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_cs_meta($course_meta_fields);
}



// Fields for Learning Post type
$prefix_c = 'ls';
$lesson_meta_fields = array(
	array(
		'label'	=> 'Lesson Resources',
		'desc'	=> '',
		'id'	=> $prefix_c.'_resource',
		'type'	=> 'repeatable',
	
	),
    array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);
    
// display meta for Learning
function display_ls_meta($custom_fields){
    global $custom_meta_fields, $post;

    // Begin the field table and loop
	echo '<table class="form-table">';
        
	foreach ($custom_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
                    
                    case 'multi_select':
                            $meta = json_decode($meta);
                            if(!$meta){
                                $meta = array();
                            }
                            
						echo '<select name="'.$field['id'].'[]" id="'.$field['id'].'" multiple class="multi_select">';
						foreach ($field['options'] as $option) {
							echo '<option',  in_array($option['value'] ,$meta) == true ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                        
					break;
                    
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				
				
					// repeatable
					case 'repeatable':
                                    $options = array (
                                    		'Download Icon' => 'fa-download',
                                    		'Link Icon' => 'fa-link',
                                    	);
					 ?>
                          	<script type="text/javascript">
                            	jQuery(document).ready(function( $ ){
                            		jQuery( '#add-row' ).on('click', function() {
                            			var row = jQuery( '.empty-row.screen-reader-text' ).clone(true);
                            			row.removeClass( 'empty-row screen-reader-text' );
                            			row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                            			return false;
                            		});                              	
                            		jQuery( '.remove-row' ).on('click', function() {
                            			jQuery(this).parents('tr').remove();
                            			return false;
                            		});
                            	});
                            	</script>  
                                <table id="repeatable-fieldset-one" width="100%" class="<?php echo $field['id']; ?>">
                            	<thead>
                            		<tr>
                            			<th width="36%">Icon Select</th>
                            			<th width="12%">Resource Title</th>
                            			<th width="36%">Resource URL</th>
                                        <th width="8%">URL in new tab</th>
                            			<th width="8%"></th>
                                        
                            		</tr>
                            	</thead>
                            	<tbody>
                            	<?php
                            	if ( $meta ) :
                            	   foreach ( $meta as $field ) {
                            	?>
                            	<tr>
                            		
                            	
                            		<td>
                            			<select name="select[]">
                            			<?php foreach ( $options as $label => $value ) : ?>
                            			<option value="<?php echo $value; ?>"<?php selected( $field['select'], $value ); ?>><?php echo $label; ?></option>
                            			<?php endforeach; ?>
                            			</select>
                            		</td>
                                    <td><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>
                      	             <td><input type="text" class="widefat" name="url[]" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] ); else echo 'http://'; ?>" /></td>
                                    <td><label><input type="checkbox" name="link_newatab[]" value="yes" <?php if ($field['link_newatab'] != '') echo "checked"; ?>/> Yes</label></td>
                            	
                            		<td><a class="button remove-row" href="#">Remove</a></td>
                            	</tr>
                            	<?php
                            	}
                            	else :
                            	// show a blank one
                            	?>
                            	<tr>
                            		
                            	
                            		<td>
                            			<select name="select[]">
                            			<?php foreach ( $options as $label => $value ) : ?>
                            			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                            			<?php endforeach; ?>
                            			</select>
                            		</td>
                      	             <td><input type="text" class="widefat" name="name[]" /></td>
                            		<td><input type="text" class="widefat" name="url[]" value="http://" /></td>
                                    <td><label><input type="checkbox" name="link_newatab[]" value="yes" /> Yes</label></td>
                            	
                            		<td><a class="button remove-row" href="#">Remove</a></td>
                            	</tr>
                            	<?php endif; ?>
                            	
                            	<!-- empty hidden one for jQuery -->
                            	<tr class="empty-row screen-reader-text">
                            	
                            	
                            		<td>
                                		<select name="select[]">
                                        			<?php foreach ( $options as $label => $value ) : ?>
                                        			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                        			<?php endforeach; ?>
                                        </select>
                            		</td>
                             	      <td><input type="text" class="widefat" name="name[]" /></td>
                            		
                            		<td><input type="text" class="widefat" name="url[]" value="http://" /></td>
                                    <td><label><input type="checkbox" name="link_newatab[]" value="yes" /> Yes</label></td>
                            		  
                            		<td><a class="button remove-row" href="#">Remove</a></td>
                            	</tr>
                            	</tbody>
                            	</table>
                            	
                            	<p><a id="add-row" class="button" href="#">Add another</a></p>
					<?php break;
				}
		echo '</td></tr>';
	} 
	echo '</table>'; 
}

function show_ls_meta_box() {
	global $custom_meta_fields, $post,$lesson_meta_fields;
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	display_ls_meta($lesson_meta_fields);
}




function save_course_meta($post_id) {
    global $custom_meta_fields;
	global $course_meta_fields,$lesson_meta_fields;
    
    
	// verify nonce
	if (!isset( $_POST['custom_meta_box_nonce'] )  || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
    
  $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
  $post_tp = get_post_type($post_id);
  
  
      if($post_tp == 'courses'){
         foreach ($course_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
    
    if($post_tp == 'lessons'){
         foreach ($lesson_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
    		$old = get_post_meta($post_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'repeatable'){
            
                $old = get_post_meta($post_id, $field['id'], true);
            	$new = array();
            	
            	
            	$selects = $_POST['select'];
                $names = $_POST['name'];
            	$urls = $_POST['url'];
                $link_newatab = $_POST['link_newatab'];
            	
            	$count = count( $names );
                  $options = array ('Download Icon' => 'fa-download',
                                    'Link Icon' => 'fa-link',
                                    );
            	
            	for ( $i = 0; $i < $count; $i++ ) {
            		if ( $names[$i] != '' ) :
                    
            			$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
                        
            			
                        
            			if ( in_array( $selects[$i], $options ) )
            				$new[$i]['select'] = $selects[$i];
            			else
            				$new[$i]['select'] = '';
            		
            			if ( $urls[$i] == 'http://' )
            				$new[$i]['url'] = '';
            			else
            				$new[$i]['url'] = stripslashes( $urls[$i] ); // and however you want to sanitize
                
                        $new[$i]['link_newatab'] =  $link_newatab[$i] ;
                            
            		endif;
            	}
            
            
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			update_post_meta($post_id, $field['id'], $new);
    		} elseif ('' == $new && $old) {
    			delete_post_meta($post_id, $field['id'], $old);
    		}
    	}
    }
    
}
add_action('save_post', 'save_course_meta');




// Display selected Course for lesson in Admin.
add_filter( 'manage_edit-lessons_columns', 'sa_edit_lessons_columns' ) ;
function sa_edit_lessons_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Lesson' ),
		'course' => __( 'Course' ),
		'date' => __( 'Date' )
	);
	return $columns;
}

add_action( 'manage_lessons_posts_custom_column', 'sa_manage_lessons_columns', 10, 2 );
function sa_manage_lessons_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'course' :
            $cid= get_the_ID();
		  $args = array('post_type'=> 'courses','posts_per_page'=>-1,'orderby'=> 'menu_order','order'=>'ASC');
            $pages = get_posts($args);
            $tmp = array();
            if( $pages ) {
            foreach ( $pages as $ap ){ 
                $duration = get_post_meta( $ap->ID, 'home_lession_select', true );
                $duration = json_decode($duration);
                if($duration){
                if(in_array($cid,$duration)){
                    $tmp[] = get_the_title($ap->ID); 
                    } 
                }
                }
            } 
			/* If no duration is found, output a default message. */
			if ( empty( $tmp ) )
				echo __( 'Unknown' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
			  echo implode(", ",$tmp);
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}



// Set user type in Course Category
global $wp_roles;
$user_role = array();
foreach ( $wp_roles->role_names as $role => $name ) {
    $user_role[$role] = array ('label' => $name,'value'	=> $role);
}
$lp_type_meta_fields = array(
	array (
		'label'	=> 'Accessible User Types',
		'desc'	=> '',
		'id'	=> 'user_type',
		'type'	=> 'checkbox_group',
		'options' => $user_role
	),
);  
add_action( 'course-categories_add_form_fields', 'add_cs_type_group_field', 10, 2 );
function add_cs_type_group_field($taxonomy) {
    global $lp_type_meta_fields;
	foreach ($lp_type_meta_fields as $field) {
		$meta = "";
		echo '<div class="form-field term-group">
				<label for="'.$field['id'].'">'.$field['label'].'</label><div class="custom_checkbox">';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				}
		echo '</div></div>';
	} 
}


add_action( 'created_course-categories', 'save_cs_type', 10, 2 );
function save_cs_type( $term_id, $tt_id ){
         if( isset( $_POST['user_type'] ) && '' !== $_POST['user_type'] ){
        $group = $_POST['user_type'];
        add_term_meta( $term_id, 'user_type', $group, true );
    }
}


add_action( 'course-categories_edit_form_fields', 'edit_cs_type_field', 10, 2 );
function edit_cs_type_field( $term, $taxonomy ){
  global $feature_groups;
 global $lp_type_meta_fields;
	foreach ($lp_type_meta_fields as $field) {
		$feature_group = get_metadata( $term->term_id, $field['id'], true );
		$meta = $feature_group;
		echo '<tr class="form-field term-group-wrap"><th scope="row"><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
				switch($field['type']) {
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
				} 
		echo '</td></tr>';
	} 
}

add_action( 'edited_course-categories', 'update_cs_type', 10, 2 );
function update_cs_type( $term_id, $tt_id ){
        global $lp_type_meta_fields;
        foreach ($lp_type_meta_fields as $field) {
            if($field['type'] == 'tax_select') continue;
            $old = get_metadata($term_id, $field['id'], true);
    		$new = $_POST[$field['id']];
            if($field['type'] == 'multi_select'){
               $new = $_POST[$field['id']];
               $new = json_encode($new);
            }else{
                $new = $_POST[$field['id']];
            }
    		if ($new && $new != $old) {
    			 update_term_meta( $term_id, $field['id'], $new );
    		} elseif ('' == $new && $old) {
    			delete_term_meta($term_id, $field['id'], $old);
    		}
    	}
}


?>