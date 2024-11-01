<?php
/* 
Plugin Name: WP Quick Deploy Revisited
Plugin URI: http://wordpress.org/extend/plugins/wp-quick-deploy-revisited
Description: Install and manage SEO plugins and custom plugin sets for easy deployment.
Version: 1.0
Author: Valentin Mayr
Author URI: http://gooyahbing.com
License: "GPL3"
*/

/*
Copyright 2011  Valentin Mayr
Credits: 
Vladimir Prelovac http://www.prelovac.com/vladimir for the awesome original WP Quick Deloy plugin (http://www.prelovac.com/vladimir/wordpress-plugins/wp-quick-deploy) which I just expanded for more flexibility.
Marko Novakovic http://www.linkedin.com/pub/marko-novakovic/b/b09/727 for contribution to the original plugin
*/

if (isset($quick_deployment)) return false;

register_activation_hook(__FILE__,'custompi_install');

require_once(dirname(__FILE__) . '/wp-quick-deploy-revisited.class.php');

//* Create DB Table if not present *//

	global $custompitab_db_version;	
	$custompitab_db_version = "1.0";
	function custompi_install() {
		global $custompitab_db_version;
		global $wpdb;
		$table_name = $wpdb->prefix . "custompi";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
			$sql = "CREATE TABLE " . $table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				name tinytext NOT NULL,
				text text NOT NULL,
				url VARCHAR(55) DEFAULT '' NOT NULL,
				UNIQUE KEY id (id)
				);";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			add_option("custompitab_db_version", $custompitab_db_version);
    	}
	}
//* CREATE TABLE END *//

$quick_deployment = new QuickDeployment();