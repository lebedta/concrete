<?php
/*
Plugin Name: Cherry Plugin
Plugin URI: http://www.cherryframework.com/uncategorized/meet-the-cherry-plugin-bare-functionalities-no-strings-attached/
Description: Cherry team has already created a Cherry framework that can be reasonably called perfect, but we are always looking for more improvements. Meet the Cherry Plugin. This is an extension for our Cherry framework where we've included all shortcodes and widgets you will ever need. The plugin is fully compatible with any WordPress theme powered by Cherry Framework. So far the plugin is a beta release, but we're going to keep on improving it, to deliver even more cool features.
Author: Cherry Team
Author URI: http://www.cherryframework.com/
Text Domain: cherry-plugin
Domain Path: languages/
Version: 0.1
*/

//plugin settings
	if(!function_exists('cherry_plugin_settings')){
		function cherry_plugin_settings(){
			//global $wpdb;
			if ( !function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$plugin_data = get_plugin_data(plugin_dir_path(__FILE__).'/cherry_plugin.php');

			//@define('CHERRY_PLUGIN_DB', $wpdb->prefix.cherry_plugin);
			define('CHERRY_PLUGIN_DIR', plugin_dir_path(__FILE__));
			define('CHERRY_PLUGIN_URL', plugin_dir_url(__FILE__));
			define('CHERRY_PLUGIN_DOMAIN', $plugin_data['TextDomain']);
			define('CHERRY_PLUGIN_DOMAIN_DIR', $plugin_data['DomainPath']);
			define('CHERRY_PLUGIN_VERSION', $plugin_data['Version']);
			define('CHERRY_PLUGIN_NAME', $plugin_data['Name']);

			load_plugin_textdomain( CHERRY_PLUGIN_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/'.CHERRY_PLUGIN_DOMAIN_DIR);

			do_action( 'cherry_plugin_settings' );
		}
		add_action('plugins_loaded', 'cherry_plugin_settings', 0);
	}

//init plugin
	if(!function_exists('cherry_plugin_init')){
		function cherry_plugin_init(){
			//cherry_plugin_load_textdomain();

			if(is_admin()){
				include_once (CHERRY_PLUGIN_DIR . 'admin/admin.php');
			}else{
				include_once (CHERRY_PLUGIN_DIR . 'includes/web_site.php');
			}
			include_once (CHERRY_PLUGIN_DIR . 'cherry_plugin_init.php');

			do_action( 'cherry_plugin_init' );
		}
		add_action('init', 'cherry_plugin_init', 0);
	}
//activate plugin
	if(!function_exists('cherry_plugin_activate')){
		function cherry_plugin_activate(){
			//echo "cherry_plugin_activate";
		}
		register_activation_hook( __FILE__, 'cherry_plugin_activate' );
	};

//deactivate plugin
	if(!function_exists('cherry_plugin_deactivate')){
		function cherry_plugin_deactivate(){
			//echo "cherry_plugin_deactivate";
		}
		register_deactivation_hook( __FILE__, 'cherry_plugin_deactivate' );
	};

//delete plugin
	if(!function_exists('cherry_plugin_uninstall')){
		function cherry_plugin_uninstall(){
			//echo "cherry_plugin_uninstall";
		}
		register_uninstall_hook(__FILE__, 'cherry_plugin_uninstall');
	};
?>