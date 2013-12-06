<?php 
/*********************************** Smart Register Form Function Begins Here ************************************************************/
function smart_register_form(){
	global $wpdb,$organizations;
	$table=$wpdb->prefix.posts;
	$organizations=$wpdb->get_results("select ID,post_title from ".$table." where post_type='organization' and post_status='publish'",ARRAY_A);
	
        ?>
        <p>
        	<?php $first_name = ( isset( $_POST['first_name'] ) ) ? $_POST['first_name']: ''; ?>
        	<div style="float:left; width:100%; padding:1px;">
           <div style="float:left;width:150px;;"> <label for="first_name"><?php _e('First Name','smartreg') ?>:&nbsp;</label></div>
            <div style="float:left;width:450px;"> <input type="text" name="first_name" id="first_name" class="input" style="width:170px;" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="25" /></div>
            </div>
        </p>
         <p>
        	<?php $last_name = ( isset( $_POST['last_name'] ) ) ? $_POST['last_name']: ''; ?>
        	<div style="float:left; width:100%; padding:1px;">
           <div style="float:left;width:150px;"> <label for="first_name"><?php _e('Last Name','smartreg') ?>:&nbsp;</label></div>
            <div style="float:left;width:450px;"> <input type="text" name="last_name" id="last_name" class="input" style="width:170px;" value="<?php echo esc_attr(stripslashes($last_name)); ?>" size="25" /></div>
            </div>
        </p> 
        <p>
        	<?php $organization = ( isset( $_POST['organization'] ) ) ? $_POST['organization']: '';
				  $organization_new = ( isset( $_POST['organization_new'] ) ) ? $_POST['organization_new']: '';
			 ?>
        	<div style="float:left; width:100%; padding:1px;">
           <div style="float:left;width:150px;"> <label for="first_name"><?php _e('Organization','smartreg') ?>:&nbsp;</label></div>
            <div style="float:left;width:450px;">
            <select name="organization" id="organization" class="input">
            	<option value="">Select Your Organization</option>
                <?php if(!empty($organizations)){
					 foreach($organizations as $valueorg){
						 echo '<option value="'.$valueorg['ID'].'" '.($valueorg['ID']==$_POST['organization']).' >'.$valueorg['post_title'].'</option>';
					 }
				}?>
            </select>
            <p>
            Or Type your organization if its not in select box
            </p>
             <input type="text" name="organization_new" id="organization_new" class="input" style="width:170px;" value="<?php echo esc_attr(stripslashes($organization_new)); ?>" size="25" /></div>
            </div>
        </p>
         <p>
        	<?php $phone_number = ( isset( $_POST['phone_number'] ) ) ? $_POST['phone_number']: ''; ?>
        	<div style="float:left;width:100%; padding:1px;">
           <div style="float:left;width:150px;"> <label for="phone_number"><?php _e('Phone Number','smartreg') ?>:&nbsp;</label></div>
            <div style="float:left;width:450px;"> <input type="text" name="phone_number" id="phone_number" class="input" style="width:170px;" value="<?php echo esc_attr(stripslashes($phone_number)); ?>" size="25" /></div>
            </div>
        </p>
         
        <p>
        <?php $terms_conditions = ( isset( $_POST['terms_conditions'] ) ) ? $_POST['terms_conditions']: ''; ?>
        	<div style="float:left;width:100%; padding:1px;">
           <div style="float:left;width:150px;">&nbsp; </div>
            <div style="float:left;width:450px;"><input type="checkbox" name="terms_conditions" id="terms_conditions" class="input"  value="1"  <?php echo ($terms_conditions?'checked="checked"':''); ?> /> &nbsp;&nbsp;Accept <a href="<?php echo site_url();?>/termsandconditions"> terms&amp;conditions</a></div>
            </div>
        </p>
        <p>
        	<div style="float:left; width:100%; padding:1px;">
           <div style="float:left;width:150px;">Your IP Address:</div>
            <div style="float:left;width:450px;"> 
			<input type="hidden" name="ip_address" id="ip_address" value="<?php echo  $_SERVER['REMOTE_ADDR'];?>"/>
			<?php echo  $_SERVER['REMOTE_ADDR'];?>&nbsp;&nbsp;Your IP address will be recorded with your registration answers.</div>
            </div>
        </p>
        <?php
    }
/********************************************************** SAve Custom Register Values Function Begins here **************/
function save_smart_register_values($user_id){
		global $wpdb;
		$org=$_POST['organization_new'];
		//return false;
		 if ( isset( $_POST['first_name'] ) )
            update_user_meta($user_id, 'first_name', $_POST['first_name']);	
		 if ( isset( $_POST['last_name'] ) )
            update_user_meta($user_id, 'last_name', $_POST['last_name']);	
		 if ( isset( $_POST['organization'])  and $_POST['organization']!='' ){
           	 update_user_meta($user_id, 'organization', $_POST['organization']);	
		 }
		 if ( isset( $_POST['phone_number'] ) )
            update_user_meta($user_id, 'phone_number', $_POST['phone_number']);	
		 if ( isset( $_POST['terms_conditions'] ) )
            update_user_meta($user_id, 'terms_conditions', $_POST['terms_conditions']);	
		 if ( isset( $_POST['ip_address'] ) )
            update_user_meta($user_id, 'ip_address', $_POST['ip_address']);	
		//create a new organization if not exists
		$new_org = array(
			  'post_name'    => $org,
			  'post_title'    => $org,
			  'post_content'  => 'This is new Organization.',
			  'post_status'   => 'draft',
			  'post_author'   => $user_id,
			  'post_type' =>'organizations'
			);

		// Insert the post into the database
		 if ( isset( $_POST['organization_new'])  and $_POST['organization_new']!='' ){
					$org_id=wp_insert_post( $new_org );
					update_user_meta($user_id, 'organization',$org_id);
		 }
		//create the user id in this organizations meta
		update_post_meta($org_id,$_POST['user_login'],$user_id);
		update_post_meta($org_id,'no_of_disaster_responses','0');
		update_post_meta($org_id,'no_of_disaster','0');
		return true;
}
/************************************************************** Register form errors function starts here ***************************/
function smart_registration_errors($errors, $user, $user_email) {
	global $organizations;
        if ( empty( $_POST['first_name'] ) )
            $errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must enter Your First Name.','smartreg') );
		 if ( empty( $_POST['last_name'] ) )
		$errors->add( 'last_name_error', __('<strong>ERROR</strong>: You must enter Your Last Name.','smartreg') );
		 if ( empty( $_POST['phone_number'] ) )
		$errors->add( 'phone_number_error', __('<strong>ERROR</strong>: You must enter Phone Number.','smartreg') );
		 if ( empty( $_POST['terms_conditions'] ) )
		$errors->add( 'terms_conditions_error', __('<strong>ERROR</strong>: You must Accept Terms and Conditions.','smartreg') );
		if(!empty($_POST['organization_new']) and !empty( $_POST['organization']))
			$errors->add( 'terms_conditions_error', __('<strong>ERROR</strong>: Select an Organization or Type new. You can not do both.','smartreg') );
		if(!empty($_POST['organization_new'])){
			if(in_array($_POST['organization_new'],$organizations)){
				$errors->add( 'organization_new_error', __('<strong>ERROR</strong>: Organization is exists in select box. Please select it from box.','smartreg') );
			}
		}elseif(empty( $_POST['organization']) ){
				$errors->add( 'organization_error', __('<strong>ERROR</strong>: You must select your organization.','smartreg') );
			}
		
        return $errors;
    }
///////
?>