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
class Full_Twitter_Integration_Shortcodes
{

    private $full_Twitter_Integration;
    private $version;
    private $name;
    public $fti_helper;
    public $twitterObj;
    public $views;
    public $displayImages;
    public $imagesSize;
    public $displayProfileImages;

    public function __construct()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-full-twitter-api.php';

        $this->fti_helper = new Full_Twitter_Integration_Helper();
        $this->twitterObj = new Full_Twitter_Integration_Api();
        $this->views = new Full_Twitter_Integration_Public_Views();
    }


    public function setup_fti_list($atts)
    {
        $defautlValues = array('hashtag' => null, 'username' => null, 'limit' => 10, 'images' => false, 'images_size' => 'thumb', 'profile_image' => false);
        $handledValues = shortcode_atts($defautlValues, $atts, 'fti_slider');

        $this->displayImages = $this->parse_to_bool($handledValues['images']);
        $this->imagesSize = $this->set_images_size($handledValues['images_size']);
        $this->displayProfileImages= $this->parse_to_bool($handledValues['profile_image']);

        if (!is_null($handledValues['hashtag'])) {
            $return = $this->get_list_by_hashtag($handledValues);

        } else if (!is_null($handledValues['username'])) {
            $return = $this->get_list_by_username($handledValues);

        } else {
            $return = 'No matching results';
        }

        return $return;
    }

    public function setup_fti_slider($atts)
    {
        //return $this->setup_fti_list($atts);
    }

    private function get_list_by_hashtag($handledValues)
    {
        $return = "<div class='fti-tweet-list-container'>";
        $return .= $this->views->get_formated_title('#', $handledValues['hashtag']);
        $tweets = $this->twitterObj->get_tweets_by_hashtag($handledValues['hashtag'], $handledValues['limit']);
        $return .= $this->views->get_tweets_list($tweets, $handledValues['hashtag'], $this->displayImages, $this->imagesSize, $this->displayProfileImages);
        $return .= "</div>";

        return $return;
    }

    private function get_list_by_username($handledValues)
    {
        $return = "<div class='fti-tweet-list-container'>";
        if($this->displayProfileImages){
            $userData = $this->twitterObj->get_user_data($handledValues['username']);
            $return .= $this->views->get_user_title($userData);
        }else{
            $return .= $this->views->get_formated_title('@', $handledValues['username']);
        }

        $tweets = $this->twitterObj->get_tweets_by_user($handledValues['username'], $handledValues['limit']);
        $return .= $this->views->get_tweets_list($tweets, false, $this->displayImages, $this->imagesSize, $this->displayProfileImages);
        $return .= "</div>";

        return $return;
    }

    private function parse_to_bool($value){
        if( ($value == "true") || ($value == "yes")){
            return true;
        }else{
            return false;
        }

    }

    private function set_images_size($value = "thumb"){
        $value = str_replace(" ", "", $value );
        if( ($value != "thumb") && ($value != "small") && ($value != "medium") && ($value != "big") ){
            return "thumb";
        }else{
            return $value;
        }
    }

}
