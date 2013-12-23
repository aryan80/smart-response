<?php
class customised_emails{
	
	private $options;
	
	public function __construct(){
		//i assumed here that the tex domain smart will be used for a language translation if it would be need in futire...
		$plugin_dir = basename(dirname(__FILE__)); 
		load_plugin_textdomain('smart', false, $plugin_dir.'/languages'); 
		register_activation_hook( __FILE__,array($this,'add_custom_settings'));
		//add a new menu in settings menu
		add_action('admin_menu',array($this,'add_custom_menu_settings'));
		add_action( 'admin_init', array( $this, 'page_init' ) );
		
	}
	public function add_custom_settings(){
		//the default plugin settings will go here
		
	}
	public function add_custom_menu_settings(){
		//add the custom menu to settings menu
		add_submenu_page('options-general.php','email-custom-settings','Emails Settings','manage_options','email_custom_settings',array($this,'admin_custom_menu_settings'));
	}
	public function admin_custom_menu_settings(){
		 // Set class property
        $this->options = get_option( 'custom_emails_settings' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>My Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'custom_emails_settings_group' );   
                do_settings_sections( 'email-custom-settings' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
	}
	
	public function __destruct(){
		register_deactivation_hook( __FILE__, array($this,'remove_custom_settings') );
	}
	public function remove_custom_settings(){
		//here is ths code to rmeove any custom settings for this plugin
	}
	public function page_init()
    {        
        register_setting(
            'custom_emails_settings_group', // Option group
            'custom_emails_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_general_emails_section_id', // ID
            'Emails Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'email-custom-settings' // Page
        );  
		add_settings_field(
            'general_emails', // ID
            'General Emails:', // Title 
            array( $this, 'general_emails_callback' ), // Callback
            'email-custom-settings', // Page
            'setting_general_emails_section_id' // Section           
        ); 
		add_settings_section(
            'setting_disaster_emails_section_id', // ID
            'Emails Disaster Frequency Settings', // Title
            array( $this, 'print_disaster_section_info' ), // Callback
            'email-custom-settings' // Page
        );
		add_settings_field(
            'email_disaster', // ID
            'Disaster to Emails Frequency:', // Title 
            array( $this, 'disaster_emails_callback' ), // Callback
            'email-custom-settings', // Page
            'setting_disaster_emails_section_id' // Section           
        );   
		add_settings_field(
            'email_fd', // ID
            'Emails Frequency to Disaster:', // Title 
            array( $this, 'disaster_frequency_emails_callback' ), // Callback
            'email-custom-settings', // Page
            'setting_disaster_emails_section_id' // Section           
        );
		add_settings_section(
            'setting_country_emails_section_id', // ID
            'Emails Country Frequency Settings', // Title
            array( $this, 'print_country_section_info' ), // Callback
            'email-custom-settings' // Page
        ); 
		add_settings_field(
            'email_country', // ID
            'Country to Emails Frequency:', // Title 
            array( $this, 'country_emails_callback' ), // Callback
            'email-custom-settings', // Page
            'setting_country_emails_section_id' // Section           
        );   
		add_settings_field(
            'email_fc', // ID
            'Emails Frequency to Country:', // Title 
            array( $this, 'country_frequency_emails_callback' ), // Callback
            'email-custom-settings', // Page
            'setting_country_emails_section_id' // Section           
        );         
    }
	public function print_country_section_info(){
		print 'Enter your settings for Country Emails here:';	
	}
	public function country_emails_callback(){
			$split_country=explode('_',$this->options['email_country_frequency']);
			$allcountries=$this->get_all_countries();
			echo '<select name="email_country">';
			echo '<option value="">Select Country to set Emails Frequency for:</option>';
			if(!empty($allcountries)){
				foreach($allcountries as $country){
					echo '<option value="'.$country['post_name'].'"'.($country['post_name']==$split_country[0]?'selected':'').'>'.$country['post_title'].'</option>';
				}
			}
			echo '</select>';
	}
	public function country_frequency_emails_callback(){
		$split_disaster=explode('_',$this->options['email_country_frequency']);
		 printf('<input type="radio" id="general_emails" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'daily',($split_disaster[1]=='daily'?'checked':''),'&nbsp;&nbsp;Daily<br/>');
		printf('<input type="radio" id="general_emails2" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'weekly',($split_disaster[1]=='weekly'?'checked':''),'&nbsp;&nbsp;Weekly<br/>');
		printf('<input type="radio" id="general_emails3" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'monthly',($split_disaster[1]=='monthly'?'checked':''),'&nbsp;&nbsp;Monthly<br/>');
		printf('<input type="radio" id="general_emails4" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'quarterly',($split_disaster[1]=='quarterly'?'checked':''),'&nbsp;&nbsp;Quarterly<br/>');
		printf('<input type="radio" id="general_emails5" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'semi-annually',($split_disaster[1]=='semi-annually'?'checked':''),'&nbsp;&nbsp;Semi-Annually<br/>');
		printf('<input type="radio" id="general_emails6" name="custom_emails_settings[email_fd]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'annually',($split_disaster[1]=='annually'?'checked':''),'&nbsp;&nbsp;Annually<br/>');
	}
	public function disaster_frequency_emails_callback(){
		$split_disaster=explode('_',$this->options['email_disaster_frequency']);
		 printf('<input type="radio" id="general_emails" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'daily',($split_disaster[1]=='daily'?'checked':''),'&nbsp;&nbsp;Daily<br/>');
		printf('<input type="radio" id="general_emails2" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'weekly',($split_disaster[1]=='weekly'?'checked':''),'&nbsp;&nbsp;Weekly<br/>');
		printf('<input type="radio" id="general_emails3" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'monthly',($split_disaster[1]=='monthly'?'checked':''),'&nbsp;&nbsp;Monthly<br/>');
		printf('<input type="radio" id="general_emails4" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'quarterly',($split_disaster[1]=='quarterly'?'checked':''),'&nbsp;&nbsp;Quarterly<br/>');
		printf('<input type="radio" id="general_emails5" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'semi-annually',($split_disaster[1]=='semi-annually'?'checked':''),'&nbsp;&nbsp;Semi-Annually<br/>');
		printf('<input type="radio" id="general_emails6" name="custom_emails_settings[email_fc]" value="%s" %s/>%s',
            isset( $split_disaster[1] ) ? esc_attr( $split_disaster[1]) : 'annually',($split_disaster[1]=='annually'?'checked':''),'&nbsp;&nbsp;Annually<br/>');
	}
	public function disaster_emails_callback(){
			$disaster_value=$this->options['email_disaster_frequency'];
			$split_disaster=explode('_',$this->options['email_disaster_frequency']);
			$alldisasters=$this->get_all_disasters();
			echo '<select name="email_disaster">';
			echo '<option value="">Select Disaster to set Emails Frequency for:</option>';
			if(!empty($alldisasters)){
				foreach($alldisasters as $disaster){
					echo '<option value="'.$disaster['post_name'].'"'.($disaster['post_name']==$split_disaster[0]?'selected':'').'>'.$disaster['post_title'].'</option>';
				}
			}
			echo '</select>';
	}
	 public function sanitize( $input )
    {
	   // print_r($input);
		//print_r($_POST);
		$new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['general_emails']) )
            $new_input['general_emails']= sanitize_text_field( $input['general_emails']);
		if( isset( $_POST['email_disaster']) )
        	$new_input['email_disaster_frequency']= $_POST['email_disaster'].'_'.$input['email_fd'];
		if( isset( $_POST['email_country']) )
        	$new_input['email_country_frequency']= $_POST['email_country'].'_'.$input['email_fc'];
			
		//print_r($new_input);
		//die();
        return $new_input;
    }
	public function print_section_info()
    {
        print 'Enter your settings for general Emails here:';
    }
	public function general_emails_callback()
    {
	    printf('<input type="radio" id="general_emails" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'daily',($this->options['general_emails']=='daily'?'checked':''),'&nbsp;&nbsp;Daily<br/>');
		printf('<input type="radio" id="general_emails2" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'weekly',($this->options['general_emails']=='weekly'?'checked':''),'&nbsp;&nbsp;Weekly<br/>');
		printf('<input type="radio" id="general_emails3" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'monthly',($this->options['general_emails']=='monthly'?'checked':''),'&nbsp;&nbsp;Monthly<br/>');
		printf('<input type="radio" id="general_emails4" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'quarterly',($this->options['general_emails']=='quarterly'?'checked':''),'&nbsp;&nbsp;Quarterly<br/>');
		printf('<input type="radio" id="general_emails5" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'semi-annually',($this->options['general_emails']=='semi-annually'?'checked':''),'&nbsp;&nbsp;Semi-Annually<br/>');
		printf('<input type="radio" id="general_emails6" name="custom_emails_settings[general_emails]" value="%s" %s/>%s',
            isset( $this->options['general_emails'] ) ? esc_attr( $this->options['general_emails']) : 'annually',($this->options['general_emails']=='annually'?'checked':''),'&nbsp;&nbsp;Annually<br/>');
	  }
	public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
	public function print_disaster_section_info(){
		 print 'Enter your settings for Disaster Frequency Emails here:';
	}
	private function get_all_disasters(){
		global $wpdb;
		$disasters=$wpdb->get_results("select post_title,post_name from ".$wpdb->prefix.posts." where post_type='post' and post_status='publish'",ARRAY_A);
		if(!empty($disasters)){
			return $disasters;
		}else{
			return false;	
		}
	}
	private function get_all_countries(){
		global $wpdb;
		$countries=$wpdb->get_results("select post_title,post_name from ".$wpdb->prefix.posts." where post_type='country' and post_status='publish'",ARRAY_A);
		if(!empty($countries)){
			return $countries;
		}else{
			return false;	
		}
	}
}
?>