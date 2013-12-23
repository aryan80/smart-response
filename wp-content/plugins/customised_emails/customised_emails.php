<?php
/*
Plugin Name: Customised Emailing
Author: Aryan Choudhary
Description: The plugin manages Customised Emails.
version:1.0
email:aryanchoudhary@gmail.com
textdomain:smart
*/
if ( !session_id() )session_start();
define('PLUGIN_URL', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
define('PLUGIN_DIR', WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)));
define('CUSTOMISED_EMAILING_VERSION', '1.0');
include('functions.php');
//create the class instance here
$cemails=new customised_emails();
?>
