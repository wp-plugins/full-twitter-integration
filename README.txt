# Full Twitter Integration - Wordpress Plugin #

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


### FAQs

Why its not displaying my tweets?

> The Search API is not complete index of all Tweets, but instead an index of recent Tweets. At the moment that index includes between 6-9 days of Tweets.