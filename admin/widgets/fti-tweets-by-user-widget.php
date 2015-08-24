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
class fti_tweets_by_user_widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'fti_tweets_by_user_widget',
            __('FTI Get tweets mentioning a User', 'fti_tweets_by_user_widget_domain'),
            array('description' => __('Display Tweets where a User was mentioned', 'fti_tweets_by_user_widget_domain'),)
        );

        require_once plugin_dir_path( dirname( __FILE__ ) ) . '../includes/class-full-twitter-api.php';
    }

    public function widget($args, $instance)
    {
        $views = new Full_Twitter_Integration_Public_Views();
        $twitterClass = new Full_Twitter_Integration_Api();

        $userData = $twitterClass->get_user_data($instance['title']);

        $views->display_widget_title($args, $instance, '@', $userData);

        $tweetsArray = $twitterClass->get_tweets_by_user( $instance['title'], $instance['max-num-tweets'] );

        $views->loop_tweets_for_widget($tweetsArray, null, $instance);


        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = isset($instance['title'])? $instance['title'] : __('@PaulMcCartney', 'fti_tweets_by_user_widget_domain');
        $maxNumTweets = isset($instance['max-num-tweets'])? $instance['max-num-tweets'] : __(10, 'fti_tweets_by_user_widget_domain');
        $displayPofileImage = isset($instance['display-profile-image']) ? $instance['display-profile-image'] : false;
        $displayTweetsImages = isset($instance['display-tweets-images']) ? $instance['display-tweets-images'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('User (Ex. @PaulMcCartney):'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('max-num-tweets'); ?>"><?php _e('Number of tweets to display (default: 10, max: 100):'); ?></label>
            <input id="<?php echo $this->get_field_id('max-num-tweets'); ?>"
                   name="<?php echo $this->get_field_name('max-num-tweets'); ?>" type="number" max="100" min="1"
                   value="<?php echo esc_attr($maxNumTweets); ?>" class="number-field" />
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('display-profile-image'); ?>"
                   name="<?php echo $this->get_field_name('display-profile-image'); ?>" type="checkbox"
                   <?php echo ($displayPofileImage)? 'checked' : ''; ?> class="number-field" />
            <label for="<?php echo $this->get_field_id('display-profile-image'); ?>"><?php _e('Display Users profile image?'); ?></label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('display-tweets-images'); ?>"
                   name="<?php echo $this->get_field_name('display-tweets-images'); ?>" type="checkbox"
                <?php echo ($displayTweetsImages)? 'checked' : ''; ?> class="number-field" />
            <label for="<?php echo $this->get_field_id('display-tweets-images'); ?>"><?php _e('Display Tweets images?'); ?></label>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['max-num-tweets'] = (!empty($new_instance['max-num-tweets'])) ? intval( strip_tags($new_instance['max-num-tweets']) ) : '';
        $instance['display-profile-image'] = isset($new_instance['display-profile-image']) ? $new_instance['display-profile-image']: false;
        $instance['display-tweets-images'] = isset($new_instance['display-tweets-images']) ? $new_instance['display-tweets-images']: false;

        return $instance;
    }
}
