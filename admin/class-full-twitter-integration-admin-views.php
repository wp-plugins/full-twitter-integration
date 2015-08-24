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
class Full_Twitter_Integration_Admin_Views
{

    private $full_Twitter_Integration;
    private $version;
    private $name;
    private $ftiData;
    private $settingsFieldsName;

    private $fti_helper;
    private $button_url = '';
    private $userData;

    private $twitterObj;

    public function __construct($full_Twitter_Integration, $version, $name)
    {
        $this->fti_helper = new Full_Twitter_Integration_Helper();
        $this->twitterObj = new Full_Twitter_Integration_Api();

        $this->full_Twitter_Integration = $this->fti_helper->get_slug();
        $this->version = $this->fti_helper->get_version();
        $this->name = $this->fti_helper->get_name();
        $this->settingsFieldsName = $this->fti_helper->get_settings_fields_name();

        $this->apiKeyFieldName = $this->fti_helper->get_twitter_api_key_field_name();
        $this->secretKeyFieldName = $this->fti_helper->get_twitter_secret_key_field_name();

        //To load the saved data
        $this->ftiData = get_option($this->full_Twitter_Integration);

    }


    /**
     * @since    1.0.0
     * @access   protected
     */
    public function generate_admin_main_page()
    {


        $oauth_options = get_option('fti-twitter-oauth-options');
        $request_token = get_option('fti-twitter-request-token');

        $is_logged = (isset($oauth_options['twitter-oauth-verifier']) && isset($request_token['oauth_token'])) ? true : false;

        if ($is_logged) {
            //Get logged data
            $this->userData = $this->twitterObj->get_my_data();


            if (!isset($this->userData->screen_name) && !isset($_GET['fti-reloaded'])) {
                //Data is not loaded yet
                ?>
                <div class="fti-loading-message">
                    <h2>Syncing your Twitter Account</h2>

                    <div class="fti-syncing"></div>
                </div>
            <?php
            } else if (!isset($this->userData->screen_name) && isset($_GET['fti-reloaded'])) {
                $this->display_logout_message();
            } else {
                $this->display_logged_message();
            }

        } else {
            //User is not logged with Twitter
            $twitterObj = new Full_Twitter_Integration_Api();
            $this->button_url = $twitterObj->get_log_in_url();

            $this->get_log_in_form();
        }

        ?>



        <div class="fti-admin-main-container toggle-boxes-container">
            <header>
                <a href="<?php echo $this->fti_helper->get_external_fti_url(); ?>" target="_blank"
                   class="fti-twitter-title">
                    <?php echo $this->name; ?>
                </a>

                <span class="fti-twitter-logo"></span>

                <?php

                if ($is_logged && isset($this->userData->screen_name)) {
                    ?>
                    <div class="fti-logged-block">
                        <div class="fti-user-btn" style="color: #<?php echo $this->userData->profile_link_color; ?>;">
                            @<?php echo $this->userData->screen_name; ?>
                            <img src="<?php echo $this->userData->profile_image_url; ?>"
                                 style="border-color: #<?php echo $this->userData->profile_link_color; ?>;">
                            <a href="<?php echo $this->fti_helper->get_fti_url(); ?>&fti_log_out=true"
                               class="fti-log-out">Log Out</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="fti-log-in-block">
                        <a class="log-in-btn log-in-with-twitter-data"
                           href="<?php echo isset($this->button_url['twitter_log_in_url']) ? $this->button_url['twitter_log_in_url'] : ''; ?>"
                           fti-ws="<?php echo isset($this->button_url['webservice_create_url']) ? $this->button_url['webservice_create_url'] : ''; ?>">
                            Log In with Twitter
                        </a>
                    </div>
                <?php } ?>


                <div class="go-back-btn btn-hide">
                    << Go back
                </div>
            </header>

            <div class="fti-full-container toggle-block fti-block-initial toggle-active">
                <div class="fti-half-inner">
                    <h2>Welcome to the Full Twitter Integration!</h2>
                    <h4>With this plugin you will be able to display tweets all around your site with just a few simple
                        steps. Trust me, it's really simple ;)</h4>

                    <h3>Just choose where do you want to display the tweets:</h3>
                </div>
                <div class="fti-blocks-container">

                    <a class="fti-option-block" switchClass="fti-block-widget">
                        <h3>In a Widget</h3>

                        <div class="fti-option-block-inner">
                            <span class="fti-option-image widget-mode"></span>
                            <h4>Choose and filter the tweets you want to display on your Wordpress site.</h4>
                        </div>
                        <div class="fti-filter"></div>
                    </a>
                    <a class="fti-option-block" switchClass="fti-block-content">
                        <h3>In your Content</h3>

                        <div class="fti-option-block-inner">
                            <span class="fti-option-image content-mode"></span>
                            <h4>Add a [shortcode] to your page/post content an display the tweets you want.</h4>
                        </div>
                        <div class="fti-filter"></div>
                    </a>
                    <a class="fti-option-block" switchClass="fti-block-code">
                        <h3>Or in your Code</h3>

                        <div class="fti-option-block-inner">
                            <span class="fti-option-image code-mode"></span>
                            <h4>Are you a Developer? Well we have a couple simple tools that will help you to integrate
                                tweets.</h4>
                        </div>
                        <div class="fti-filter"></div>
                    </a>
                </div>

                <h4>Need more information? <br>
                    Read our <a href="<?php echo $this->fti_helper->get_external_fti_url(); ?>/#documentation" target="_blank">API
                        Documentation</a>
                </h4>
            </div>

            <?php
            $this->widget_admin_block();
            $this->content_admin_block();
            $this->code_admin_block();
            ?>

            <div class="fti-pop-up">
                <a class="log-in-btn"
                   href="<?php echo isset($this->button_url['twitter_log_in_url']) ? $this->button_url['twitter_log_in_url'] : ''; ?>">
                    <span class="right-side">Let's do it! <strong>Log In with Twitter</strong></span>
                </a>
            </div>


        </div>


        <?php

        if ($is_logged && !isset($this->userData->screen_name) && !isset($_GET['fti-reloaded'])) {
            ?>
            <script>
                window.location = "<?php echo $this->fti_helper->adminUrl?>&fti-reloaded";
            </script>
        <?php
        }

    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function get_log_in_form()
    {

        ?>

        <div class="fti-admin-main-container log-in-message">
            <h2>To get all these awesome stuff we will need you to Log In with your Twitter Account</h2>
            <h5>(Don't worry, we are not publishing anything in your name)</h5>

            <a class="log-in-with-twitter log-in-with-twitter-data"
               href="<?php echo isset($this->button_url['twitter_log_in_url']) ? $this->button_url['twitter_log_in_url'] : ''; ?>"
               fti-ws="<?php echo isset($this->button_url['webservice_create_url']) ? $this->button_url['webservice_create_url'] : ''; ?>"
                >
                <span class="left-side"></span>
                <span class="right-side">Let's do it! <strong>Log In with Twitter</strong></span>
            </a>
        </div>

    <?php
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function display_logged_message()
    {
        if (isset($_GET['fti-reloaded'])) {
            ?>
            <br>
            <br>

            <h3>Awesome man! You are logged as @<?php echo $this->userData->screen_name; ?></h3>
        <?php
        }
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    public function display_logout_message()
    {
        ?>
        <br>
        <br>

        <h3>Sorry, something went wrong. Please try to
            <a href="<?php echo $this->fti_helper->get_fti_url(); ?>&fti_log_out=true"
               class="fti-log-out">Log Out</a>
            and sync your account again.
        </h3>
    <?php
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    private function widget_admin_block()
    {
        ?>
        <div class="fti-full-container toggle-block fti-block-widget">
            <div class="fti-explanation-inner">

                <div class="fti-explanation-block">
                    <h1>Display tweets in a Widget, couldn't be easier</h1>
                    <h5>Simple as any other
                        <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank">Wordpress Widget</a>, just go
                        <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank">Appearance>Widgets</a> and
                        choose the most suitable FTI Widget for you, or choose them all!
                    </h5>
                    <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank"
                       class="fti-sample-image fti-widget-sample"></a>
                    <h5>
                        You will be able to set the
                        <strong>Number of tweets to display</strong>,
                        and the option to hide/show the <strong>User profile image</strong> and the
                        <strong>Tweets images</strong>.
                    </h5>
                </div>

                <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank"
                   class="fti-explanation-image-block widget-explanation-image">

                </a>
            </div>
        </div>
    <?php
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    private function content_admin_block()
    {
        ?>
        <div class="fti-full-container toggle-block fti-block-content">
            <div class="fti-explanation-inner">

                <div class="fti-explanation-block">
                    <h1>Tweets in your Content, just add a Shortcode</h1>
                    <h5>Use the
                        <a href="https://en.support.wordpress.com/display-posts-shortcode/" target="_blank">Wordpress
                            Shortcodes</a>
                        to display the tweets on your Posts/Pages and filter them as you wish. Set a
                        <strong>Hashtag</strong> or a <strong>Username</strong>
                        and set the values (optional) to customize the Tweets. Just add the Shortcode to your post/page
                        content and that's all!
                    </h5>
                    <h5>
                        This shortcode sample will display PearlJam's Tweets with their profile images and limit them to
                        5.
                        <br>
                        <code>[fti-list username="PearlJam" limit="5" profile_image="true"]</code>
                    </h5>
                    <h5>
                        And here it's getting Tweets with the hashtag "#Wordpress" including the images content of each
                        and with a medium size.
                        <br>
                        <code>[fti-list hashtag="Wordpress" images="true" images_size="medium"]</code>
                    </h5>
                    <h5>
                        <strong><u>Shortcode parameters</u></strong>
                        <br>
                        <strong>hashtag</strong> (Required) - [yourHashtag] Default: none.
                        <br>
                        <strong>username</strong> (Required) - [aTwitterUserName] Default: none.
                        <br>
                        <strong>images</strong> (Optional) - [true/false] Default: false.
                        <br>
                        <strong>images_size</strong> (Optional) - [thumb/small/medium/large] Default: thumb.
                        <br>
                        <strong>profile_image</strong> (Optional) - [true/false] Default: false.

                    </h5>

                </div>

                <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank"
                   class="fti-explanation-image-block content-explanation-image">

                </a>
            </div>
        </div>
    <?php
    }

    /**
     * @since    1.0.0
     * @access   protected
     */
    private function code_admin_block()
    {
        ?>
        <div class="fti-full-container toggle-block fti-block-code">
            <div class="fti-explanation-inner">

                <div class="fti-explanation-block">
                    <h1>So you are a Dev uh? Use our functions!</h1>
                    <h5>We have a really simple API to get the tweets you want in your code. Customize the parameters
                        and get an Array with the Tweets (objects).
                    </h5>

                    <h5>
                        <strong><u>These are our functions:</u></strong>

                        <br>
                        <code>get_tweets_by_hashtag($hashtag, $limit)</code>
                        <br>
                        <code>get_tweets_by_user($user_name, $limit)</code>
                        <br>
                        <code>get_user_tweets($user_name, $limit)</code>
                        <br>
                        <code>get_timeline_tweets($user_name)</code>
                        <br>
                        <code>get_user_data($user_name)</code>
                        <br>
                        <code>get_my_data()</code>
                        <br>
                        <br>
                        The <strong>$user_name</strong> should be the Twitter screen name, the one with @. Eg:
                        PaulMcCartney
                    </h5>

                </div>

                <a href="<?php echo admin_url('widgets.php'); ?>" target="_blank"
                   class="fti-explanation-image-block code-explanation-image">

                </a>
            </div>
        </div>
    <?php
    }
}



