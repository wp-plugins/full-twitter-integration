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

require_once plugin_dir_path(dirname(__FILE__)) . '/twitteroauth-master/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class Full_Twitter_Integration_Api
{

    private $full_Twitter_Integration;
    private $version;
    private $name;
    private $ftiData;
    private $oauthCallbackUrl;

    private $sessionOauthTokenName;
    private $sessionOauthTokenSecretName;
    private $connection;

    private $webServiceUrl;
    private $fti_helper;
    private $errors;


    public function __construct()
    {

        if ($this->curlIsDisabled()) {
            return exit;
        }
        $this->fti_helper = new Full_Twitter_Integration_Helper();

        $this->full_Twitter_Integration = $this->fti_helper->get_slug();
        $this->version = $this->fti_helper->get_version();
        $this->name = $this->fti_helper->get_name();
        $this->apiKeyFieldName = $this->fti_helper->get_twitter_api_key_field_name();
        $this->secretKeyFieldName = $this->fti_helper->get_twitter_secret_key_field_name();

        $this->sessionOauthTokenName = $this->fti_helper->get_session_oauth_name();
        $this->sessionOauthTokenSecretName = $this->fti_helper->get_session_oauth_name_secret();

        $this->webServiceUrl = $this->fti_helper->get_webservice_url();

        $this->errors['not_logged'] = '<span class="fti-error-message">You need to setup your <a href="' . $this->fti_helper->adminUrl . '" target="_blank">Full Twitter Integration</a> account</span>';
        $this->errors['sync'] = '<span class="fti-error">(Loading Tweets)</span>';
    }

    private function curlIsDisabled()
    {
        if (!function_exists('curl_init')) {
            echo "<br><br><br><br><h2>Please enable Curl to use this plugin autoload</h2>";
            echo "<h3>Get More info in <a href='http://php.net/manual/en/curl.installation.php' target='_blank'>This link</a></h3>";
            return true;
        }
    }

    public function get_authenticated_conection()
    {
        $request_token = get_option('fti-twitter-request-token');
        $oauth_options = get_option('fti-twitter-oauth-options');
        $access_token = get_option('fti-twitter-oauth_token');

        if (!isset($access_token['oauth_token']) || !isset($access_token['oauth_token_secret'])) {

            try {
                //There's no access token save
                $this->connection = new TwitterOAuth($this->fti_helper->get_twitter_api_key_field(), $this->fti_helper->get_twitter_secret_key_field(), $request_token['oauth_token'], $request_token['oauth_token_secret']);
                $access_token = $this->connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_options['twitter-oauth-verifier']));

                update_option('fti-twitter-oauth_token', $access_token);

            } catch (Exception $some) {
                echo $this->errors['sync'];
            }

        } else {

            try {
                //Access token was saved and it can get the connection directly
                $this->connection = new TwitterOAuth($this->fti_helper->get_twitter_api_key_field(), $this->fti_helper->get_twitter_secret_key_field(), $access_token['oauth_token'], $access_token['oauth_token_secret']);

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return false;
            }

        }

        return true;
    }


    public function log_out_session()
    {
        delete_option('fti-twitter-request-token');
        delete_option('fti-twitter-oauth-options');
        delete_option('fti-twitter-request-token');
        delete_option('fti-twitter-oauth_token');
        delete_option($this->full_Twitter_Integration);
    }

    public function get_user_data($screen_name)
    {
        if ($this->get_authenticated_conection()) {

            try {
                $userData = $this->connection->get("users/show", array("screen_name" => $screen_name));
            } catch (Exception $some) {
                echo $this->errors['sync'];
                return null;
            }

            if ($userData) {
                return $userData;
            }
        }

        return null;
    }

    public function get_logged_data()
    {
        if ($this->get_authenticated_conection()) {

            try {
                $userData = $this->connection->get("account/verify_credentials");

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return null;
            }

            if ($userData) {
                return $userData;
            }
        }

        return null;
    }

    public function get_timeline_tweets($limit = 10)
    {
        if ($this->get_authenticated_conection()) {
            try {
                $limit = $this->set_top_limit($limit);
                $tweets = $this->connection->get("statuses/home_timeline", array("count" => $limit, "exclude_replies" => true));

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return null;
            }

            if (isset($tweets->errors) && $this->has_twitter_api_errors($tweets->errors)) {
                return false;
            }
            return $tweets;
        } else {
            return $this->get_fti_expired_token_button();
        }

    }


    public function get_my_data()
    {
        if ($this->get_authenticated_conection()) {
            $userData = $this->connection->get("account/settings", array());
            if(isset($userData->screen_name)){
                return $this->get_user_data($userData->screen_name);
            }

        }

    }

    private function set_top_limit($limit)
    {
        if ($limit > 100) {
            $limit = 100;
        }
        return $limit;
    }

    public function get_tweets_by_hashtag($hashtag, $limit)
    {

        if ($this->get_authenticated_conection()) {
            $hashtag = '#' . str_replace('#', '', $hashtag);

            try {
                $limit = $this->set_top_limit($limit);
                $tweets = $this->connection->get("search/tweets", array("q" => $hashtag, "count" => $limit));
            } catch (Exception $some) {
                echo $this->errors['sync'];
                return false;
            }

            if (isset($tweets->errors) && $this->has_twitter_api_errors($tweets->errors)) {
                return false;
            }

            if (isset($tweets->statuses)) {
                return $tweets->statuses;
            }

        } else {
            echo $this->get_fti_expired_token_button();
            return false;
        }

    }


    public function get_tweets_by_user($user, $limit)
    {
        if ($this->get_authenticated_conection()) {
            try {
                $limit = $this->set_top_limit($limit);
                $tweets = $this->connection->get("search/tweets", array("q" => $user, "count" => $limit));

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return false;
            }

            if (isset($tweets->errors) && $this->has_twitter_api_errors($tweets->errors)) {
                return false;
            }

            if (isset($tweets->statuses)) {
                return $tweets->statuses;
            }

        } else {
            echo $this->get_fti_expired_token_button();
            return false;
        }

    }

    public function get_user_tweets($user = null, $limit)
    {
        if (is_null($user) || !isset($user->screen_name)) {
            return false;
        }

        if ($this->get_authenticated_conection()) {

            try {
                $limit = $this->set_top_limit($limit);
                $tweets = $this->connection->get("statuses/user_timeline", array("q" => $user->screen_name, "count" => $limit));

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return false;
            }

            if (isset($tweets->errors) && $this->has_twitter_api_errors($tweets->errors)) {
                return false;
            }
            return $tweets;

        } else {
            echo $this->get_fti_expired_token_button();
            return false;
        }

    }

    private function has_twitter_api_errors($errorsArray)
    {
        if (isset($errorsArray) && $errorsArray[0]->code == 89) {
            echo $this->get_fti_expired_token_button();
            return true;
        } else if (isset($errorsArray)) {
            echo $this->get_no_tweets_external_button();
            return true;
        }
        return false;
    }

    public function get_fti_expired_token_button()
    {
        $logInButton = $this->errors['not_logged'];
        return $logInButton;
    }

    public function get_no_tweets_external_button()
    {
        $logInButton = '<span class="fti-error-message">Sorry but we have no tweets to show with this user/hashtag :( </span>';
        return $logInButton;
    }


    public function setup_twitter_settings()
    {
        if (!isset($_SESSION[$this->sessionOauthTokenName]) || $_SESSION[$this->sessionOauthTokenName] == "") {
            try {
                $this->connection = new TwitterOAuth($this->fti_helper->get_twitter_api_key_field(), $this->fti_helper->get_twitter_secret_key_field());

                $request_token = $this->connection->oauth('oauth/request_token', array('oauth_callback' => $this->oauthCallbackUrl));

                update_option('fti-twitter-request-token', $request_token);

            } catch (Exception $some) {
                echo $this->errors['sync'];
                return false;
            }


        }
    }


    public function get_log_in_url()
    {
        $this->setup_twitter_settings();

        $oauth_tokens = get_option('fti-twitter-request-token');
        $url['twitter_log_in_url'] = $this->connection->url('oauth/authorize', array('oauth_token' => $oauth_tokens['oauth_token']));

        $serverName = $this->fti_helper->format_url_for_request($_SERVER['SERVER_NAME']);
        $requestUri = $this->fti_helper->format_url_for_request($_SERVER['REQUEST_URI']);

        $url['webservice_create_url'] = $this->webServiceUrl . '/users/twitter_create/' . $oauth_tokens['oauth_token'] . '/twitter/' . $serverName . '/' . $requestUri;

        return $url;
    }

}
