<?php

/**
 * @link              http://full-twitter-integration.com
 * @since             1.0.0
 * @package           Full_Twitter_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Full Twitter Integration
 * Plugin URI:        http://full-twitter-integration.atomas.com.ar
 * Description:       Use all the twitter APIs functions in your website. Search by HASHTAGS, get the FOLLOWERS, display your TWEETS and more.
 * Version:           1.0.0
 * Author:            Tomas Agrimbau
 * Author URI:        http://theamalgama.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       full-twitter-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-full-twitter-integration-activator.php
 */
function activate_full_twitter_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-full-twitter-integration-activator.php';
	Full_twitter_integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-full-twitter-integration-deactivator.php
 */
function deactivate_full_twitter_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-full-twitter-integration-deactivator.php';
	Full_twitter_integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_full_twitter_integration' );
register_deactivation_hook( __FILE__, 'deactivate_full_twitter_integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-full-twitter-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_full_twitter_integration() {

	$plugin = new Full_twitter_integration();
	$plugin->run();

    require_once plugin_dir_path( __FILE__ ) . 'includes/fti-global-functions.php';

}
run_full_twitter_integration();



