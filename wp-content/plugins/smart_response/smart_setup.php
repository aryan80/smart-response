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

function add_smart_metabox(){
	 add_meta_box('smart_metabox_for_response', 'Response Post\'s Organization', 'smart_organization_function', 'response_surveys', 'normal', 'default');
}
function smart_organization_function(){
	global $wpdb,$post;
			$table=$wpdb->prefix.posts;
			$org=$wpdb->get_results("select post_name from ".$table." where post_type='organizations' and post_status='publish'",ARRAY_A);
			$disasters=$wpdb->get_results("select post_name from ".$table." where post_type='disasters' and post_status='publish'",ARRAY_A);
			$corg=get_post_meta($post->ID,'organization',true);
			$disaster=get_post_meta($post->ID,'disaster',true);
			?>

            <div style="float:left; width:100%;"><h4>
                   <?php echo _e('Organizations : ','smart');?> <select name="organizations" >
                    	<option value="" >Select Organization</option>
                        <?php
							if(!empty($org)){
								foreach($org as $one_org){
									echo '<option value="'.$one_org['post_name'].'" '.($corg==$one_org['post_name']?'selected':'').'>'.$one_org['post_name'].'</option>';
								}
							}
						?>

                    </select>
           </h4></div>
           <div style="float:left; width:100%;"><h4><label for="current_disaster">This Response's disaster is &nbsp;:&nbsp;<strong><?php echo $disaster;?></strong></label> </h4></div>
            <div style="float:left; width:100%;"><h4>
                   <?php echo _e('Disasters : ','smart');?> <select name="disasters" onchange="this.form.submit();">
                    	<option value="" >Select Disaster</option>
                         <?php
							if(!empty($disasters)){
								foreach($disasters as $one_disater){
									if($disaster!=$one_disater['post_name'])
									echo '<option value="'.$one_disater['post_name'].'" >'.$one_disater['post_name'].'</option>';
								}
							}
						?>
                    </select>
                    </h4>
           </div>
<?php
}
add_action( 'add_meta_boxes', 'add_smart_metabox' );
function smart_save_organization_meta($post_id,$post){

	if(isset($_POST['organization']) and $_POST['organization']!=''){
		update_post_meta($post_id,'organization',$_POST['organization']);
	}
	if(isset($_POST['disaster']) and $_POST['disaster']!=''){
		update_post_meta($post_id,'disaster',$_POST['disaster']);
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

