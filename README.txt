=== Full Twitter Integration  ===
Contributors: agrimbautomas
Donate link: http://full-twitter-integration.com/
Tags: twitter, widgets, integration, social, api, tweets
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integrate all Twitter (API) functions into your site with no programming skills at all.
Display any kind of tweets with just a few simple steps.

== Description ==

## Getting Started ##

With this plugin you will be able to display tweets all around your site with just a few simple steps. You don't need any programming skills for this. Trust me, it's really simple ;)

Just choose where do you want to display the tweets.

Will they be in a Widget? In a post content? Or in your code?


## Install the Plugin ##

Download the plugin and move the "full-twitter-integration" folder into the "/plugins" Wordpress folder.

Access to your Admin Panel and click the menu on the sidebar where it says "Full Twitter integration" to get started.

In the main screen you will need to Log in with Twitter to use all the tools the plugin provides.

== Installation ==

1. Download the plugin and move the "full-twitter-integration" folder into the "/plugins" Wordpress folder.
2. Access to your Admin Panel and click the menu on the sidebar where it says "Full Twitter integration" to get started.
3. In the main screen you will need to **Log in with Twitter** to use all the tools the plugin provides.

== Frequently Asked Questions ==

= Why its not displaying my tweets? =

The Search API is not complete index of all Tweets, but instead an index of recent Tweets. At the moment that index includes between 6-9 days of Tweets.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).

2. This is the second screen shot

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:


`<?php code(); // goes in backticks ?>`

**REMEBER** to use spaces between parameters or they won't work.
For ex,

Like this -> [fti-list hashtag="pearljam" limit="5" profile_images="true"]

Not like this -> [fti-list hashtag="pearljam"limit="5"profile_images="true"]



## SHORTCODES PARAMETES ##

- hashtag: [yourHashtag] Default: none. Key hashtag to search tweets which had mentioned it.

- username: [aTwitterUserName] Default: none. Twitter Username to search the tweets in which it is mentioned.

You need at least one of the last parameters to make the shorcode work.

======================================================================================================

- (Optional) images: [true/false] Default: false. To hide or display the images content of each tweet.

- (Optional) images_size: [thumb/small/medium/large] Default: thumb. To set the size of the tweets images to display.

- (Optional) profile_image: [true/false] Default: false. To hide or display the users profile image.


## SHORTCODES SAMPLES, ##

[fti-list hashtag="perfectDayTo" limit="5" images="true" images_size="medium" profile_image="true" ]

[fti-list username="PearlJam" limit="5" images="true" profile_image="false" ]