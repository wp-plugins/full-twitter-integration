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

function get_tweets_by_hashtag($hashtag, $limit){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_tweets_by_hashtag($hashtag, $limit);
}

function get_tweets_by_user($user_name, $limit){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_tweets_by_user($user_name, $limit);
}

function get_user_tweets($user_name, $limit){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_user_tweets($user_name, $limit);
}

function get_timeline_tweets($user_name){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_timeline_tweets($user_name);
}

function get_user_data($user_name){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_user_data($user_name);
}

function get_my_data(){
    $fti = new Full_Twitter_Integration_Api();
    return $fti->get_my_data();
}
