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
class Full_Twitter_Integration {

	/**
	 * @since    1.0.0
	 * @access   protected
	 */
	protected $loader;

	/**
     * @since    1.0.0
	 * @access   protected
	 */
	protected $full_Twitter_Integration;

	/**
	 * @since    1.0.0
	 * @access   protected
	 */
	protected $version;

    /**
     * @since    1.0.0
     * @access   protected
     */
    private $name;


    /**
     * @since    1.0.0
     * @access   protected
     */
	public function __construct() {

		$this->full_Twitter_Integration = 'full-twitter-integration';
		$this->version = '1.0.0';
		$this->name = 'Full Twitter Integration';


		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
    private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-full-twitter-integration-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-full-twitter-integration-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-full-twitter-integration-helper.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-full-twitter-integration-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-full-twitter-integration-public.php';

		$this->loader = new Full_Twitter_Integration_Loader();

        require_once plugin_dir_path( dirname( __FILE__ ) )  . 'admin/class-full-twitter-integration-admin-views.php';
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	private function set_locale() {

		$plugin_i18n = new Full_Twitter_Integration_i18n();
		$plugin_i18n->set_domain( $this->get_full_Twitter_Integration() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	private function define_admin_hooks() {

		$plugin_admin = new Full_Twitter_Integration_Admin( $this->get_full_Twitter_Integration(), $this->get_version(), $this->get_name() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_create_menu' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_admin_settings' );

        $this->loader->add_action( 'widgets_init', $plugin_admin, 'admin_create_widgets' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'save_settings_data' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'fti_log_out' );
        $this->loader->add_action( 'init', $plugin_admin, 'register_shortcodes' );

	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	private function define_public_hooks() {

		$plugin_public = new Full_Twitter_Integration_Public( $this->get_full_Twitter_Integration(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	public function run() {
		$this->loader->run();
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	public function get_full_Twitter_Integration() {
		return $this->full_Twitter_Integration;
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	public function get_loader() {
		return $this->loader;
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	public function get_version() {
		return $this->version;
	}

    /**
     * @since    1.0.0
     * @access   protected
     */
	public function get_name() {
		return $this->name;
	}

}
