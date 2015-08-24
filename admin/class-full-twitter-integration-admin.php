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
class Full_Twitter_Integration_Admin
{

    private $full_Twitter_Integration;
    private $version;
    private $name;
    private $settingsFieldsName;
    private $redirectUrlName;
    public $twitterObj;

    public function __construct()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-full-twitter-api.php';

        $this->fti_helper = new Full_Twitter_Integration_Helper();
        $this->twitterObj = new Full_Twitter_Integration_Api();

        $this->full_Twitter_Integration = $this->fti_helper->get_slug();
        $this->version = $this->fti_helper->get_version();
        $this->name = $this->fti_helper->get_name();
        $this->settingsFieldsName = $this->fti_helper->get_settings_fields_name();
        $this->redirectUrlName = $this->fti_helper->get_redirect_url_value();
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->full_Twitter_Integration, plugin_dir_url(__FILE__) . 'css/full-twitter-integration-admin.css', array(), $this->version, 'all');
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->full_Twitter_Integration, plugin_dir_url(__FILE__) . 'js/full-twitter-integration-admin.js', array('jquery'), $this->version, true);
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function admin_create_menu()
    {
        add_menu_page($this->name . ' Plugin ',
            $this->name,
            'manage_options',
            $this->full_Twitter_Integration,
            array($this, 'manage_admin_page'),
            'dashicons-twitter',
            82);



    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function register_admin_settings()
    {

    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function admin_create_widgets()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/widgets/class-admin-widgets.php';

        $widgets_admin = new Full_Twitter_Integration_Widget($this->full_Twitter_Integration, $this->version, $this->name);
        $widgets_admin->register_slider_widget();
        $widgets_admin->register_tweets_by_hashtag_widget();
        $widgets_admin->register_tweets_by_user_widget();
        $widgets_admin->register_user_tweets_widget();

    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function manage_admin_page()
    {

        $viewsGenerator = new Full_Twitter_Integration_Admin_Views($this->full_Twitter_Integration, $this->version, $this->name);
        $viewsGenerator->generate_admin_main_page();
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function save_settings_data()
    {
        $ftiData = get_option($this->full_Twitter_Integration);

        $arrayValues = $ftiData;
        $this->save_twitter_oauth($arrayValues);

        if (isset($_POST['option_page']) && ($_POST['option_page'] == $this->settingsFieldsName)) {


            $arrayValues = array();
            $arrayValues['fti-api-key'] = isset($_POST['fti-api-key']) ? $_POST['fti-api-key'] : '';
            $arrayValues['fti-api-secret'] = isset($_POST['fti-api-secret']) ? $_POST['fti-api-secret'] : '';
            $arrayValues['fti-api-created-at'] = isset($ftiData['fti-api-created-at']) ? $ftiData['fti-api-created-at'] : date("Y-m-d H:i:s");
            $arrayValues['fti-api-updated-at'] = date("Y-m-d H:i:s");

            $arrayValues['twitter-oauth-token'] = isset($_GET['oauth_token']) ? $_GET['oauth_token'] : $ftiData['twitter-oauth-token'];
            $arrayValues['twitter-oauth-verifier'] = isset($_GET['oauth_verifier']) ? $_GET['oauth_verifier'] : $ftiData['twitter-oauth-verifier'];

            update_option($this->full_Twitter_Integration, $arrayValues);
        }
    }

    public function fti_log_out()
    {
        if(isset($_GET['fti_log_out']) && $_GET['fti_log_out'] == 'true'){
            $this->twitterObj->log_out_session();
            wp_redirect($this->fti_helper->get_fti_url());
        }

    }

    public function register_shortcodes()
    {

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-full-twitter-shortcodes.php';

        $shortCodesClass = new Full_Twitter_Integration_Shortcodes();
        //Register all the shortcodes
        add_shortcode( 'fti-list', array( $shortCodesClass, 'setup_fti_list') );
        add_shortcode( 'fti-slider', array( $shortCodesClass, 'setup_fti_slider') );
    }


    private function save_twitter_oauth($arrayValues)
    {
        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            $ftiData = get_option($this->full_Twitter_Integration);

            $arrayValues['twitter-oauth-token'] = isset($_GET['oauth_token']) ? $_GET['oauth_token'] : $ftiData['twitter-oauth-token'];
            $arrayValues['twitter-oauth-verifier'] = isset($_GET['oauth_verifier']) ? $_GET['oauth_verifier'] : $ftiData['twitter-oauth-verifier'];

            update_option('fti-twitter-oauth-options', $arrayValues);

            wp_redirect($this->fti_helper->get_fti_url());
        }

    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function my_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo '<div class="wrap">';
        echo '<p>Here is where the form would go if I actually had options.</p>';
        echo '</div>';
    }
}
