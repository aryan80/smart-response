<?php
/* plugin Name: Smart Register
Author: Aryan Choudhary
Email: aryanchoudhary80@gmail.com
version:1.0
description: The plugin is just used for some customization in registration form.
*/
include('functions.php');
$organizations=array();
add_action('register_form','smart_register_form');
add_filter('registration_errors', 'smart_registration_errors', 10, 3);
add_action('user_register','save_smart_register_values');

/**
 * Adds a custom meta box to the main column on the Response edit screens.
 */
function add_smart_metabox(){
	 add_meta_box('smart_metabox_for_response', 'Organization and Disaster Information', 'smart_organization_function', 'responses', 'normal', 'high');
}

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function smart_organization_function($post){
	global $wpdb,$post;
			$table=$wpdb->prefix.posts;
			$disasters=$wpdb->get_results("select post_title from ".$table." where post_type='disasters' and post_status='publish'",ARRAY_A);
            $user_id = get_current_user_id();
            // get association associated with user
            $corg = trim(get_user_meta($user_id, 'organization', true));
            // get organization post
            $orgPost=$wpdb->get_results("select ID from ".$table." where post_status='publish' and post_type='organizations' and post_title='" . $corg . "'");
            $orgPost = $orgPost[0];
            // get disaster associated to current post
			$disaster = trim(get_post_meta($post->ID,'disaster',true));
            // get disasters already associated with the organization
            $orgDisasters = get_post_meta($orgPost->ID,'disasters',false);
            $tempDisaster = isset($_POST['disaster']) and $_POST['disaster']!='';
			?>

			<?php print_r($orgDisasters) ?>


            <div style="width:100%;">
               <label>Organization:
                  <input type="text" name="custom_organization" value="<?php echo $corg ?>"  />
               </label>
           </div>
           <div style="width:100%;">
               <label>Disaster:
               <?php
               if($disaster && $disaster != ''){
               ?>
                  <input type="text" name="disaster" value="<?php echo $disaster ?>" disabled />
                  <p><strong>Note:</strong> You can not change the disaster once it has been set.</p>
               <?php } else { ?>
                   <select name="disaster">
                        <option value="" >Select Disaster</option>
                         <?php
                            if(!empty($disasters)){
                                foreach($disasters as $one_disater){
                                    $title = trim($one_disater['post_title']);
                                    // only show disaster as in option if it's not associated
                                    // already with the organization, preventing orgs
                                    // from creating more than 1 response per disaster
                                    if(!in_array($title,$orgDisasters)){
                                        echo '<option value="'.$title.'" '.($tempDisaster==$title?'selected':'').'>'.$title.'</option>';
                                    }
                                }
                            }
                          ?>
                </select>
               <?php } ?>
               </label>
           </div>
<?php
}
add_action( 'add_meta_boxes', 'add_smart_metabox' );

/**
 * Extra steps taken on saving posts
 * @param WP_Post->ID $post_id The object ID of the current post/page.
 */
function smart_save_organization_meta($post_id){
    global $wpdb;

    if ( $_POST['post_type'] != 'responses' ) {
        return;
    }

    $table=$wpdb->prefix.posts;

    // update this Post's custom meta data for organization and disaster

    if($_POST['organization'] and $_POST['organization']!=''){
        update_post_meta($post_id,'organization',$_POST['organization']);
    }

    if($_POST['disaster'] and $_POST['disaster']!=''){
        update_post_meta($post_id,'disaster',$_POST['disaster']);
    }


    // get the organization's Post
    $orgPost=$wpdb->get_results("select ID from ".$table." where post_status='publish' and post_type='organizations' and post_title='" . $_POST['custom_organization'] . "'");
    $orgPost = $orgPost[0];

    // add the disaster to organization's Post disasters meta data field
    if($orgPost){
        add_post_meta($orgPost->ID,'disasters',$_POST['disaster']);
    }


	//here is the custom fields unix time stamps
	if(isset($_POST)){
		//exclude the default fields of posts for updating the custom fields into metaposts
		$post_default_fields=array('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_excerpt', 'post_status', 'comment_status', 'ping_status', 'post_password', 'post_name', 'to_ping', 'pinged', 'post_modified', 'post_modified_gmt', 'post_content_filtered', 'post_parent', 'guid', 'menu_order', 'post_type', 'post_mime_type','comment_count');
		$valid_meta_custom_fields=array();
		foreach($_POST as $key=>$value){
			if(!in_array($key,$post_default_fields)){
				$valid_meta_custom_fields[$key]=$value;
			}
		}
		if(!empty($valid_meta_custom_fields)){
			foreach($valid_meta_custom_fields as $meta_key=>$meta_value){
				update_post_meta($post_id,$meta_key.'_timestamp',time());
			}
		}
	}
}
add_action('save_post', 'smart_save_organization_meta', 1, 2);

