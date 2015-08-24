<?php
/**
 *
 * @link       http://full-twitter-integration.com
 * @since      1.0.0
 * @package    Full_Twitter_Integration
 * @subpackage Full_Twitter_Integration/public
 * @author     Tomas Agrimbau <tomas@theamalgama.com>
 *
 */
class Full_Twitter_Integration_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $full_Twitter_Integration    The ID of this plugin.
	 */
	private $full_Twitter_Integration;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $full_Twitter_Integration       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

        $fti_helper = new Full_Twitter_Integration_Helper();

        $this->full_Twitter_Integration = $fti_helper->get_slug();
        $this->version = $fti_helper->get_version();
        $this->name = $fti_helper->get_name();

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-full-twitter-integration-public-views.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Full_Twitter_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Full_Twitter_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->full_Twitter_Integration, plugin_dir_url( __FILE__ ) . 'css/full-twitter-integration-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Full_Twitter_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Full_Twitter_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->full_Twitter_Integration, plugin_dir_url( __FILE__ ) . 'js/full-twitter-integration-public.js', array( 'jquery' ), $this->version, false );

	}

}
