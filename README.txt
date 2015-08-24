=== Full Twitter Integration  ===
Contributors: agrimbautomas
Donate link: http://full-twitter-integration.com/
Tags: twitter, widgets, integration, social, api, tweets
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display any kind of tweet with just a few simple steps and no programming skills

== Description ==

= Getting Started =

With this plugin you will be able to display tweets all around your site with just a few simple steps. You don't need any programming skills for this.
Trust me, it's really simple ;)

Just choose where do you want to display the tweets.

Will they be in a Widget? In a post content? Or in your code?


= Display tweets in a widget, couldn't be easier =

Simple as any other [Wordpress Widget]("http://codex.wordpress.org/WordPress_Widgets"), just go Appearance>Widgets and choose the most suitable FTI Widget for you, or choose them all!

You will be able to set the **Number of tweets to display**, and the option to hide/show the **User profile image** and the **Tweets images**.




= Tweets in your content, just add a shorcode = 

Use the [Wordpress Shortcodes]("https://en.support.wordpress.com/display-posts-shortcode/") to display the tweets on your Posts/Pages and filter them as you wish. Set a **Hashtag** or a **Username** and set the values (optional) to customize the Tweets. Just add the Shortcode to your post/page content and that's all!

This shortcode sample will display PearlJam's Tweets with their profile images and limit them to 5. 
` [fti-list username="PearlJam" limit="5" profile_image="true"] `

And here it's getting Tweets with the hashtag "#Wordpress" including the images content of each and with a medium size. 
`[fti-list hashtag="Wordpress" images="true" images_size="medium"] `

**Shortcode parameters** 

*   hashtag (Required) - [yourHashtag] Default: none. 
*   username (Required) - [aTwitterUserName] Default: none. 
* images (Optional) - [true/false] Default: false. 
* images_size (Optional) - [thumb/small/medium/large] Default: thumb. 
* profile_image (Optional) - [true/false] Default: false.




= Display Tweets in your code =

We have a really simple API to get the tweets you want in your code. Customize the parameters and get an Array with the Tweets (objects).

**These are our functions:**

* get_tweets_by_hashtag($hashtag, $limit) 
* get_tweets_by_user($user_name, $limit) 
* get_user_tweets($user_name, $limit) 
* get_timeline_tweets($user_name) 
* get_user_data($user_name) 
* get_my_data() 

The **$user_name** should be the Twitter screen name, the one with @. Eg: PaulMcCartney



== Installation ==

1. Download the plugin and move the "full-twitter-integration" folder into the "/plugins" Wordpress folder.
2. Access to your Admin Panel and click the menu on the sidebar where it says "Full Twitter integration" to get started.
3. In the main screen you will need to **Log in with Twitter** to use all the tools the plugin provides.






== Frequently Asked Questions ==

= Why its not displaying my tweets? =

The Search API is not complete index of all Tweets, but instead an index of recent Tweets. At the moment that index includes between 6-9 days of Tweets.

= Remember =

Use spaces between parameters or they won't work.

For ex,

Like this -> `[fti-list hashtag="pearljam" limit="5" profile_images="true"]`

Not like this -> `[fti-list hashtag="pearljam"limit="5"profile_images="true"]`



= SHORTCODES PARAMETES =

- hashtag: [yourHashtag] Default: none. Key hashtag to search tweets which had mentioned it.

- username: [aTwitterUserName] Default: none. Twitter Username to search the tweets in which it is mentioned.

You need at least one of the last parameters to make the shorcode work.


- (Optional) images: [true/false] Default: false. To hide or display the images content of each tweet.

- (Optional) images_size: [thumb/small/medium/large] Default: thumb. To set the size of the tweets images to display.

- (Optional) profile_image: [true/false] Default: false. To hide or display the users profile image.


= Shortcode samples =

`[fti-list hashtag="perfectDayTo" limit="5" images="true" images_size="medium" profile_image="true" ]`

`[fti-list username="PearlJam" limit="5" images="true" profile_image="false" ]`







== Screenshots ==

1. Download the plugin and move the "full-twitter-integration" folder into the "/plugins" Wordpress folder.
    Access to your Admin Panel and click the menu on the sidebar where it says "Full Twitter integration" to get started.
    In the main screen you will need to **Log in with Twitter** to use all the tools the plugin provides.

2. Simple as any other [Wordpress Widget]("http://codex.wordpress.org/WordPress_Widgets"), just go Appearance>Widgets and choose the most suitable FTI Widget for you, or choose them all!
    You will be able to set the **Number of tweets to display**, and the option to hide/show the **User profile image** and the **Tweets images**.

