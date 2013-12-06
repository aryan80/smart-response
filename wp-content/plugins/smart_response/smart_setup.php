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



function hide_personal_options(){ 
?>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#your-profile .form-table:first, #your-profile h3:first").remove();
  });
</script>
<?php }
add_action('admin_head','hide_personal_options');

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['user_phone1'] = 'Phone 1';
	$profile_fields['user_phone2'] = 'Phone 2';
	$profile_fields['user_mobile1'] = 'Mobile 1';
	$profile_fields['user_mobile2'] = 'Mobile 2';
	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
function add_organization_section( $user ) {
?>
	<h3><?php _e('Organization Section', 'smart'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th>
				<label for="organization"><?php _e('Organization Name', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="organization" id="organization" value="<?php echo esc_attr( get_the_author_meta( 'organization', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Organization Name.', 'smart'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				<label for="title"><?php _e('Organization Title', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Organization Title.', 'smart'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="user_org_contact_name"><?php _e('Contact Name', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="user_org_contact_name" id="user_org_contact_name" value="<?php echo esc_attr( get_the_author_meta( 'user_org_contact_name', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Contact Name for Organization.', 'smart'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="user_org_contact_title"><?php _e('Contact Title', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="user_org_contact_title" id="user_org_contact_title" value="<?php echo esc_attr( get_the_author_meta( 'user_org_contact_title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Organization Contact Title.', 'smart'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="user_org_contact_phone"><?php _e('Contact Phone', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="user_org_contact_phone" id="user_org_contact_phone" value="<?php echo esc_attr( get_the_author_meta( 'user_org_contact_phone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Organization Contact Phone.', 'smart'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				<label for="user_org_contact_email"><?php _e('Contact Email', 'smart'); ?>
			</label></th>
			<td>
				<input type="text" name="user_org_contact_email" id="user_org_contact_email" value="<?php echo esc_attr( get_the_author_meta( 'user_org_contact_email', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please Enter Organization Contact Email.', 'smart'); ?></span>
			</td>
		</tr>
	</table>
<?php }

function save_organization_section( $user_id ) {
	
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	update_usermeta( $user_id, 'organization', $_POST['organization'] );
	update_usermeta( $user_id, 'title', $_POST['title'] );
	update_usermeta( $user_id, 'user_org_contact_name', $_POST['user_org_contact_name'] );
	update_usermeta( $user_id, 'user_org_contact_title', $_POST['user_org_contact_title'] );
	update_usermeta( $user_id, 'user_org_contact_phone', $_POST['user_org_contact_phone'] );
	update_usermeta( $user_id, 'user_org_contact_email', $_POST['user_org_contact_email'] );
}

add_action( 'show_user_profile', 'add_organization_section' );
add_action( 'edit_user_profile', 'add_organization_section' );

add_action( 'personal_options_update', 'save_organization_section' );
add_action( 'edit_user_profile_update', 'save_organization_section' );

function is_orgnization_has_permission($organization_id=NULL){
	//function to check if this organization has the permission
	$check_post_type='response_surveys';
	$current_screen=get_current_screen();
	$action=$current_screen->action;
	$post_type=$current_screen->post_type;
	if($action=='add'){
		if($check_post_type==$post_type){
			//then check the organizations disaster and surveys
			$total_disasters_for_this_org=get_post_meta($user_org_id,'no_of_disaster',true);
			$total_disasters_res_for_this_org=get_post_meta($user_org_id,'no_of_disaster_responses',true);
			if($total_disasters_for_this_org!=$total_disasters_res_for_this_org){
				echo 'The Organization do not has permission to add new survey!All Desasters have been responded for the user\'s organization.';
				return true;
			}else{
				echo 'The user\'s organization has permission for the disasters';	
				return false; // means the organization has completed all survesy for all disasters. no disaster is pending.	
			}
		}
	}
	//check if the post type of current post edit is 
}
function check_new_survey_for_the_current_user_organization(){
	//check for post survey that user have permission or not to create a survey for this disater for this country
	//so get user's organization first
	$current_user = wp_get_current_user();
	$userid= $current_user->ID;
	$user_org_id=get_user_meta($userid,'organization',true);
	//checkfor a permission for this org
	if(is_orgnization_has_permission($user_org_id)){ 
		exit;
	}
}
add_action('admin_head','check_new_survey_for_the_current_user_organization');
 ?>
        	
