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
class Full_Twitter_Integration_Helper
{

    protected $loader;
    protected $full_Twitter_Integration;
    protected $version;
    private $name;

    private $settingsFieldsName;
    private $twitterApiKeyField;
    private $twitterSecretKeyField;
    private $twitterApiKeyFieldName;
    private $twitterSecretKeyFieldName;
    private $oauthCallbackUrl;
    private $sessionOauthTokenName;
    private $sessionOauthTokenSecretName;
    private $redirectUrlName;
    private $webServiceUrl;
    private $twitterTokenName;
    private $twitterVerifierName;
    private $ftiExternalUrl;
    public $adminUrl;

    public function __construct()
    {

        $this->full_Twitter_Integration = 'full-twitter-integration';
        $this->version = '1.0.0';
        $this->name = 'Full Twitter Integration';
        $this->settingsFieldsName = $this->full_Twitter_Integration . '-settings-fields';

        $this->twitterApiKeyField = '1gp31MxbswlXSeWSrz4tLqy7P';
        $this->twitterSecretKeyField = 'AN44MJpRxp7w2zrWz3xNdFSulLPaU4aDTEEqIZsEIukrX95Oic';
        $this->twitterApiKeyFieldName = 'fti-api-key';
        $this->twitterSecretKeyFieldName = 'fti-api-secret';

        $this->oauthCallbackUrl = 'http://testing.local/wordpress/';
        $this->sessionOauthTokenName = 'fti_oauth_token';
        $this->sessionOauthTokenSecretName = 'fti_oauth_token_secret';

        $this->redirectUrlName = 'fti_redirect_url_value';
        $this->webServiceUrl = 'http://api.full-twitter-integration.com';

        $this->twitterTokenName = 'twitter-oauth-token';
        $this->twitterVerifierName = 'twitter-oauth-verifier';

        $this->ftiExternalUrl = 'http://full-twitter-integration.com';
        $this->adminUrl = admin_url() . '?page=' . $this->get_slug();

    }


    public function format_url_for_request($url)
    {
        $to_replace = array('/', '.', '?');
        $new_values = array('{slash}', '{dot}', '{question}');

        return str_replace($to_replace, $new_values, $url);
    }

    public function get_fti_url()
    {
        return menu_page_url($this->full_Twitter_Integration, false);
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_version()
    {
        return $this->version;
    }

    public function get_slug()
    {
        return $this->full_Twitter_Integration;
    }

    public function get_settings_fields_name()
    {
        return $this->settingsFieldsName;
    }

    public function get_twitter_api_key_field_name()
    {
        return $this->twitterApiKeyFieldName;
    }

    public function get_twitter_secret_key_field_name()
    {
        return $this->twitterSecretKeyFieldName;
    }

    public function get_twitter_api_key_field()
    {
        return $this->twitterApiKeyField;
    }

    public function get_twitter_secret_key_field()
    {
        return $this->twitterSecretKeyField;
    }

    public function get_oauth_callback_url()
    {
        return $this->oauthCallbackUrl;
    }

    public function get_session_oauth_name()
    {
        return $this->sessionOauthTokenName;
    }

    public function get_session_oauth_name_secret()
    {
        return $this->sessionOauthTokenSecretName;
    }

    public function get_redirect_url_value()
    {
        return $this->redirectUrlName;
    }

    public function get_webservice_url()
    {
        return $this->webServiceUrl;
    }

    public function get_twitter_token_name()
    {
        return $this->twitterTokenName;
    }

    public function get_twitter_verifier_name()
    {
        return $this->twitterVerifierName;
    }

    public function get_external_fti_url()
    {
        return $this->ftiExternalUrl;
    }


}
