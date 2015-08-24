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
class Full_Twitter_Integration_Widget
{

    /**
     * @since    1.0.0
     * @access   protected
     */
    private $full_Twitter_Integration;

    /**
     * @since    1.0.0
     * @access   protected
     */
    private $version;

    /**
     * @since    1.0.0
     * @access   protected
     */
    private $name;

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function __construct($full_Twitter_Integration, $version, $name)
    {

        $this->full_Twitter_Integration = $full_Twitter_Integration;
        $this->version = $version;
        $this->name = $name;

    }

    public function register_slider_widget(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/fti-tweets-by-timeline.php';

        register_widget('fti_slider_widget');
    }

    public function register_tweets_by_hashtag_widget(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/fti-tweets-by-hashtag-widget.php';

        register_widget('fti_tweets_by_hashtag_widget');
    }

    public function register_tweets_by_user_widget(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/fti-tweets-by-user-widget.php';

        register_widget('fti_tweets_by_user_widget');
    }

    public function register_user_tweets_widget(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/fti-user-tweets-widget.php';

        register_widget('fti_user_tweets_widget');
    }
}